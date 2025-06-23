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
                        <h3>Edit Group</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ url('updategroup', $gro->id) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" id="nama" name="name" class="form-control" placeholder="Input Nama Disini" value="{{ $gro->name }}">
                            </div>
                            <div class="form-group">
                                <textarea type="text" name="keterangan" id="" class="form-control" placeholder="Input Keterangan Disini">{{ $gro->keterangan }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Data</button>
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

