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
                  <th class="text-center">Name</th>
                  <th class="text-center">Keterangan</th>
                  <th class="text-center">Aksi</th>
                </tr>

              </thead>
              <tbody>
                @foreach ($dtGroup as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name}}</td>
                  <td>{{ $item->keterangan}}</td>
                  <td>
                    <button class="btn btn-primary mr-2"><a href="/show/{{ $item->name}}" target="_blank" style="color: white;">Display</a></button>
                    <a href="{{ url('editgroup',$item->id) }}"><i class="fas fa-edit" style="color: #fdf512"></i></a>
                    &nbsp;
                    <a href="#" data-toggle="modal" data-target="#confirmDeleteModal">
                      <i class="fas fa-trash-alt" style="color: crimson"></i>
                    </a>
                  </td>
                </tr>
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

  <!-- Modal Konfirmasi Penghapusan -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              Apakah Anda yakin ingin menghapus data ini?
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <a href="{{ url('deletegroup', $item->id) }}" class="btn btn-danger">Hapus</a>
          </div>
      </div>
  </div>
</div>

  <!-- jQuery -->
  <script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "columnDefs": [{
          "className": "text-center",
          "targets": [0, 1, 2, 3], // table ke 1
        }, ],
        "buttons": [{
          text: 'Tambah Data <i class="fas fa-plus-square"></i>',
          action: function(e, dt, node, config) {
            // Mengarahkan ke rute Laravel menggunakan tautan Blade
            window.location.href = "{{ route('creategroup') }}";
          },
          className: 'btn-success' // Menambahkan kelas CSS untuk warna hijau
        }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>

  @include('sweetalert::alert')
</section>
@endsection