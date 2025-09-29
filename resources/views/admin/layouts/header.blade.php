<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon"href="{{ @$adminDashboardTheme->icon != null ? asset(@$adminDashboardTheme->icon) : admin_path('images/logos/holol-icon.png') }}" type="image/png" />

    <title> {{ trans('admin.' . config('app.name')) }} | @yield('title', trans('admin.holol') )</title>

	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    @if (app()->getLocale() == 'ar')
        @vite(['resources/assets/admin/app-style-rtl.css'])
    @else
    @vite(['resources/assets/admin/app-style.css?v=0.0.1'])
    @endif

    @vite(['resources/assets/admin/data-tables.css'])

    @yield('style')

    <style>
        .navbar-custom-color {
            color: <?php echo @$adminDashboardTheme->navbar_color; ?> !important;
        }

        ;

        .side-navbar-custom-color a,
        .side-navbar-custom-color i,
        .side-navbar-custom-color span,
        .side-navbar-custom-color p {
            color: <?php echo @$adminDashboardTheme->side_navbar_color; ?> !important;
        }

        ;
    </style>




</head>
