@extends('layouts.master')
@section('title.home')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{$judul}}</h1>
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
            <a href="{{ route('createfile') }}" class="btn btn-success">Tambah Data <i class="fas fa-plus-square"></i></a>

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
                  <th style="width: 10px">No</th>
                  <th>Group</th>
                  <th>Type File</th>
                  <th>Direktori</th>
                  <th>Duration</th>
                  <th class="text-center">Aksi</th>
                </tr>

                @foreach ($dataFile as $item)

              </thead>
              <tbody>
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->groups->name}}</td>
                  <td>{{ $item->typeFile }}</td>
                  <td>{{ $item->direktori }}</td>
                  <td>{{ $item->duration }}</td>
                  <td class="text-center">
                    @if ($item->typeFile == "images")
                    <a href="#" id="edit" data-id="{{$item->id}}"><i class="fas fa-regular fa-stopwatch" style="color: #fdf512;margin-right:3px"></i></a>
                    @endif

                    <a href="{{ url('deletefile',$item->id) }}"><i class="fas fa-trash-alt" style="color: crimson"></i></a>
                  </td>
                </tr>

                @endforeach

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
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Duration Image</h5>
              <button type="button" onclick="$('#formDuration').trigger('reset')" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formDuration" method="post" action="/editDuration">
              @csrf
              <input type="text" id="id" name="id" hidden>
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" id="duration" name="duration" class="form-control" placeholder="Millisecond">
                </div>
              </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onclick="$('#formDuration').trigger('reset')" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="document.getElementById('formDuration').submit()">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).on('click', '#edit', function(e) {
    e.preventDefault();
    var uid = $(this).data('id');

    $('#id').val(uid);
    $('#exampleModalCenter').modal('show');
  })
</script>
@endsection
@include('sweetalert::alert')