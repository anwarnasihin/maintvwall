@extends('layouts.master')
@section('title.home')
@section('content')
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
                  <td>{{ $item->direktori }}</td>
                  <td>{{ $item->duration }}</td>
                  <td>{{ $item->str_date }}</td>
                  <td>{{ $item->ed_date }}</td>
                  <td class="text-center">
                    @if ($item->typeFile == "images")
                    <a href="#" id="edit" data-id="{{$item->id}}"><i class="fas fa-regular fa-stopwatch" style="color: #fdf512;margin-right:3px"></i></a>
                    @endif

                    <a href="{{ url('deletefile',$item->id) }}"><i class="fas fa-trash-alt" style="color: crimson"></i></a>
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
              <h5 class="modal-title" id="exampleModalCenterTitle">Duration Image</h5>
              <button type="button" onclick="$('#formDuration').trigger('reset')" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formDuration" method="post" action="/editDuration">
              @csrf
              <input type="text" id="id" name="id" hidden>
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" id="duration" name="duration" class="form-control" placeholder="Millisecond">
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
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script>
  $(document).on('click', '#edit', function(e) {
    e.preventDefault();
    var uid = $(this).data('id');

    $('#id').val(uid);
    $('#exampleModalCenter').modal('show');
  })
</script>

<!-- jQuery -->
<script src="{{asset ('assets/plugins/jquery/jquery.min.js')}}"></script>
<script>
  $(function() {
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
        targets: [5, 6],
        render: function(oTable) {
          return moment(oTable).format('DD-MM-YYYY');
        }
      }, ],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection
@include('sweetalert::alert')