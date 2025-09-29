<section id="projects">
    <div class="container mt-5">
        <div class="categories-nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">الكل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">مشاريع الاطعام</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">مشاريع الكساء</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> مشاريع السكن</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        أخـــــــرى
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">مشاريع السكن</a></li>
                        <li><a class="dropdown-item" href="#">صدقات اللحوم</a></li>
                        <li><a class="dropdown-item" href="#"> الوجبات الساخنة </a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="projects-body row">
            <!-- project -->
            <div class="col-lg-6">
                <div class="project shadow">
                    <div class="header d-flex">
                        <a class="project-title" href="" title="">
                            <h5>وقف الاوقاف</h5>
                        </a>
                        <ul class="project-social p-0 nav flex-column" data-bs-toggle="collapse"
                            href="#socialShare2" role="button" aria-expanded="false"
                            aria-controls="socialShare2">
                            <a class="social-share nav-link active">
                                <i class="icofont-share"></i>
                            </a>
                            <span class="collapse toggelShare" id="socialShare2">
                                <a target="blank" class="nav-link">
                                    <i class="icofont-facebook"></i>
                                </a>
                                <a target="blank" class="nav-link">
                                    <i class="icofont-brand-whatsapp"></i>
                                </a>
                                <a target="blank" class="nav-link">
                                    <i class="icofont-envelope"></i>
                                </a>
                                <a target="blank" class="nav-link">
                                    <i class="icofont-twitter"></i>
                                </a>
                            </span>
                        </ul>
                    </div>
                    <div class="project-img">
                        <a class="" href="#" title="">
                            <img class="" src="{{asset('site/img/projects/project1.png')}}">
                        </a>
                    </div>
                    <div class="project-details my-3">
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-success"
                                role="progressbar" style="width: 25%" aria-valuenow="37"
                                aria-valuemin="0" aria-valuemax="100">
                                37%
                            </div>
                        </div>

                        <div class="target mt-2">
                            <small class="">
                                تم جمع
                                <span class="target-number text-main"> 57,512 </span>
                                <span class="text-main"> ر.س </span>
                            </small>
                            <small class="float-start">
                                المتبقي
                                <span class="target-number text-secound"> 787,512 </span>
                                <span class="text-secound"> ر.س </span>
                            </small>
                        </div>

                    
                        
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">قال رسول الله صلى الله عليه وسلم : أن وكافل اليتيم كهاتين في الجنة , وأشار بإصبعه السبابة والوسطى</h5>
                        <hr/>
                        <h6 class="fs-6 mb-2 text-body-secondary">مبلغ التبرع</h6>
                            <div class="options">
                                <div class="option-item">
                                    <input type="radio" id="radio-1" value="" name="donation_type" required=""> 
                                    <label class="bg-secound" for="radio-1">
                                        <h6 class="title">سهم العطاء</h6>
                                        <div class="price">
                                            <span>512</span>
                                            <small>ر.س</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="option-item">
                                    <input type="radio" id="radio-2" value="" name="donation_type" required=""> 
                                    <label class="bg-main" for="radio-2">
                                        <h6 class="title">كفالة 6 شهور</h6>
                                        <div class="price">
                                            <span>2560</span>
                                            <small>ر.س</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="option-item">
                                    <input type="radio" id="radio-3" value="" name="donation_type" required=""> 
                                    <label class="bg-dark" for="radio-3">
                                        <h6 class="title">كفالة لمدة عام</h6>
                                        <div class="price">
                                            <span>5120</span>
                                            <small>ر.س</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        <hr/>
                        <div id="gift-block">
                            <label class="form-check-label checkbox-label">
                                <input class="form-check-input" type="checkbox" data-bs-toggle="collapse" data-bs-target="#gift-body">
                                <span class="checkbox"></span>
                              أرغب فى اهداء هذا التبرع
                            </label>
                            <div class="collapse py-3" id="gift-body">
                                <div class="gifts owl-carousel owl-rtl owl-loaded owl-drag">
                                    <div class="gift-item">
                                        <img src="{{asset('site/img/charities/charity.jpg')}}" alt="">
                                        <label for="gift-1" class="radio-label">
                                            <input type="radio" id="gift-1" value="" name="gift_type" required=""> 
                                            <span class="radio"></span>
                                        </label>
                                    </div>                                       
                                    <div class="gift-item">
                                        <img src="{{asset('site/img/charities/charity.jpg')}}" alt="">
                                        <label for="gift-2" class="radio-label">
                                            <input type="radio" id="gift-2" value="" name="gift_type" required=""> 
                                            <span class="radio"></span>
                                        </label>
                                    </div>                                       
                                    <div class="gift-item">
                                        <img src="{{asset('site/img/charities/charity.jpg')}}" alt="">
                                        <label for="gift-3" class="radio-label">
                                            <input type="radio" id="gift-3" value="" name="gift_type" required=""> 
                                            <span class="radio"></span>
                                        </label>
                                    </div>                                       
                                    <div class="gift-item">
                                        <img src="{{asset('site/img/charities/charity.jpg')}}" alt="">
                                        <label for="gift-4" class="radio-label">
                                            <input type="radio" id="gift-4" value="" name="gift_type" required=""> 
                                            <span class="radio"></span>
                                        </label>
                                    </div>                                       
                                </div>
                                <h5 class="fs-6 text-center my-3">بيانات المهدى اليه</h5>
                                <div class="mb-3 row">
                                    <label for="input-1" class="col-sm-2 col-form-label">الإسم</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="input-1">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="input-2" class="col-sm-2 col-form-label">الجوال</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="input-2">
                                    </div>
                                </div>
                                <label class="form-check-label checkbox-label">
                                    <input class="form-check-input" type="checkbox">
                                    <span class="checkbox"></span>
                                        ارسال نسخة من البطاقة الى جوالى
                                        
                                </label>
                                <hr/>
                                <label class="form-check-label checkbox-label">
                                    <input class="form-check-input" type="checkbox">
                                    <span class="checkbox"></span>
                                        اضافة اهداء لشخص اخر
                                </label>
                            </div>
                            
                        </div>
                        <hr/>
                        <div class="donation-now">
                            <input type="text" class="form-control"
                                placeholder="مبلغ اخر">
                            <button class="bg-main btn "> اتبرع
                                الان</button>
                            <button class="bg-secound btn ">
                                <i class="icofont-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    console.log('boo boo baa');

    $('.gifts').owlCarousel({
    rtl:true,
    loop:false,
    margin:10,
    nav:false,
    dots: true,
    
  })
</script>
