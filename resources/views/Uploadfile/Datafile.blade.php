@extends('layouts.master')
@section('title.home')
@section('content')

<style>
  #player img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
  }

  #player video {
    width: 100%;
    height: auto;
  }

  #youtube-player {
    width: 100%;
    height: 100%;
  }

  .day-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
  }

  .day-wrapper .form-check-inline {
    margin-right: 15px;
    margin-bottom: 10px;
  }

  .modal-lg {
    max-width: 900px !important;
  }

  .form-check-input {
    margin-right: 5px;
  }

  .form-check-label {
    margin-bottom: 0;
    font-weight: normal;
  }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{$judul}}</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" style="width: 10px">No</th>
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
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>{{ $item->groups ? $item->groups->name : ' ' }}</td>
                  <td>{{ $item->typeFile }}</td>
                  <td><a id="showKonten" href="#" data-type="{{ $item->typeFile }}" data-konten="{{ $item->direktori }}">{{ $item->direktori }}</a></td>
                  <td>{{ $item->duration }}</td>
                  <td>{{ $item->str_date }}</td>
                  <td class="{{$item->ed_date <= date('Y-m-d')?'text-danger':''}}">{{ $item->ed_date }}</td>
                  <td>{{ optional($item->user)->name }}</td>
                  <td class="text-center">
                    @if ($item->typeFile != "youtube")
                    <form id="form{{ $loop->iteration }}" action="/download" method="post">
                      @csrf
                      <input type="hidden" name="konten" value="{{ $item->direktori }}">
                      <a onclick="document.getElementById('form{{ $loop->iteration }}').submit();" type="submit" data-toggle="tooltip" title="download">
                        <i class="fas fa-solid fa-download" style="color: #00f5e4;"></i>
                      </a>
                    </form>
                    @endif
                    <a href="#" id="edit"
                      data-id="{{$item->id}}"
                      data-direktori="{{ $item->typeFile }}"
                      data-duration="{{ $item->duration }}"
                      data-str-date="{{ $item->str_date }}"
                      data-ed-date="{{ $item->ed_date }}"
                      data-selected-days="{{ $item->selected_days }}"
                      data-toggle="tooltip" title="Edit">
                      <i class="far fa-edit" style="color: #e7ea2e;"></i>
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
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
 <!-- Modal edit -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Edit Source</h5>
              <button type="button" onclick="resetForm()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formDuration" method="post" action="/editDuration">
              @csrf
              <input type="hidden" id="id" name="id">

              <div class="modal-body">
                <div class="row">
                  <div id="durationDiv" class="form-group col-12">
                    <label for="duration">Duration (milliseconds)</label>
                    <input type="number" id="duration" name="duration" class="form-control" placeholder="Enter duration in milliseconds" min="0">
                    <small class="form-text text-muted">Only applicable for images. Leave empty for videos.</small>
                  </div>

                  <div class="form-group col-6">
                    <label for="str_date">Start Date</label>
                    <div class="input-group date" id="strDate" data-target-input="nearest">
                      <input type="text" name="str_date" id="str_date" class="form-control datetimepicker-input" data-target="#strDate" placeholder="YYYY-MM-DD">
                      <div class="input-group-append" data-target="#strDate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-6">
                    <label for="ed_date">End Date</label>
                    <div class="input-group date" id="edDate" data-target-input="nearest">
                      <input type="text" name="ed_date" id="ed_date" class="form-control datetimepicker-input" data-target="#edDate" placeholder="YYYY-MM-DD">
                      <div class="input-group-append" data-target="#edDate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                 
                  <div class="mb-4 col-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Days <span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-3">
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

                    <div class="mt-4 form-check">
                      <input type="checkbox" id="checkAll" class="form-check-input" />
                      <label class="form-check-label" for="checkAll">Select All Days</label>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Select which days of the week this media should be displayed</p>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="resetForm()" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="modalShowKonten" tabindex="-1" role="dialog" aria-labelledby="modalShowKontenTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Preview Content</h5>
              <button type="button" class="close" onclick="player.innerHTML = '';" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="player"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="player.innerHTML = '';">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>
