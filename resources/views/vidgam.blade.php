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
        }

        #player {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: width 0.5s, height 0.5s, background-color 0.5s;
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

        #date {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #fff;
            font-size: 18px;
            opacity: 0.5;
            /* Tambahkan properti opacity */
            font-family: "Segoe UI", Arial, sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            letter-spacing: 0.5px;
        }

        #day {
            font-size: 24px;
            font-weight: bold;
            opacity: 1;
            /* Tambahkan properti opacity */
            font-family: "Segoe UI", Arial, sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            letter-spacing: 2px;
        }

        #clock {
            position: absolute;
            top: 50px;
            left: 10px;
            color: #fff;
            font-size: 50px;
            opacity: 0.5;
            /* Tambahkan properti opacity */
            font-family: "Segoe UI", Arial, sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            letter-spacing: 3px;
            font-weight: bold;
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
    </style>
</head>

<body>
    <div id="container">
        <div id="date">
            <span id="day"></span>, <span id="formattedDate"></span>
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



        function updateTime() {
            var currentDate = new Date();
            var hours = currentDate.getHours();
            var minutes = currentDate.getMinutes();
            var seconds = currentDate.getSeconds();
            var day = currentDate.getDay();
            var date = currentDate.getDate();
            var month = currentDate.getMonth();
            var year = currentDate.getFullYear();

            // Mengatur format waktu dengan 2 digit
            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            // Mengatur format tanggal dengan 2 digit
            date = (date < 10) ? "0" + date : date;

            var dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            var dayName = dayNames[day];
            var monthName = monthNames[month];

            dayElement.textContent = dayName;
            formattedDateElement.textContent = date + " " + monthName + " " + year;

            clock.textContent = hours + ":" + minutes + ":" + seconds;

            setTimeout(updateTime, 1000); // Memperbarui waktu setiap detik
        }

        document.addEventListener("DOMContentLoaded", function() {
            startSlideshow();
        });
    </script>
</body>

</html>