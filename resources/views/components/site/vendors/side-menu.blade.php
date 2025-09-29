 <!--Menu section-->
<div class="col-12 order-lg-1 order-1 col-lg-12">

    <!--Menu-->
    <div class="d-flex border-main my-4 mx-3 bg-white  justify-content-center align-content-center">

        <div class="meun-li p-3 {{ Route::is('site.vendors.index') ? 'active' : '' }} ">
            <a href="{{ route('site.vendors.index') }}">
                <div class="row py-2 justify-content-center align-content-center text-center">
                    <div class="">
                        <i class="icofont-home fs-3 text-main"></i>
                    </div>
                    <div class="col-10 mt-2">
                        <h1 class="fs-6"> @lang('Home') </h1>
                    </div>
                </div>
            </a>
        </div>
        <hr>





        <div class="meun-li p-3 {{ Route::is('site.vendors.orders.index') ? 'active' : '' }}">
            <a href="{{ route('site.vendors.orders.index') }}">
            <div class="row py-2 justify-content-center align-content-center text-center">
                <div class="">
                    <i class="icofont-file-spreadsheet fs-3 text-main"></i>
                </div>
                <div class="col-10 mt-2">
                    <h1 class="fs-6"> @lang('Orders List') </h1>
                </div>
            </div>
            </a>
        </div>
        <hr>

        <div class="meun-li p-3 {{ Route::is('site.vendors.products.index') ? 'active' : '' }}">
            <a href="{{ route('site.vendors.products.index') }}">
                <div class="row py-2 justify-content-center align-content-center text-center">
                    <div class="">
                        <i class="icofont-gift fs-3 text-main"></i>
                    </div>
                    <div class="col-10 mt-2">
                        <h1 class="fs-6"> @lang('Products')</h1>
                    </div>
                </div>
            </a>
        </div>
        <hr>

        <div class="meun-li p-3 {{ Route::is('site.vendors.products.create') ? 'active' : '' }}">
            <a href="{{ route('site.vendors.products.create') }}">
                <div class="row py-2  justify-content-center align-content-center text-center">
                    <div class="">
                        <i class="icofont-plus fs-3 text-main"></i>
                    </div>
                    <div class="col-10 mt-2">
                        <h1 class="fs-6"> @lang('Add a product')</h1>
                    </div>
                </div>
            </a>
        </div>
        <hr>



        <div class="p-3" dir="ltr">
            <a href="{{ route('site.logout') }}" class="text-danger nav-item">
                <div class="row py-2  justify-content-center align-content-center text-center">
                    <div class="">
                        <i class="icofont-logout fs-3 text-danger"></i>
                    </div>
                    <div class="col-10 mt-2">
                        <h1 class="fs-6"> @lang('logout')</h1>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <!--Menu-->

</div>
<!--Menu section-->
