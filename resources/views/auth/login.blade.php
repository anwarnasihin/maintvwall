<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | TV WALL BINUS</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <style>
      /* RESET UKURAN */
      * { box-sizing: border-box; }

      body {
          margin: 0;
          padding: 0;
          font-family: 'Poppins', sans-serif;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          /* Background Gambar */
          background-image: url("{{ asset('assets/dist/img/virtual background - bekasi-04.png') }}");
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
      }

      body::before {
          content: "";
          position: absolute;
          top: 0; left: 0; right: 0; bottom: 0;
          background: rgba(0, 0, 0, 0.4);
          z-index: -1;
      }

      /* KARTU KACA (GLASS) */
      .glass-card {
          background: rgba(255, 255, 255, 0.2);
          backdrop-filter: blur(20px);
          -webkit-backdrop-filter: blur(20px);
          border: 1px solid rgba(255, 255, 255, 0.3);
          border-radius: 20px;
          padding: 25px 40px 40px 40px;
          width: 400px;
          max-width: 90%;
          box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
          color: white;
          text-align: center;
      }

      /* STYLE LOGO DI ATAS WELCOME */
      .login-logo-img {
          width: 200px;  /* Ukuran Logo (bisa diubah) */
          height: auto;
          margin-bottom: -30px; /* Jarak ke tulisan Welcome */
          filter: drop-shadow(0 5px 5px rgba(255, 255, 255, 0.2)); /* Bayangan logo biar timbul */
      }

      .glass-card h2 {
          font-weight: 700;
          margin-bottom: 5px;
          font-size: 32px;
          margin-top: 0;
          letter-spacing: 1px;
          text-shadow: 0 2px 4px rgba(0,0,0,0.2);
      }
      .glass-card p.subtitle {
          font-size: 13px;
          color: rgba(255, 255, 255, 0.9);
          margin-bottom: 30px;
          font-weight: 300;
      }

      /* FORM STYLE */
      .form-group {
          text-align: left;
          margin-bottom: 20px;
          width: 100%;
          position: relative;
      }

      .form-group label {
          font-weight: 500;
          font-size: 13px;
          margin-bottom: 8px;
          display: block;
          color: white;
          text-shadow: 0 1px 2px rgba(0,0,0,0.3);
      }

      /* INPUT CUSTOM */
      .custom-input {
          width: 100% !important;
          background: rgba(255, 255, 255, 0.95) !important;
          border: none !important;
          border-radius: 10px !important;
          height: 48px !important;
          padding-left: 15px;
          padding-right: 45px;
          font-size: 14px;
          color: #333;
          outline: none;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
          transition: all 0.3s;
      }
      .custom-input:focus {
          background: white !important;
          box-shadow: 0 0 0 4px rgba(241, 196, 15, 0.4);
      }

      /* TEXT HELP (Contact Admin) */
      .text-help {
          font-size: 12px;
          color: rgba(255, 255, 255, 0.9);
          margin-top: 5px;
          margin-bottom: 20px;
          text-align: center;
          font-style: italic;
      }

      /* TOMBOL LOGIN */
      .btn-warning-custom {
          width: 100% !important;
          background-color: #f1c40f;
          color: #2c3e50;
          font-weight: 700;
          font-size: 15px;
          border-radius: 10px;
          height: 48px !important;
          border: none;
          /* margin-top: 10px;  <-- Hapus ini kalau sudah ada text help */
          transition: all 0.3s;
          box-shadow: 0 5px 15px rgba(0,0,0,0.2);
          text-transform: uppercase;
          letter-spacing: 1px;
          cursor: pointer;
      }
      .btn-warning-custom:hover {
          background-color: #d4ac0d;
          transform: translateY(-2px);
      }

      /* IKON MATA */
      .eye-icon-container {
          position: absolute;
          right: 15px;
          top: 42px;
          cursor: pointer;
          color: #666;
          z-index: 10;
          font-size: 16px;
      }
      .eye-icon-container:hover { color: #333; }
  </style>
</head>
<body>

  <div class="glass-card">

      <img src="{{ asset('assets/dist/img/Road-To-45.png') }}" alt="Logo Binus" class="login-logo-img">

      <h2>Welcome </h2>
      <p class="subtitle">Please enter your details to sign in.</p>

      @if ($errors->any())
        <div class="alert alert-danger p-2 mb-3 text-left" style="font-size: 13px; background: rgba(231, 76, 60, 0.9); border:none; color: white; border-radius: 8px;">
             <i class="fas fa-exclamation-circle mr-1"></i> Email atau Password salah.
        </div>
      @endif

      <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="custom-input" placeholder="example@binus.edu" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label style="color: white; font-size: 13px; text-align: left; display: block; margin-bottom: 8px;">Password</label>
            <div style="position: relative;">
                {{-- Input Password --}}
                <input type="password" name="password" id="passwordInput" class="custom-input"
                    placeholder="••••••••" required
                    style="width: 100% !important; padding-right: 45px !important; display: block !important;">

                {{-- Icon Mata (Dipaksa Muncul dengan Inline Style) --}}
                <i class="fas fa-eye" id="eyeIcon" onclick="togglePassword()"
                style="position: absolute;
                        right: 15px;
                        top: 50%;
                        transform: translateY(-50%);
                        color: #989898;
                        cursor: pointer;
                        z-index: 9999 !important;
                        font-size: 18px;
                        display: block !important;"></i>
            </div>
        </div>

        <button type="submit" class="btn btn-warning-custom">
            LOGIN
        </button>
        {{-- TAMBAH BARU --}}
         <p style="font-size: 13px; color: white; margin-top: 10px;">
            Don't have an account yet?
            <a href="{{ route('register') }}" style="color: #f1c40f; font-weight: 600; text-decoration: none;">
                Register here
            </a>
         </p>


      </form>
  </div>

<script>
    function togglePassword() {
        var inputPass = document.getElementById("passwordInput");
        var iconPass = document.getElementById("eyeIcon");
        if (inputPass.type === "password") {
            inputPass.type = "text";
            iconPass.classList.remove("fa-eye");
            iconPass.classList.add("fa-eye-slash");
        } else {
            inputPass.type = "password";
            iconPass.classList.remove("fa-eye-slash");
            iconPass.classList.add("fa-eye");
        }
    }
</script>


<script>
    function togglePassword() {
        var inputPass = document.getElementById("passwordInput");
        var iconPass = document.getElementById("eyeIcon");

        if (inputPass.type === "password") {
            inputPass.type = "text";
            iconPass.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            inputPass.type = "password";
            iconPass.classList.replace("fa-eye-slash", "fa-eye");
        }
    }
</script>

{{-- Script untuk menangkap pesan sukses dari Register --}}
@if(session('toast_success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('toast_success') }}",
        timer: 3500,
        showConfirmButton: false,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endif
</body>
</html>
