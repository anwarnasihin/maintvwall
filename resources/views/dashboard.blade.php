@extends('layouts.master')
@section('title.home', 'Dashboard TV Wall')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Inter:wght@400;700&display=swap');

    .dashboard-container {
        background-image: linear-gradient(rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), url('assets/dist/img/virtual background - bekasi-04.png');
        background-size: cover;
        min-height: 90vh;
        border-radius: 15px;
        padding: 20px;
    }

    /* Jam & Tanggal Mini (Atas) */
    .top-info-bar {
        display: flex;
        justify-content: center;
        gap: 30px;
        background: rgba(139, 0, 0, 0.1);
        padding: 10px;
        border-radius: 50px;
        backdrop-filter: blur(5px);
        margin-bottom: 20px;
    }

    #clock-digital {
        font-family: 'Orbitron', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: #8B0000;
    }

    #date-digital {
        font-family: 'Orbitron', sans-serif;
        font-size: 18px;
        color: #333;
        padding-top: 5px;
    }

    /* Preview Area (Tengah) */
    .preview-container {
    background: rgba(0, 0, 0, 0.05);
    border: 2px dashed rgba(139, 0, 0, 0.3);
    border-radius: 20px;
    width: 65% !important; /* Perkecil sedikit lagi dari 65% ke 60% */
    margin: 0 auto 25px auto !important; /* Kurangi margin bawah dari 15px ke 5px */
    aspect-ratio: 16 / 9;
    /* HAPUS baris height: 500px di sini! */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    backdrop-filter: blur(5px);
}
    /* Pastikan gambar/video di dalamnya mengikuti ukuran container baru */
    .preview-container img,
    .preview-container video {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Agar konten tidak terpotong saat diperkecil */
    }

    /* Mengurangi padding di area dashboard agar icon lebih rapat ke atas */
    .content-wrapper {
        padding-top: 10px !important;
    }

    /* 2. Sesuaikan Statistik agar Mepet ke Bawah */
    .row.mt-3 {
    /* Dari -40px atau -50px, kita coba turunkan ke -15px atau -20px saja */
    margin-top: -20px !important;
    position: relative;
    z-index: 10;
}

    .preview-label {
        position: absolute;
        top: 10px;
        left: 20px;
        background: #8B0000;
        color: white;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    /* Modern Glassmorphism Stats Box */
    .col-5ths {
        flex: 0 0 20%;
        max-width: 20%;
        padding: 10px;
    }

    .content {
        padding-top: 0 !important;
    }

    .small-box {
        border-radius: 12px !important;
        position: relative;
        display: block;
        margin-bottom: 10px !important; /* Perkecil margin antar box */
        padding: 5px 0 !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3) !important;
        overflow: hidden;
        color: #fff !important;
        min-height: 100px; /* Perkecil tinggi box sedikit agar hemat ruang */
        transition: all 0.3s ease-in-out;
    }

    /* Memperkecil ukuran angka (h3) */
    .small-box h3 {
        font-size: 1.5rem !important; /* Dari ukuran default yang besar */
        font-weight: 700;
        margin: 0 0 5px 0 !important;
    }

    /* Memperkecil teks keterangan di bawah angka */
    .small-box p {
        font-size: 0.8rem !important;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* INI EFEK SHADOW HITAM GRADASI DI DALAM BOX */
    .small-box::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30%;
        background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
        z-index: 1;
    }

    .small-box .inner h4 {
        font-size: 1.8rem; /* Ukuran angka disesuaikan */
        font-weight: 800;
        margin: 0;
    }

    .small-box .inner p {
        font-size: 14px; /* Ukuran teks keterangan diperkecil */
        font-weight: 600;
        text-transform: uppercase;
    }

    .small-box .inner {
    padding: 8px 12px; /* Lebih kecil dari 12px 15px */
    position: relative;
    z-index: 5;
}

    /* MODIFIKASI IKON AGAR LEBIH KEREN */
    .small-box .icon {
        position: absolute;
        top: 5px;
        right: 10px;
        z-index: 2;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        opacity: 0.25;
    }

    .small-box .icon > i {
        font-size: 40px !important; /* Ukuran ikon disesuaikan dengan box yang lebih kecil */
        filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.2));
        top: 10px !important;
    }

    /* EFEK SAAT DI-HOVER */
    .small-box:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 30px rgba(0,0,0,0.5) !important;
    }

    .small-box:hover .icon {
        top: -15px; /* Ikon naik lebih tinggi */
        opacity: 0.5;
        transform: rotate(-10deg); /* Kasih efek miring dikit biar dinamis */
    }
