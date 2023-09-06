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
          <div class="card-header">
            <a href="{{ route('creategroup') }}" class="btn btn-success">Tambah Data <i class="fas fa-plus-square"></i></a>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center" style="width: 10px">No</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Keterangan</th>
                  <th class="text-center">Aksi</th>
                </tr>

                @foreach ($dtGroup as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name}}</td>
                  <td>{{ $item->keterangan}}</td>
                  <td class="text-center">
                    <a href="{{ url('editgroup',$item->id) }}"><i class="fas fa-edit" style="color: #fdf512"></i></a>
                    |
                    <a href="{{ url('deletegroup',$item->id) }}"><i class="fas fa-trash-alt" style="color: crimson"></i></a>
                  </td>
                </tr>
                @endforeach

              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <!-- /.card -->
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection
@include('sweetalert::alert')