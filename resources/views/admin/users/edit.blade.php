@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit User</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">

        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Form Edit Data</h3>
          </div>

          <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="card-body">

              <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
              </div>

              <div class="form-group">
                    <label>Role (Jabatan)</label>
                    <select name="role" class="form-control">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
              </div>

              <div class="form-group">
                <label>Password Baru <small class="text-muted">(Biarkan kosong jika tidak diganti)</small></label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Password baru...">
                    <div class="input-group-append">
                        <div class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                            <span class="fas fa-eye" id="eyeIcon"></span>
                        </div>
                    </div>
                </div>
              </div>

            </div>

            <div class="card-footer">
              <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-warning">Update Data</button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection



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
