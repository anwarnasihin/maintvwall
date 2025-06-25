@extends('layouts.master')
@section('title.home')
@section('content')
<section class="content">
    <section class="content-header">
        <div class="container-fluid">
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
        <div class="card-body" style="background-image: url('assets/dist/img/Wallpaper-ZOOM.003.jpeg'); background-size: cover; background-repeat: no-repeat; min-height: 45em;">
            <h2 class="card-body" style="text-align: center; font-size: 30px; font-weight: bold; color: #007BFF; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                <span style="color: #007BFF; opacity: 0.8;">Welcome to the </span><span style="color: #FF5733;">BINUS @Bekasi TV Wall</span> <span style="opacity: 0.8;">Application</span>
            </h2>

            <img src="assets/dist/img/C.png" alt="Description of the image" style="display: block; margin: 0 auto;" width="85" height="95">


            <!-- <div class="mt-4">
                @if(count($files) > 0)
                    @foreach ($files as $file)
                        <div class="mb-4 text-center">
                            @if ($file->typeFile == 'images')
                                <img src="{{ asset($file->direktori) }}" 
                                    style="max-width: 80%; height: auto; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);">
                            @elseif ($file->typeFile == 'video')
                                <video style="max-width: 80%;" controls autoplay loop>
                                    <source src="{{ asset($file->direktori) }}" type="video/mp4">
                                </video>
                            @elseif ($file->typeFile == 'youtube')
                                <iframe width="80%" height="400px" 
                                        src="{{ $file->direktori }}" frameborder="0" allowfullscreen></iframe>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-muted mt-3" style="font-size: 20px;">Tidak ada konten aktif hari ini.</p>
                @endif
            </div> -->


        </div>


    </div>

</section>
@endsection