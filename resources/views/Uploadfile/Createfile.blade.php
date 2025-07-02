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
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Group TV WALL</label>
                                    <select class="form-control select2" name="group" style="width: 100%;">
                                        <option value="#" selected="selected">--PLEASE SELECT HERE--</option>
                                        @foreach ($group as $groups )
                                        <option value="{{$groups->id}}">{{$groups->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Type File</label>
                                    <select class="form-control select2" id="typeFile" name="typeFile" style="width: 100%;">
                                        <option value="#" selected="selected">--PLEASE SELECT HERE--</option>
                                        <option value="images">Image</option>
                                        <option value="video">Video</option>
                                        <option value="youtube">Youtube</option>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label>File Upload</label>
                                    <input type="file" id="file" name="file" class="form-control">
                                    <input type="text" id="linkYoutube" name="linkYoutube" class="form-control">
                                </div>
                                <div class="form-group col-12">
                                    <input type="text" id="duration" name="duration" class="form-control" placeholder="Millisecond">
                                </div>
                                <div class="form-group col-6">
                                    <label>Start Date</label>
                                    <div class="input-group date" id="strDate" data-target-input="nearest">
                                        <input type="text" name="str_date" id="str_date" class="form-control datetimepicker-input" data-target="#strDate">
                                        <div class="input-group-append" data-target="#strDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>End Date</label>
                                    <div class="input-group date" id="edDate" data-target-input="nearest">
                                        <input type="text" name="ed_date" id="ed_date" class="form-control datetimepicker-input" data-target="#edDate">
                                        <div class="input-group-append" data-target="#edDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                            <div class="form-group">
                                <label>Pilih Hari Tampil</label>
                                <br>
                                <label><input type="checkbox" name="selected_days[]" value="1"> Senin</label>
                                <label><input type="checkbox" name="selected_days[]" value="2"> Selasa</label>
                                <label><input type="checkbox" name="selected_days[]" value="3"> Rabu</label>
                                <label><input type="checkbox" name="selected_days[]" value="4"> Kamis</label>
                                <label><input type="checkbox" name="selected_days[]" value="5"> Jumat</label>
                                <label><input type="checkbox" name="selected_days[]" value="6"> Sabtu</label>
                                <label><input type="checkbox" name="selected_days[]" value="7"> Minggu</label>
                                <label><input type="checkbox" id="checkAll"> All Day</label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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

            //Date picker
            $('#strDate,#edDate').datetimepicker({
                format: 'YYYY-MM-DD'
            });


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
    @section('scripts')
<script>
    $(document).ready(function() {
        $('#checkAll').change(function() {
            let isChecked = $(this).prop('checked');
            $('input[name="selected_days[]"]').prop('checked', isChecked);
        });

        $('input[name="selected_days[]"]').change(function() {
            let totalHari = $('input[name="selected_days[]"]').length;
            let checkedHari = $('input[name="selected_days[]"]:checked').length;
            $('#checkAll').prop('checked', totalHari === checkedHari);
        });
    });
</script>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#checkAll').change(function() {
            let isChecked = $(this).prop('checked');
            $('input[name="selected_days[]"]').prop('checked', isChecked);
        });

        $('input[name="selected_days[]"]').change(function() {
            let totalHari = $('input[name="selected_days[]"]').length;
            let checkedHari = $('input[name="selected_days[]"]:checked').length;
            $('#checkAll').prop('checked', totalHari === checkedHari);
        });
    });
</script>
@endsection

</section>
@endsection