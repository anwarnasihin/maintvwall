@extends('layouts.master')
@section('title.home')
@section('content')

<style>
  /* --- Styling CSS --- */
  #player img { max-width: 100%; max-height: 100%; width: auto; height: auto; }
  #player video { width: 100%; height: auto; }
  #youtube-player { width: 100%; height: 100%; }
  .day-wrapper { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
  .day-wrapper .form-check-inline { margin-right: 15px; margin-bottom: 10px; }
  .modal-lg { max-width: 900px !important; }
  .form-check-input { margin-right: 5px; }
  .form-check-label { margin-bottom: 0; font-weight: normal; }

  /* Styling tambahan untuk checkbox di tabel */
  .sub_chk { cursor: pointer; width: 18px; height: 18px; }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">{{$judul}}</h1></div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">

            {{-- --- AREA TOMBOL ATAS --- --}}
            <div class="mb-3 d-flex align-items-center" style="gap: 10px;">
                {{-- Container untuk Tombol Tambah Data dari DataTable --}}
                <div id="button_tambah_container"></div>

                {{-- Tombol Pilih Semua --}}
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnSelectAll">
                    <i class="far fa-check-square"></i> Pilih Semua
                </button>

                {{-- Tombol Hapus Masal --}}
                <button class="btn btn-danger btn-sm" id="deleteAll" style="display:none;">
                    <i class="fas fa-trash"></i> Hapus yang Tercentang (<span id="countSelected">0</span>)
                </button>
            </div>

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" style="width: 70px;">No</th>
                  <th class="text-center">Group</th>
                  <th class="text-center">Type File</th>
                  <th class="text-center">Direktori</th>
                  <th class="text-center">Duration</th>
                  <th class="text-center">Start Date</th>
                  <th class="text-center">End Date</th>
                  <th class="text-center">User Created</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($dataFile as $item)
                @php $isExpired = \Carbon\Carbon::now('Asia/Jakarta')->gt($item->ed_date); @endphp
                <tr style="{{ $isExpired ? 'background-color: #FFE4EF;' : '' }}">
                  <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                            <input type="checkbox" class="sub_chk" data-id="{{$item->id}}">
                            <span class="ml-1">{{ $loop->iteration }}</span>
                        </div>
                  </td>
                  <td>{{ $item->groups ? $item->groups->name : ' ' }}</td>
                  <td>{{ $item->typeFile }}</td>
                  <td>
                        <a id="showKonten" href="#" data-type="{{ $item->typeFile }}" data-konten="{{ $item->direktori }}">
                            {{-- Logika: Jika youtube tampilkan link asli, jika file ambil namanya saja --}}
                            @if($item->typeFile == 'youtube')
                                {{ $item->direktori }}
                            @else
                                <i class="fas fa-file-alt mr-1"></i> {{ basename($item->direktori) }}
                            @endif
                        </a>
                  </td>
                  <td>{{ $item->duration }}</td>

                  <td class="text-center">
                    {{ date('d M Y', strtotime($item->str_date)) }} <br>
                    <small class="badge badge-success"><i class="far fa-clock"></i> {{ date('H:i', strtotime($item->str_date)) }}</small>
                  </td>

                  <td class="text-center">
                    <div style="{{ $isExpired ? 'color: #ff4d4d; font-weight: bold;' : '' }}">
                        {{ date('d M Y', strtotime($item->ed_date)) }}
                    </div>
                    <small class="badge {{ $isExpired ? 'badge-dark' : 'badge-danger' }}"
                        style="{{ $isExpired ? 'background-color: #ff4d4d !important; color: white;' : '' }}">
                        <i class="far fa-clock"></i> {{ date('H:i', strtotime($item->ed_date)) }}
                    </small>
                    @if($isExpired) <br><small class="text-danger" style="font-weight: 800; font-size: 10px;">EXPIRED</small> @endif
                  </td>

                  <td>{{ optional($item->user)->name }}</td>
                  <td class="text-center">
                    @if ($item->typeFile != "youtube")
                    <form id="form{{ $loop->iteration }}" action="/download" method="post" style="display:inline;">
                      @csrf
                      <input type="hidden" name="konten" value="{{ $item->direktori }}">
                      <a onclick="document.getElementById('form{{ $loop->iteration }}').submit();" type="button" data-toggle="tooltip" title="download">
                        <i class="fas fa-solid fa-download" style="color: #20c544;"></i>
                      </a>
                    </form>
                    @endif

                    <a href="#" class="edit-btn"
                      data-id="{{$item->id}}"
                      data-direktori="{{ $item->typeFile }}"
                      data-duration="{{ $item->duration }}"
                      data-str-date="{{ $item->str_date }}"
                      data-ed-date="{{ $item->ed_date }}"
                      data-selected-days="{{ $item->selected_days }}"
                      data-youtube="{{ $item->youtube_link }}"
                      data-toggle="tooltip" title="Edit">
                      <i class="far fa-edit" style="color: #1e1efa;"></i>
                    </a>

                    <a href="#" class="text-danger delete-item" data-id="{{ $item->id }}" data-toggle="tooltip" title="Hapus">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- --- MODAL EDIT (SUDAH DILENGKAPI BIAR TIDAK BLANK HITAM) --- --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Content Source</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('editDuration') }}" method="POST">
                @csrf
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="uid" name="uid">
                <div class="modal-body">
                    <div class="row">
                        <div id="durationDiv" class="form-group col-12">
                            <label>Duration (ms)</label>
                            <input type="number" id="duration" name="duration" class="form-control">
                        </div>
                        <div id="youtube_group" class="form-group col-12" style="display:none;">
                            <label>Link YouTube</label>
                            <input type="text" id="youtube_link" name="youtube_link" class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label>Start Date</label>
                            <div class="input-group date" id="strDate" data-target-input="nearest">
                                <input type="text" name="str_date" id="str_date" class="form-control datetimepicker-input" data-target="#strDate">
                                <div class="input-group-append" data-target="#strDate" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>End Date</label>
                            <div class="input-group date" id="edDate" data-target-input="nearest">
                                <input type="text" name="ed_date" id="ed_date" class="form-control datetimepicker-input" data-target="#edDate">
                                <div class="input-group-append" data-target="#edDate" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div>
                            </div>
                        </div>
                            {{-- Edit ceklis Allday --}}
                        <div class="form-group col-12">
                            <label>Days</label>
                            <div class="d-flex flex-wrap mb-3" style="gap:10px;">
                                @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $idx => $day)
                                <div class="border p-2 text-center" style="min-width:60px; border-radius: 5px;">
                                    {{-- Tambahkan class 'day-chk' di sini --}}
                                    <input type="checkbox" name="selected_days[]" class="day-chk" value="{{$idx+1}}"> <br>
                                    <small><b>{{$day}}</b></small>
                                </div>
                                @endforeach
                            </div>

                            {{-- Gunakan onclick="pilihSemuaHari(this)" agar langsung terpanggil --}}
                            <div class="form-check">
                                <input type="checkbox" id="checkAllDays" class="form-check-input" onclick="pilihSemuaHari(this)">
                                <label class="form-check-label" for="checkAllDays" style="font-size: 14px; cursor: pointer; font-weight: bold; color: #007bff;">
                                    <i class="fas fa-check-double"></i> Select All Days
                                </label>
                            </div>
                        </div>
                        {{-- END Edit ceklis Allday --}}

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW --}}
<div class="modal fade" id="modalShowKonten" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content"><div class="modal-body text-center" id="player"></div></div>
    </div>
