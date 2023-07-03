<!DOCTYPE html>
<html lang="es">
<head>
	<title>Bienvenido</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	{{--TOKEN PARA CAMBIOS--}}
    <meta name="token" id="token" value="{{ csrf_token() }}">
    {{--META PARA RUTA DINAMICA--}}
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Login</title>

	<!-- Normalize V8.0.1 -->
	<link rel="stylesheet" href="css/normalize.css">

	<!-- Bootstrap V4.3 -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Bootstrap Material Design V4.0 -->
	<link rel="stylesheet" href="css/bootstrap-material-design.min.css">

	<!-- Font Awesome V5.9.0 -->
	<link rel="stylesheet" href="css/all.min.css">

	<!-- Sweet Alerts V8.13.0 CSS file -->
	<link rel="stylesheet" href="css/sweetalert2.min.css">

	<!-- Sweet Alert V8.13.0 JS file -->
	<script src="js/sweetalert2.min.js" ></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	
	<!-- General Styles -->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="login-container">
		<div class="login-content">
			<p class="text-center">
				<i class="fas fa-user-circle fa-5x"></i>
			</p>
			<p class="text-center">
				Inicia sesión con tu cuenta
			</p>
			<form action="{{url('login')}}" method="POST">
				@csrf
				<div class="form-group">
					<label class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
					<input type="text" class="form-control" name="name" pattern="[a-zA-Z0-9]{1,35}" maxlength="35">
				</div>
				<div class="form-group" id="show_hide_password">
					<label class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
					<input type="password" class="form-control password1" name="password" maxlength="200"><a href=""><i class="fa fa-fw fa-eye-slash password-icon" aria-hidden="true"></i></a>
				</div>
				<!-- <a href="home.html" class="btn-login text-center">LOG IN</a> -->
				<input type="submit" value="Ingresar" class="btn-login text-center"/>
			</form>
		</div>
	</div>

	
	<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
	<!-- jQuery V3.4.1 -->
	<script src="js/jquery.min.js" ></script>

	<!-- popper -->
	<script src="js/popper.min.js" ></script>

	<!-- Bootstrap V4.3 -->
	<script src="js/bootstrap.min.js" ></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<script src="js/jquery.mCustomScrollbar.concat.min.js" ></script>

	<!-- Bootstrap Material Design V4.0 -->
	<script src="js/bootstrap-material-design.min.js" ></script>

	<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

	<script src="js/main.js" ></script>
	<script type="text/javascript">
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
	</script>
</body>
</html>