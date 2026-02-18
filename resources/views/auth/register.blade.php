<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | TV WALL BINUS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>
      * { box-sizing: border-box; }
      body {
          margin: 0; padding: 0;
          font-family: 'Poppins', sans-serif;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
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
      .glass-card {
          background: rgba(255, 255, 255, 0.2);
          backdrop-filter: blur(20px);
          -webkit-backdrop-filter: blur(20px);
          border: 1px solid rgba(255, 255, 255, 0.3);
          border-radius: 20px;
          padding: 25px 40px 40px 40px;
          width: 420px;
          max-width: 95%;
          box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
          color: white;
          text-align: center;
      }
      .login-logo-img {
          width: 180px;
          height: auto;
          margin-bottom: -25px;
          filter: drop-shadow(0 5px 5px rgba(255, 255, 255, 0.2));
      }
      .glass-card h2 {
          font-weight: 700;
          font-size: 28px;
          margin-bottom: 5px;
          text-shadow: 0 2px 4px rgba(0,0,0,0.2);
      }
      .subtitle {
          font-size: 13px;
          color: rgba(255, 255, 255, 0.9);
          margin-bottom: 25px;
          font-weight: 300;
      }
      .form-group {
          text-align: left;
          margin-bottom: 15px;
          width: 100%;
          position: relative;
      }
      .form-group label {
          font-weight: 500;
          font-size: 12px;
          margin-bottom: 5px;
          display: block;
          color: white;
      }
      .custom-input {
          width: 100% !important;
          background: rgba(255, 255, 255, 0.95) !important;
          border: none !important;
          border-radius: 10px !important;
          height: 42px !important;
          padding: 0 15px;
          font-size: 14px;
          color: #333;
          outline: none;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
          padding-right: 45px !important; /* Beri ruang untuk icon mata */
      }
      .btn-warning-custom {
          width: 100% !important;
          background-color: #f1c40f;
          color: #2c3e50;
          font-weight: 700;
          font-size: 15px;
          border-radius: 10px;
          height: 48px !important;
          border: none;
          margin-top: 10px;
          transition: all 0.3s;
          box-shadow: 0 5px 15px rgba(0,0,0,0.2);
          text-transform: uppercase;
          cursor: pointer;
      }
      .btn-warning-custom:hover {
          background-color: #d4ac0d;
          transform: translateY(-2px);
      }

      /* Pastikan bagian ini ada di dalam <style> Boss */
        .eye-icon-container {
            position: absolute;
            right: 15px;
            top: 40px; /* Sesuaikan angka ini agar pas di tengah input */
            cursor: pointer;
            color: #666;
            z-index: 9999; /* Angka tinggi supaya tidak tertutup input */
            font-size: 16px;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
        }

.eye-icon-container:hover {
    color: #333;
}

/* Tambahan agar form-group stabil */
.form-group {
    position: relative; /* Wajib ada ini Boss */
    margin-bottom: 20px;
    text-align: left;
}
  </style>
</head>
<body>
  <div class="glass-card">
      <img src="{{ asset('assets/dist/img/Road-To-45.png') }}" alt="Logo Binus" class="login-logo-img">
      <h2>Join Us</h2>
      <p class="subtitle">Create your account to manage TV Wall.</p>

      <x-validation-errors class="mb-3 text-left" style="font-size: 12px; color: #ffeb3b;" />

      <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="form-group">
              <label>Full Name</label>
              <input type="text" name="name" class="custom-input" placeholder="Enter your name" value="{{ old('name') }}" required autofocus>
          </div>
          <div class="form-group">
              <label>Email Address</label>
              <input type="email" name="email" class="custom-input" placeholder="example@binus.edu" value="{{ old('email') }}" required>
          </div>

          <div class="form-group" style="position: relative; margin-bottom: 20px;">
                <label>Password</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="password" name="password" id="passwordInput" class="custom-input" placeholder="••••••••" required style="padding-right: 45px; width: 100%;">
                    {{-- <i class="fas fa-eye" id="eyeIcon" onclick="togglePassword()" style="position: absolute; right: 15px; color: #f1c40f; cursor: pointer; z-index: 9999; font-size: 18px;"></i> --}}
                </div>
            </div>

            <div class="form-group" style="position: relative; margin-bottom: 20px;">
                <label>Confirm Password</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="password" name="password_confirmation" id="passwordConfirmInput" class="custom-input" placeholder="••••••••" required style="padding-right: 45px; width: 100%;">
                    <i class="fas fa-eye" id="eyeConfirmIcon" onclick="toggleConfirmPassword()" style="position: absolute; right: 15px; color: #878787; cursor: pointer; z-index: 9999; font-size: 18px;"></i>
                </div>
            </div>
          <button type="submit" class="btn btn-warning-custom">REGISTER</button>
          <p style="font-size: 13px; color: white; margin-top: 20px;">
              Already have an account? <a href="{{ route('login') }}" style="color: #f1c40f; font-weight: 600; text-decoration: none;">Login here</a>
          </p>
      </form>
  </div>

 <script>
    function togglePassword() {
        var x = document.getElementById("passwordInput");
        var y = document.getElementById("eyeIcon");
        if (x.type === "password") {
            x.type = "text";
            y.className = "fas fa-eye-slash";
        } else {
            x.type = "password";
            y.className = "fas fa-eye";
        }
    }

    function toggleConfirmPassword() {
        var x = document.getElementById("passwordConfirmInput");
        var y = document.getElementById("eyeConfirmIcon");
        if (x.type === "password") {
            x.type = "text";
            y.className = "fas fa-eye-slash";
        } else {
            x.type = "password";
            y.className = "fas fa-eye";
        }
    }
</script>
</body>
</html>
