<html>
 <head>
  <title>{{ config('app.name') }}</title>
  <link rel="icon" href="{{asset('favicon.ico')}}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Icon fonts -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/ionicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/linearicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/open-iconic.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/pe-icon-7-stroke.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables/datatables.css') }}">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/bootstrap.css') }}" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/appwork.css') }}" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-corporate.css') }}" class="theme-settings-theme-css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/colors.css') }}" class="theme-settings-colors-css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/uikit.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

  <script src="{{ asset('assets/vendor/js/layout-helpers.js') }}"></script>

  <script src="{{ asset('assets/vendor/js/theme-settings.js') }}"></script>
  <script>
    window.themeSettings = new ThemeSettings({
      cssPath: 'http://34.202.173.112/lifelineservices/assets/vendor/css/rtl/',
      themesPath: 'http://34.202.173.112/lifelineservices/assets/vendor/css/rtl/'
    });
  </script>

  <script src="{{ asset('assets/vendor/js/material-ripple.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/layout-helpers.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/pace.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/authentication.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}">
  <link rel="stylesheet" href="{{ asset('datepicker/css/datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.css')}}">

  <style>
  input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			margin: 0;
  }
  </style>
 </head>

 <body>
  <div id="app">

  </div>

  <!-- Core scripts -->
  <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/sidenav.js') }}"></script>

  <!-- Libs -->
  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
  <script src="{{ asset('assets/js/demo.js') }}"></script>
  <script src="{{ asset('assets/js/ui_notifications.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>

  <script src="{{ asset(mix('js/app.js')) }}"></script>

 </body>
</html>
