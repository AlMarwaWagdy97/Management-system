<div class="user-items">
    @if ($user == null)
        <div class="usericon p-2" onclick="window.location.href='{{ route('site.login') }}';">
            <i class="fa-solid fa-user fs-4"></i>
        </div>
        <div class="usertext px-2" onclick="window.location.href='{{ route('site.login') }}';">
            <a class="me-4"> @lang('Login') </a>
        </div>
    @else
            <div class="usericon p-1" class="dropdown-toggle " id="login" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user fs-4"></i>
            </div>
            <div class="usertext text-white d-none d-lg-block">
                <a href="{{ route('site.profile.index') }}">
                    <span class="me-5 p-1">{{ @explode(' ', @$user->full_name ?? @$user->name  )[0] }}</span>
                </a>
            </div>
            <ul class="dropdown-menu" aria-labelledby="login">
                <li><a class="dropdown-item" href="{{ route('site.profile.index') }}"> @lang('Profile') </a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="{{ route('site.logout') }}"> @lang('logout') </a></li>
            </ul>
    @endif
</div>
