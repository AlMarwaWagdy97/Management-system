<!--Menu section-->
<div class="col-12 order-lg-1 order-1 col-lg-3">
        
    <!--Menu-->
    <div class="row border-main my-4 mx-3 bg-white">

        <div class="col-12 meun-li p-3 {{ Route::is('site.referer.index') ? 'active' : '' }} ">
            <a href="{{ route('site.referer.index') }}">
                <div class="row py-2 justify-content-center align-content-center">
                    <div class="col-2">
                        <i class="icofont-user fs-3 text-main"></i>
                    </div>
                    <div class="col-10">
                        <h1 class="fs-5"> @lang('Personal account') </h1>
                    </div>
                </div>
            </a>
        </div>
        <hr>

              
 


        <div class="col-12  meun-li p-3 {{ Route::is('site.referer.orders.index') ? 'active' : '' }}">
            <a href="{{ route('site.referer.orders.index') }}">
            <div class="row py-2 justify-content-center align-content-center">
                <div class="col-2">
                    <i class="icofont-file-spreadsheet fs-3 text-main"></i>
                </div>
                <div class="col-10">
                    <h1 class="fs-5"> @lang('Orders List') </h1>
                </div>
            </div>
            </a>
        </div>
        <hr>
      
        <div class="col-12  meun-li p-3" dir="ltr">
            <a href="{{ route('site.logout') }}">
                <div class="row py-1  justify-content-center align-content-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-danger fs-6"> 
                            @lang('logout')
                            <i class="icofont-logout fs-6 px-1 text-white"></i>
                        </button>
                    </div>
                    
                </div>
            </a>
        </div>

    </div>
    <!--Menu-->

</div>
<!--Menu section-->