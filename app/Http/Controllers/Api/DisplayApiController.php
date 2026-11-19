<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\DisplayPlaylist;
use App\Models\source;
use App\Models\text;

class DisplayApiController extends Controller
{
    /**
     * Menerima heartbeat dari PC Display.
     */
    public function heartbeat(Request $request)
    {
        $display = $request->attributes->get('authenticated_display');

        if (!$display) {
            return response()->json([
                'success' => false,
                'message' => 'Identitas Display tidak ditemukan.',
            ], 401);
        }

        $validated = $request->validate([
            'hostname' => 'nullable|string|max:150',
            'ip_address' => 'nullable|ip',
            'agent_version' => 'nullable|string|max:30',
        ]);

        $display->last_seen_at = now();

        if (!empty($validated['hostname'])) {
            $display->hostname = $validated['hostname'];
        }

        $display->ip_address = $request->ip();

        if (!empty($validated['agent_version'])) {
            $display->agent_version = $validated['agent_version'];
        }

        $display->save();

        return response()->json([
            'success' => true,
            'message' => 'Heartbeat berhasil diterima.',
            'display' => [
                'display_code' => $display->display_code,
                'display_name' => $display->display_name,
                'last_seen_at' => $display->last_seen_at,
                'agent_version' => $display->agent_version,
            ],
            'server_time' => now()->toIso8601String(),
        ]);
    }

    /**
     * Mengirim manifest playlist dan running text
     * kepada PC Display yang sudah terautentikasi.
     */
    public function manifest(Request $request)
    {
        $display = $request->attributes->get('authenticated_display');

        if (!$display) {
            return response()->json([
                'success' => false,
                'message' => 'Identitas Display tidak ditemukan.',
            ], 401);
        }

        // Waktu dan hari mengikuti zona waktu Jakarta.
        $now = Carbon::now('Asia/Jakarta');
        $todayday = (string) $now->dayOfWeekIso;

        // Ambil seluruh Group yang tersedia dan tidak dihapus.
		$availableGroups = \App\Models\group::query()
   		 ->orderBy('name')
   		 ->get();

		$groupsData = [];

		foreach ($availableGroups as $group) {

            $fileMetadataCache = [];

            // Ambil playlist group jika tersedia.
            $playlist = DisplayPlaylist::with('items')
                ->where('group_id', $group->id)
                ->first();

            // Query media yang memenuhi jadwal.
            $activeSources = source::where('group', $group->id)
                ->where('str_date', '<=', $now)
                ->where('ed_date', '>=', $now)
                ->whereRaw(
                    "JSON_CONTAINS(selected_days, ?)",
                    ['"' . $todayday . '"']
                )
                ->get()
                ->keyBy('id');

            if ($playlist && $playlist->items->isNotEmpty()) {

                // Ikuti urutan playlist dan pertahankan duplikat.
                $media = $playlist->items
                    ->sortBy('position')
                    ->map(function ($item) use ($activeSources) {
                        return $activeSources->get($item->source_id);
                    })
                    ->filter()
                    ->values();

                $playlistName = $playlist->name;

            } else {

                // Jika tidak ada playlist, gunakan seluruh media aktif.
                $media = $activeSources->values();

                $playlistName = 'Default';
            }

            // Ambil running text aktif khusus group ini.
            $texts = text::where('status', 1)
                ->whereHas('groups', function ($query) use ($group) {
                    $query->where('groups.id', $group->id);
                })
                ->get(['id', 'judul', 'deskripsi', 'status']);

            $groupsData[] = [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'playlist_name' => $playlistName,

                'media' => $media->map(function ($item, $index) use (&$fileMetadataCache) {

                    $mediaPath = public_path($item->direktori);

                    if (!isset($fileMetadataCache[$item->id])) {
                        $exists = is_file($mediaPath);

                        $fileMetadataCache[$item->id] = [
                            'size_bytes' => $exists ? filesize($mediaPath) : null,
                            'sha256' => $exists ? hash_file('sha256', $mediaPath) : null,
                        ];
                    }

                    return [
                        'source_id' => $item->id,
                        'position' => $index + 1,
                        'type' => $item->typeFile,
                        'path' => $item->direktori,
                        'duration' => (int) $item->duration,
                        'str_date' => $item->str_date,
                        'ed_date' => $item->ed_date,
                        'selected_days' => json_decode(
                            $item->selected_days,
                            true
                        ),
                        'size_bytes' => $fileMetadataCache[$item->id]['size_bytes'],
                        'sha256' => $fileMetadataCache[$item->id]['sha256'],
                    ];
                })->values(),


                'texts' => $texts,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Manifest berhasil dibuat.',
            'display' => [
                'display_code' => $display->display_code,
                'display_name' => $display->display_name,
            ],
            'active_group_id' => $display->active_group_id,
            'server_time' => $now->toIso8601String(),
            'groups' => $groupsData,
        ]);
    }

    /**
     * Download media untuk perangkat Display terautentikasi.
     */
    public function downloadMedia(Request $request, $sourceId)
    {
        $display = $request->attributes->get('authenticated_display');

        if (!$display) {
            return response()->json([
                'success' => false,
                'message' => 'Identitas Display tidak ditemukan.',
            ], 401);
        }

        // Izinkan Display mengakses media dari seluruh Group aktif.
        $groupIds = \App\Models\group::query()
            ->pluck('id');

        $media = \App\Models\source::whereKey($sourceId)
            ->whereIn('group', $groupIds)
            ->first();

        if (!$media) {
            return response()->json([
                'success' => false,
                'message' => 'Media tidak ditemukan atau tidak diizinkan.',
            ], 404);
        }

        // Hanya file lokal gambar/video yang boleh diunduh.
        $type = strtolower((string) $media->typeFile);

        if (!in_array($type, ['images', 'video'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis media tidak mendukung download.',
            ], 422);
        }

        $relativePath = str_replace('\\', '/', (string) $media->direktori);

        // Tolak path absolut, URL, dan karakter kontrol.
        if (
            str_starts_with($relativePath, '/') ||
            preg_match('/^[a-zA-Z]:/', $relativePath) ||
            preg_match('/[\x00-\x1F\x7F]/', $relativePath)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Path media tidak valid.',
            ], 422);
        }

        // Pastikan path hanya menuju folder media yang sesuai.
        $allowedPrefix = $type === 'video'
            ? 'assets/video/'
            : 'assets/images/';

        if (
            !str_starts_with($relativePath, $allowedPrefix) ||
            str_contains($relativePath, '..')
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi media tidak diizinkan.',
            ], 422);
        }

        $basePath = realpath(public_path(rtrim($allowedPrefix, '/')));
        $filePath = realpath(public_path($relativePath));

        if (
            !$basePath ||
            !$filePath ||
            !str_starts_with($filePath, $basePath . DIRECTORY_SEPARATOR) ||
            !is_file($filePath)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'File media tidak ditemukan.',
            ], 404);
        }

        return response()->download($filePath, basename($filePath));
    }

}
