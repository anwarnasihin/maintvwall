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
                    <a href="#" class="btn btn-success">Tambah Data <i class="fas fa-plus-square"></i></a>
                    
                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Group</th>
                        <th>Type File</th>
                        <th>Direktori</th>
                        <th>Duration</th>
                        <th>Aksi</th>
                      </tr>

                      @foreach ($dataFile as $item)
                          
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->group}}</td>
                        <td>{{ $item->typeFile }}</td>
                        <td>{{ $item->direktori }}</td>
                        <td>{{ $item->duration }}</td>
                        <td></td>
                      </tr>
                      
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              <!-- /.card -->
               <!-- /.card-body -->
               <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
@endsection

