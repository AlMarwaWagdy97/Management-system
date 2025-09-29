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

        {{-- Domains ------------------------------------------------ --}}
        <li class="menu-label"> النطاق الإلكتروني </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-globe"></i></div>
                <div class="menu-title">النطاقات</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('admin.domains.index') }}">
                        <i class='bx bx-list-ul'></i> قائمة النطاقات
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.domains.statistics') }}">
                        <i class='bx bx-bar-chart'></i> الإحصائيات
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}">
                        <i class='bx bx-receipt'></i> الطلبات
                    </a>
                </li>
            </ul>
        </li>
        {{-- End Domains ------------------------------------------------ --}}

        {{-- CMS ------------------------------------------------ --}}
        <li class="menu-label"> @lang('admin.cms') </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">@lang('admin.cms')</div>
            </a>
            <ul>
                {{-- System --------------------------------------------------------------- --}}
                <li>
                    <a class="has-arrow">
                        <i class='fadeIn animated bx bx-dialpad'></i>@lang('admin.system')
                    </a>
                    <ul>
                        {{-- User --------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.users.index') }}">
                                <i class='bx bx-user-circle'></i>@lang('admin.users')
                            </a>
                        </li>
                        {{-- End User --------------------------------------------------------------- --}}
                        {{-- Rules  ----------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.roles.index') }}">
                                <i class='bx bx-lock'></i>@lang('admin.roles')
                            </a>
                        </li>
                        {{-- End Rules ----------------------------------------------------------- --}}
                        {{-- Menus -------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.menus.index') }}">
                                <i class="fadeIn animated bx bx-sitemap"></i> @lang('admin.menus')
                            </a>
                        </li>
                        {{-- End Menus ----------------------------------------------------------- --}}
                        {{-- Pages --------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.pages.index') }}">
                                <i class="fadeIn animated bx bx-layout"></i> @lang('admin.pages')
                            </a>
                        </li>
                        {{-- End Pages ------------------------------------------------------------ --}}
                        {{-- news  --------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.news.index') }}">
                                <i class="fadeIn animated bx bx-news"></i> @lang('admin.news')
                            </a>
                        </li>
                        {{-- End news  ----------------------------------------------------------- --}}
                        {{-- Slider --------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.slider.index') }}">
                                <i class="fadeIn animated bx bx-slider-alt"></i> @lang('admin.slider')
                            </a>
                        </li>
                        {{-- End Slider ----------------------------------------------------------- --}}
                        {{-- Contact Us ----------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.contact-us.index') }}">
                                <i class="fadeIn animated bx bx-envelope"></i> @lang('admin.contact_us')
                            </a>
                        </li>
                        {{-- End Contact Us ------------------------------------------------------- --}}
                    </ul>
                </li>
                {{-- End System ----------------------------------------------------  --}}

                {{-- Blog ----------------------------------------------------------- --}}
                <li>
                    <a class="has-arrow">
                        <i class='bx bxs-news'></i> @lang('admin.blogs')
                    </a>
                    <ul>
                        {{-- Categories --------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.categories.index') }}">
                                <i class='bx bx-category'></i>@lang('categories.categories')
                            </a>
                        </li>
                        {{-- End Categories ------------------------------------------------------- --}}
                        {{-- Articles ------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.articles.index') }}">
                                <i class='bx bx-table'></i>@lang('articles.articles')
                            </a>
                        </li>
                        {{-- End Articles --------------------------------------------------------- --}}
                        {{-- Tags ----------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.tag.index') }}">
                                <i class='bx bxs-purchase-tag-alt'></i>@lang('admin.tags')
                            </a>
                        </li>
                        {{-- End Tags ----------------------------------------------------------- --}}
                    </ul>
                </li>
                {{-- End Blog ------------------------------------------------------- --}}

                {{-- Works ----------------------------------------------------------- --}}
                <li>
                    <a class="has-arrow">
                        <i class='bx bx-layer-plus'></i> @lang('admin.works')
                    </a>
                    <ul>
                        {{-- Portfolio tags ----------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.portfolio-tags.index') }}">
                                <i class='bx bxs-purchase-tag-alt'></i> @lang('admin.tags')
                            </a>
                        </li>
                        {{-- End Portfolio tags -------------------------------------------------------- --}}

                        {{-- Portfolio ----------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.portfolio.index') }}">
                                <i class='bx bx-images'></i> @lang('portfolio.portfolio')
                            </a>
                        </li>
                        {{-- End Portfolio -------------------------------------------------------- --}}

                        {{-- project -------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.projects.index') }}">
                                <i class='bx bx-briefcase-alt'></i> @lang('project.project')
                            </a>
                        </li>
                        {{-- End project ---------------------------------------------------------- --}}

                        {{-- services ------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.services.index') }}">
                                <i class='bx bx-wink-smile'></i> @lang('services.services')
                            </a>
                        </li>
                        {{-- End services --------------------------------------------------------- --}}
                    </ul>
                </li>
                {{-- End Works ------------------------------------------------------- --}}

                {{-- Settings -------------------------------------------------------- --}}
                <li>
                    <a class="has-arrow">
                        <i class='bx bx-cog'></i> @lang('admin.settings')
                    </a>
                    <ul>
                        {{-- settings --------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.settings.index') }}">
                                <i class='bx bx-cog'></i> @lang('settings.system_settings')
                            </a>
                        </li>
                        {{-- End setiings ----------------------------------------------------------- --}}
                        {{-- Themes --------------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.themes.dashboard') }}">
                                <i class='bx bx-palette'></i> @lang('themes.themes')
                            </a>
                        </li>
                        {{-- End Themes ----------------------------------------------------------- --}}
                        {{-- Payment Method ------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.payment-method.index') }}">
                                <i class='bx bx-credit-card'></i> @lang('admin.payment_methods')
                            </a>
                        </li>
                        {{-- End Payment Method ----------------------------------------------------------- --}}
                        {{-- Media ----------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.media.index') }}">
                                <i class='bx bx-radio-circle'></i>@lang('admin.media')
                            </a>
                        </li>
                        {{-- End Media ----------------------------------------------------------- --}}
                    </ul>
                </li>
                {{-- End Settings ---------------------------------------------------- --}}
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
