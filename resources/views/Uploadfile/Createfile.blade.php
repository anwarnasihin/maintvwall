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

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Display Days <span class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-3">
                                    <!-- Hari-hari -->
                                    <label class="flex flex-col items-center text-center">
                                        <input type="checkbox" name="selected_days[]" value="1" class="peer hidden" />
                                        <div class="w-20 px-2 py-2 rounded-md border border-gray-300 peer-checked:bg-purple-600 peer-checked:text-white">
                                            <div class="font-semibold">Mon</div>
                                            <div class="text-xs text-gray-500 peer-checked:text-white">Monday</div>
                                        </div>
                                    </label>
                                    <label class="flex flex-col items-center text-center">
                                        <input type="checkbox" name="selected_days[]" value="2" class="peer hidden" />
                                        <div class="w-20 px-2 py-2 rounded-md border border-gray-300 peer-checked:bg-purple-600 peer-checked:text-white">
                                            <div class="font-semibold">Tue</div>
                                            <div class="text-xs text-gray-500 peer-checked:text-white">Tuesday</div>
                                        </div>
                                    </label>
                                    <label class="flex flex-col items-center text-center">
                                        <input type="checkbox" name="selected_days[]" value="3" class="peer hidden" checked />
                                        <div class="w-20 px-2 py-2 rounded-md border border-gray-300 peer-checked:bg-purple-600 peer-checked:text-white">
                                            <div class="font-semibold">Wed</div>
                                            <div class="text-xs text-gray-500 peer-checked:text-white">Wednesday</div>
                                        </div>
                                    </label>
                                    <label class="flex flex-col items-center text-center">
                                        <input type="checkbox" name="selected_days[]" value="4" class="peer hidden" />
                                        <div class="w-20 px-2 py-2 rounded-md border border-gray-300 peer-checked:bg-purple-600 peer-checked:text-white">
                                            <div class="font-semibold">Thu</div>
                                            <div class="text-xs text-gray-500 peer-checked:text-white">Thursday</div>
                                        </div>
                                    </label>
                                    <label class="flex flex-col items-center text-center">
                                        <input type="checkbox" name="selected_days[]" value="5" class="peer hidden" />
                                        <div class="w-20 px-2 py-2 rounded-md border border-gray-300 peer-checked:bg-purple-600 peer-checked:text-white">
                                            <div class="font-semibold">Fri</div>
                                            <div class="text-xs text-gray-500 peer-checked:text-white">Friday</div>
                                        </div>
                                    </label>
                                    <label class="flex flex-col items-center text-center">
                                        <input type="checkbox" name="selected_days[]" value="6" class="peer hidden" />
                                        <div class="w-20 px-2 py-2 rounded-md border border-gray-300 peer-checked:bg-purple-600 peer-checked:text-white">
                                            <div class="font-semibold">Sat</div>
                                            <div class="text-xs text-gray-500 peer-checked:text-white">Saturday</div>
                                        </div>
                                    </label>
                                    <label class="flex flex-col items-center text-center">
                                        <input type="checkbox" name="selected_days[]" value="7" class="peer hidden" checked />
                                        <div class="w-20 px-2 py-2 rounded-md border border-gray-300 peer-checked:bg-purple-600 peer-checked:text-white">
                                            <div class="font-semibold">Sun</div>
                                            <div class="text-xs text-gray-500 peer-checked:text-white">Sunday</div>
                                        </div>
                                    </label>
                                </div>

                                <label class="mt-4 flex items-center space-x-2">
                                    <input type="checkbox" id="checkAll" class="h-4 w-4 text-purple-600 border-gray-300 rounded" />
                                    <span class="text-sm text-gray-700 font-medium">Select All Days</span>
                                </label>
                                <p class="text-sm text-gray-400">Select which days of the week this media should be displayed</p>
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
