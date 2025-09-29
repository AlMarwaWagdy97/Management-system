@extends('cashier.site.layout')

@section('content')
<div class="container">
<div class="row min-vh-100 d-flex justify-content-center align-items-center">
  <div class="col-md-4">
    <h3 class="mb-3">تسجيل دخول الكاشير</h3>

    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('site.cashier.login.post') }}">
      @csrf

      <div class="mb-3">
        <label for="email">البريد الإلكتروني</label>
        <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus>
      </div>

      <div class="mb-3">
        <label for="password">كلمة المرور</label>
        <input id="password" name="password" type="password" class="form-control" required>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label for="remember" class="form-check-label">تذكرني</label>
      </div>

      <button class="btn btn-primary w-100" type="submit">دخول</button>
    </form>
  </div>
</div>
</div>

@endsection
