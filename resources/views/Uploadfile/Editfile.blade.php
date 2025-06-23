@extends('layouts.master')
@section('title.home')
@section('content')
     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <h3>Edit File</h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('updatefile',$dt->id)}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" id="group" name="group" class="form-control" placeholder="Group" value="{{ $dt->group }}">
                        </div>
                        <div class="form-group">
                            <input type="text" id="typeFile" name="typeFile" class="form-control" placeholder="Type File" value="{{ $dt->typeFile }}">
                        </div>
                        <div class="form-group">
                            <input type="text" id="direktori" name="direktori" class="form-control" placeholder="Direktori" value="{{ $dt->direktori }}">
                        </div>
                        <div class="form-group">
                            <input type="text" id="duration" name="duration" class="form-control" placeholder="Duration" value="{{ $dt->duration }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Edit Data</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
@endsection

