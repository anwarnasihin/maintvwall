@extends('layouts.master')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">
                <i class="fas fa-list-ol mr-2"></i>
                Display Playlist
            </h4>

            <div class="text-muted">
                Group:
                <strong>{{ $group->name }}</strong>
            </div>
        </div>

        <div>
            <a href="{{ route('showGroup', $group->name) }}"
               target="_blank"
               class="btn btn-primary">

                <i class="fas fa-tv mr-1"></i>
                Display

            </a>
        </div>

    </div>


    {{-- INFO --}}
    <div class="alert alert-info">

        <i class="fas fa-info-circle mr-2"></i>

        Klik tombol
        <strong>Tambah</strong>
        untuk memasukkan media ke playlist.

        Media yang sama
        <strong>boleh ditambahkan berkali-kali</strong>.

        Setelah masuk playlist, urutannya dapat diubah dengan
        <strong>drag & drop</strong>.

    </div>


    <div class="row">

        {{-- ===================================================== --}}
        {{-- MEDIA AKTIF --}}
        {{-- ===================================================== --}}

        <div class="col-md-5">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>
                        <i class="fas fa-photo-video mr-2"></i>
                        Media Aktif
                    </strong>

                </div>


                <div class="card-body">

                    @if($sources->count() === 0)

                        <div class="text-center text-muted py-5">

                            <i class="fas fa-photo-video fa-3x mb-3"></i>

                            <p class="mb-0">
                                Tidak ada media aktif untuk group ini.
                            </p>

                        </div>

                    @else

                        <div class="small text-muted mb-3">

                            Media yang memenuhi jadwal aktif saat ini.

                        </div>


                        <div id="availableMedia">

                            @foreach($sources as $source)

                                <div class="media-card">

                                    <div class="drag-handle">

                                        <i class="fas fa-photo-video"></i>

                                    </div>


                                    <div class="media-info">

                                        <div class="media-title media-preview-trigger"
                                            data-source-id="{{ $source->id }}"
                                            title="Klik untuk melihat preview">
                                            {{ basename($source->direktori) }}
                                        </div>


                                        <div class="media-meta">

                                            <span>
                                                <i class="fas fa-hashtag"></i>
                                                ID {{ $source->id }}
                                            </span>


                                            @if($source->typeFile)

                                                <span>
                                                    <i class="fas fa-file"></i>
                                                    {{ $source->typeFile }}
                                                </span>

                                            @endif


                                            @if($source->duration)

                                                <span>
                                                    <i class="fas fa-clock"></i>
                                                    {{ $source->duration }} detik
                                                </span>

                                            @endif

                                        </div>

                                    </div>


                                    <button type="button"
                                            class="btn btn-sm btn-primary add-media"
                                            data-source-id="{{ $source->id }}">

                                        <i class="fas fa-plus"></i>
                                        Tambah

                                    </button>

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- PLAYLIST --}}
        {{-- ===================================================== --}}

        <div class="col-md-7">

            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <strong>

                        <i class="fas fa-stream mr-2"></i>
                        Urutan Playlist

                    </strong>


                    <span id="playlistCount"
                          class="badge badge-secondary">

                        {{ $playlist ? $playlist->items->count() : 0 }}
                        item

                    </span>

                </div>


                <div class="card-body">


                    <div class="small text-muted mb-3">

                        Geser item untuk mengubah urutan playlist.

                        <br>

                        <span class="text-info">
                            <i class="fas fa-info-circle"></i>
                            Media yang sama dapat muncul lebih dari satu kali.
                        </span>

                    </div>

                {{-- PINDAH POSISI PLAYLIST --}}
                <div class="border rounded p-3 mb-3">
                    <div class="font-weight-bold mb-2">
                        <i class="fas fa-exchange-alt mr-1"></i>
                        Pindahkan Posisi Konten
                    </div>

                    <div class="form-row align-items-end">
                        <div class="col-5 col-md-4 mb-2">
                            <label for="moveFromPosition" class="small mb-1">
                                Urutan asal
                            </label>
                            <input
                                type="number"
                                id="moveFromPosition"
                                class="form-control form-control-sm"
                                min="1"
                                placeholder="Mis. 90">
                        </div>

                        <div class="col-5 col-md-4 mb-2">
                            <label for="moveToPosition" class="small mb-1">
                                Urutan tujuan
                            </label>
                            <input
                                type="number"
                                id="moveToPosition"
                                class="form-control form-control-sm"
                                min="1"
                                placeholder="Mis. 10">
                        </div>

                        <div class="col-12 col-md-4 mb-2">
                            <button
                                type="button"
                                id="movePositionBtn"
                                class="btn btn-sm btn-outline-primary btn-block">
                                <i class="fas fa-arrows-alt mr-1"></i>
                                Pindahkan
                            </button>
                        </div>
                    </div>

                    <small class="text-muted">
                        Masukkan nomor urutan asal dan tujuan. Perubahan disimpan
                        setelah menekan tombol Simpan Urutan.
                    </small>
                </div>


                    {{-- PLAYLIST ITEMS --}}

                    <div id="playlistItems">

                        @if($playlist && $playlist->items->count() > 0)

                            @foreach($playlist->items as $index => $item)

                                @if($item->source)

                                    <div class="playlist-card"
                                         data-source-id="{{ $item->source->id }}">

                                        <div class="playlist-number">

                                            {{ $index + 1 }}

                                        </div>


                                        <div class="drag-handle">

                                            <i class="fas fa-grip-vertical"></i>

                                        </div>


                                        <div class="media-info">

                                            <div class="media-title">

                                                {{ basename($item->source->direktori) }}

                                            </div>


                                            <div class="media-meta">

                                                <span>
                                                    <i class="fas fa-hashtag"></i>
                                                    ID {{ $item->source->id }}
                                                </span>


                                                @if($item->source->typeFile)

                                                    <span>
                                                        <i class="fas fa-file"></i>
                                                        {{ $item->source->typeFile }}
                                                    </span>

                                                @endif


                                                @if($item->source->duration)

                                                    <span>
                                                        <i class="fas fa-clock"></i>
                                                        {{ $item->source->duration }} detik
                                                    </span>

                                                @endif

                                            </div>

                                        </div>


                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger remove-media"
                                                title="Hapus dari playlist">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </div>

                                @endif

                            @endforeach

                        @endif

                    </div>


                    {{-- EMPTY STATE --}}

                    <div id="emptyPlaylist"
                         class="empty-playlist"
                         style="{{ ($playlist && $playlist->items->count() > 0) ? 'display:none;' : '' }}">
                        <i class="fas fa-list-ol fa-3x mb-3"></i>
                        <h5>
                            Playlist belum dibuat
                        </h5>
                        <p class="text-muted mb-0">
                            Klik
                            <strong>Tambah</strong>
                            pada media di sebelah kiri.
                        </p>
                    </div>

                    <hr>


                    {{-- ACTION --}}

                    <div class="d-flex justify-content-between align-items-center">

                        <div id="playlistSaveStatus" class="text-muted small">
                            <i class="fas fa-info-circle mr-1"></i>
                            Urutan playlist tersimpan.
                        </div>

                        <button type="button"
                                id="savePlaylistBtn"
                                class="btn btn-success"
                                disabled>

                            <i class="fas fa-save mr-1"></i>

                            Simpan Urutan

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- STYLE --}}
{{-- ============================================================= --}}

