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
                            <div class="form-group">
                                <input type="text" name="judul" id="" class="form-control" placeholder="Judul">
                            </div>
                            <div class="form-group">
                                <textarea name="deskripsi" id="" class="form-control" placeholder="Deskripsi"></textarea>
                            </div>
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

