@extends('layouts.master')

@section('title', 'Kelola User')

@section('content')

{{-- 1. LIBRARY SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- JQUERY (Wajib untuk efek animasi fade out) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- STYLE CSS --}}
<style>
    .action-icons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
    }

    .icon-btn {
        border: none;
        background: none;
        padding: 0;
        font-size: 1.1rem;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.2s;
    }

    /* WARNA IKON */
    .icon-btn.edit { color: #007bff; }
    .icon-btn.delete { color: #dc3545; }

    .icon-btn:hover { transform: scale(1.2); }
    button.icon-btn:focus { outline: none; }
</style>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar User</h1>
      </div>
      <div class="col-sm-6 text-right">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Tambah User Baru
        </a>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        {{-- ALERT SUKSES (Kotak Hijau) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Pengguna Aplikasi</h3>
          </div>

          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Nama Lengkap</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th class="text-center" width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $key => $user)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if($user->role == 'admin')
                        <span class="badge badge-primary">Administrator</span>
                    @else
                        <span class="badge badge-success">User Biasa</span>
                    @endif
                  </td>

                  <td class="text-center">
                      <div class="action-icons">

                          <a href="{{ route('admin.users.edit', $user->id) }}"
                             class="icon-btn edit"
                             title="Edit Data">
                              <i class="fas fa-edit"></i>
                          </a>

                          <form action="{{ route('admin.users.destroy', $user->id) }}"
                                method="POST"
                                class="d-inline"
                                id="delete-form-{{ $user->id }}">
                              @csrf
                              @method('DELETE')
                              <button type="button"
                                      class="icon-btn delete"
                                      title="Hapus User"
                                      onclick="hapusData({{ $user->id }})">
                                  <i class="fas fa-trash-alt"></i>
                              </button>
                          </form>

                      </div>
                  </td>

                </tr>
                @endforeach

                @if($users->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                            Belum ada data user.
                        </td>
                    </tr>
                @endif

              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

{{-- SCRIPT GABUNGAN (AUTO CLOSE ALERT + POPUP HAPUS) --}}
<script>
    // 1. Script Auto-Close Alert (Hilang Sendiri)
    $(document).ready(function() {
        // Cari elemen dengan ID #success-alert
        // Tunggu 3000ms (3 detik), lalu slideUp pelan-pelan
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
        });
    });

    // 2. Script SweetAlert Hapus
    function hapusData(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data user ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', // Warna Merah (sesuai tombol delete)
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

@endsection
