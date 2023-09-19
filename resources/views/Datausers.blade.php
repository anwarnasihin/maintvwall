@extends('layouts.master')
@section('title.home')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        {{-- <h1 class="m-0">{{$judul}}</h1> --}}
      </div><!-- /.col -->

    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" style="width: 10px">No</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Password</th>
                  <th class="text-center">Aksi</th>
                </tr>

              </thead>
              <tbody>
                @foreach ($dtUser as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name}}</td>
                  <td>{{ $item->email }}</td>
                  <td>Password Tidak Ditampilkan</td>
                  <td>
                    <a href="#" id="edit" class="edit-button" data-id="{{$item->id}}" data-name="{{ $item->name }}" data-email="{{ $item->email }}">
                      <i class="far fa-edit" style="color: #e7ea2e;"></i>
                  </a>
                    &nbsp;
                    <a href="#" class="text-danger delete-item" data-id="{{ $item->id }}">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>

                <div class="modal fade" id="modal-hapus#">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Apakah kamu yakin ingin menghapus data ini<b>#</b> </p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <form action="#" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-primary ml-auto" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->


      <!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form id="editForm" action="{{ route('updateuser', ['id' => $item->id]) }}" method="POST">
                  @csrf
                  <input type="hidden" id="id" name="id">
                  <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" class="form-control" id="name" name="name">
                  </div>
                  <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="text" class="form-control" id="email" name="email">
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" form="editForm" class="btn btn-primary">Save Changes</button>
          </div>
      </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).on('click', '#edit', function(e) {
    e.preventDefault();
    var uid = $(this).data('id');
    var name = $(this).data('name');
    var email = $(this).data('email');

    $('#id').val(uid);
    $('#name').val(name);
    $('#email').val(email);

    $('#editModal').modal('show');
});
</script>

  <!-- jQuery -->
  <script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
  <script>
    $(function() {
        var createGroupModal = $("#createGroupModal");

        // Meng-handle klik tombol "Tambah Data"
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "columnDefs": [{
                "className": "text-center",
                "targets": [0, 1, 2, 3], // table ke 1
            }],
            "buttons": [{
                text: 'Tambah Data <i class="fas fa-plus-square"></i>',
                action: function(e, dt, node, config) {
                    // Menampilkan modal ketika tombol diklik
                    createGroupModal.modal('show');
                },
                className: 'btn-success'
            }]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Meng-handle form submission ketika modal disimpan
        $("#createForm").submit(function(e) {
            e.preventDefault();
            // Lakukan AJAX request untuk menyimpan data
            // Setelah selesai, sembunyikan modal
            createGroupModal.modal('hide');
        });
    });
</script>

<!-- Modal untuk menambah data -->
<div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGroupModalLabel">Tambah Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk input data -->
                <form id="formuser">
                  @csrf
                    <div class="form-group">
                        {{-- <label for="nama">Nama:</label> --}}
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        {{-- <label for="deskripsi">Email:</label> --}}
                        <input class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        {{-- <label for="deskripsi">Password:</label> --}}
                        <input class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanData">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{--javascript Hapus Data --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Tangkap acara klik tautan hapus
      document.querySelectorAll('.delete-item').forEach(function (link) {
          link.addEventListener('click', function (e) {
              e.preventDefault();
              
              var itemId = this.dataset.id;
              
              // Tampilkan SweetAlert untuk konfirmasi hapus
              Swal.fire({
                  title: 'Apakah Anda yakin?',
                  text: 'Anda tidak akan dapat mengembalikan data ini!',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Ya, Hapus',
                  cancelButtonText: 'Batal'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Redirect atau lakukan penghapusan di sini
                      window.location.href = 'deleteuser/' + itemId;
                  }
              });
          });
      });
  });
</script>

<!-- Java script menambah data -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  $(document).ready(function() {
      // Meng-handle klik tombol "Simpan"
      $('#simpanData').click(function() {
          // Ambil data dari input dalam modal
          var nama = $('#nama').val();
          var email = $('#email').val();
          var password = $('#password').val();

          // Kirim data ke server menggunakan AJAX
          $.ajax({
              url: "{{ route('simpanuser') }}",
              method: "POST",
              data: {
                  _token: "{{ csrf_token() }}",
                  nama: nama,
                  email: email,
                  password: password
              },
              success: function(response) {
                  // Menutup modal
                  $('#createGroupModal').modal('hide');
                  
                  // Mengosongkan formulir
                  document.getElementById('formuser').reset();

                  // Menampilkan SweetAlert
                  Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan!',
                  }).then(() => {
                      // Reload halaman jika diperlukan
                      window.location.reload();
                  });
              },
          });
      });
  });
</script>


  @include('sweetalert::alert')
</section>
@endsection