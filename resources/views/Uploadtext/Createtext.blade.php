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
                        <h3>Upload Running Text</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ url('simpantext')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <label for="judul">Judul</label>
                            <input type="text" name="judul" class="form-control">

                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="content" class="form-control" cols="30" rows="5"></textarea>

                            {{-- STATUS --}}
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Publish</option>
                                <option value="0">Tidak Publish</option>
                            </select>

                            <br>

                            {{-- GROUP --}}
                            <div class="form-group">
                                <label>Ditampilkan pada Group</label>

                                <div class="border rounded p-3">

                                    @foreach ($groups as $group)
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="groups[]"
                                                value="{{ $group->id }}"
                                                id="group_{{ $group->id }}"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="group_{{ $group->id }}"
                                            >
                                                {{ $group->name }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>

                                <small class="text-muted">
                                    Pilih satu atau beberapa group yang akan menggunakan running text ini.
                                </small>
                            </div>

                            <br>

                            {{-- TOMBOL --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    Simpan Data
                                </button>
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

