@extends('layouts.master')

@section('title', 'Tambah User')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Tambah User Baru</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">

        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Form Tambah Data</h3>
          </div>

          <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="card-body">

              <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama..." required>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
              </div>

              <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password..." required>
                    <div class="input-group-append">
                        <div class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                            <span class="fas fa-eye" id="eyeIcon"></span>
                        </div>
                    </div>
                </div>
              </div>

              <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="user">User Biasa</option>
                    <option value="admin">Administrator</option>
                </select>
              </div>

            </div>

            <div class="card-footer">
              <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-success">Simpan Data</button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection

{{-- SCRIPT FITUR MATA (Show/Hide Password) --}}
<script>
    function togglePassword() {
        var inputPass = document.getElementById("passwordInput");
        var iconPass = document.getElementById("eyeIcon");

        if (inputPass.type === "password") {
            // Ubah jadi text (huruf terlihat)
            inputPass.type = "text";
            // Ubah ikon jadi mata dicoret
            iconPass.classList.remove("fa-eye");
            iconPass.classList.add("fa-eye-slash");
        } else {
            // Kembalikan jadi password (titik-titik)
            inputPass.type = "password";
            // Ubah ikon jadi mata biasa
            iconPass.classList.remove("fa-eye-slash");
            iconPass.classList.add("fa-eye");
        }
    }
</script>
