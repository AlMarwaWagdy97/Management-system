@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  {{session('warning') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


@if(count($errors->all()) > 0)
      @foreach($errors->all() as $error)
        <h5 class="success-message text-danger mt-1">
            <span class="message"> {{ $error }} </span>
        </h5>
      @endforeach
@endif
