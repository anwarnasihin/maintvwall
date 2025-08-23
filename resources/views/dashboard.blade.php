@extends('layouts.master')
@section('title.home')
@section('content')

{{-- Gaya jam keren dengan Orbitron + efek glow --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&display=swap');

    #clock-digital {
        margin-top: 20px;
        font-size: 64px;
        font-weight: 700;
        font-family: 'Orbitron', sans-serif;
        color:rgb(99, 0, 0);
    }

    #date-digital {
        font-weight: 700;
        font-family: 'Orbitron', sans-serif;
        color: rgb(99, 0, 0);
    }
</style>

<section class="content">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body" style="position: relative; background-image: url('assets/dist/img/virtual background - bekasi-04.png'); background-size: cover; background-repeat: no-repeat; min-height: 45em; text-align: center;">

            {{-- Teks Welcome --}}
            <h2 style="font-size: 30px; font-weight: bold; color: #007BFF; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                <span style="color: #007BFF; opacity: 0.8;">Welcome to the </span>
                <span style="color: #FF5733;">BINUS @Bekasi TV Wall</span>
                <span style="opacity: 0.8;">Application</span>
            </h2>

            {{-- Logo --}}
            <img src="assets/dist/img/Road-To-45.png" alt="Logo Road To 45" style="display: block; margin: 0 auto;" width="175" height="185">

            {{-- JAM DIGITAL --}}
            <div id="clock-digital">00:00:00 AM</div>
            <div id="date-digital" style="font-size: 30px;"></div>

            <style>
    /* Box dengan background transparan */
    .small-box.bg-info {
        background-color: rgba(23, 162, 184, 0.8) !important;
    }
    .small-box.bg-success {
        background-color: rgba(40, 167, 69, 0.8) !important;
    }
    .small-box.bg-warning {
        background-color: rgba(255, 193, 7, 0.8) !important;
    }
    .small-box.bg-danger {
        background-color: rgba(220, 53, 69, 0.8) !important;
    }
    .small-box.bg-primary {
        background-color: rgba(0, 123, 255, 0.8) !important;
    }


    /* Teks angka besar */
.small-box .inner h3 {
    color: #fff !important;
    font-size: 70px !important; /* ukuran angka */
    font-weight: bold;
}

/* Teks keterangan lebih kecil */
.small-box .inner p {
    color: #fff !important;
    font-size: 16px !important; /* ukuran teks bawah */
}


    /* Icon per box → warna bisa beda */
    .small-box.bg-info .icon i {
        color: #198b9e; /* warna box */
        font-size: 60px !important; /*size icon di box*/
    }
    .small-box.bg-success .icon i {
        color: #278f42; /* warna box */
        font-size: 60px !important; /*size icon di box*/
    }
    .small-box.bg-warning .icon i {
        color: #d3a311; /* warna box */
        font-size: 60px !important; /*size icon di box*/
    }
    .small-box.bg-danger .icon i {
        color: #920616; /* warna box */
        font-size: 60px !important; /*size icon di box*/
    }
    .small-box.bg-primary .icon i {
        color: #04478f; /* warna box */
        font-size: 60px !important; /*size icon di box*/
    }

    /* Style posisi & ukuran icon */
    .small-box .icon {
        font-size: 40px;
        right: 10px;
        top: 10px;
    }
</style>

            {{-- STATISTIK --}}
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mt-5"> {{-- g3 disana untuk mengatur jarak antar box, semakin besar angkanya maka akan semakin lebar jaraknya--}}
                    <div class="col">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalUsers }}</h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalImages }}</h3>
                                <p>Total Images</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $totalVideos }}</h3>
                                <p>Total Videos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totalTexts }}</h3>
                                <p>Total Texts</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-font"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $totalGroups }}</h3>
                                <p>Total Groups</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>
                    </div>

                </div>

        </div>
    </div>
</section>

{{-- SCRIPT JAM DIGITAL --}}
<script>
    function updateClock() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12;
        hours = hours ? hours : 12;

        document.getElementById('clock-digital').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;

        const day = String(now.getDate()).padStart(2, '0');
        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const month = monthNames[now.getMonth()];
        const year = now.getFullYear();

        document.getElementById('date-digital').textContent = `${day} ${month} ${year}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection
