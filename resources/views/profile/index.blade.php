@extends('layouts.template') 
 
@section('content')
<div class="d-flex justify-content-center row row-cols-lg-2 mx-3">
    <div class="card card-primary card-outline mr-lg-3 col-lg-3'">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="{{ auth()->user()->profile_url ? asset('profile_picture/' . auth()->user()->profile_url) : asset('storage/profile_picture/blank_profile.jpg') }}"
                 alt="User profile picture">
          </div>
    
          <h3 class="profile-username text-center">{{ Auth::user()->nama }}</h3>
    
          <p class="text-muted text-center">{{ Auth::user()->level->level_nama }}</p>
    
          <a onclick="modalAction('{{ url('profile/upload_profile_ajax')}}')" class="btn btn-primary btn-block"><b>Upload Profil</b></a>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-primary mr-lg-3 col-lg-6">
        <div class="card-header">
          <h3 class="card-title">About Me</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-book mr-1"></i> Education</strong>
    
          <p class="text-muted">
            B.S. in Computer Science from the University of Tennessee at Knoxville
          </p>
    
          <hr>
    
          <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
    
          <p class="text-muted">Malibu, California</p>
    
          <hr>
    
          <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
    
          <p class="text-muted">
            <span class="tag tag-danger">UI Design</span>
            <span class="tag tag-success">Coding</span>
            <span class="tag tag-info">Javascript</span>
            <span class="tag tag-warning">PHP</span>
            <span class="tag tag-primary">Node.js</span>
          </p>
    
          <hr>
    
          <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
    
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
        </div>
        <!-- /.card-body -->
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection 
 
@push('css') 
@endpush 

@push('js')
<script>
    function modalAction(url = '') {
      $('#myModal').load(url, function() {
          $('#myModal').modal('show');
      });
    } 
</script>
@endpush