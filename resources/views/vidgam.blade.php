<!DOCTYPE html>
<html>

<head>
    <title>TV Wall BINUS@BEKASI</title>
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
        }

        #container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        #player {
            width: 100%;
            height: calc(100% - 50px);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: width 0.5s, height 0.5s, background-color 0.5s;
        }

        #footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 50px; /* Sesuaikan tinggi footer sesuai kebutuhan Anda */
    background-color: rgba(0, 57, 212, 0.8); /* Warna latar belakang footer */
    color: #fff; /* Warna teks footer */
    text-align: center; /* Pusatkan teks dalam footer */
    line-height: 50px; /* Sesuaikan dengan tinggi footer untuk pusatkan vertikal teks */
}

        #player.transition {
            width: 100%;
            height: 100%;
            background-color: white;
        }

        #player img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }

        #player video {
            width: 100%;
            height: auto;
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

        #runningTextContainer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            font-size: 26px;
            font-family: "Segoe UI", Arial, sans-serif;
            font-weight: bold;
            background-color: rgba(0, 0, 0, 1);
            color: #fff;
            padding: 10px;
            z-index: 9999;
            white-space: nowrap; /* Mencegah teks wrap */
        }

        #datetime {
            display: inline-block;
            vertical-align: bottom; /* Mengatur vertikal ke bawah */
        }

        #datetime > div {
            text-shadow: 2px 2px 4px rgba(185, 236, 0, 0.5); /* Tambahkan bayangan teks */
            display: inline-block;
            margin-right: 3px; /* Jarak antara elemen-elemen dalam datetime */
        }

        #runningText {
            text-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5); /* Tambahkan bayangan teks */
        }
    </style>
</head>

<body>
    <div id="runningTextContainer">
        <!-- Elemen datetime -->
        <div id="datetime">
            <div id="day"><span id="dayValue"></span></div>
            <div id="date"><span id="dateValue"></span></div>
            <div id="clock"><span id="clockValue"></span></div>
        </div>
        <!-- Running text -->
        <marquee id="runningText" behavior="scroll" direction="left">
            Bina Nusantara @Bekasi, Striving for excellence, Perseverance, Integrity, Respect, Innovation, Teamwork
        </marquee>
    </div>


    <div id="container">
        <div id="date">
            {{-- <span id="day"></span>, <span id="formattedDate"></span> --}}
        </div>
        <div id="clock"></div>
        <div id="player"></div>
    </div>

    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script>
        var data;

        var currentData = 0;
        var player = document.getElementById("player");
        var clock = document.getElementById("clock");
        var dayElement = document.getElementById("day");
        var formattedDateElement = document.getElementById("formattedDate");
        var slideshowInterval;

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
            updateTime();
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
                currentData = 0;

                $.ajax({
                    type: 'POST',
                    url: '/getContent',
                    data: {
                        _token: "{{ csrf_token() }}",
                        group: '{{$group}}',
                    },
                    success: function(dataa) {
                        data = dataa;
                        playVideoAndImage();
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

        function updateRunningText() {
            // Ambil elemen-elemen jam, tanggal, dan hari
            var clockValue = document.getElementById("clockValue");
            var dateValue = document.getElementById("dateValue");
            var dayValue = document.getElementById("dayValue");

            var currentDate = new Date();
            var hours = currentDate.getHours();
            var minutes = currentDate.getMinutes();
            var seconds = currentDate.getSeconds();
            var day = currentDate.getDay();
            var date = currentDate.getDate();
            var month = currentDate.getMonth();
            var year = currentDate.getFullYear();

            var dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            var dayName = dayNames[day];
            var monthName = monthNames[month];

            // Format jam, misalnya "01:23:45"
            var formattedTime = (hours < 10 ? "0" : "") + hours + ":" +
                                (minutes < 10 ? "0" : "") + minutes + ":" +
                                (seconds < 10 ? "0" : "") + seconds;

            // Format tanggal, misalnya "Tanggal 31 Desember 2023"
            var formattedDate = "" + date + " " + monthName + " " + year;

            // Format hari, misalnya "Hari Senin"
            var formattedDay = "" + dayName;

            // Update teks jam, tanggal, dan hari
            clockValue.textContent = formattedTime;
            dateValue.textContent = formattedDate;
            dayValue.textContent = formattedDay;
        }

        // Panggil fungsi updateRunningText() untuk menginisialisasi isi jam, tanggal, dan hari
        updateRunningText();

        // Panggil fungsi updateRunningText() sesuai dengan kebutuhan
        setInterval(updateRunningText, 1000); // Mengubah teks setiap 1 detik
    </script>
</body>

</html>