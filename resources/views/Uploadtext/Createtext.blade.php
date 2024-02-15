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
                        <h3>Upload Running Text</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ url('simpantext')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" class="form-control">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="content" class="form-control" cols="30" rows="5"></textarea>
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Publish</option>
                                <option value="0">Tidak Publish</option>
                            </select>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Simpan Data</button>
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

