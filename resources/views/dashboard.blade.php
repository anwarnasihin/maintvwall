@extends('layouts.master')
@section('title.home')
@section('content')
<section class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <img src="assets/dist/img/b1.png" alt="Description of the image" style="display: block; margin: 0 auto;" width="290" height="290">
            <h2 class="card-body" style="text-align: center; font-size: 24px; font-weight: bold; color: #007BFF; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                Welcome to the <span style="color: #FF5733;">BINUS @Bekasi TV Wall</span> Application
            </h2>
            
            
        </div>
        

    </div>

</section>
@endsection