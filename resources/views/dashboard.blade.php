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

    /* Glassmorphism untuk Card Chart */
    .bg-light-glass {
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        transition: transform 0.3s ease;
    }
    .bg-light-glass:hover {
        transform: scale(1.02);
    }

    .small-box {
        border-radius: 12px !important;
        position: relative;
        display: block;
        margin-bottom: 10px !important;
        padding: 5px 0 !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3) !important;
        overflow: hidden;
        color: #fff !important;
        min-height: 100px;
        transition: all 0.3s ease-in-out;
    }

    .small-box h4 { font-size: 1.8rem; font-weight: 800; margin: 0; }
    .small-box p { font-size: 14px; font-weight: 600; text-transform: uppercase; }

    .small-box .inner { padding: 8px 12px; position: relative; z-index: 5; }

    .small-box .icon {
        position: absolute;
        top: 5px;
        right: 10px;
        z-index: 2;
        opacity: 0.25;
    }

    .small-box .icon > i { font-size: 40px !important; }

    .small-box:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 30px rgba(0,0,0,0.5) !important;
    }

    .col-5ths { flex: 0 0 20%; max-width: 20%; padding: 10px; }
</style>

<section class="content">
    <div class="container-fluid pt-2">
        <div class="card-body dashboard-container text-center">

            <div class="top-info-bar mx-auto" style="max-width: 500px;">
                <div id="clock-digital">00:00:00</div>
                <div id="date-digital"></div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-md-5">
                    <div class="card bg-light-glass p-3" style="border-radius: 20px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(139,0,0,0.2);">
                        <h5 class="text-bold" style="color: #8B0000; font-size: 14px;">SERVER STORAGE</h5>
                        <div style="width: 160px; margin: 0 auto;">
                            <canvas id="diskChart"></canvas>
                        </div>
                        <p class="mt-2 mb-0" style="font-weight: bold; color: #333;">
                            Used: {{ $usedDiskGB }}GB / {{ $totalDiskGB }}GB ({{ $diskPercent }}%)
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-light-glass p-3" style="border-radius: 20px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(139,0,0,0.2);">
                        <h5 class="text-bold" style="color: #8B0000; font-size: 14px;">SERVER HEALTH (RAM)</h5>
                        <div style="height: 160px;">
                            <canvas id="ramChart"></canvas>
                        </div>
                        <p class="mt-2 mb-0" style="font-weight: bold; color: #333;">
                            Load: {{ $usedRamGB }}GB / {{ $totalRamGB }}GB ({{ $memoryPercent }}%)
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                @php
                    $stats = [
                        ['count' => $totalUsers, 'label' => 'Users', 'icon' => 'fas fa-users', 'bg' => 'bg-info', 'url' => route('datausers')],
                        ['count' => $totalImages, 'label' => 'Images', 'icon' => 'fas fa-image', 'bg' => 'bg-success', 'url' => route('datafile')],
                        ['count' => $totalVideos, 'label' => 'Videos', 'icon' => 'fas fa-video', 'bg' => 'bg-warning', 'url' => route('datafile')],
                        ['count' => $totalTexts, 'label' => 'Texts', 'icon' => 'fas fa-font', 'bg' => 'bg-danger', 'url' => route('datatext')],
                        ['count' => $totalGroups, 'label' => 'Groups', 'icon' => 'fas fa-layer-group', 'bg' => 'bg-primary', 'url' => route('datagroup')],
                    ];
                @endphp

                @foreach($stats as $stat)
                <div class="col-5ths">
                    <a href="{{ $stat['url'] }}" style="text-decoration: none;">
                        <div class="small-box {{ $stat['bg'] }}">
                            <div class="inner">
                                <h4>{{ $stat['count'] }}</h4>
                                <p>{{ $stat['label'] }}</p>
                            </div>
                            <div class="icon"><i class="{{ $stat['icon'] }}"></i></div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('clock-digital').textContent = now.toLocaleTimeString('id-ID');
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        document.getElementById('date-digital').textContent = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Chart Disk
    new Chart(document.getElementById('diskChart'), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [{{ $diskPercent }}, {{ 100 - $diskPercent }}],
                backgroundColor: ['#ffc107', 'rgba(0,0,0,0.1)'],
                borderWidth: 0
            }]
        },
        options: { cutout: '80%', plugins: { tooltip: { enabled: false } } }
    });

    // Chart RAM
    new Chart(document.getElementById('ramChart'), {
        type: 'line',
        data: {
            labels: ['-4m', '-3m', '-2m', '-1m', 'Now'],
            datasets: [{
                label: 'RAM %',
                data: [40, 45, 42, 48, {{ $memoryPercent }}],
                borderColor: '#8B0000',
                fill: true,
                backgroundColor: 'rgba(139, 0, 0, 0.1)',
                tension: 0.4
            }]
        },
        options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true, max: 100 } } }
    });
</script>

@endsection
