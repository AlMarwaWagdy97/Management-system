<!doctype html>
<html lang="en" @if (app()->getLocale() == 'ar') dir="rtl" @else  dir="ltr" @endif class="{{ Cookie::get('mode') }} {{ Cookie::get('color-header') }}  {{ Cookie::get('color-side') }}">
@include('admin.layouts.header')

<body @if (app()->getLocale() == 'ar') dir="rtl" @else  dir="ltr" @endif>
    <style>
        .topbar {
            left: 0;
        }
    </style>
	<div class="wrapper">
        <!-- Navbar ---- -->
        @include('admin.layouts.navbar')

        <div class="error-404 d-flex align-items-center justify-content-center mt-5">
			<div class="container">
				<div class="card py-5">
					<div class="row g-0">
						<div class="col col-xl-5">
							<div class="card-body p-4">
								<h1 class="display-1"><span class="text-primary">@yield('code')</span></h1>
								<h2 class="font-weight-bold display-4">@yield('error_title')</h2>
								<p>@yield('message')</p>
								<div class="mt-5"> <a href="{{ route('admin.home') }}" class="btn btn-primary btn-lg px-md-5 radius-30">Go Home</a>
									<a href="javascript:history.back()" class="btn btn-outline-dark btn-lg ms-3 px-md-5 radius-30">Back</a>
								</div>
							</div>
						</div>
						<div class="col-xl-7">
							<img src="@yield('image', admin_path('images/errors-images/sad.jpg'))" class="img-fluid" alt="" width="550px">
						</div>
					</div>
					<!--end row-->
				</div>
			</div>
		</div>

        <!-- footer -->
        @include('admin.layouts.footer')

	</div>

    <!-- search Modal ---- -->
    @include('admin.layouts.search')

    <!-- Right Side Navbar ---- -->
    @include('admin.layouts.right-sidebar')

   <!-- JAVASCRIPT -->
   @include('admin.layouts.script')


</body>

</html>

