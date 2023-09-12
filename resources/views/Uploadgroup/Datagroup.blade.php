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
                    <a data-toggle="modal" data-target="#modal-hapus{{$item->id}}"><i class="fas fa-trash-alt" style="color: crimson"></i></a>
                  </td>
                </tr>

                <div class="modal fade" id="modal-hapus{{$item->id}}">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Apakah kamu yakin ingin menghapus data <b>{{ $item->name}}</b> </p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <form action="{{ route('deletegroup',['id' => $item->id]) }}" method="POST">
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