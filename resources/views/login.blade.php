<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>T-Track | Login</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Public Sans:300,400,500,600,700"]},
			custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{ asset('assets/css/fonts.min.css') }}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
</head>
<body class="login">
	<div class="wrapper wrapper-login wrapper-login-full p-0">
		<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-warning-gradient">
			<h1 class="title fw-bold text-white mb-3">T-Track<small>(Tempe Tracking)</small></h1>
			<p class="subtitle text-white op-7">Aplikasi website untuk monitoring produksi tempe berbasis IoT (Interner of Things). Cari tau sebanyak apa produksi tempe di usahamu menggunakan aplikasi ini.</p>
		</div>
		<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
			<div class="container container-login container-transparent animated fadeIn">
				<h3 class="text-center">Sign In To Admin</h3>
				<form class="login-form" method="POST" action="{{ route('login.store') }}">
                    @csrf
					<div class="form-group">
						<label for="email"><b>Email</b></label>
						<input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="form-group">
						<label for="password"><b>Password</b></label>
						<div class="position-relative">
							<input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror">
							<div class="show-password">
								<i class="icon-eye"></i>
							</div>
						</div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="form-group form-action-d-flex mb-3">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="rememberme" name="remember">
							<label class="custom-control-label m-0" for="rememberme">Remember Me</label>
						</div>
						<button type="submit" class="btn btn-warning text-white col-md-5 float-end mt-3 mt-sm-0 fw-bold">Sign In</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
	
	<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
</body>
</html>