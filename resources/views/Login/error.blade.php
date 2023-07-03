<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	{{--TOKEN PARA CAMBIOS--}}
    <meta name="token" id="token" value="{{ csrf_token() }}">
    {{--META PARA RUTA DINAMICA--}}
    <meta name="route" id="route" value="{{url('/')}}">
	<title>Verifique los datos</title>
	<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<body>
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>Oops!</h1>
			</div>
			<h2>Usuario no encontrado</h2>
			<p>Verifique los datos ingresados e intente de nuevo</p>
			<a href="{{url('/')}}">Volver a intentar</a>
		</div>
	</div>
</body>
</html>