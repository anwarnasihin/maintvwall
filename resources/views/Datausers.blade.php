@extends('layouts.master')
@section('title.home')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        {{-- <h1 class="m-0">{{$judul}}</h1> --}}
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <div class="table-responsive">
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
                                      <a href="#" id="edit" class="edit-button" data-id="{{$item->id}}" data-name="{{ $item->name }}" data-email="{{ $item->email }}" data-toggle="tooltip" title="Edit">
                                        <i class="far fa-edit" style="color: #e7ea2e;"></i>
                                      </a>
                                      &nbsp;
                                      <a href="#" class="text-danger delete-item" data-id="{{ $item->id }}" data-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                      </a>
                                    </td>
                                  </tr>

                                  {{-- aksi dan sweet alert Hapus --}}
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
                                    </div>
                                  </div>
                                  {{-- end aksi dan sweet alert hapus --}}

                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->


                <!-- Modals tambah data -->
                <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="createGroupModalLabel">Tambah Data Baru</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_from()">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>

                      <!-- Form untuk input data -->
                      <div class="modal-body">
                        <form id="formuser" method="post" role="form" enctype="multipart/form-data">
                          @csrf
                          <span id="peringatan"></span>
                          <input type="hidden" id="id">
                            <div class="form-group">
                              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                            </div>
                            <div class="form-group">
                              <input class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_from()">Tutup</button>
                            <button type="button" class="btn btn-primary" id="simpanData">Simpan</button>
                          </div>
                        </form>
                    </div>
                  </div>
                </div>
                <!-- End Modals tambah data )-->

                <!-- jQuery -->
                <script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
                <script>
                  $(function() {
                    var createGroupModal = $("#createGroupModal");

                    // Meng-handle klik tombol "Tambah Datauser"
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
                          $("#simpanData").removeClass("btn btn-primary update");
                          $("#simpanData").addClass("btn btn-primary add");
                        },
                        className: 'btn-success',
                      }]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                    //add data
                    $('.modal-footer').on('click', '.add', function() {
                      try {
                        var form = document.getElementById("formuser");
                        var fd = new FormData(form);

                        // Ambil nilai nama, email, dan password dari form
                            var nama = fd.get('nama');
                            var email = fd.get('email');
                            var password = fd.get('password');

                            // Validasi Nama (hanya huruf)
                            var namaRegex = /^[A-Za-z\s]+$/;
                            if (!namaRegex.test(nama)) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Nama hanya boleh berisi huruf dan spasi atau tidak boleh kosong.',
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'OK'
                                });
                                return;
                            }

                            // Validasi Email (unik)
                            // Anda perlu mengirim email ke server untuk memeriksa keunikannya
                            // Di sini, kita hanya memeriksa apakah email sudah diisi
                            if (!email) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Email harus diisi.',
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'OK'
                                });
                                return;
                            }

                            // Validasi Password (huruf dan angka)
                            var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
                            if (!passwordRegex.test(password)) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Password harus terdiri dari minimal 8 karakter, termasuk huruf dan angka.',
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'OK'
                                });
                                return;
                            }


                        $.ajax({
                            type: 'POST',
                            url: '{{ url("simpanuser") }}',
                            data: fd,
                            processData: false,
                            contentType: false,
                            success: function(data) {

                                    $('#createGroupModal').modal('hide');
                                    reset_from();

                                    // Add SweetAlert notification for a successful update
                                      Swal.fire({
                                          icon: 'success',
                                          title: 'Data Saved Successfully!',
                                          text: 'Data berhasil di tambahkan.',
                                          confirmButtonColor: '#3085d6',
                                          confirmButtonText: 'OK'
                                      }).then((result) => {
                                          // You can add additional logic here if needed
                                          if (result.isConfirmed) {
                                              location.reload();
                                          }
                                          
                                      });
                                    
                                  },
                                  error: function(xhr, status, error) {
                                    // Tangani pengecualian di sini
                                    // Anda dapat menampilkan pesan kesalahan atau melakukan tindakan lain sesuai kebutuhan
                                    console.error(xhr.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Data sudah ada.',
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    });
                                } 
                              });
                          } catch (error) {
                              // Tangani pengecualian JavaScript di sini jika terjadi selama eksekusi kode di atas
                              console.error(error);
                          }
                        });
                    //end add data

                    // edit data
                    $(document).on('click', '#edit', function(e) {
                    e.preventDefault();
                    var uid = $(this).data('id');

                    $.ajax({
                      type: 'POST',
                      url: 'edituser',
                      data: {
                          '_token': "{{ csrf_token() }}",
                          'id': uid,
                      },
                      success: function(data) {
                          //console.log(data);
                          //isi form
                          $('#id').val(data.id);
                          $('#nama').val(data.name);
                          $('#email').val(data.email);
                          $('#password').val(data.password);

                          id = $('#id').val();

                          $('.modal-title').text('Edit Data');
                          $("#simpanData").removeClass("btn btn-primary add");
                          $("#simpanData").addClass("btn btn-primary update");
                          $('#createGroupModal').modal('show');

                      },
                  });
                })
                    //end edit data

                    // update
                  $('.modal-footer').on('click', '.update', function() {
                      var form = document.getElementById("formuser");
                      var fd = new FormData(form);
                      $.ajax({
                          type: 'POST',
                          url: 'updateuser/' + id,
                          data: fd,
                          processData: false,
                          contentType: false,
                          success: function(data) {
                              $('#createGroupModal').modal('hide');
                              reset_from();
                              
                              // Add SweetAlert notification for a successful update
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Data Updated Successfully!',
                                  text: 'Data berhasil di updated.',
                                  confirmButtonColor: '#3085d6',
                                  confirmButtonText: 'OK'
                              }).then((result) => {
                                  // You can add additional logic here if needed
                                  if (result.isConfirmed) {
                                      location.reload();
                                  }
                              });
                          }
                      });
                  });
                      //end update

                  });
                  function reset_from() {
                    document.getElementById("formuser").reset();
                    } 
                </script>

                {{--javascript Hapus Data --}}
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                              window.location.href = 'deleteuser/' + itemId;}
                        });
                      });
                    });
                  });
                </script>

  @include('sweetalert::alert')
</section>
@endsection