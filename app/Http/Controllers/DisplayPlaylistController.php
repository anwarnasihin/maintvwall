<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DisplayPlaylist;
use App\Models\group;
use App\Models\source;
use Carbon\Carbon;

class DisplayPlaylistController extends Controller
{
    /**
     * Menampilkan halaman pengaturan Display Playlist.
     */
    public function index($group)
    {
        // Cari group berdasarkan nama.
        // Fallback ke ID untuk menjaga kompatibilitas
        // dengan pola yang sudah digunakan oleh UploadfileController.
        $groupData = group::where('name', $group)->first();

        if (!$groupData) {
            $groupData = group::find($group);
        }

        // Kalau group tidak ditemukan, biarkan Laravel
        // mengembalikan 404 daripada menjalankan query
        // dengan group ID null.
        abort_if(!$groupData, 404);

        $now = Carbon::now('Asia/Jakarta');
        $today = $now->dayOfWeekIso;

        // Ambil playlist milik group ini.
        $playlist = DisplayPlaylist::with([
            'items.source'
        ])
            ->where('group_id', $groupData->id)
            ->first();

        // Ambil content yang sedang aktif.
        //
        // FILTER INI mengikuti logika Display yang sekarang:
        // - sesuai group
        // - ed_date belum lewat
        // - hari ini termasuk selected_days
        //
        // Belum mengubah logic /show/{group}.
        $sources = source::where('group', $groupData->id)
            ->where('ed_date', '>=', $now)
            ->whereRaw("JSON_CONTAINS(selected_days, '\"$today\"')")
            ->get();

        return view('DisplayPlaylist.index', [
            'group' => $groupData,
            'playlist' => $playlist,
            'sources' => $sources,
        ]);
    }

    public function save(Request $request, $group)
    {
        $groupData = group::where('name', $group)->first();

        if (!$groupData) {
            $groupData = group::find($group);
        }

        abort_if(!$groupData, 404);

        $items = $request->input('items', []);

        if (!is_array($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Format playlist tidak valid.',
            ], 422);
        }

        /*
        * Ambil source yang memang aktif untuk group ini.
        *
        * Aturan filter dibuat sama dengan Playlist Manager
        * dan aturan content TV Wall yang sudah ada.
        */

        $now = Carbon::now('Asia/Jakarta');
        $today = $now->dayOfWeekIso;

        $activeSources = source::where('group', $groupData->id)
            ->where('ed_date', '>=', $now)
            ->whereRaw("JSON_CONTAINS(selected_days, '\"$today\"')")
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        /*
        * Pastikan setiap source yang dikirim memang berasal
        * dari group ini dan masih aktif.
        *
        * Source yang sama boleh muncul berkali-kali.
        */

        foreach ($items as $sourceId) {

            if (!in_array((int) $sourceId, $activeSources, true)) {

                return response()->json([
                    'success' => false,
                    'message' => 'Ada media dalam playlist yang tidak aktif atau bukan milik group ini.',
                ], 422);

            }

        }

        try {

            DB::transaction(function () use ($groupData, $items) {

                /*
                * Satu group menggunakan satu playlist.
                *
                * Jika belum ada, buat playlist default.
                */

                $playlist = DisplayPlaylist::firstOrCreate(
                    [
                        'group_id' => $groupData->id,
                    ],
                    [
                        'name' => 'Default Playlist',
                    ]
                );

                /*
                * Hapus urutan lama.
                *
                * File/source asli TIDAK dihapus.
                * Yang dihapus hanya item playlist.
                */

                $playlist->items()->delete();

                /*
                * Simpan urutan baru.
                *
                * Source yang sama boleh muncul berkali-kali.
                */

                $position = 1;

                foreach ($items as $sourceId) {

                    $playlist->items()->create([
                        'source_id' => (int) $sourceId,
                        'position' => $position,
                    ]);

                    $position++;

                }

            });

            return response()->json([
                'success' => true,
                'message' => 'Urutan playlist berhasil disimpan.',
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan playlist.',
            ], 500);

        }
    }
}