</div>

<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
window.addEventListener('load', function() {
    // 1. Inisialisasi DataTable
    var table = $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": [{ text: 'Tambah Data <i class="fas fa-plus-square"></i>', action: function() { window.location.href = "{{ route('createfile') }}"; }, className: 'btn-success' }],
        "columnDefs": [{ "orderable": false, "targets": 0 }]
    });
    table.buttons().container().appendTo('#button_tambah_container');

    // 2. Logika Pilih Semua
    var isAllSelected = false;
    $('#btnSelectAll').on('click', function() {
        isAllSelected = !isAllSelected;
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input.sub_chk', rows).prop('checked', isAllSelected);
        $(this).html(isAllSelected ? '<i class="far fa-window-close"></i> Batal Pilih' : '<i class="far fa-check-square"></i> Pilih Semua');
        updateDeleteUI();
    });

    $('#example1 tbody').on('change', 'input.sub_chk', function() { updateDeleteUI(); });

    function updateDeleteUI() {
        var checkedCount = table.$('input.sub_chk:checked').length;
        $('#countSelected').text(checkedCount);
        if (checkedCount > 0) { $('#deleteAll').fadeIn(); } else { $('#deleteAll').fadeOut(); }
    }

    // 3. Hapus Masal
    $('#deleteAll').on('click', function() {
        var ids = [];
        table.$('input.sub_chk:checked').each(function() { ids.push($(this).attr('data-id')); });
        Swal.fire({ title: 'Hapus '+ids.length+' data?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Hapus!' }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({ url: "{{ route('hapusmasal') }}", type: 'DELETE', data: { _token: "{{ csrf_token() }}", ids: ids.join(",") }, success: function() { location.reload(); } });
            }
        });
    });

    // 4. Fungsi Edit
    $('body').on('click', '.edit-btn', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');
        var direktori = $(this).data('direktori');
        $('#id').val(uid); $('#uid').val(uid);
        if (direktori == "images") { $('#durationDiv').show(); $('#duration').val($(this).data('duration')); } else { $('#durationDiv').hide(); }
        $('#str_date').val($(this).data('str-date'));
        $('#ed_date').val($(this).data('ed-date'));
        $('#exampleModalCenter').modal('show');
    });

    // 5. Preview & Hapus Satuan
