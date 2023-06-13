<?php
// Antes de enviar cualquier cookie, configura la bandera HttpOnly
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_httponly', 1);


// Resto del código PHP
include 'partials/head.php';
include 'partials/menu.php';
date_default_timezone_set('America/Mexico_City');

// ...
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'">
    <title>Inicio</title>
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self'">
  <!-- Resto de las etiquetas head -->
    <!-- Aquí se pueden agregar otros metadatos y enlaces a archivos CSS -->
</head>
<body>
    <!-- Contenido de la página -->
</body>
</html>



<div class="container">

	<div class="starter-template">
		<br>
		<br>
		<br>
		<div class="jumbotron">
			<div class="container">
				<h1>Sistema Login</h1>
				<p>Bienvenido/a a nuestro sistema de login. Inicia sesión para acceder a tu cuenta.</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<h2>Características principales</h2>
				<ul>
					<li>Fácil de usar</li>
					<li>Seguro y confiable</li>
					<li>Acceso rápido a tu cuenta</li>
					<li>Personalizable según tus necesidades</li>
				</ul>
			</div>
			<div class="col-md-6">
				<h2>¿Cómo empezar?</h2>
				<p>Para comenzar a utilizar nuestro sistema de login, simplemente sigue estos pasos:</p>
				<ol>
					<li>Crea una cuenta si aún no tienes una.</li>
					<li>Inicia sesión con tu nombre de usuario y contraseña.</li>
					<li>Explora las opciones disponibles según tu tipo de cuenta.</li>
					<li>Disfruta de todas las funcionalidades que ofrecemos.</li>
				</ol>
			</div>
		</div>

	</div>

</div>

<?php include 'partials/footer.php';?>
