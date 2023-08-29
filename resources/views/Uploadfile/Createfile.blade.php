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
                        <h3>Upload File</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('simpanfile')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Group TV WALL</label>
                                <select class="form-control select2" name="group" style="width: 100%;">
                                    <option value="#" selected="selected">--PLEASE SELECT HERE--</option>
                                    @foreach ($group as $groups )
                                    <option value="{{$groups->id}}">{{$groups->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Type File</label>
                                <select class="form-control select2" id="typeFile" name="typeFile" style="width: 100%;">
                                    <option value="#" selected="selected">--PLEASE SELECT HERE--</option>
                                    <option value="images">Image</option>
                                    <option value="video">Video</option>
                                    <option value="youtube">Youtube</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>File Upload</label>
                                <input type="file" id="file" name="file" class="form-control">
                                <input type="text" id="linkYoutube" name="linkYoutube" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" id="duration" name="duration" class="form-control" placeholder="Millisecond">
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
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#duration').hide();
            $('#linkYoutube').hide();
        });
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()


            $('#typeFile').on('change', function() {
                if ($('#typeFile').val() == "images") {
                    $('#duration').show();
                } else {
                    $('#duration').hide();
                }

                if ($('#typeFile').val() == "youtube") {
                    $('#file').hide();
                    $('#linkYoutube').show();
                } else {
                    $('#file').show();
                    $('#linkYoutube').hide();
                }

            });
        })
    </script>
</section>
@endsection

