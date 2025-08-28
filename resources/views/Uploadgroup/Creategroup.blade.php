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
                        <h3>Upload Group</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ url('simpangroup')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" name="nama" id="" class="form-control" placeholder="Input Nama Disini">
                            </div>
                            <div class="form-group">
                                <textarea type="text" name="keterangan" id="" class="form-control" placeholder="Input Keterangan Disini"></textarea>
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