</style>

<section class="content">
    <div class="container-fluid pt-2">
        <div class="card-body dashboard-container text-center">

            <div class="top-info-bar mx-auto" style="max-width: 500px;">
                <div id="clock-digital">00:00:00</div>
                <div id="date-digital"></div>
            </div>

           <div class="preview-container shadow-inner">
    <span class="preview-label">LIVE PREVIEW CONTENT</span>

    @if(count($files) > 0)
        @foreach($files as $key => $file)
            <div class="mySlides fade-animation" style="display: {{ $key == 0 ? 'block' : 'none' }}; height: 100%; width: 100%;">
                @if($file->typeFile == 'images')
                    <img src="{{ asset($file->direktori) }}" style="height: 100%; width: 100%; object-fit: contain;">
                @elseif($file->typeFile == 'video')
                    <video src="{{ asset($file->direktori) }}" autoplay muted loop style="height: 100%; width: 100%; object-fit: contain;"></video>
                @endif
            </div>
        @endforeach
    @else
        <div class="text-center text-muted">
            <i class="fas fa-tv fa-4x mb-3" style="opacity: 0.2;"></i>
            <p>Standby: Tidak ada jadwal tayang saat ini.</p>
        </div>
    @endif
</div>

{{-- CSS Tambahan untuk Animasi Fade --}}
<style>
    .fade-animation {
        animation: fadeEffect 1.5s;
    }

    @keyframes fadeEffect {
        from {opacity: .4}
        to {opacity: 1}
    }
</style>

<script>
    let slideIndex = 0;
    const slides = document.getElementsByClassName("mySlides");

    if (slides.length > 0) {
        showSlides();
    }

    function showSlides() {
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}

        let currentSlide = slides[slideIndex-1];
        currentSlide.style.display = "block";

        // --- LOGIKA DURASI DINAMIS ---
        let duration = 5000; // Default 5 detik untuk gambar

        // Cek apakah di dalam slide ini ada elemen video
        let video = currentSlide.querySelector('video');

        if (video) {
            video.currentTime = 0; // Ulang video dari awal setiap slide muncul
            video.play();

            // Atur durasi slide show sesuai durasi video (dalam milidetik)
            // Kita kasih limit maksimal misal 30 detik supaya tidak kelamaan kalau videonya panjang banget
            duration = video.duration ? (video.duration * 1000) : 15000;
        }

        setTimeout(showSlides, duration);
    }
</script>

            <div class="row mt-3">
                @php
                    $stats = [
                        [
                            'count' => $totalUsers,
                            'label' => 'Users',
                            'icon' => 'fas fa-users',
                            'bg' => 'bg-info',
                            'url' => route('admin.users.index') // Sesuaikan nama route user kamu
                        ],
                        [
                            'count' => $totalImages,
                            'label' => 'Images',
                            'icon' => 'fas fa-image',
                            'bg' => 'bg-success',
                            'url' => route('datafile') // Di sini kamu bisa arahkan ke halaman filter image jika ada
                        ],
                        [
                            'count' => $totalVideos,
                            'label' => 'Videos',
                            'icon' => 'fas fa-video',
                            'bg' => 'bg-warning',
                            'url' => route('datafile') // Arahkan ke menu Data Video
                        ],
                        [
                            'count' => $totalTexts,
                            'label' => 'Texts',
                            'icon' => 'fas fa-font',
                            'bg' => 'bg-danger',
                            'url' => route('datatext') // Arahkan ke menu Add Text
                        ],
                        [
                            'count' => $totalGroups,
                            'label' => 'Groups',
                            'icon' => 'fas fa-layer-group',
                            'bg' => 'bg-primary',
                            'url' => route('datagroup') // Arahkan ke menu Add Group
                        ],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="col-5ths">
                        <a href="{{ $stat['url'] }}" style="text-decoration: none; display: block;">
                            <div class="small-box {{ $stat['bg'] }}">
                                <div class="inner">
                                    <h4>{{ $stat['count'] }}</h4>
                                    <p>{{ $stat['label'] }}</p>
                                </div>
                                <div class="icon">
                                    <i class="{{ $stat['icon'] }}"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
            </div>

        </div>
    </div>
</section>

<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('clock-digital').textContent = now.toLocaleTimeString('id-ID');
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        document.getElementById('date-digital').textContent = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection
