@extends('layouts.master')

@section('content')

<style>
/* =========================================================
   RECYCLE BIN
   ========================================================= */

.recycle-bin-page .content-header {
    padding: 15px 0 10px 0;
}

.recycle-bin-page .content-header h1 {
    font-size: 28px;
    font-weight: 500;
    margin: 0;
}

.recycle-bin-page .content-header h1 i {
    margin-right: 8px;
}

.recycle-bin-card {
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.recycle-bin-card .card-header {
    background: linear-gradient(90deg, #ffc107 0%, #ffca28 100%);
    color: #212529;
    min-height: 44px;
    padding: 10px 15px;
}

.recycle-bin-card .card-title {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
}

.recycle-bin-card .card-tools .badge {
    font-size: 12px;
    padding: 5px 8px;
}

.recycle-bin-card .card-body {
    padding: 20px;
}

/* =========================================================
   TOOLBAR
   ========================================================= */

.recycle-toolbar {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 12px 15px;
}

.recycle-toolbar .bulk-action-buttons {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.recycle-toolbar .bulk-action-buttons .btn {
    min-width: 145px;
    margin: 0;
}

/* =========================================================
   TABLE
   ========================================================= */

.recycle-bin-card table {
    margin-bottom: 0;
}

.recycle-bin-card table thead th {
    background: #f4f6f9;
    vertical-align: middle;
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
}

.recycle-bin-card table tbody td {
    vertical-align: middle;
    font-size: 14px;
}

.recycle-bin-card table tbody tr:hover {
    background-color: #fffdf0;
}

.recycle-file-name {
    max-width: 350px;
    word-break: break-word;
}

.recycle-preview {
    color: #007bff;
    text-decoration: none !important;
    cursor: pointer;
    font-weight: 500;
}

.recycle-preview:hover {
    color: #0056b3;
    text-decoration: underline !important;
}

.recycle-action-btn {
    white-space: nowrap;
}

.recycle-action-btn .btn {
    margin: 2px;
}

/* =========================================================
   EMPTY STATE
   ========================================================= */

.recycle-empty {
    padding: 45px 20px !important;
}

.recycle-empty-icon {
    font-size: 58px;
    color: #adb5bd;
    margin-bottom: 15px;
}

.recycle-empty h4 {
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 8px;
}

.recycle-empty p {
    margin-bottom: 0;
    font-size: 14px;
}

/* =========================================================
   MODAL PREVIEW
   ========================================================= */

#recyclePreviewModal .modal-dialog {
    width: fit-content;
    max-width: 95vw;
    margin: 1.75rem auto;
}

#recyclePreviewModal .modal-content {
    width: fit-content;
    max-width: 95vw;
    margin: 0 auto;
    border-radius: 6px;
    overflow: hidden;
    background: #000;
}

#recyclePreviewModal .modal-header {
    width: 100%;
    padding: 10px 15px;
    background: #f4f6f9;
    color: #212529;
}

#recyclePreviewModal .modal-title {
    font-size: 18px;
    font-weight: 600;
}

#playerRecycle {
    width: fit-content;
    max-width: 95vw;
    min-width: 0;
    min-height: 0;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    overflow: hidden;
}

#playerRecycle img {
    display: block;
    width: auto;
    height: auto;
    max-width: 90vw;
    max-height: 75vh;
    object-fit: contain;
    margin: 0 auto;
}

#playerRecycle video {
    display: block;
    width: auto;
    height: auto;
    max-width: 90vw;
    max-height: 75vh;
    object-fit: contain;
    background: #000;
    margin: 0 auto;
}

/* YouTube tetap 16:9 agar iframe presisi */
#playerRecycle .youtube-preview-wrapper {
    position: relative;
    width: min(90vw, 1000px);
    aspect-ratio: 16 / 9;
    background: #000;
    overflow: hidden;
    margin: 0 auto;
}

#playerRecycle .youtube-preview-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
}

@media (max-width: 768px) {
    #recyclePreviewModal .modal-dialog {
        width: fit-content;
        max-width: 95vw;
        margin: 1rem auto;
    }

    #recyclePreviewModal .modal-content {
        width: fit-content;
        max-width: 95vw;
    }

    #playerRecycle {
        max-width: 95vw;
    }

    #playerRecycle img,
    #playerRecycle video {
        max-width: 90vw;
        max-height: 70vh;
    }

    #playerRecycle .youtube-preview-wrapper {
        width: 90vw;
        max-width: 90vw;
    }

    .recycle-bin-page .content-header h1 {
        font-size: 23px;
    }

    @media (max-width: 768px) {
        .recycle-toolbar .bulk-action-buttons {
            justify-content: flex-start;
            width: 100%;
        }

        .recycle-toolbar .bulk-action-buttons .btn {
            width: auto;
            margin: 0;
        }
    }

    .recycle-file-name {
        max-width: none;
    }
}

/* =========================================================
   MODAL KONFIRMASI
   ========================================================= */

.recycle-confirm-modal {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
}

.recycle-confirm-header {
    background: #f4f6f9;
    border-bottom: 1px solid #dee2e6;
    padding: 15px 20px;
}

.recycle-confirm-header .modal-title {
    font-size: 18px;
    font-weight: 700;
}

.recycle-confirm-big-icon {
    width: 75px;
    height: 75px;
    margin: 5px auto 15px auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
}

.recycle-confirm-big-icon.restore {
    background: #e8f7ee;
    color: #28a745;
}

.recycle-confirm-big-icon.delete {
    background: #fdeaea;
    color: #dc3545;
}

.recycle-confirm-heading {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 8px;
}

#recycleConfirmMessage {
    font-size: 14px;
    line-height: 1.6;
}

#recycleConfirmButton {
    min-width: 125px;
}

#recycleConfirmModal .modal-footer {
    padding: 15px 20px 20px;
    border-top: none;
}

#recycleConfirmModal .btn {
    min-width: 100px;
    border-radius: 6px;
    font-weight: 600;
}

@media (max-width: 576px) {
    #recycleConfirmModal .modal-dialog {
        margin: 1rem;
    }

    .recycle-confirm-big-icon {
        width: 65px;
        height: 65px;
        font-size: 28px;
    }
}
</style>

