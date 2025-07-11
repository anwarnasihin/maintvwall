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
        color:rgb(99, 0, 0); /* Biru neon */
        
    }

    #date-digital {
    font-weight: 700;
    font-family: 'Orbitron', sans-serif; /* Gunakan font yang sama dengan jam */
    color: rgb(99, 0, 0); /* Warna yang sama dengan jam */
}
</style>

<section class="content">
    <section class="content-header">
        <div class="container-fluid">
        </div>
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
            
            <h2 class="card-body" style="font-size: 30px; font-weight: bold; color: #007BFF; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                <span style="color: #007BFF; opacity: 0.8;">Welcome to the </span>
                <span style="color: #FF5733;">BINUS @Bekasi TV Wall</span>
                <span style="opacity: 0.8;">Application</span>
            </h2>

            <img src="assets/dist/img/Road-To-45.png" alt="Logo Road To 45" style="display: block; margin: 0 auto;" width="175" height="185">

            {{-- JAM DIGITAL DI BAWAH LOGO --}}
            <div id="clock-digital">00:00:00 AM</div>
            <div id="date-digital" style="font-size: 30px; color: rgb(99, 0, 0);"></div>

        </div>
    </div>
</section>

{{-- SCRIPT JAM DIGITAL 12 JAM --}}
<script>
    function updateClock() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12;
        hours = hours ? hours : 12; // jam 0 jadi 12

        document.getElementById('clock-digital').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;

        // Tanggal, bulan, dan tahun dalam format "11 Juli 2025"
        const day = String(now.getDate()).padStart(2, '0');
        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const month = monthNames[now.getMonth()]; // Mendapatkan nama bulan
        const year = now.getFullYear();

        document.getElementById('date-digital').textContent = `${day} ${month} ${year}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection
