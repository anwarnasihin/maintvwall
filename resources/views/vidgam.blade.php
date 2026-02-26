<!DOCTYPE html>
<html>
{{-- otomatis melakukan penyegaran data setiap satu jam --}}
<meta http-equiv="refresh" content="3600">
<head>
    <title>TV Wall BINUS@BEKASI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    /* --- 1. LAYOUT DASAR --- */
    body {
        margin: 0; padding: 0;
        width: 100vw; height: 100vh;
        /* background-color: #000; */
        background-color: transparent;
        /* background-image: url('/logo/bg8.jpg'); */
        background-image: none;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        font-family: "Segoe UI", Arial, sans-serif; /* Font Standar Bersih */
    }

    /* --- 2. AREA KONTEN (ATAS) --- */
    #main-content {
        flex-grow: 1;
        position: relative;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        z-index: 10;
    }

    #player {
        width: 100%; height: 100%;
        display: flex; justify-content: center; align-items: center;
        transition: opacity 0.5s ease-in-out;
        opacity: 1;
    }
    #player.fade-out { opacity: 0; }

    #player img, #player video {
        max-width: 100%; max-height: 100%;
        width: auto; height: auto;
        object-fit: contain;
        filter: drop-shadow(0 0 10px rgba(0,0,0,0.5));
    }

    #youtube-player { width: 100%; height: 100%; }

    .no-content {
        font-size: 24px; color: white;
        background: rgba(0, 0, 0, 0.6);
        padding: 20px; border-radius: 10px; text-align: center;
    }

    /* --- 3. FOOTER GEOMETRIS (FIXED RAPI) --- */
    footer {
        height: 45px;
        width: 100%;
        background: transparent;
        display: flex;
        align-items: center;
        z-index: 9999;
        flex-shrink: 0;
        overflow: hidden;
        position: relative;
        box-shadow: 0 -8px 15px rgba(0, 0, 0, 0.2);
    }

    /* --- KOTAK PEMBUNGKUS JAM (WARNA KUNING) --- */
    #date-time {
        /* Supaya Kotak Kuning ada di atas Kotak Biru */
        z-index: 20;
        position: relative;

        /* Bikin Miring Kotaknya */
        transform: skewX(-30deg);
        background: linear-gradient(180deg, #F9AF2D 0%,  #F2E313 100%);

        /* Pengaturan Tata Letak */
        height: 100%;
        display: flex;
        align-items: center;

        /* --- BAGIAN PENTING: BIAR RAPAT KIRI --- */
        /* Ini kuncinya Boss. Kita paksa tulisannya nempel ke kiri (awal) */
        justify-content: flex-start;

        /* Hapus jarak otomatis bawaan komputer */
        gap: 0px;

        /* Jarak dalam kotak (Kiri 40, Kanan 20) */
        padding: 0 20px 0 40px;
        margin-left: -20px;

        /* Dekorasi Garis & Bayangan Hitam */
        border-right: 5px solid #fff;
        outline: 5px solid #F2E313;
        box-shadow: 4px 4px 0px #000000;

        /* Warna Tulisan "," */
        /* color: #061e5c !important; */
        font-weight: 800;
        font-size: 20px;

        /* Tulisan Dilarang Turun Baris */
        white-space: nowrap;

        /*Text Shadow*/
        text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.8);
    }

    /* --- PENGATURAN TULISAN (HARI, TANGGAL, JAM) --- */
    #date-time span, #day, #date, #time, #date-time div {
        /* Tegakkan tulisan biar gak miring */
        transform: skewX(30deg);
        display: inline-block;

        /* Jenis Huruf */
        font-family: "Segoe UI", Arial, sans-serif;

        /* Warna text date (Wajib) */
        color: #061e5c !important;
        font-weight: 800;
        font-style: normal;
        text-shadow: none;

        /* NOL-KAN SEMUA JARAK (Biar kita atur sendiri di bawah) */
        margin: 0px !important;
        padding: 0px !important;

        /*Text hari, tanggal, bulan tahun & waktu Shadow*/
        text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.8);

    }

    /* --- ATUR JARAK SENDIRI DI SINI BOSS --- */

    /* 1. Pengaturan Jarak "Minggu," ke Angka "8" */
    #day {
        /* Ubah angka 3px ini. */
        /* Kalau mau nempel banget, ganti jadi 0px */
        margin-right: -10px !important;
    }

    /* 2. Pengaturan Jarak "2026" ke Jam "07:00" */
    #date {
        /* Saya kasih jarak 15px biar TANGGAL dan JAM tidak dempetan */
        margin-right: 0px !important;
    }
    /* --- KOTAK RUNNING TEXT (BIRU) --- */
    .marquee-wrapper {
        z-index: 10;
        transform: skewX(-30deg);
        background: linear-gradient(180deg, #2b52b9 0%,  #0077d4 100%); //Warna gradiasi

        flex-grow: 1;
        height: 100%;
        display: flex;
        align-items: center;
        overflow: hidden;

        margin-left: 15px;
        width: 105%;
        margin-right: -20px;
        box-shadow: inset 10px 0 20px rgba(0,0,0,0.2);
    }

    /* --- PERBAIKAN RUNNING TEXT (TEGAK) --- */
    .marquee-content {
        transform: skewX(30deg); /* Balikin Tegak */
        display: inline-block;

        position: absolute;
        white-space: nowrap;
        will-change: transform;

        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 20px;
        font-weight: 700;
        font-style: normal;      /* HAPUS MIRING */
        color: #fff;

        text-shadow: 2px 2px 5px rgba(0,0,0,0.8);
        line-height: 45px;
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }

   /* Animasi Marquee - Perbaikan Jarak Tempuh */
@keyframes marquee-animation {
    0%   {
        left: 100%;
        transform: skewX(30deg);
    }
    100% {
        /* Ganti ke -200% atau lebih supaya teks sepanjang apapun pasti hilang dulu */
        left: -250%;
        transform: skewX(30deg);
    }
}
</style>

</head>

<body>
{{-- BG VIDEO --}}
    <video autoplay muted loop id="bg-video" style="
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
        z-index: -1; /* Supaya di belakang konten */
        object-fit: cover;
    ">
        <source src="{{ asset('logo/player1.mp4') }}" type="video/mp4">
    </video>

    <div id="main-content">
        <div id="player">
            <div class="no-content">Memuat Konten...</div>
        </div>
    </div>

    <footer>
        <div id="date-time">
            <span id="day"></span>
            <span id="date"></span>
            <span id="time"></span>
        </div>

        <div class="marquee-wrapper">
            <div id="running-text" class="marquee-content">
                Loading Text...
            </div>
        </div>
    </footer>

    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script>
        // --- DATA SETUP ---
        var data = @json($files);
        var groupName = "{{ $group }}";
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var currentData = 0;
        var player = document.getElementById("player");

        // TARUH DI SINI BARIS BARUNYA:
        var pendingTexts = null;

        $(document).ready(function() {
            updateDateTime();
            setInterval(updateDateTime, 1000); // Jam jalan terus

            // Start Player
            if (data && data.length > 0) {
                playVideoAndImage();
            } else {
                refreshContent(true); // Kalo kosong, pancing request ke server
            }

            // Start Running Text
            refreshContent(true);

            // Detektif yang menunggu teks sampai hilang dari layar
            document.getElementById('running-text').addEventListener('animationiteration', function() {
                if (pendingTexts !== null) {
                    console.log("Teks sudah hilang di ujung kuning, sekarang saatnya update data baru!");
                    updateRunningText(pendingTexts);
                    pendingTexts = null; // Kosongkan gudang setelah dipakai
                }
            });
        });

        // --- FUNGSI UTAMA: PLAYER (DENGAN TRANSISI) ---
        function playVideoAndImage() {
            if (data && data.length > 0) {
                // Sainty Check: Kalau index kebablasan, reset ke 0
                if (currentData >= data.length) currentData = 0;

                var media = data[currentData];
                var playerDiv = document.getElementById("player");

                // 1. EFEK FADE OUT (Layar Merenup)
                playerDiv.classList.add("fade-out");

                // 2. TUNGGU 0.5 DETIK (Sesuai CSS), BARU GANTI KONTEN
                setTimeout(function() {

                    playerDiv.innerHTML = ""; // Bersihkan konten lama

                    // --- LOGIC PATH ---
                    var rawPath = media.directory || media.direktori;
                    var finalPath = "";
                    if (rawPath.includes('assets/')) {
                        finalPath = '/' + rawPath;
                    } else {
                        if (media.typeFile === "video") finalPath = '/assets/video/' + rawPath;
                        else finalPath = '/assets/images/' + rawPath;
                    }

                    console.log("Playing [" + (currentData+1) + "/" + data.length + "]:", finalPath);

                    // A. VIDEO
                    if (media.typeFile === "video") {
                        var vid = document.createElement("video");
                        vid.src = finalPath;
                        vid.muted = false;      // Wajib mute
                        vid.autoplay = true;   // Auto play
                        vid.controls = false;  // Tombol hilang
                        vid.loop = false;      // Video JANGAN looping sendiri, biar logic kita yg handle nextContent
                        vid.style.width = "100%";
                        vid.style.height = "100%";

                        // Kalo video selesai -> Pindah konten
                        vid.onended = function() { nextContent(); };
                        vid.onerror = function() { nextContent(); };

                        playerDiv.appendChild(vid);
                        var promise = vid.play();
                        if (promise !== undefined) promise.catch(error => {});
                    }
                    // B. IMAGE
                    else if (media.typeFile === "images") {
                        var img = document.createElement("img");
                        img.src = finalPath;
                        img.onerror = function() { nextContent(); };
                        playerDiv.appendChild(img);

                        // Durasi Gambar
                        var duration = media.duration > 0 ? media.duration : 10000;
                        setTimeout(function() { nextContent(); }, duration);
                    }
                    // C. YOUTUBE
                    else if (media.typeFile === "youtube") {
                        var divYT = document.createElement('div');
                        divYT.id = 'youtube-player';
                        playerDiv.appendChild(divYT);

                        var videoCode = getYoutubeId(media.direktori);
                        new YT.Player('youtube-player', {
                            height: '100%', width: '100%', videoId: videoCode,
                            playerVars: { 'autoplay': 1, 'controls': 0, 'mute': 1 },
                            events: { 'onStateChange': function(e) { if (e.data === YT.PlayerState.ENDED) nextContent(); } }
                        });
                    }

                    // 3. EFEK FADE IN (Muncul Perlahan)
                    setTimeout(function() {
                        playerDiv.classList.remove("fade-out");
                    }, 50);

                }, 500); // Waktu tunggu Fade Out (0.5 Detik)

            } else {
                // Data Kosong
                player.innerHTML = '<div class="no-content">Tidak ada jadwal tayang.<br>('+ getCurrentTime() +')</div>';
                setTimeout(function(){ refreshContent(); }, 5000);
            }
        }

        // --- FUNGSI NEXT (LOGIKA LOOPING DIPERBAIKI DISINI) ---
        function nextContent() {
            currentData++; // Pindah ke nomor selanjutnya

            // Cek apakah sudah melebihi jumlah data?
            if (currentData >= data.length) {
                console.log("Playlist Selesai. Looping ke awal (Nomor 1)...");

                // 1. RESET KE AWAL
                currentData = 0;

                // 2. MAINKAN NOMOR 1 SEKARANG JUGA
                playVideoAndImage();

                // 3. CEK UPDATE DIAM-DIAM
                refreshContent(false);
            } else {
                // Belum habis, lanjut mainkan next
                playVideoAndImage();
            }
        }

        // --- FUNGSI UPDATE DATA SERVER ---
        function refreshContent(isFirstLoad = false) {
    $.ajax({
        type: 'POST',
        url: '/getContent',
        data: { _token: csrfToken, group: groupName },
        success: function(response) {
            var newData = response[0];
            var newTexts = response[1];

            // --- 1. LOGIKA PLAYER VIDEO/IMAGE (Tetap Sama) ---
            if (JSON.stringify(newData) !== JSON.stringify(data)) {
                console.log("Ada Data Baru! Update Playlist.");
                data = newData;
                if (isFirstLoad || currentData >= data.length) {
                    currentData = 0;
                    playVideoAndImage();
                }
            } else if (isFirstLoad && (!data || data.length === 0)) {
                data = newData;
                playVideoAndImage();
            }

            // --- 2. LOGIKA RUNNING TEXT (PERUBAHAN DI SINI) ---
            if (newTexts) {
                if (isFirstLoad) {
                    // Kalau baru pertama kali buka, langsung tampilkan saja Booss
                    updateRunningText(newTexts);
                } else {
                    // Kalau sedang jalan, simpan di gudang.
                    // Biarkan si "Detektor Selesai" yang mengeksekusinya nanti
                    pendingTexts = newTexts;
                }
            }
        }
    });
}

       // --- ANIMASI RUNNING TEXT (VERSI STABIL) ---
function updateRunningText(texts) {
    var textContainer = $('#running-text');
    var fullString = "";

    // 1. Gabung teks
    texts.forEach(function(item) {
        fullString += item.deskripsi + " &nbsp; | &nbsp; ";
    });

    if(fullString === "") fullString = "Selamat Datang di BINUS University @Bekasi";

    // 2. Hanya update jika benar-benar ada perubahan isi
    if (textContainer.html().trim() !== fullString.trim()) {

        // Pasang teks baru
        textContainer.html(fullString);

        // Beri waktu 100ms agar browser selesai menghitung lebar teks
        setTimeout(function() {
            var textWidth = textContainer.width();
            var wrapperWidth = $('.marquee-wrapper').width();

            // Gunakan pembagi 60 agar kecepatan pas dan stabil
            var duration = (textWidth + wrapperWidth) / 60;

            // Matikan dan nyalakan lagi secara instan
            textContainer.css('animation', 'none');

            // Trigger reflow agar 'animation: none' benar-benar tereksekusi
            void textContainer[0].offsetWidth;

            textContainer.css({
                'animation': `marquee-animation ${duration}s linear infinite`
            });
        }, 100);
    }
}

        // --- HELPER ---
        function getYoutubeId(url) {
            var match = url.match(/(?:v=|\/live\/|\/embed\/)([a-zA-Z0-9_-]{11})/);
            return (match && match[1]) ? match[1] : url;
        }
        function getCurrentTime() {
            var now = new Date();
            return String(now.getHours()).padStart(2,'0') + ":" + String(now.getMinutes()).padStart(2,'0');
        }
       function updateDateTime() {
            const now = new Date();
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            const timeString = String(now.getHours()).padStart(2,'0') + ":" + String(now.getMinutes()).padStart(2,'0') + ":" + String(now.getSeconds()).padStart(2,'0');
            const dateString = now.getDate() + " " + months[now.getMonth()] + " " + now.getFullYear() + ",&nbsp;";

            // --- PERBAIKAN DI SINI ---
            // cuma menampilkan Nama Hari saja.
            $("#day").html(days[now.getDay()] + ",&nbsp;");
            $("#date").html(dateString);
            $("#time").text(timeString);
        }
    </script>
</body>
</html>
