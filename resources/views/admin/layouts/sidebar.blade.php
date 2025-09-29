<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ admin_path('images/logos/holol-side-logo.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">@lang('admin.holol')</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.home') }}">
                <div class="parent-icon"> <i class='bx bx-tachometer'></i>
                </div>
                <div class="menu-title">@lang('admin.dashboard')</div>
            </a>
        </li>
        {{-- System (top-level) ------------------------------------------------ --}}
        <li class="menu-label"> @lang('admin.system') </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='fadeIn animated bx bx-dialpad'></i></div>
                <div class="menu-title">@lang('admin.system')</div>
            </a>
            <ul>
                {{-- Users --------------------------------------------------------------- --}}
                <li>
                    <a href="{{ route('admin.users.index') }}">
                        <i class='bx bx-user-circle'></i>@lang('admin.users')
                    </a>
                </li>
                {{-- Roles  ----------------------------------------------------------- --}}
                <li>
                    <a href="{{ route('admin.roles.index') }}">
                        <i class='bx bx-lock'></i>@lang('admin.roles')
                    </a>
                </li>
            </ul>
        </li>
        {{-- Domain (top-level) ------------------------------------------------ --}}
        <li>
            <a href="{{ route('admin.domains.index') }}">
                <div class="parent-icon"><i class='bx bx-globe'></i></div>
                <div class="menu-title">النطاق الالكتروني</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.domains.statistics') }}">
                <div class="parent-icon"><i class='bx bx-bar-chart'></i></div>
                <div class="menu-title">الإحصائيات</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}">
                <div class="parent-icon"><i class='bx bx-receipt'></i></div>
                <div class="menu-title">الطلبات</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.refers.index') }}">
                <div class="parent-icon"><i class='bx bx-user-pin'></i></div>
                <div class="menu-title">المسوقين</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.managers.index') }}">
                <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
                <div class="menu-title">المديرين</div>
            </a>
        </li>
        {{-- End Domain (top-level) -------------------------------------------- --}}
        {{-- CMS ------------------------------------------------ --}}
        {{-- <li class="menu-label"> @lang('admin.cms') </li> --}}
        {{-- <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">@lang('admin.cms')</div>
            </a>
            <ul>
                {{-- System --------------------------------------------------------------- --}}
                {{-- <li>
                    <a class="has-arrow">
                        <i class='fadeIn animated bx bx-dialpad'></i>@lang('admin.system')
                    </a>
                    <ul>
                        {{-- User --------------------------------------------------------------- --}}
                        {{-- <li>
                            <a href="{{ route('admin.users.index') }}">
                                <i class='bx bx-user-circle'></i>@lang('admin.users')
                            </a>
                        </li> --}}
                        {{-- End User --------------------------------------------------------------- --}}
                        {{-- Rules  ----------------------------------------------------------- --}}
                        {{-- <li>
                            <a href="{{ route('admin.roles.index') }}">
                                <i class='bx bx-lock'></i>@lang('admin.roles')
                            </a>
                        </li> --}}
                        {{-- End Rules ----------------------------------------------------------- --}}
                        {{-- Menus -------------------------------------------------------------- (hidden) --}}
                        {{-- <li>
                            <a href="{{ route('admin.menus.index') }}">
                                <i class="fadeIn animated bx bx-sitemap"></i> @lang('admin.menus')
                            </a>
                        </li> --}}
                        {{-- End Menus ----------------------------------------------------------- --}}
                        {{-- Pages --------------------------------------------------------------- (hidden) --}}
                        {{-- <li>
                            <a href="{{ route('admin.pages.index') }}">
                                <i class="fadeIn animated bx bx-layout"></i> @lang('admin.pages')
                            </a>
                        </li> --}}
                        {{-- End Pages ------------------------------------------------------------ --}}
                        {{-- news  --------------------------------------------------------------- --}}
                        {{-- <li>
                            <a href="{{ route('admin.news.index') }}">
                                <i class="fadeIn animated bx bx-news"></i> @lang('admin.news')
                            </a>
                        </li> --}}
                        {{-- End news  ----------------------------------------------------------- --}}
                        {{-- Slider --------------------------------------------------------------- (hidden) --}}
                        {{-- <li>
                            <a href="{{ route('admin.slider.index') }}">
                                <i class="fadeIn animated bx bx-slider-alt"></i> @lang('admin.slider')
                            </a>
                        </li> --}}
                        {{-- End Slider ----------------------------------------------------------- --}}
                        {{-- Contact Us ----------------------------------------------------------- (hidden) --}}
                        {{-- <li>
                            <a href="{{ route('admin.contact-us.index') }}">
                                <i class="fadeIn animated bx bx-envelope"></i> @lang('admin.contact_us')
                            </a>
                        </li> --}}
                        {{-- End Contact Us ------------------------------------------------------- --}}

                    </ul>
                </li>
                {{-- End System ----------------------------------------------------  --}}

                {{-- Blog ----------------------------------------------------------- (hidden) --}}
                {{-- <li>
                    <a class="has-arrow">
                        <i class='bx bxs-news'></i> @lang('admin.blogs')
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.categories.index') }}">
                                <i class='bx bx-category'></i>@lang('categories.categories')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.articles.index') }}">
                                <i class='bx bx-table'></i>@lang('articles.articles')
                            </a>
                        </li>
                    </ul>
                </li> --}}
                {{-- End Blog ------------------------------------------------------- --}}

                {{-- Works ----------------------------------------------------------- --}}
                <li>
                    {{-- <a class="has-arrow">
                        <i class='bx bx-layer-plus'></i> @lang('admin.works')
                    </a> --}}
                    <ul>
                        {{-- Portfolio tags ----------------------------------------------------------- --}}
                        {{-- <li>
                            <a href="{{ route('admin.portfolio-tags.index') }}">
                                <i class='bx bxs-purchase-tag-alt'></i> @lang('admin.tags')
                            </a>
                        </li> --}}
                        {{-- End Portfolio tags -------------------------------------------------------- --}}

                        {{-- Portfolio ----------------------------------------------------------- --}}
                        {{-- <li>
                            <a href="{{ route('admin.portfolio.index') }}">
                                <i class='bx bx-images'></i> @lang('portfolio.portfolio')
                            </a>
                        </li> --}}
                        {{-- End Portfolio -------------------------------------------------------- --}}

                        {{-- project -------------------------------------------------------------- --}}
                        {{-- <li>
                            <a href="{{ route('admin.projects.index') }}">
                                <i class='bx bx-briefcase-alt'></i> @lang('project.project')
                            </a>
                        </li> --}}
                        {{-- End project ---------------------------------------------------------- --}}

                        {{-- services ------------------------------------------------------------- --}}
                        {{-- <li>
                            <a href="{{ route('admin.services.index') }}">
                                <i class='bx bx-wink-smile'></i> @lang('services.services')
                            </a>
                        </li> --}}
                        {{-- End services --------------------------------------------------------- --}}
                    </ul>
                </li>
                {{-- End Works ------------------------------------------------------- --}}

   

            </ul>
        </li>

        {{-- Charity Section ------------------------------------------------ --}}
        {{-- <li class="menu-label"> @lang('admin.charity') </li> --}}


        {{-- Orders Section ------------------------------------------------ --}}
        {{-- <li class="menu-label"> @lang('admin.orders') </li> --}}


        {{-- charity ------------------------------------------------ --}}
        {{-- <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-bookmark-heart"></i>
                </div>
                <div class="menu-title">@lang('charityProject.charity projects')</div>
            </a>
            <ul>
                {{-- charity sections --------------------------------------------------------------- --}}
                {{-- <li>
                    <a href="{{ route('admin.charity.sections.index') }}">
                <i class='bx bx-category'></i>@lang('sections.sections')
                </a>
        </li> --}}
        {{-- End charity sections ----------------------------------------------------- --}}

        {{-- charity Categories --------------------------------------------------------------- --}}
        {{-- <li>
            <a href="{{ route('admin.charity.categories.index') }}">
                <i class='bx bx-category'></i>@lang('projectCategories.projectCategories')
            </a>
        </li> --}}
        {{-- End charity Categories ----------------------------------------------------- --}}

        {{-- charity Tags --------------------------------------------------------------- --}}
         {{-- <li>
                    <a href="{{ route('admin.charity.tag.index') }}">
                        <i class='bx bxs-purchase-tag-alt'></i>@lang('admin.tags')
                    </a>
                </li>  --}}
        {{-- End charity Tags -------------------------------------------------------- --}}
    
      
        {{-- Status  ---------------------------------------------------------------------------------- --}}
        {{-- <li>
            <a href="{{ route('admin.status.index') }}">
                <i class='bx bx-paperclip'></i>@lang('admin.status')
            </a>
        </li> --}}
        {{-- End Status  ---------------------------------------------------------------------------- --}}
    </ul>
    </li>
    {{-- <li>
        <a href="{{ route('admin.orders.index') }}">
            <div class="parent-icon">
                <i class='bx bxs-donate-heart'></i>
            </div>
            <div class="menu-title">
                @lang('admin.orders')
                <x-admin.layouts.pending-order-number />
            </div>
        </a>
    </li> --}}

    {{-- Donors  --------------------------------------------------------------- --}}
    {{-- <li>
        <a href="{{ route('admin.donors.index') }}">
            <div class="parent-icon"> <i class='bx bx-user-pin'></i>
            </div>
            <div class="menu-title">@lang('donors.donors')</div>
        </a>
    </li> --}}
    {{-- Clients Carts  --------------------------------------------------------------- --}}
    {{-- customers ----------------------------------------------------------- --}}
    {{-- <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class='bx bxs-news'></i>
            </div>
            <div class="menu-title"> @lang('admin.customers')</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('admin.visitors') }}">
                    <i class='bx bx-category'></i>@lang('admin.visitors')
                </a>
            </li>
            <li>
                <a href="{{ route('admin.clients') }}">
                    <i class='bx bx-category'></i>@lang('admin.clients')
                </a>
            </li>
            <li>
                <a href="{{ route('admin.clients-carts.index') }}">
                    <i class="bx bx-cart"></i>@lang('admin.clients_carts')
 
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- End customers ------------------------------------------------------- --}}

    {{-- End charity market ----------------------------------------------------- --}}

    {{-- Decease ----------------------------------------------------------- --}}
    {{-- <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class='bx bx-calendar-heart'></i></i>
            </div>
            <div class="menu-title">@lang('admin.decease')</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('admin.deceases.request.index') }}">
                    <i class='bx bx-radio-circle'></i>@lang('admin.requests')
                </a>
            </li>
            <li>
                <a href="{{ route('admin.deceases.projects.index') }}">
                    <i class='bx bx-radio-circle'></i>@lang('admin.projects')
                </a>
            </li>
        </ul>
    </li> --}}

    {{-- gifts products------------------------------------------------ --}}
    {{-- <li class="menu-label"> @lang('admin.gift_products') </li> --}}
    {{-- gifts ----------------------------------------------------------- --}}
    {{-- <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon">
                    <i class='bx bxs-card'></i>
                </div>
                <div class="menu-title">@lang('admin.gifts')</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('admin.gifts.categories.index') }}">
    <i class='bx bx-category'></i>
    @lang('admin.categories')
    </a>
    </li>
    <li>
        <a href="{{ route('admin.gifts.occasions.index') }}">
            <i class='bx bxs-purchase-tag-alt'></i>
            @lang('admin.occasions')
        </a>
    </li>
    <li>
        <a href="{{ route('admin.gifts.cards.index') }}">
            <i class='bx bxs-id-card'></i>
            @lang('admin.cards')
        </a>
    </li>
    </ul>
    </li> --}}
    {{-- Products ----------------------------------------------------------- --}}
    {{-- <li> --}}
    {{-- <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-gift'></i>
                </div>
                <div class="menu-title">@lang('Gift shop')</div>
            </a> --}}
    {{-- <ul> --}}
    {{-- Store Vendor --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.eccommerce.vendors.index') }}">
    <i class='bx bx-user-pin'></i>@lang('admin.vendors')
    </a>
    </li> --}}
    {{-- End Store Vendor ----------------------------------------------------------- --}}

    {{-- Store Vendor --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.eccommerce.categories.index') }}">
    <i class='bx bx-category'></i>@lang('admin.categories')
    </a>
    </li> --}}
    {{-- products-tags --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.eccommerce.tags.index') }}">
    <i class='bx bxs-purchase-tag-alt'></i>@lang('admin.tags')
    </a>
    </li> --}}
    {{-- attributes_set --------------------------------------------------------------- --}}
    {{-- <li>
                            <a href="{{ route('admin.eccommerce.attributes-set.index') }}">
    <i class='bx bx-table'></i>@lang('admin.attributes_set')
    </a>
    </li> --}}
    {{-- products --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.eccommerce.products.index') }}">
    <i class='bx bx-gift'></i>@lang('admin.products')
    </a>
    </li> --}}
    {{-- <li>
                    <a href="{{ route('admin.reports.order-products') }}">
    <i class='bx bx-cart-alt'></i>
    @lang('Orders List')
    <x-admin.layouts.pending-product-order-number />
    </a>
    </li> --}}

    {{-- End  products ----------------------------------------------------------- --}}
    {{-- </ul>
        </li> --}}

    

    {{-- ---   beneficiaries --------------------------------------------------------------- --}}
    {{-- <li class="menu-label"> @lang('admin.beneficiaries') </li>
    <li>
        <a href="{{ route('admin.beneficiaries.index') }}">
            <div class="parent-icon"><i class='bx bx-user-check'></i>
            </div>
            <div class="menu-title">@lang('admin.beneficiaries')</div>
        </a>
    </li> --}}
    {{-- End beneficiaries ----------------------------------------------------- --}}

    {{-- Users Section ------------------------------------------------ --}}

    {{-- Application ----------------------------------------------------------- --}}
    {{-- <li class="menu-label"> @lang('admin.app') </li> --}}

    {{-- App Info ----------------------------------------------------------- --}}
    {{-- <li> --}}
    {{-- <a class="has-arrow" href="javascript:;">
                <div class="parent-icon">
                    <i class='bx bxl-android'></i>
                </div>
                <div class="menu-title">@lang('admin.app_info')</div>
            </a> --}}
    {{-- <ul> --}}
    {{-- app sections --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.app.sections.index') }}">
    <i class="bx bx-category"></i> @lang('admin.sections')
    </a>
    </li> --}}
    {{-- End app sections ---------------------------------------------------------- --}}

    {{-- app articles --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.app.articles.index') }}">
    <i class="fadeIn animated bx bx-news"></i></i>@lang('admin.articles')
    </a>
    </li> --}}
    {{-- </ul> --}}
    {{-- </li> --}}

    {{-- badal------------------------------------------------ --}}
    {{-- <li> --}}
    {{-- <a class="has-arrow" href="javascript:;">
                <div class="parent-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16">
                        <path fill="#000"
                            d="M60 120l228 71.2L516 120 288 48.8 60 120zM278.5 1.5c6.2-1.9 12.9-1.9 19.1 0l256 80C566.9 85.6 576 98 576 112v16 0 21.2L292.8 237.7c-3.1 1-6.4 1-9.5 0L0 149.2V128 112C0 98 9.1 85.6 22.5 81.5l256-80zm23.9 266.8L576 182.8v46.5l-52.8 16.5c-8.4 2.6-13.1 11.6-10.5 20s11.6 13.1 20 10.5L576 262.8V400c0 14-9.1 26.4-22.5 30.5l-256 80c-6.2 1.9-12.9 1.9-19.1 0l-256-80C9.1 426.4 0 414 0 400V262.8l43.2 13.5c8.4 2.6 17.4-2.1 20-10.5s-2.1-17.4-10.5-20L0 229.2V182.8l273.7 85.5c9.3 2.9 19.3 2.9 28.6 0zm-185.5-2.6c-8.4-2.6-17.4 2.1-20 10.5s2.1 17.4 10.5 20l64 20c8.4 2.6 17.4-2.1 20-10.5s-2.1-17.4-10.5-20l-64-20zm352 30.5c8.4-2.6 13.1-11.6 10.5-20s-11.6-13.1-20-10.5l-64 20c-8.4 2.6-13.1 11.6-10.5 20s11.6 13.1 20 10.5l64-20zm-224 9.5c-8.4-2.6-17.4 2.1-20 10.5s2.1 17.4 10.5 20l38.5 12c9.3 2.9 19.3 2.9 28.6 0l38.5-12c8.4-2.6 13.1-11.6 10.5-20s-11.6-13.1-20-10.5l-38.5 12c-3.1 1-6.4 1-9.5 0l-38.5-1z">
                        </path>
                    </svg>
                </div>
                <div class="menu-title">@lang('admin.hajj_umrah')</div>
            </a> --}}
    {{-- <ul> --}}
    {{-- Hajj and Umrah --------------------------------------------------------------- --}}
    {{-- charity Badal project --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.badal.projects.index') }}">
    <i class='bx bx-briefcase-alt'></i> @lang('project.badal_page_project')
    </a>
    </li> --}}
    {{-- End charity Badal project ---------------------------------------------------------- --}}

    {{-- Rites --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.badal.rites.index') }}">
    <i class='bx bx-radio-circle'></i>@lang('admin.rites')
    </a>
    </li> --}}
    {{-- substitutes --------------------------------------------------------------- --}}
    {{-- <li>
                    <a href="{{ route('admin.badal.substitutes.index') }}">
    <i class='bx bx-radio-circle'></i>@lang('admin.substitutes')
    </a>
    </li> --}}
    {{-- <li>
                    <a href="{{ route('admin.settings.form', 'badal') }}">
    <i class='bx bx-radio-circle'></i>@lang('admin.badal_setting')
    </a>
    </li> --}}
    {{-- <li>
                    <a href="{{ route('admin.settings.form', 'badalnotfication') }}">
    <i class='bx bx-radio-circle'></i>@lang('admin.badal_notify_setting')
    </a>
    </li> --}}
    {{-- </ul> --}}
    {{-- </li> --}}
    {{-- End badal ----------------------------------------------------------- --}}








    </ul>
    <!--end navigation-->
</div>