<div class="recycle-bin-page">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fas fa-trash-alt"></i>
                        Recycle Bin
                    </h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Recycle Bin
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <div class="card recycle-bin-card">

                <!-- CARD HEADER -->
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trash mr-2"></i>
                        Konten yang Dihapus
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-light">
                            {{ $items->count() }} Konten
                        </span>
                    </div>
                </div>

                <!-- CARD BODY -->
                <div class="card-body">

                    @if(session('toast_success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('toast_success') }}
                        </div>
                    @endif

                    @if(session('toast_error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('toast_error') }}
                        </div>
                    @endif

                    @if($items->count() > 0)

                        <!-- BULK TOOLBAR -->
                        <div class="mb-3 recycle-toolbar">
                            <div class="row align-items-center">

                                <!-- PILIH SEMUA -->
                                <div class="col-md-5 mb-2 mb-md-0">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="selectAll"
                                            autocomplete="off"
                                        >

                                        <label
                                            class="custom-control-label font-weight-bold"
                                            for="selectAll"
                                        >
                                            Pilih Semua
                                        </label>
                                    </div>

                                    <small
                                        id="selectedCount"
                                        class="text-muted ml-4"
                                    >
                                        0 konten dipilih
                                    </small>
                                </div>

                                <!-- BUTTON -->
                                <div class="col-md-7">

                                    <div class="bulk-action-buttons">

                                        <!-- RESTORE TERPILIH -->
                                        <form
                                            id="restoreSelectedForm"
                                            action="{{ route('admin.recyclebin.restoreSelected') }}"
                                            method="POST"
                                            style="display:inline;"
                                        >
                                            @csrf

                                            <div id="restoreInputs"></div>

                                            <button
                                                type="submit"
                                                id="restoreSelectedBtn"
                                                class="btn btn-success"
                                                disabled
                                            >
                                                <i class="fas fa-undo mr-1"></i>
                                                Restore Terpilih
                                            </button>
                                        </form>

                                        <!-- HAPUS PERMANEN -->
                                        <form
                                            id="forceDeleteSelectedForm"
                                            action="{{ route('admin.recyclebin.forceDeleteSelected') }}"
                                            method="POST"
                                            style="display:inline;"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <div id="deleteInputs"></div>

                                            <button
                                                type="submit"
                                                id="forceDeleteSelectedBtn"
                                                class="btn btn-danger"
                                                disabled
                                            >
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus Permanen Terpilih
                                            </button>
                                        </form>

                                    </div>

</div>
                            </div>
                        </div>

                        <!-- TABLE -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th width="5%" class="text-center">Pilih</th>
                                        <th>Nama File</th>
                                        <th width="10%">Jenis</th>
                                        <th width="12%">Group</th>
                                        <th width="15%">Dihapus Oleh</th>
                                        <th width="17%">Waktu Dihapus</th>
                                        <th width="20%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($items as $item)
                                        <tr>

                                            <!-- NOMOR -->
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>

                                            <!-- CHECKBOX -->
                                            <td class="text-center">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input item-checkbox"
                                                        id="item{{ $item->id }}"
                                                        value="{{ $item->id }}"
                                                        autocomplete="off"
                                                    >

                                                    <label
                                                        class="custom-control-label"
                                                        for="item{{ $item->id }}"
                                                    ></label>
                                                </div>
                                            </td>

                                            <!-- NAMA FILE -->
                                            <td class="recycle-file-name">
                                                <a
                                                    href="#"
                                                    class="recycle-preview"
                                                    data-type="{{ $item->typeFile }}"
                                                    data-konten="{{ $item->direktori }}"
                                                    title="Klik untuk preview"
                                                >
                                                    @if($item->typeFile == 'youtube')
                                                        <i
                                                            class="fab fa-youtube mr-1"
                                                            style="color:#ff0000;"
                                                        ></i>
                                                        {{ $item->direktori }}

                                                    @elseif($item->typeFile == 'images')
                                                        <i
                                                            class="fas fa-image mr-1"
                                                            style="color:#007bff;"
                                                        ></i>
                                                        {{ basename($item->direktori) }}

                                                    @else
                                                        <i
                                                            class="fas fa-video mr-1"
                                                            style="color:#dc3545;"
                                                        ></i>
                                                        {{ basename($item->direktori) }}
                                                    @endif
                                                </a>
                                            </td>

                                            <!-- JENIS -->
                                            <td>
                                                @if($item->typeFile == 'video')
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-video mr-1"></i>
                                                        Video
                                                    </span>

                                                @elseif($item->typeFile == 'images')
                                                    <span class="badge badge-primary">
                                                        <i class="fas fa-image mr-1"></i>
                                                        Gambar
                                                    </span>

                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fab fa-youtube mr-1"></i>
                                                        YouTube
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- GROUP -->
                                            <td>
                                                {{ $item->groups->name ?? '-' }}
                                            </td>

                                            <!-- DIHAPUS OLEH -->
                                            <td>
                                                @if($item->deletedBy)
                                                    {{
                                                        $item->deletedBy->name
                                                        ?? $item->deletedBy->username
                                                        ?? '-'
                                                    }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <!-- WAKTU DIHAPUS -->
                                            <td>
                                                @if($item->deleted_at)
                                                    {{
                                                        $item->deleted_at
                                                            ->format('d-m-Y H:i:s')
                                                    }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <!-- AKSI -->
                                            <td class="text-center recycle-action-btn">

                                                <!-- RESTORE SATUAN -->
                                                <form
                                                    action="{{ route('admin.recyclebin.restore', $item->id) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn btn-success btn-sm"
                                                        onclick="return confirm('Yakin ingin mengembalikan konten ini ke Data Source?')"
                                                    >
                                                        <i class="fas fa-undo"></i>
                                                        Restore
                                                    </button>
                                                </form>

                                                <!-- HAPUS PERMANEN SATUAN -->
                                                <form
                                                    action="{{ route('admin.recyclebin.forceDelete', $item->id) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('PERINGATAN! Konten ini akan DIHAPUS PERMANEN dan tidak dapat dikembalikan. Yakin ingin melanjutkan?')"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else

                        <!-- EMPTY STATE -->
                        <div class="text-center recycle-empty">
                            <i class="fas fa-trash-alt recycle-empty-icon"></i>

                            <h4>Recycle Bin Kosong</h4>

                            <p class="text-muted">
                                Tidak ada konten yang sedang berada di Recycle Bin.
                            </p>
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </section>
</div>

<!-- =====================================================
     MODAL PREVIEW
===================================================== -->

<div
    class="modal fade"
    id="recyclePreviewModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header"
                style="
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 100%;
                    height: 50px;
                    background: transparent;
                    border: none;
                    z-index: 9999;
                    padding: 8px 12px;
                    pointer-events: none;
                ">

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    style="
                        pointer-events: auto;
                        margin-left: auto;
                        width: 38px;
                        height: 38px;
                        border-radius: 50%;
                        background: rgba(0,0,0,0.65);
                        color: #fff;
                        opacity: 1;
                        font-size: 25px;
                        line-height: 30px;
                        padding: 0;
                        border: none;
                        cursor: pointer;
                    "
                >
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body text-center p-0">
                <div id="playerRecycle"></div>
            </div>

        </div>
    </div>
</div>

<!-- =====================================================
     MODAL KONFIRMASI AKSI
===================================================== -->

<div
    class="modal fade"
    id="recycleConfirmModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="recycleConfirmTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content recycle-confirm-modal">

            <div class="modal-header recycle-confirm-header">
                <h5
                    class="modal-title"
                    id="recycleConfirmTitle"
                >
                    <i
                        id="recycleConfirmIcon"
                        class="fas fa-question-circle mr-2"
                    ></i>
                    Konfirmasi
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">

                <div
                    id="recycleConfirmBigIcon"
                    class="recycle-confirm-big-icon"
                >
                    <i class="fas fa-question"></i>
                </div>

                <h4 id="recycleConfirmHeading">
                    Apakah Anda yakin?
                </h4>

                <p
                    id="recycleConfirmMessage"
                    class="text-muted mb-0"
                >
                    Silakan konfirmasi tindakan Anda.
                </p>

            </div>

            <div class="modal-footer justify-content-center">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </button>

                <button
                    type="button"
                    id="recycleConfirmButton"
                    class="btn btn-primary"
                >
                    <i
                        id="recycleConfirmButtonIcon"
                        class="fas fa-check mr-1"
                    ></i>
                    Ya, Lanjutkan
                </button>

            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script>
$(document).ready(function () {

    console.log('Recycle Bin JS aktif');


    /* =========================================================
       PREVIEW KONTEN
       Bagian ini dipertahankan agar fungsi preview yang sudah
       berjalan baik tidak berubah.
       ========================================================= */

    $('body').on('click', '.recycle-preview', function (e) {

        e.preventDefault();
        e.stopPropagation();

        var type = $(this).data('type');
        var direktori = $(this).data('konten');
        var player = document.getElementById('playerRecycle');

        if (!player) {
            console.error('playerRecycle tidak ditemukan.');
            return;
        }

        player.innerHTML = '';

        console.log('=================================');
        console.log('Preview diklik');
        console.log('Type:', type);
        console.log('File:', direktori);
        console.log('=================================');


        /* =====================================================
           GAMBAR
           ===================================================== */

        if (type === 'images') {

            var trashPath =
                String(direktori).replace(/^assets\//, 'trash/');

            var previewUrl =
                "{{ asset('') }}" + trashPath;

            console.log('Preview gambar URL:', previewUrl);

            player.innerHTML = `
                <img
                    src="${previewUrl}"
                    alt="Preview Gambar"
                    style="
                        display:block;
                        width:auto;
                        height:auto;
                        max-width:90vw;
                        max-height:75vh;
                        object-fit:contain;
                        margin:0 auto;
                    "
                    onerror="recyclePreviewError(
                        'Gambar tidak ditemukan di Recycle Bin.'
                    )"
                >
            `;
        }


        /* =====================================================
           VIDEO MP4
           ===================================================== */

        else if (type === 'video') {

            var trashPath =
                String(direktori).replace(/^assets\//, 'trash/');

            var previewUrl =
                "{{ asset('') }}" + trashPath;

            console.log('Preview video URL:', previewUrl);

            player.innerHTML = `
                <video
                    src="${previewUrl}"
                    autoplay
                    loop
                    muted
                    playsinline
                    preload="auto"
                    controls
                    style="
                        display:block;
                        width:auto;
                        height:auto;
                        max-width:90vw;
                        max-height:75vh;
                        object-fit:contain;
                        background:#000;
                        margin:0 auto;
                    "
                    onerror="recyclePreviewError(
                        'Video tidak ditemukan di Recycle Bin.'
                    )"
                ></video>
            `;

            var video = player.querySelector('video');

            if (video) {

                video.muted = true;
                video.loop = true;
                video.autoplay = true;
                video.playsInline = true;

                var playPromise = video.play();

                if (playPromise !== undefined) {

                    playPromise.catch(function (error) {

                        console.log(
                            'Autoplay video diblokir browser:',
                            error
                        );

                    });
                }
            }
        }


        /* =====================================================
           YOUTUBE
           ===================================================== */

        else if (type === 'youtube') {

            console.log('Preview YouTube diklik');
            console.log('URL YouTube:', direktori);

            var videoId = getYouTubeId(direktori);

            console.log('YouTube Video ID:', videoId);

            if (videoId) {

                player.innerHTML = `
                    <div class="youtube-preview-wrapper">
                        <iframe
                            id="youtubePreviewFrame"
                            src="https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&playsinline=1&rel=0"
                            title="Preview YouTube"
                            frameborder="0"
                            allow="autoplay; encrypted-media; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                `;

            } else {

                console.error('ID YouTube tidak ditemukan.');

                player.innerHTML = `
                    <div class="alert alert-danger m-4">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Link YouTube tidak valid.</strong>
                        <br>
                        Link YouTube pada konten ini
                        tidak dapat dikenali.
                    </div>
                `;
            }
        }


        /* =====================================================
           TYPE TIDAK DIKENAL
           ===================================================== */

        else {

            console.error(
                'Type konten tidak dikenal:',
                type
            );

            player.innerHTML = `
                <div class="alert alert-warning m-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Jenis konten tidak dikenali.
                </div>
            `;
        }


        $('#recyclePreviewModal').modal('show');

    });


    /* =========================================================
       AMBIL YOUTUBE VIDEO ID
       ========================================================= */

    function getYouTubeId(url) {

        if (!url) {
            return null;
        }

        url = String(url).trim();

        /*
         * Mendukung:
         * https://www.youtube.com/watch?v=xxxxx
         * https://youtube.com/watch?v=xxxxx
         * https://youtu.be/xxxxx
         * https://www.youtube.com/embed/xxxxx
         * https://www.youtube.com/live/xxxxx
         * https://www.youtube.com/shorts/xxxxx
         */

        var regExp =
            /(?:youtube\.com\/(?:watch\?v=|embed\/|live\/|shorts\/)|youtu\.be\/)([^#&?\/]+)/;

        var match = url.match(regExp);

        if (match) {
            return match[1];
        }

        return null;
    }


    /* =========================================================
       ERROR PREVIEW
       ========================================================= */

    window.recyclePreviewError = function (message) {

        var player =
            document.getElementById('playerRecycle');

        if (!player) {
            return;
        }

        player.innerHTML = `
            <div class="alert alert-danger m-4">
                <i class="fas fa-exclamation-circle mr-2"></i>
                ${message}
            </div>
        `;
    };


    /* =========================================================
       BERSIHKAN PLAYER SAAT MODAL DITUTUP
       ========================================================= */

    $('#recyclePreviewModal').on(
        'hidden.bs.modal',
        function () {

            var player =
                document.getElementById('playerRecycle');

            if (player) {
                player.innerHTML = '';
            }
        }
    );


    /* =========================================================
       BULK ACTION
       Hanya satu sistem handler.
       Ini mencegah event submit ganda/konflik.
       ========================================================= */

    const selectAll =
        document.getElementById('selectAll');

    const checkboxes =
        document.querySelectorAll('.item-checkbox');

    const selectedCount =
        document.getElementById('selectedCount');

    const restoreBtn =
        document.getElementById('restoreSelectedBtn');

    const deleteBtn =
        document.getElementById('forceDeleteSelectedBtn');

    const restoreInputs =
        document.getElementById('restoreInputs');

    const deleteInputs =
        document.getElementById('deleteInputs');

    const restoreForm =
        document.getElementById('restoreSelectedForm');

    const deleteForm =
        document.getElementById('forceDeleteSelectedForm');


    /*
     * Kalau Recycle Bin kosong, elemen bulk memang tidak ada.
     * Jangan jalankan kode bulk.
     */

    if (
        !selectAll ||
        !selectedCount ||
        !restoreBtn ||
        !deleteBtn ||
        !restoreInputs ||
        !deleteInputs ||
        !restoreForm ||
        !deleteForm
    ) {
        return;
    }


    /* =========================================================
       AMBIL ID TERPILIH
       ========================================================= */

    function getSelectedIds() {

        return Array.from(checkboxes)
            .filter(function (checkbox) {
                return checkbox.checked;
            })
            .map(function (checkbox) {
                return checkbox.value;
            });
    }


    /* =========================================================
       UPDATE PILIHAN
       ========================================================= */

    function updateSelection() {

        var ids = getSelectedIds();
        var count = ids.length;
        var total = checkboxes.length;

        selectedCount.textContent =
            count + ' konten dipilih';

        restoreBtn.disabled =
            count === 0;

        deleteBtn.disabled =
            count === 0;

        /*
         * PENTING:
         * Pilih Semua hanya checked jika SEMUA item dipilih.
         * Jika sebagian dipilih, gunakan indeterminate.
         */

        selectAll.checked =
            total > 0 && count === total;

        selectAll.indeterminate =
            count > 0 && count < total;

        /*
         * Sinkronkan hidden input.
         * Hidden input hanya berisi item yang benar-benar dipilih.
         */

        restoreInputs.innerHTML = '';
        deleteInputs.innerHTML = '';

        ids.forEach(function (id) {

            var restoreInput =
                document.createElement('input');

            restoreInput.type = 'hidden';
            restoreInput.name = 'ids[]';
            restoreInput.value = id;

            restoreInputs.appendChild(
                restoreInput
            );


            var deleteInput =
                document.createElement('input');

            deleteInput.type = 'hidden';
            deleteInput.name = 'ids[]';
            deleteInput.value = id;

            deleteInputs.appendChild(
                deleteInput
            );

        });
    }


    /* =========================================================
       PILIH SEMUA
       ========================================================= */

    selectAll.addEventListener(
        'change',
        function () {

            checkboxes.forEach(
                function (checkbox) {

                    checkbox.checked =
                        selectAll.checked;

                }
            );

            updateSelection();
        }
    );


    /* =========================================================
       CHECKBOX INDIVIDUAL
       ========================================================= */

    checkboxes.forEach(
        function (checkbox) {

            checkbox.addEventListener(
                'change',
                function () {

                    updateSelection();

                }
            );
        }
    );


    /* =========================================================
       MODAL KONFIRMASI
       ========================================================= */

    let recycleConfirmAction = null;


    function showRecycleConfirm(options) {

        $('#recycleConfirmTitle').html(
            '<i class="' +
            options.headerIcon +
            ' mr-2"></i>' +
            options.title
        );

        $('#recycleConfirmBigIcon')
            .removeClass('restore delete')
            .addClass(options.type)
            .html(
                '<i class="' +
                options.bigIcon +
                '"></i>'
            );

        $('#recycleConfirmHeading').text(
            options.heading
        );

        $('#recycleConfirmMessage').html(
            options.message
        );

        $('#recycleConfirmButton')
            .removeClass(
                'btn-success btn-danger btn-primary'
            )
            .addClass(options.buttonClass)
            .html(
                '<i class="' +
                options.buttonIcon +
                ' mr-1"></i>' +
                options.buttonText
            );

        recycleConfirmAction =
            options.action;

        $('#recycleConfirmModal').modal('show');
    }


    /* =========================================================
       TOMBOL YA, LANJUTKAN
       ========================================================= */

    $('#recycleConfirmButton')
        .off('click.recycleConfirm')
        .on(
            'click.recycleConfirm',
            function () {

                if (
                    typeof recycleConfirmAction ===
                    'function'
                ) {
                    recycleConfirmAction();
                }
            }
        );


    /* =========================================================
       SUBMIT FORM BULK SECARA AMAN
       ========================================================= */

    function submitBulkForm(form, ids) {

        /*
         * Bersihkan hidden input lama.
         * Kemudian buat ulang berdasarkan checkbox saat ini.
         */

        var container =
            form === restoreForm
                ? restoreInputs
                : deleteInputs;

        container.innerHTML = '';

        ids.forEach(function (id) {

            var input =
                document.createElement('input');

            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;

            container.appendChild(input);

        });

        /*
         * Gunakan native submit.
         * Ini sengaja supaya handler submit modal tidak
         * terpanggil lagi.
         */

        HTMLFormElement.prototype.submit.call(form);
    }


    /* =========================================================
       RESTORE TERPILIH
       ========================================================= */

    $(restoreForm)
        .off('submit.recycleRestore')
        .on(
            'submit.recycleRestore',
            function (event) {

                event.preventDefault();

                var form = this;
                var ids = getSelectedIds();

                if (ids.length === 0) {
                    return;
                }

                showRecycleConfirm({

                    type: 'restore',

                    title:
                        'Konfirmasi Restore',

                    headerIcon:
                        'fas fa-undo',

                    bigIcon:
                        'fas fa-undo',

                    heading:
                        'Kembalikan konten?',

                    message:
                        'Sebanyak <strong>' +
                        ids.length +
                        ' konten</strong> akan dikembalikan ke <strong>Data Source</strong>.',

                    buttonClass:
                        'btn-success',

                    buttonIcon:
                        'fas fa-check',

                    buttonText:
                        'Ya, Restore',

                    action: function () {

                        $('#recycleConfirmModal')
                            .modal('hide');

                        submitBulkForm(
                            form,
                            ids
                        );
                    }
                });
            }
        );


    /* =========================================================
       HAPUS PERMANEN TERPILIH
       ========================================================= */

    $(deleteForm)
        .off('submit.recycleDelete')
        .on(
            'submit.recycleDelete',
            function (event) {

                event.preventDefault();

                var form = this;
                var ids = getSelectedIds();

                if (ids.length === 0) {
                    return;
                }

                showRecycleConfirm({

                    type: 'delete',

                    title:
                        'Peringatan Hapus Permanen',

                    headerIcon:
                        'fas fa-exclamation-triangle',

                    bigIcon:
                        'fas fa-trash-alt',

                    heading:
                        'Hapus konten secara permanen?',

                    message:
                        '<strong>' +
                        ids.length +
                        ' konten</strong> akan dihapus secara permanen.<br>' +
                        '<span class="text-danger">' +
                        'Data dan file tidak dapat dikembalikan lagi.' +
                        '</span>',

                    buttonClass:
                        'btn-danger',

                    buttonIcon:
                        'fas fa-trash',

                    buttonText:
                        'Ya, Hapus Permanen',

                    action: function () {

                        $('#recycleConfirmModal')
                            .modal('hide');

                        submitBulkForm(
                            form,
                            ids
                        );
                    }
                });
            }
        );


    /* =========================================================
       RESET AKSI SAAT MODAL DITUTUP
       ========================================================= */

    $('#recycleConfirmModal').on(
        'hidden.bs.modal',
        function () {

            recycleConfirmAction = null;

        }
    );


    /* =========================================================
       KONDISI AWAL
       ========================================================= */

    updateSelection();

});
</script>

@endsection
