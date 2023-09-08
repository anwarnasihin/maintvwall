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
                  <td class="text-center">
                    <a href="{{ url('editgroup',$item->id) }}"><i class="fas fa-edit" style="color: #fdf512"></i></a>
                    &nbsp;
                    <a href="{{ url('deletegroup',$item->id) }}"><i class="fas fa-trash-alt" style="color: crimson"></i></a>
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

  <!-- jQuery -->
<script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": [{
            text: 'Tambah Data <i class="fas fa-plus-square"></i>',
            action: function (e, dt, node, config) {
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