<style>

.media-card,
.playlist-card {

    display: flex;

    align-items: center;

    border: 1px solid #dee2e6;

    border-radius: 6px;

    background: #fff;

    padding: 12px 14px;

    margin-bottom: 10px;

    transition: all .15s ease;

}


.media-card:hover,
.playlist-card:hover {

    border-color: #adb5bd;

    box-shadow: 0 2px 7px rgba(0,0,0,.08);

}


.drag-handle {

    width: 30px;

    color: #adb5bd;

    cursor: grab;

    text-align: center;

    font-size: 16px;

}


.drag-handle:active {

    cursor: grabbing;

}


.media-info {

    min-width: 0;

    flex: 1;

}


.media-title {

    font-weight: 600;

    color: #343a40;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}


.media-meta {

    display: flex;

    flex-wrap: wrap;

    gap: 12px;

    margin-top: 5px;

    font-size: 12px;

    color: #6c757d;

}


.playlist-number {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-right: 8px;

    border-radius: 50%;

    background: #f1f3f5;

    color: #495057;

    font-weight: 700;

    flex-shrink: 0;

}


.playlist-card {

    cursor: default;

}


.playlist-card .remove-media {

    margin-left: 10px;

    flex-shrink: 0;

}


.sortable-ghost {

    opacity: .35;

    background: #e9ecef;

}


.empty-playlist {

    text-align: center;

    padding: 70px 20px;

    color: #adb5bd;

}


.empty-playlist h5 {

    color: #6c757d;

    margin-top: 10px;

}


.add-media {

    flex-shrink: 0;

    margin-left: 10px;

}

/* ============================================================= */
/* PLAYLIST RESULT MODAL */
/* ============================================================= */

.playlist-result-modal {

    border: none;

    border-radius: 12px;

    overflow: hidden;

}


.playlist-result-icon {

    width: 72px;

    height: 72px;

    margin: 0 auto;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 32px;

    background: #d4edda;

    color: #28a745;

}


.playlist-result-modal h5 {

    font-weight: 600;

    color: #343a40;

}


.playlist-result-modal p {

    font-size: 14px;

}

#playlistPreviewBody {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    min-height: 300px;
    overflow: hidden;
}

#playlistPreviewBody img {
    display: block;
    max-width: 100%;
    max-height: 75vh;
    width: auto;
    height: auto;
    object-fit: contain;
    margin: 0 auto;
}

#playlistPreviewBody video {
    display: block;
    max-width: 100%;
    max-height: 75vh;
    width: auto;
    height: auto;
    object-fit: contain;
    margin: 0 auto;
}

</style>


{{-- ============================================================= --}}
{{-- SORTABLEJS --}}
{{-- ============================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const playlistItems = document.getElementById('playlistItems');

    const emptyPlaylist = document.getElementById('emptyPlaylist');

    const playlistCount = document.getElementById('playlistCount');

    const saveButton = document.getElementById('savePlaylistBtn');


    /*
     * Data media aktif.
     *
     * Hanya dipakai untuk kebutuhan UI tahap ini.
     * Belum ada proses penyimpanan database.
     */

    const mediaData = @json($sources);


    /*
     * Cari informasi media berdasarkan ID.
     */

    function getMedia(sourceId) {

        return mediaData.find(function (media) {

            return Number(media.id) === Number(sourceId);

        });

    }


    /*
     * Buat satu item playlist.
     *
     * Source yang sama boleh dibuat berkali-kali.
     */

    function createPlaylistItem(sourceId) {

        const media = getMedia(sourceId);

        if (!media) {
            return null;
        }


        const item = document.createElement('div');

        item.className = 'playlist-card';

        item.dataset.sourceId = media.id;


        item.innerHTML = `

            <div class="playlist-number"></div>

            <div class="drag-handle">

                <i class="fas fa-grip-vertical"></i>

            </div>


            <div class="media-info">

                <div class="media-title"></div>

                <div class="media-meta">

                    <span class="media-id"></span>

                    <span class="media-type"></span>

                    <span class="media-duration"></span>

                </div>

            </div>


            <button type="button"
                    class="btn btn-sm btn-outline-danger remove-media"
                    title="Hapus dari playlist">

                <i class="fas fa-times"></i>

            </button>

        `;


        const mediaTitle = item.querySelector('.media-title');

            mediaTitle.textContent =
                media.direktori.split('/').pop();

            mediaTitle.style.cursor = 'pointer';
            mediaTitle.style.textDecoration = 'underline';
            mediaTitle.title = 'Klik untuk melihat preview';


        item.querySelector('.media-id').innerHTML =
            '<i class="fas fa-hashtag"></i> ID ' + media.id;


        if (media.typeFile) {

            item.querySelector('.media-type').innerHTML =
                '<i class="fas fa-file"></i> ' + media.typeFile;

        } else {

            item.querySelector('.media-type').remove();

        }


        if (media.duration) {

            item.querySelector('.media-duration').innerHTML =
                '<i class="fas fa-clock"></i> ' +
                media.duration +
                ' detik';

        } else {

            item.querySelector('.media-duration').remove();

        }



        return item;

    }


    function extractPlaylistYouTubeId(url) {

    if (!url) {
        return '';
    }

    const match = String(url).match(
        /(?:youtube\.com\/(?:watch\?v=|embed\/|live\/)|youtu\.be\/)([^&?\/]+)/
    );

    return match ? match[1] : '';
}


    /*
     * Update nomor urutan.
     */

    function updatePlaylistNumbers() {

        const items =
            playlistItems.querySelectorAll('.playlist-card');


        items.forEach(function (item, index) {

            const number =
                item.querySelector('.playlist-number');

            number.textContent = index + 1;

        });


        const total = items.length;


        playlistCount.textContent =
            total + (total === 1 ? ' item' : ' item');


        if (total === 0) {

            emptyPlaylist.style.display = '';

        } else {

            emptyPlaylist.style.display = 'none';

        }

    }


    /*
     * Tandai bahwa playlist berubah.
     *
     * Belum dikirim ke server.
     */


    function markChanged() {
        saveButton.disabled = false;

        const status = document.getElementById('playlistSaveStatus');

        if (status) {
            status.className = 'text-muted small';
            status.innerHTML =
                '<i class="fas fa-info-circle mr-1"></i> ' +
                'Perubahan belum disimpan ke database.';
        }
    }


    // Pindahkan item ke nomor urutan yang ditentukan.
    const movePositionButton = document.getElementById('movePositionBtn');
    const moveFromInput = document.getElementById('moveFromPosition');
    const moveToInput = document.getElementById('moveToPosition');

    movePositionButton.addEventListener('click', function () {
        const items = Array.from(
            playlistItems.querySelectorAll('.playlist-card')
        );

        const total = items.length;
        const from = Number(moveFromInput.value);
        const to = Number(moveToInput.value);

        if (
            !Number.isInteger(from) ||
            !Number.isInteger(to) ||
            from < 1 ||
            to < 1 ||
            from > total ||
            to > total
        ) {
            alert('Nomor urutan harus antara 1 dan ' + total + '.');
            return;
        }

        if (from === to) {
            alert('Urutan asal dan tujuan sama.');
            return;
        }

        // Ambil item dari posisi asal.
        const movingItem = items.splice(from - 1, 1)[0];

        // Masukkan item ke posisi tujuan.
        items.splice(to - 1, 0, movingItem);

        // Terapkan urutan baru ke tampilan playlist.
        items.forEach(function (item) {
            playlistItems.appendChild(item);
        });

        // Perbarui nomor dan tandai perubahan belum disimpan.
        updatePlaylistNumbers();
        markChanged();

        moveFromInput.value = '';
        moveToInput.value = '';
    });


    /*
     * Tambahkan media ke playlist.
     */

    document.querySelectorAll('.add-media').forEach(function (button) {

        button.addEventListener('click', function () {

            const sourceId =
                this.dataset.sourceId;


            const item =
                createPlaylistItem(sourceId);


            if (!item) {
                return;
            }


            playlistItems.appendChild(item);


            updatePlaylistNumbers();

            markChanged();

        });

    });


    /*
     * Hapus item dari playlist.
     *
     * Yang dihapus hanya item playlist.
     * Source/media asli tidak disentuh.
     */

    playlistItems.addEventListener('click', function (event) {

        const button =
            event.target.closest('.remove-media');


        if (!button) {
            return;
        }


        const item =
            button.closest('.playlist-card');


        if (!item) {
            return;
        }


        item.remove();


        updatePlaylistNumbers();

        markChanged();

    });


        /*
     * Preview konten playlist.
     *
     * Event delegation digunakan agar:
     * - item lama dari database bisa preview
     * - item baru hasil Tambah juga bisa preview
     * - duplicate source tetap bisa preview
     */

     function showMediaPreview(media) {

    if (!media) {
        return;
    }

    const previewBody =
        document.getElementById('playlistPreviewBody');

    const previewTitle =
        document.getElementById('playlistPreviewTitle');

    const direktori =
        media.direktori;

    const type =
        media.typeFile;

    previewTitle.textContent =
        direktori.split('/').pop();

    previewBody.innerHTML = '';

    // ==========================================
    // GAMBAR
    // ==========================================

    if (type === 'images') {

        const img =
            document.createElement('img');

        img.src =
            "{{ asset('') }}" + direktori;

        img.alt =
            'Preview konten';

        img.style.display = 'block';
        img.style.maxWidth = '100%';
        img.style.maxHeight = '75vh';
        img.style.width = 'auto';
        img.style.height = 'auto';
        img.style.margin = '0 auto';

        previewBody.appendChild(img);

    }

    // ==========================================
    // VIDEO
    // ==========================================

    else if (type === 'video') {

        const video =
            document.createElement('video');

        video.src =
            "{{ asset('') }}" + direktori;

        video.autoplay = true;
        video.loop = true;
        video.muted = true;
        video.playsInline = true;
        video.controls = false;

        video.style.display = 'block';
        video.style.maxWidth = '100%';
        video.style.maxHeight = '75vh';
        video.style.width = 'auto';
        video.style.height = 'auto';
        video.style.margin = '0 auto';
        video.style.background = '#000';

        previewBody.appendChild(video);

    }

    // ==========================================
    // YOUTUBE
    // ==========================================

    else if (type === 'youtube') {

        const videoId =
            extractPlaylistYouTubeId(direktori);

        if (!videoId) {

            previewBody.innerHTML =
                '<div class="alert alert-danger">' +
                'Link YouTube tidak valid.' +
                '</div>';

        } else {

            const iframe =
                document.createElement('iframe');

            iframe.src =
                'https://www.youtube.com/embed/' +
                videoId +
                '?autoplay=1&mute=1&playsinline=1&rel=0';

            iframe.title =
                'Preview YouTube';

            iframe.frameBorder = '0';

            iframe.allow =
                'autoplay; encrypted-media; picture-in-picture';

            iframe.allowFullscreen = true;

            iframe.style.width = '100%';
            iframe.style.height = '70vh';

            previewBody.appendChild(iframe);

        }

    }

    // ==========================================
    // TIPE TIDAK DIKENAL
    // ==========================================

    else {

        previewBody.innerHTML =
            '<div class="alert alert-warning">' +
            'Jenis konten tidak dikenali.' +
            '</div>';

    }

    $('#playlistPreviewModal').modal('show');
}

    playlistItems.addEventListener('click', function (event) {

    const mediaTitle =
        event.target.closest('.media-title');

    if (!mediaTitle) {
        return;
    }

    event.preventDefault();
    event.stopPropagation();

    const item =
        mediaTitle.closest('.playlist-card');

    if (!item) {
        return;
    }

    const sourceId =
        Number(item.dataset.sourceId);

    const media =
        getMedia(sourceId);

    if (!media) {
        return;
    }

    showMediaPreview(media);

});

const availableMedia =
    document.getElementById('availableMedia');

if (availableMedia) {

    availableMedia.addEventListener('click', function (event) {

        const mediaTitle =
            event.target.closest('.media-preview-trigger');

        if (!mediaTitle) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const sourceId =
            Number(mediaTitle.dataset.sourceId);

        const media =
            getMedia(sourceId);

        if (!media) {
            return;
        }

        showMediaPreview(media);

    });

}

    /*
     * Drag & drop playlist.
     */

    if (playlistItems) {

        new Sortable(playlistItems, {

            animation: 150,

            handle: '.drag-handle',

            ghostClass: 'sortable-ghost',

            onEnd: function () {

                updatePlaylistNumbers();

                markChanged();

            }

        });

    }


    /*
     * Tombol simpan.
     *
     * BELUM melakukan penyimpanan database.
     *
     * Sengaja hanya memberi informasi bahwa
     * backend belum diaktifkan.
     */

    saveButton.addEventListener('click', function () {

        const items =
            Array.from(
                playlistItems.querySelectorAll('.playlist-card')
            ).map(function (item) {

                return Number(item.dataset.sourceId);

            });


        if (items.length === 0) {

            alert('Playlist masih kosong.');

            return;

        }


        saveButton.disabled = true;

        saveButton.innerHTML =
            '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';


        fetch(
            '{{ route('displayPlaylist.save', $group->name) }}',
            {
                method: 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'Accept': 'application/json',

                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                },

                body: JSON.stringify({

                    items: items

                })

            }
        )

        .then(async function (response) {

            const text = await response.text();

            console.log('Save playlist response:', response.status, text);

            try {

                return JSON.parse(text);

            } catch (error) {

                throw new Error(
                    'Server mengembalikan response yang bukan JSON: ' +
                    text.substring(0, 500)
                );

            }

        })

        .then(function (result) {

            if (result.success) {

                document.getElementById('playlistResultIcon').innerHTML =
                    '<i class="fas fa-check"></i>';

                document.getElementById('playlistResultIcon').style.background =
                    '#d4edda';

                document.getElementById('playlistResultIcon').style.color =
                    '#28a745';

                document.getElementById('playlistResultTitle').textContent =
                    'Playlist Berhasil Disimpan';

                document.getElementById('playlistResultMessage').textContent =
                    result.message || 'Urutan playlist berhasil disimpan.';

                saveButton.disabled = true;

                const saveStatus = document.getElementById('playlistSaveStatus');

                if (saveStatus) {
                    saveStatus.className = 'text-success small';
                    saveStatus.innerHTML =
                        '<i class="fas fa-check-circle mr-1"></i> ' +
                        'Urutan playlist tersimpan.';
                }

                saveButton.innerHTML =
                    '<i class="fas fa-save mr-1"></i> Simpan Urutan';


                $('#playlistResultModal').modal('show');

            } else {

                document.getElementById('playlistResultIcon').innerHTML =
                    '<i class="fas fa-exclamation"></i>';

                document.getElementById('playlistResultIcon').style.background =
                    '#f8d7da';

                document.getElementById('playlistResultIcon').style.color =
                    '#dc3545';

                document.getElementById('playlistResultTitle').textContent =
                    'Gagal Menyimpan Playlist';

                document.getElementById('playlistResultMessage').textContent =
                    result.message ||
                    'Gagal menyimpan playlist.';


                saveButton.disabled = false;

                saveButton.innerHTML =
                    '<i class="fas fa-save mr-1"></i> Simpan Urutan';


                $('#playlistResultModal').modal('show');

            }

        })

        .catch(function (error) {

    console.error(error);

    document.getElementById('playlistResultIcon').innerHTML =
        '<i class="fas fa-exclamation"></i>';

    document.getElementById('playlistResultIcon').style.background =
        '#f8d7da';

    document.getElementById('playlistResultIcon').style.color =
        '#dc3545';

    document.getElementById('playlistResultTitle').textContent =
        'Terjadi Kesalahan';

    document.getElementById('playlistResultMessage').textContent =
        'Terjadi kesalahan saat menyimpan playlist.';

    saveButton.disabled = false;

    saveButton.innerHTML =
        '<i class="fas fa-save mr-1"></i> Simpan Urutan';

    $('#playlistResultModal').modal('show');

});

    });


    /*
     * Initial state.
     */

    updatePlaylistNumbers();

});

</script>

{{-- ============================================================= --}}
{{-- PLAYLIST RESULT MODAL --}}
{{-- ============================================================= --}}

<div class="modal fade"
     id="playlistResultModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="playlistResultModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered"
         role="document">

        <div class="modal-content playlist-result-modal">

            <div class="modal-body text-center p-4">

                <div id="playlistResultIcon"
                     class="playlist-result-icon">

                    <i class="fas fa-check"></i>

                </div>


                <h5 id="playlistResultTitle"
                    class="mt-3 mb-2">

                    Playlist Berhasil Disimpan

                </h5>


                <p id="playlistResultMessage"
                   class="text-muted mb-4">

                    Urutan playlist berhasil disimpan.

                </p>


                <button type="button"
                        class="btn btn-primary px-4"
                        data-dismiss="modal">

                    Oke

                </button>

            </div>

        </div>

    </div>

</div>


<!-- ==========================================
     MODAL PREVIEW PLAYLIST
========================================== -->

<div class="modal fade"
     id="playlistPreviewModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="playlistPreviewTitle"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered"
         role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"
                    id="playlistPreviewTitle">
                    Preview Konten
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body text-center"
                 id="playlistPreviewBody"
                 style="min-height: 200px;">

            </div>

        </div>

    </div>

</div>

@endsection
