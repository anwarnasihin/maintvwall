@extends('layouts.master')

@section('title.home', 'Upload File')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<style>
    .upload-area {
        border: 2px dashed #ced4da;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    .upload-area:hover { background-color: #e9ecef; }
    .upload-area.dragover {
        background-color: #e2e6ea;
        border-color: #28a745;
        transform: scale(1.02);
    }
    /* Jurus Pamungkas Menghilangkan Tombol Browse Bawaan Browser */
/* Jurus Pamungkas Menghilangkan Tombol Browse secara Fisik dan Visual */
/* JURUS PAKSA: MENGHILANGKAN BROWSE SEKARANG JUGA! */
#file {
    position: absolute !important;
    opacity: 0 !important;
    width: 0 !important;
    height: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    border: none !important;
    display: block !important;
    overflow: hidden !important;
    pointer-events: none !important;
}
</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Upload File Content</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('simpanfile')}}" method="POST" enctype="multipart/form-data" id="formUpload">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Group TV WALL</label>
                                    <select class="form-control select2" name="group" style="width: 100%;">
                                        <option value="#" selected="selected">--PLEASE SELECT HERE--</option>
                                        @foreach ($group as $groups)
                                            <option value="{{$groups->id}}">{{$groups->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Type Content</label>
                                    <select class="form-control select2" id="typeFile" name="typeFile" style="width: 100%;">
                                        <option value="#" selected="selected">--PLEASE SELECT HERE--</option>
                                        <option value="images">Image</option>
                                        <option value="video">Video</option>
                                        <option value="youtube">Youtube</option>
                                    </select>
                                </div>
                            </div>

                            <div id="youtubeWrapper" style="display: none; margin-bottom: 20px;">
                                <div class="form-group">
                                    <label class="text-primary">Link YouTube Public</label>
                                    <input type="text" id="linkYoutube" name="linkYoutube" class="form-control"
                                           placeholder="Tempelkan link YouTube di sini..."
                                           style="border: 2px solid #007bff !important; height: 45px !important;">
                                    <small class="text-danger"><b>* Pastikan link tidak private agar bisa diputar di TV Wall!</b></small>
                                </div>
                            </div>

                                {{-- Drop And Drag Upload Area --}}
                            <div id="uploadWrapper">
                                <div class="form-group">
                                    <label id="labelFile">File Upload</label>

                                    <input type="file" id="file" name="file[]" onchange="showFileName(this)" multiple
                                        style="display: none !important;"> {{-- Sembunyikan input file BROWSE..--}}

                                    <div class="upload-area mt-2" id="dropZone" onclick="document.getElementById('file').click()">
                                        <i class="fas fa-cloud-upload-alt fa-3x" style="color: #6c757d; margin-bottom: 10px;"></i>
                                        <p class="mb-1">Drag & Drop file di sini</p>
                                        <small style="color: #adb5bd;">atau klik untuk mencari di komputer</small>
                                        <div id="fileNameDisplay" class="mt-3 text-success font-weight-bold" style="display: none; text-align: left; font-size: 13px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="form-group col-12" id="durationRow">
                                    <label>Duration (Millisecond)</label>
                                    <input type="text" id="duration" name="duration" class="form-control" placeholder="Contoh: 5000 untuk 5 detik">
                                </div>

                                <div class="form-group col-6">
                                    <label>Start Date & Time (Otomatis)</label>
                                    <div class="input-group date" id="strDate" data-target-input="nearest">
                                        <input type="text" name="str_date" class="form-control datetimepicker-input" data-target="#strDate" value="{{ date('Y-m-d H:i', strtotime('-5 minutes')) }}"/>
                                        <div class="input-group-append" data-target="#strDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>End Date & Time</label>
                                    <div class="input-group date" id="edDate" data-target-input="nearest">
                                        <input type="text" name="ed_date" class="form-control datetimepicker-input" data-target="#edDate" placeholder="Pilih Tanggal & Jam"/>
                                        <div class="input-group-append" data-target="#edDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="d-block mb-2">Display Days <span class="text-danger">*</span></label>
                                <div class="d-flex flex-wrap" style="gap: 10px;">
                                    @foreach(['Mon'=>'Monday', 'Tue'=>'Tuesday', 'Wed'=>'Wednesday', 'Thu'=>'Thursday', 'Fri'=>'Friday', 'Sat'=>'Saturday', 'Sun'=>'Sunday'] as $short => $long)
                                    <label class="text-center">
                                        <input type="checkbox" name="selected_days[]" value="{{ $loop->iteration }}" class="day-chk" checked style="display:none;">
                                        <div class="day-box p-2 rounded border" style="width: 80px; cursor: pointer; background: #2374ff; color: white;">
                                            <span class="font-weight-bold">{{ $short }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <input type="checkbox" id="checkAll" checked> <label for="checkAll">Select All Days</label>
                                </div>
                            </div>

                            <div id="progressContainer" style="display:none;" class="mb-3">
                                <div class="progress" style="height: 25px;">
                                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%;">0%</div>
                                </div>
                            </div>

                            <div class="text-left"> {{-- Tambahkan div ini supaya tombol bergeser ke kanan --}}
                                <button type="submit" class="btn btn-success px-2 py-2">
                                    <i class="fas fa-save mr-1"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    $(document).ready(function() {
        // 1. INisialisasi Dasar
        $('.select2').select2();
        $('#durationRow').hide();

        // 2. Setting Kalender (Tempus Dominus)
        var dateConfig = {
            format: 'YYYY-MM-DD HH:mm',
            sideBySide: true,
            allowInputToggle: true, // Klik di kotak mana saja kalender muncul
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'far fa-calendar-check',
                clear: 'far fa-trash-alt',
                close: 'fas fa-times'
            }
        };

        // Langsung pasang kalender saat halaman dimuat
        $('#strDate').datetimepicker(dateConfig);
        $('#edDate').datetimepicker(dateConfig);

        // 3. LOGIKA GANTI TYPE CONTENT (YouTube vs File)
        $('#typeFile').on('change', function() {
            let val = $(this).val();
            if (val == "youtube") {
                $('#uploadWrapper').hide();
                $('#youtubeWrapper').show();
                $('#durationRow').hide();
            } else {
                $('#uploadWrapper').show();
                $('#youtubeWrapper').hide();
                if (val == "images") {
                    $('#durationRow').show();
                } else {
                    $('#durationRow').hide();
                }
            }

            // Re-inisialisasi kalender agar tidak "nge-freeze"
            $('#strDate').datetimepicker(dateConfig);
            $('#edDate').datetimepicker(dateConfig);
        });

        // 4. LOGIKA DRAG & DROP
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('file');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eName => {
            dropZone.addEventListener(eName, (e) => { e.preventDefault(); e.stopPropagation(); }, false);
        });

        dropZone.addEventListener('dragover', (e) => {
            dropZone.classList.add('dragover');
            e.dataTransfer.dropEffect = 'copy'; // Ubah logo jadi tanda +
        });

        dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('dragover'); });

        dropZone.addEventListener('drop', (e) => {
            dropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                renderFileList(files);
            }
        });

        // 5. LOGIKA CHECKBOX HARI (Display Days)
        $('#checkAll').change(function() {
            $('.day-chk').prop('checked', $(this).prop('checked'));
            updateDayBoxStyle();
        });

        $('.day-chk').change(function() {
            $('#checkAll').prop('checked', $('.day-chk').length === $('.day-chk:checked').length);
            updateDayBoxStyle();
        });

        function updateDayBoxStyle() {
            $('.day-chk').each(function() {
                let box = $(this).next('.day-box');
                if ($(this).is(':checked')) {
                    box.css({'background': '#0060df', 'color': 'white'});
                } else {
                    box.css({'background': 'white', 'color': '#333'});
                }
            });
        }

        updateDayBoxStyle(); // Jalankan sekali saat load

        // 6. LOGIKA SUBMIT FORM (AXIOS)
        $('#formUpload').on('submit', function (e) {
            let typeFile = $('#typeFile').val();
            if (typeFile === 'youtube') return true; // Simpan normal jika youtube

            e.preventDefault();
            let formData = new FormData(this);
            $('#progressContainer').show();
            $('#btnSimpan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            axios.post(this.action, formData, {
                onUploadProgress: (p) => {
                    let perc = Math.round((p.loaded * 100) / p.total);
                    $('#progressBar').css('width', perc + '%').html(perc + '%');
                }
            }).then(() => {
                window.location.href = "{{ route('datafile') }}";
            }).catch(() => {
                alert('Gagal upload! Periksa file atau koneksi.');
                $('#btnSimpan').prop('disabled', false).html('Simpan Data');
            });
        });
    });

    function showFileName(input) { if (input.files) renderFileList(input.files); }

    function renderFileList(files) {
        let d = document.getElementById('fileNameDisplay');
        if (d) {
            d.style.display = 'block'; d.innerHTML = "";
            for (let i = 0; i < files.length; i++) {
                d.innerHTML += `<div><i class="fas fa-check-circle"></i> ${files[i].name}</div>`;
            }
        }
    }
</script>
@endsection
