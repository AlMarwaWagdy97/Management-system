@if(session()->has('success'))
  <div class="alert alert-success border-0 bg-success alert-dismissible fade show text-center">
    <div class="text-white">{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


@if(session()->has('error'))
  <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show  text-center">
    <div class="text-white">{{ session('error') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session()->has('warning'))
  <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show  text-center">
    <div class="text-white">{{ session('warning') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


@if(count($errors->all()) > 0)
  <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show  text-center">
    <div class="text-white">
      @foreach($errors->all() as $error)
        <li class="list-group-item">{{ $error }}</li>
      @endforeach
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
