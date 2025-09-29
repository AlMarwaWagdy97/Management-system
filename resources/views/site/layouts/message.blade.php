@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show mt-3 mx-2" role="alert">
    <p class="text-center">{{ session('success') }} </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


@if(session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show mt-3 mx-2" role="alert">
    <p class="text-center">{{ session('error') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session()->has('warning'))
  <div class="alert alert-warning alert-dismissible fade show mt-3 mx-2" role="alert">
    <p class="text-center"> {{ session('warning') }} </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


{{-- @if(@count($errors->all()) > 0)
<div class="alert alert-danger alert-dismissible fade show mt-3 mx-2" role="alert">
  <div  class="text-center">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif --}}
