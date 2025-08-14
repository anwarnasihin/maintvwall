<!DOCTYPE html>
<html>

<head>
    <title>TV Wall BINUS@BEKASI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-size: 100% auto;
            /* Lebar gambar mengisi seluruh lebar, tinggi mengikuti lebar gambar */
            background-repeat: no-repeat;
            /* Agar gambar tidak diulang */
            background-image: url('/logo/backVidGram.jpg');

            /* new */
            color: #fff;
            font-family: "Segoe UI", Arial, sans-serif;
            font-weight: bold;
            font-size: 24px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        #container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        #player {
            width: 100%;
            height: calc(100% - 40px);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: width 0.5s, height 0.5s, background-color 0.5s;
        }

        /* new */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            /* fallback color */
            background-color: #001477;

            /* gradiasi */
            background: linear-gradient(90deg, #006496, #008ED3, #F2E313);

            padding: 4px 0;
            display: flex;
            justify-content: space-between;
            align-items: center; /* biar teks pas di tengah */
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            color: #fff;
        }

        #player.transition {
            width: 100%;
            height: 100%;
            background-color: white;
        }

        #player img {
            max-width: 100%;
            max-height: calc(100% - 28px);
            /* 28px adalah tinggi dari runningTextContainer dan paddingnya */
            width: auto;
            height: auto;
        }

        #player video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: calc(100% - 40px);
            /* 40px adalah tinggi "running text" termasuk padding */
        }


        #youtube-player {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Mengatur tinggi gambar berdasarkan lebar layar */
        @media screen and (max-width: 768px) {
            #player img {
                height: 100vh;
                width: auto;
            }
        }

        @media screen and (min-width: 769px) {
            #player img {
                max-height: 100%;
                /* height: auto; */
                height: 100%;
            }
        }

        /* new */
        #running-text-container {
            flex-grow: 1;
            overflow: hidden;
            white-space: nowrap;
            border-top-left-radius: 7px;
            border-top-right-radius: 15px;
            white-space: nowrap;
        }

        /* new */
        #date-time {
            display: flex;
            align-items: center;
            margin-left: 5px;
            margin-right: 5px;
            max-width: 1500px;
        }

        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
            width: 100%;
        }

        /* new */
        #running-text {
            display: inline-block;
            font-size: 24px;
            font-family: "Segoe UI", Arial, sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            font-weight: bold;
            color: #ffffff; /* Warna kuning */
            animation: marquee linear infinite;
        }


        /* new */
        #date-time>div {
            display: flex;
            white-space: nowrap;
            /* Mencegah teks memisah saat diperbesar */
        }

        /* new */
        #date {
            margin-right: 5px;
            /* Menambahkan spasi antara "date" dan "time" */
        }

        @keyframes marquee {
            0% {
                transform: translateX(50%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>
    <div id="container">
        {{-- <div id="date">
            <span id="day"></span>, <span id="formattedDate"></span>
        </div> --}}
        <div id="clock"></div>
        <div id="player"></div>
    </div>

    @foreach($files as $konten)
    @if($konten->typeFile === 'images')
    <img src="{{ asset('storage/uploads/'.$konten->directory) }}" alt="Image" style="width: 100%;">
    @elseif($konten->typeFile === 'video')
    <video autoplay muted playsinline loop style="width: 100%;">
        <source src="{{ asset('storage/uploads/'.$konten->directory) }}" type="video/mp4">
    </video>
    @elseif($konten->typeFile === 'youtube')
    <iframe width="100%" height="500" src="{{ $konten->directory }}" frameborder="0" allowfullscreen></iframe>
    @endif
    @endforeach



    <footer>
        <div id="date-time">
            <div>
                <span id="day"></span>, <span id="date"> </span>
                <span id="time"> </span>
                <span style="margin: 0 5px 0 5px;line-height: 1.2em;">|</span>
            </div>
        </div>

        <div id="running-text-container" class="marquee-container">
            <div id="running-text">
                Bina Nusantara @Bekasi, Striving for excellence, Perseverance,
                Integrity, Respect, Innovation, Teamwork
            </div>
        </div>
    </footer>




    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const runningText = document.getElementById('running-text');
            const containerWidth = document.querySelector('.marquee-container').offsetWidth;
            const textWidth = runningText.offsetWidth;

            // Set speed in pixels per second
            const speed = 80; // Ubah kecepatan sesuai keinginan

            // Calculate the duration for the entire animation
            const duration = (textWidth + containerWidth) / speed;

            // Set the duration for the animation
            runningText.style.animationDuration = `${duration}s`;

            // Position the text to start just outside the container
            runningText.style.left = `${containerWidth}px`;
        });


        var data;
        var count = 0;

        var currentData = 0;
        var player = document.getElementById("player");
        var clock = document.getElementById("clock");
        var dayElement = document.getElementById("day");
        var formattedDateElement = document.getElementById("formattedDate");
        var slideshowInterval;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        function createVideoPlayer(src) {
            var videoPlayer = document.createElement("video");
            videoPlayer.id = "videoPlayer";
            videoPlayer.src = '/' + src;
            // videoPlayer.controls = true;
            // videoPlayer.muted = true;
            return videoPlayer;
        }

        function createImagePlayer(src) {
            var imagePlayer = document.createElement("img");
            imagePlayer.id = "imagePlayer";
            imagePlayer.src = '/' + src;
            imagePlayer.alt = "Slideshow Image";
            return imagePlayer;
        }

        function startSlideshow() {
            // stopSlideshow();

            var container = document.getElementById("container");
            if (container.requestFullscreen) {
                container.requestFullscreen();
            } else if (container.mozRequestFullScreen) {
                container.mozRequestFullScreen();
            } else if (container.webkitRequestFullscreen) {
                container.webkitRequestFullscreen();
            } else if (container.msRequestFullscreen) {
                container.msRequestFullscreen();
            }

            playVideoAndImage();
            // updateTime();
        }

        function stopSlideshow() {
            clearInterval(slideshowInterval);
        }

        function playVideoAndImage() {
            if (data && currentData < data.length) {
                var media = data[currentData];
                var mediaPlayer;

                if (media.typeFile === "video") {
                    mediaPlayer = createVideoPlayer(media.direktori);

                    // Menambahkan kelas untuk transisi
                    player.classList.add('transition');

                    player.innerHTML = "";
                    // Menunggu durasi transisi selesai
                    setTimeout(function() {
                        // Menghapus kelas transisi
                        player.classList.remove('transition');

                        player.appendChild(mediaPlayer);

                        mediaPlayer.setAttribute('autoplay', 'autoplay');
                    }, 1000); // Ganti 500 dengan durasi transisi Anda (dalam milidetik)
                    mediaPlayer.addEventListener('loadedmetadata', function() {
                        var videoDuration = Math.floor(mediaPlayer.duration * 1000);

                        setTimeout(function() {
                            currentData++;
                            playVideoAndImage();
                        }, videoDuration + 1000);
                    });
                }
                if (media.typeFile === "images") {
                    mediaPlayer = createImagePlayer(media.direktori);

                    // Menambahkan kelas untuk transisi
                    player.classList.add('transition');

                    player.innerHTML = "";

                    // Menunggu durasi transisi selesai
                    setTimeout(function() {
                        // Menghapus kelas transisi
                        player.classList.remove('transition');

                        // Menambahkan media player setelah transisi selesai
                        player.appendChild(mediaPlayer);

                        // Menambahkan timeout untuk melanjutkan setelah durasi media
                        setTimeout(function() {
                            currentData++;
                            playVideoAndImage();
                        }, media.duration);
                    }, 1000); // Ganti 500 dengan durasi transisi Anda (dalam milidetik)
                }
                if (media.typeFile === "youtube") {

                    // URL video YouTube
                    var youtubeUrl = media.direktori;

                    // Mencari posisi awal kode video
                    var startPos = youtubeUrl.lastIndexOf("/") + 1;

                    // Mengambil kode video dari URL
                    var videoCode = youtubeUrl.substring(startPos);

                    // Menambahkan kelas untuk transisi
                    player.classList.add('transition');

                    player.innerHTML = "";

                    // Menunggu durasi transisi selesai
                    setTimeout(function() {
                        // Menghapus kelas transisi
                        player.classList.remove('transition');

                        var youtubePlayerDiv = document.createElement('div');
                        youtubePlayerDiv.id = 'youtube-player'; // Use a different ID to avoid conflicts
                        player.classList.add('transition');
                        player.appendChild(youtubePlayerDiv);
                        player.classList.remove('transition');
                        setTimeout(function() {
                            var youtubePlayerDiv = new YT.Player('youtube-player', {
                                height: '100%', // Set height to 100%
                                width: '100%',
                                videoId: videoCode,
                                playerVars: {
                                    'controls': 0, // Kontrol video (0 untuk dihilangkan)
                                    'autoplay': 1, // Autoplay video (1 untuk ya)
                                    // ... tambahkan opsi lain sesuai kebutuhan
                                },
                                events: {
                                    'onStateChange': onPlayerStateChange
                                }
                            });
                        }, 100)
                    }, 1000); // Ganti 500 dengan durasi transisi Anda (dalam milidetik)

                    function onPlayerStateChange(event) {
                        if (event.data === YT.PlayerState.ENDED) {
                            // Saat video selesai, ganti elemen iframe dengan elemen div
                            currentData++;
                            playVideoAndImage();

                        }
                    }
                }

            } else {

                if (count == 3) {
                    window.location.reload();
                    count = 0;
                }
                currentData = 0;

                $.ajax({
                    type: 'POST',
                    url: '/getContent',
                    data: {
                        _token: csrfToken,
                        group: '{{$group}}',
                    },
                    success: function(dataa) {
                        data = dataa[0];
                        csrfToken = dataa[2];
                        playVideoAndImage();
                        setRunningText(dataa[1]);
                        count++;
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan di sini, contohnya:
                        console.error(xhr.responseText);
                    }
                });


            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            startSlideshow();
        });

        function updateDateTime() {
            const now = new Date();
            const days = [
                "Minggu",
                "Senin",
                "Selasa",
                "Rabu",
                "Kamis",
                "Jumat",
                "Sabtu",
            ];
            const day = days[now.getDay()];
            const date = now.getDate();
            const monthNames = [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ];
            const month = monthNames[now.getMonth()];
            const year = now.getFullYear();
            const hours = now.getHours().toString().padStart(2, "0");
            const minutes = now.getMinutes().toString().padStart(2, "0");
            const seconds = now.getSeconds().toString().padStart(2, "0");

            document.getElementById("day").textContent = day;
            document.getElementById("date").textContent =
                date + " " + month + " " + year;
            document.getElementById("time").textContent =
                hours + ":" + minutes + ":" + seconds;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    <script>
        function setRunningText(data) {
            var runningText = $('#running-text');
            runningText.empty();

            data.forEach(function(item) {
                runningText.append(item.deskripsi + '&nbsp;|&nbsp;');
            });
        }
    </script>

</body>

</html>