$('body').on('click', '#showKonten', function(e) {
    e.preventDefault();
    var type = $(this).data('type');
    var direktori = $(this).data('konten');
    var player = document.getElementById("player");

    // --- LOGIKA BARU AGAR YOUTUBE BISA TAMPIL ---
    if (type == "youtube") {
        var videoId = extractYouTubeId(direktori);
        if(videoId) {
            player.innerHTML = `<iframe width="100%" height="450"
                                src="https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1"
                                frameborder="0" allow="autoplay; encrypted-media"
                                allowfullscreen></iframe>`;
        } else {
            player.innerHTML = `<div class="alert alert-danger">ID YouTube tidak valid Booss!</div>`;
        }
    }
    else if (type == "images") {
        player.innerHTML = `<img src="${direktori}" style="max-width:100%">`;
    }
    else {
        player.innerHTML = `<video src="${direktori}" autoplay loop muted style="width:100%"></video>`;
    }

    $('#modalShowKonten').modal('show');
});

// Fungsi pembantu ambil ID Video YouTube (Tetap taruh di sini Booss)
function extractYouTubeId(url) {
    // Regex sakti untuk menangkap ID dari link biasa, embed, maupun LIVE
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|live\/)([^#\&\?]*).*/;
    var match = url.match(regExp);

    // Kembalikan ID jika panjangnya 11 karakter (standar YouTube)
    return (match && match[2].length == 11) ? match[2] : null;
}

    $('body').on('click', '.delete-item', function(e) {
        e.preventDefault();
        var itemId = $(this).data('id');
        Swal.fire({ title: 'Hapus data?', icon: 'warning', showCancelButton: true }).then((result) => {
            if (result.isConfirmed) { window.location.href = 'deletefile/' + itemId; }
        });
    });

    // 6. Init Datepicker
    $('#strDate, #edDate').datetimepicker({ format: 'YYYY-MM-DD HH:mm', sideBySide: true });
});



// Javascript untuk checklist Allday di Modal Edit
// 1. Logika Klik "Pilih Semua Hari"
$('body').on('click', '#checkAllDays', function() {
    // Ambil status apakah tombol utama diceklis atau tidak
    var isChecked = $(this).is(':checked');

    // Paksa semua checkbox hari mengikuti status tombol utama
    $('.day-chk').prop('checked', isChecked);
});

// 2. Logika Balikan (Jika hari di-uncheck manual satu per satu)
$('body').on('change', '.day-chk', function() {
    var totalHari = $('.day-chk').length;
    var totalDiceklis = $('.day-chk:checked').length;

    // Jika semua hari diceklis manual, maka tombol "Pilih Semua" otomatis ikut nyala
    if (totalDiceklis === totalHari) {
        $('#checkAllDays').prop('checked', true);
    } else {
        $('#checkAllDays').prop('checked', false);
    }
});

// END NEW
function pilihSemuaHari(sumber) {
    // Ambil semua elemen yang punya class 'day-chk'
    var checkboxes = document.getElementsByClassName('day-chk');

    // Paksa setiap kotak hari mengikuti status tombol "Pilih Semua"
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = sumber.checked;
    }
}
</script>

@if(session('toast_success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('toast_success') }}", timer: 3000, showConfirmButton: false });</script>
@endif
@endsection
