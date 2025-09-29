@extends('site.app')
@section('title', __('Add Payment Cards'))
@section('content')

<main class="ProfileSection">
<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.profile.side-menu />

            <!--edit section -->
            <div class="col-12 order-lg-2 order-2 col-lg-9 mx-auto ">
                <div class="Visa row">
                  <div class="info shadow  custom-border bg-white  px-md-5 py-md-5  m-md-4">
                        <h1 class="fs-4 text-md-end text-center mt-5 text-black"> @lang('Add Payment Cards') </h1>
                        <form action="{{ route('site.profile.cards.save') }}" method="POST">
                          @csrf


                          <div class="row AddVisa bg-light text-md-end text-center mx-1 my-3">

                            <div class="col-md-6 col-12 mt-5 mx-0 mx-md-auto mb-5">
                              <div class="NumberOfcard row col-12">
                                <label class=""> @lang('Card Number') </label>
                                <input type="text" name="number" maxlength="16" required placeholder=" xxxx xxxx xxxx xxxx"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                  class="form-control bg-white px-md-2 mx-2 mt-1 rounded-pill @error('number') is-invalid @enderror">
                                  @error('number')
                                    <span class="text-danger">{{ $message }}</span>
                                  @enderror
                              </div>
              
                              <div class="NumberOfcard col-12 row my-4">
                                <div class="row col-8 ">
                                  <label class="col-12 fs-6 px-0 me-2"> @lang('Expired Date') </label>
                                  <div class="col-12 row">
                                      <div class="col-lg-6 col-12 px-1">
                                          <input type="text" name="expired_month" maxlength="2" required placeholder="MM" class="form-control mm @error('expired_month') is-invalid @enderror" id="expMonth"
                                          inputmode="numeric" pattern="[0-9]*"
                                          oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                          @error('expired_month')
                                            <span class="text-danger">{{ $message }}</span>
                                          @enderror
                                      </div>
                                      <div class="col-lg-6 col-12 px-1">
                                          <input type="text" name="expired_year" maxlength="2" required placeholder=" YY" class="form-control yy mt-1 mt-lg-0 @error('expired_year') is-invalid @enderror" id="expYear" 
                                            inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  >
                                            @error('expired_year')
                                              <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                      </div>
                                  </div>
                                </div>
  
                                <div class="row col">
                                  <label class="fs-6 px-0 me-2"> @lang('CVV') </label>
                                  <input type="text" name="cvv" maxlength="3" required placeholder=" CVV"
                                  id="cvv" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    class="form-control col px-2 rounded-pill @error('cvv') is-invalid @enderror">
                                    @error('cvv')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
            
                              </div>
              
                              <div class="NumberOfcard row  col-12">
                                <label class=""> @lang('The name registered on the card') </label>
                                <input type="text" name="name" required id="visaname" required class="form-control bg-white mx-2 mt-1 px-2 rounded-pill  @error('cvv') is-invalid @enderror"">
                                @error('name')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>       
                            </div>
              
                            <div class="col-md-6 col-12 justify-content-center align-content-center  mt-5 mb-5">
                              <div class="col-12">
                                <img src="{{ site_path('img/visa/payment-cards.png') }}" class="img-fluid w-100 flip-img" alt="">
                              </div>
                            </div>
                          </div>

                          <div class="submit mt-4 float-right">
                            <button type="submit" class="btn bg-main col col-xl-3  fs-5 mx-3 text-center text-white"> @lang('Save') </button>
                          </div>

                        </form>
            
                      </div>
                </div>

            </div>

        </div>
    </div>
</div>
</main>

@endsection
