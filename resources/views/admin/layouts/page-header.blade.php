<div class="page-breadcrumb d-sm-flex align-items-center mb-3 ">
        <div class="breadcrumb-title pe-3">@yield('title', trans('admin.dashboard') )</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="@yield('title_route', route('admin.home'))"> @yield('title_page', trans('admin.dashboard') )</a>
                    </li>
                </ol>
            </nav>
        </div>
    
    <div class="ms-auto text-end">
        <div class="btn-group">
            @yield('button_page')
        </div>
    </div>
</div>
<hr>