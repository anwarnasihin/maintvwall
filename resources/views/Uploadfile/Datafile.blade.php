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
                  <td>{{ $item->ed_date }}</td>
                  <td class="text-center">
                    @if ($item->typeFile != "youtube")
                    <form id="form{{ $loop->iteration }}" action="/download" method="post">
                      @csrf
                      <input type="hidden" name="konten" value="{{ $item->direktori }}">
                      <a onclick="document.getElementById('form{{ $loop->iteration }}').submit();" type="submit"><i class="fas fa-solid fa-download" style="color: #00f5e4;"></i></a>
                    </form>
                    @endif
                    <a href="#" id="edit" data-id="{{$item->id}}" data-direktori="{{ $item->typeFile }}" data-duration="{{ $item->duration }}"><i class="far fa-edit" style="color: #e7ea2e;"></i></a>
                    <a href="#" data-toggle="modal" data-target="#confirmDeleteModal">
                      <i class="fas fa-trash-alt" style="color: crimson"></i>
                    </a>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
          <!-- /.card -->
          <!-- /.card-body -->

        </div>
        <!-- /.card -->
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Edit Source</h5>
              <button type="button" onclick="$('#formDuration').trigger('reset')" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formDuration" method="post" action="/editDuration">
              @csrf
              <input type="text" id="id" name="id" hidden>
              <div class="modal-body">
                <div class="row">
                  <div id="durationDiv" class="form-group col-12">
                    <label>Duration</label>
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
              </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onclick="$('#formDuration').trigger('reset')" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="document.getElementById('formDuration').submit()">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Konfirmasi Penghapusan -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              Apakah Anda yakin ingin menghapus data ini?
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <a href="{{ url('deletefile', $item->id) }}" class="btn btn-danger">Hapus</a>
          </div>
      </div>
  </div>
</div>

      <!-- Modal -->
      <div class="modal fade" id="modalShowKonten" tabindex="-1" role="dialog" aria-labelledby="modalShowKontenTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="player.innerHTML = '';">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
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
  $(document).on('click', '#edit', function(e) {
    e.preventDefault();
    var uid = $(this).data('id');
    var direktori = $(this).data('direktori');

    $('#id').val(uid);
    if (direktori == "images") {
      $('#durationDiv').show();
      $('#duration').val($(this).data('duration'));
    } else {
      $('#durationDiv').hide();
      $('#duration').val(null);
    }

    $('#exampleModalCenter').modal('show');
  })

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
      // videoPlayer.controls = true;
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

        mediaPlayer.play(); // Play video after metadata is loaded
      });
    }

    if (type == "youtube") {
      var youtubeUrl = direktori;

      // Mencari posisi awal kode video
      var startPos = youtubeUrl.lastIndexOf("/") + 1;

      // Mengambil kode video dari URL
      var videoCode = youtubeUrl.substring(startPos);

      player.innerHTML = "";
      var youtubePlayerDiv = document.createElement('div');
      youtubePlayerDiv.id = 'youtube-player'; // Use a different ID to avoid conflicts
      player.appendChild(youtubePlayerDiv);

      var youtubePlayerDiv = new YT.Player('youtube-player', {
        height: '100%', // Set height to 100%
        width: '100%',
        videoId: videoCode,
        playerVars: {
          'controls': 0, // Kontrol video (0 untuk dihilangkan)
          'autoplay': 1, // Autoplay video (1 untuk ya)
          // ... tambahkan opsi lain sesuai kebutuhan
        }
      });
    }

    $('#modalShowKonten').modal('show');
  })
</script>

<!-- jQuery -->
<script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
<script>
  $(function() {
    //Date picker
    $('#strDate,#edDate').datetimepicker({
      format: 'DD/MM/YYYY'
    });


    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": [{
        text: 'Tambah Data <i class="fas fa-plus-square"></i>',
        action: function(e, dt, node, config) {
          // Mengarahkan ke rute Laravel menggunakan tautan Blade
          window.location.href = "{{ route('createfile') }}";
        },
        className: 'btn-success' // Menambahkan kelas CSS untuk warna hijau
      }],
      "columnDefs": [{
        "className": "text-center",
        "targets": [0, 1, 2, 3, 4, 5], // table ke 1
      }, {
        targets: [5, 6],
        render: function(oTable) {
          return moment(oTable).format('DD-MM-YYYY');
        }
      }, ],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@include('sweetalert::alert')
@endsection
