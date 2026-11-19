<?php

namespace App\Http\Controllers;

use App\Models\Display;
use App\Models\group;
use Illuminate\Http\Request;

class DisplayMonitoringController extends Controller
{
    /**
     * Menampilkan halaman monitoring Display.
     */
    public function index()
    {
        return view('DisplayMonitoring.index');
    }

    /**
     * Mengambil status seluruh perangkat Display
     * beserta seluruh Group yang tersedia.
     */
    public function status(Request $request)
    {
        $now = now();
        $offlineThreshold = 90;

        // Ambil seluruh Group yang tidak dihapus (soft delete).
        $availableGroups = group::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                ];
            })
            ->values();

        $displays = Display::with(['groups', 'activeGroup'])
            ->orderBy('display_name')
            ->get()
            ->map(function ($display) use ($now, $offlineThreshold) {

                if (!$display->is_enabled) {
                    $status = 'disabled';
                } elseif (
                    $display->last_seen_at &&
                    $display->last_seen_at->lte($now) &&
                    $display->last_seen_at->diffInSeconds($now) <= $offlineThreshold
                ) {
                    $status = 'online';
                } else {
                    $status = 'offline';
                }

                return [
                    'id' => $display->id,
                    'display_code' => $display->display_code,
                    'display_name' => $display->display_name,
                    'hostname' => $display->hostname,
                    'ip_address' => $display->ip_address,

                    'status' => $status,
                    'is_enabled' => $display->is_enabled,

                    'last_seen_at' => $display->last_seen_at?->toIso8601String(),
                    'last_sync_at' => $display->last_sync_at?->toIso8601String(),
                    'last_sync_version' => $display->last_sync_version,
                    'agent_version' => $display->agent_version,

                    // Relasi penugasan lama tetap ditampilkan.
                    'groups' => $display->groups->map(function ($group) {
                        return [
                            'id' => $group->id,
                            'name' => $group->name,
                        ];
                    })->values(),

                    // Group yang sedang aktif.
                    'active_group' => $display->activeGroup
                        ? [
                            'id' => $display->activeGroup->id,
                            'name' => $display->activeGroup->name,
                        ]
                        : null,
                ];
            });

        return response()->json([
            'success' => true,
            'server_time' => $now->toIso8601String(),
            'offline_threshold_seconds' => $offlineThreshold,

            'summary' => [
                'total' => $displays->count(),
                'online' => $displays->where('status', 'online')->count(),
                'offline' => $displays->where('status', 'offline')->count(),
                'disabled' => $displays->where('status', 'disabled')->count(),
            ],

            // Daftar seluruh Group untuk dropdown Dashboard.
            'available_groups' => $availableGroups,

            'displays' => $displays->values(),
        ]);
    }

    /**
     * Mengganti Group aktif pada perangkat Display.
     */
    public function changeActiveGroup(Request $request, Display $display)
    {
        $validated = $request->validate([
            'group_id' => 'required|integer',
        ]);

        // Group harus tersedia dan tidak dalam kondisi soft deleted.
        $selectedGroup = group::query()
            ->find($validated['group_id']);

        if (!$selectedGroup) {
            return response()->json([
                'success' => false,
                'message' => 'Group tidak ditemukan atau sudah dihapus.',
            ], 422);
        }

        // Simpan pilihan Group aktif.
        $display->active_group_id = $selectedGroup->id;
        $display->save();

        return response()->json([
            'success' => true,
            'message' => 'Group aktif berhasil diperbarui.',
            'active_group' => [
                'id' => $selectedGroup->id,
                'name' => $selectedGroup->name,
            ],
        ]);
    }
}
