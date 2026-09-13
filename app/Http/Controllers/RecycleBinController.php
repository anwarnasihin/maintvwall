<?php

namespace App\Http\Controllers;

use App\Models\source;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecycleBinController extends Controller
{
    /**
     * Menampilkan semua konten yang sudah masuk Recycle Bin.
     */
    public function index()
    {
        $items = source::onlyTrashed()
            ->with(['groups', 'user', 'deletedBy'])
            ->latest('deleted_at')
            ->get();

        return view('RecycleBin.index', compact('items'));
    }

    /**
     * Restore satu konten dari Recycle Bin.
     */
    public function restore($id)
    {
        $item = source::onlyTrashed()->findOrFail($id);

        // Untuk file lokal, pindahkan kembali dari trash ke assets
        if ($item->typeFile !== 'youtube') {

            $filename = basename($item->direktori);

            $trashPath = public_path(
                'trash/' . $item->typeFile . '/' . $filename
            );

            $originalPath = public_path($item->direktori);

            if (!file_exists($trashPath)) {
                return back()->with(
                    'toast_error',
                    'File tidak ditemukan di Recycle Bin.'
                );
            }

            // Pastikan folder assets tersedia
            $originalDirectory = dirname($originalPath);

            if (!is_dir($originalDirectory)) {
                mkdir($originalDirectory, 0755, true);
            }

            // Jangan restore jika file dengan nama yang sama sudah ada
            if (file_exists($originalPath)) {
                return back()->with(
                    'toast_error',
                    'File dengan nama yang sama sudah ada di folder assets.'
                );
            }

            if (!rename($trashPath, $originalPath)) {
                return back()->with(
                    'toast_error',
                    'Gagal mengembalikan file.'
                );
            }
        }

        $item->deleted_by = null;
        $item->restore();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'memulihkan konten dari Recycle Bin: ' . $item->direktori
        ]);

        return back()->with(
            'toast_success',
            'Konten berhasil dikembalikan.'
        );
    }

    /**
     * Menghapus satu konten secara permanen.
     */
    public function forceDelete($id)
    {
        $item = source::onlyTrashed()->findOrFail($id);

        // Hapus file fisik dari Recycle Bin
        if ($item->typeFile !== 'youtube') {

            $filename = basename($item->direktori);

            $trashPath = public_path(
                'trash/' . $item->typeFile . '/' . $filename
            );

            if (file_exists($trashPath) && is_file($trashPath)) {
                unlink($trashPath);
            }
        }

        $item->forceDelete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'menghapus permanen konten dari Recycle Bin: ' . $item->direktori
        ]);

        return back()->with(
            'toast_success',
            'Konten berhasil dihapus permanen.'
        );
    }

    /**
 * Restore beberapa konten sekaligus.
 */
public function restoreSelected(Request $request)
{
    $ids = $request->ids;

    if (!is_array($ids) || empty($ids)) {
        return back()->with(
            'toast_error',
            'Tidak ada konten yang dipilih.'
        );
    }

    $items = source::onlyTrashed()
        ->whereIn('id', $ids)
        ->get();

    $restoredCount = 0;

    foreach ($items as $item) {

        if ($item->typeFile !== 'youtube') {

            $filename = basename($item->direktori);

            $trashPath = public_path(
                'trash/' . $item->typeFile . '/' . $filename
            );

            $originalPath = public_path($item->direktori);

            if (!file_exists($trashPath)) {
                continue;
            }

            $originalDirectory = dirname($originalPath);

            if (!is_dir($originalDirectory)) {
                mkdir($originalDirectory, 0755, true);
            }

            // Jangan menimpa file yang sudah ada
            if (file_exists($originalPath)) {
                continue;
            }

            if (!rename($trashPath, $originalPath)) {
                continue;
            }
        }

        $item->deleted_by = null;
        $item->restore();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'memulihkan konten dari Recycle Bin: ' . $item->direktori
        ]);

        $restoredCount++;
    }

    return back()->with(
        'toast_success',
        $restoredCount . ' konten berhasil dikembalikan.'
    );
}


/**
 * Hapus beberapa konten secara permanen.
 */
public function forceDeleteSelected(Request $request)
    {
        $ids = $request->ids;

        if (!is_array($ids) || empty($ids)) {
            return back()->with(
                'toast_error',
                'Tidak ada konten yang dipilih.'
            );
        }

        $items = source::onlyTrashed()
            ->whereIn('id', $ids)
            ->get();

        $deletedCount = 0;

        foreach ($items as $item) {

            if ($item->typeFile !== 'youtube') {

                $filename = basename($item->direktori);

                $trashPath = public_path(
                    'trash/' . $item->typeFile . '/' . $filename
                );

                if (file_exists($trashPath) && is_file($trashPath)) {
                    unlink($trashPath);
                }
            }

            $item->forceDelete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'menghapus permanen konten dari Recycle Bin: ' . $item->direktori
            ]);

            $deletedCount++;
        }

        return back()->with(
            'toast_success',
            $deletedCount . ' konten berhasil dihapus permanen.'
        );
    }
}