<script>
  function resetForm() {
    $('#formDuration')[0].reset();
    $('input[name="selected_days[]"]').prop('checked', false);
    $('#checkAll').prop('checked', false);
  }

  function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
  }

  $(document).on('click', '#edit', function(e) {
    e.preventDefault();
    var uid = $(this).data('id');
    var direktori = $(this).data('direktori');
    var duration = $(this).data('duration');
    var strDate = $(this).data('str-date');
    var edDate = $(this).data('ed-date');
    var selectedDays = $(this).data('selected-days');

    console.log('Edit data:', {
      id: uid,
      direktori: direktori,
      duration: duration,
      strDate: strDate,
      edDate: edDate,
      selectedDays: selectedDays
    });

    // Reset form first
    resetForm();

    // Set values
    $('#id').val(uid);

    if (direktori == "images") {
      $('#durationDiv').show();
      $('#duration').val(duration || '');
    } else {
      $('#durationDiv').hide();
      $('#duration').val('');
    }

    // Set dates
    if (strDate) {
      $('#str_date').val(formatDate(strDate));
    }
    if (edDate) {
      $('#ed_date').val(formatDate(edDate));
    }

    // Set selected days
    if (selectedDays) {
      try {
        var days = [];
        if (typeof selectedDays === 'string') {
          days = JSON.parse(selectedDays);
        } else if (Array.isArray(selectedDays)) {
          days = selectedDays;
        }

        console.log('Parsed days:', days);

        if (Array.isArray(days)) {
          days.forEach(function(day) {
            var dayValue = String(day); // Convert to string for comparison
            $('input[name="selected_days[]"][value="' + dayValue + '"]').prop('checked', true);
            console.log('Checking day:', dayValue);
          });

          // Check if all days are selected
          if (days.length === 7) {
            $('#checkAll').prop('checked', true);
          }
        }
      } catch (e) {
        console.log('Error parsing selected days:', e);
      }
    }

    $('#exampleModalCenter').modal('show');
  });

  $(document).on('click', '#showKonten', function(e) {
    e.preventDefault();
    var type = $(this).data('type');
    var direktori = $(this).data('konten');
    var player = document.getElementById("player");
    var mediaPlayer;

    function createVideoPlayer(src) {
      var videoPlayer = document.createElement("video");
      videoPlayer.id = "videoPlayer";
      videoPlayer.src = src;
      videoPlayer.muted = true;
      return videoPlayer;
    }

    function createImagePlayer(src) {
      var imagePlayer = document.createElement("img");
      imagePlayer.id = "imagePlayer";
      imagePlayer.src = src;
      imagePlayer.alt = "Slideshow Image";
      return imagePlayer;
    }

    if (type == "images") {
      mediaPlayer = createImagePlayer(direktori);
      player.innerHTML = "";
      player.appendChild(mediaPlayer);
    }

    if (type == "video") {
      mediaPlayer = createVideoPlayer(direktori);
      player.innerHTML = "";
      player.appendChild(mediaPlayer);

      mediaPlayer.addEventListener('loadedmetadata', function() {
        var videoDuration = Math.floor(mediaPlayer.duration * 1000);
        setTimeout(function() {
          currentData++;
          playVideoAndImage();
        }, videoDuration);
        mediaPlayer.play();
      });
    }

    if (type == "youtube") {
      var youtubeUrl = direktori;
      var startPos = youtubeUrl.lastIndexOf("/") + 1;
      var videoCode = youtubeUrl.substring(startPos);

      player.innerHTML = "";
      var youtubePlayerDiv = document.createElement('div');
      youtubePlayerDiv.id = 'youtube-player';
      player.appendChild(youtubePlayerDiv);

      var youtubePlayerDiv = new YT.Player('youtube-player', {
        height: '100%',
        width: '100%',
        videoId: videoCode,
        playerVars: {
          'controls': 0,
          'autoplay': 1,
        }
      });
    }

    $('#modalShowKonten').modal('show');
  });

  // Script untuk handle ceklis "All Day"
  $(document).ready(function() {
    $('#checkAll').on('change', function() {
      const isChecked = $(this).is(':checked');
      $('input[name="selected_days[]"]').prop('checked', isChecked);
    });

    // Check "All Day" if all individual days are selected
    $('input[name="selected_days[]"]').on('change', function() {
      const totalDays = $('input[name="selected_days[]"]').length;
      const checkedDays = $('input[name="selected_days[]"]:checked').length;
      $('#checkAll').prop('checked', checkedDays === totalDays);
    });
  });
</script>

<!-- jQuery -->
<script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
<script>
  $(function() {
    //Date picker
    $('#strDate,#edDate').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": [{
        text: 'Tambah Data <i class="fas fa-plus-square"></i>',
        action: function(e, dt, node, config) {
          window.location.href = "{{ route('createfile') }}";
        },
        className: 'btn-success'
      }],
      "columnDefs": [{
        "className": "text-center",
        "targets": [0, 1, 2, 3, 4, 5],
      }, {
        targets: [5, 6],
        render: function(oTable) {
          return moment(oTable).format('YYYY-MM-DD');
        }
      }],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-item').forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var itemId = this.dataset.id;

        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: 'Anda tidak akan dapat mengembalikan data ini!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'deletefile/' + itemId;
          }
        });
      });
    });
  });
</script>

@include('sweetalert::alert')
@if(session('toast_success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('toast_success') }}",
  });
</script>
@endif
@endsection