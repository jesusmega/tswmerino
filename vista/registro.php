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
    <title>Registro</title>
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self'">
  <!-- Resto de las etiquetas head -->
    <!-- Aquí se pueden agregar otros metadatos y enlaces a archivos CSS -->
</head>
<body>
    <!-- Contenido de la página -->
</body>
</html>



<style type="text/css">
    /* Estilos generales */
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 0.5px;
    }

    /* Estilos para el panel */
    .panel {
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    .panel-body {
      padding: 20px;
    }

    .panel legend {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
	  text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
	  
    }

    .form-control {
      width: 100%;
      height: 40px;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    /* Estilos para el botón */
    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      border-radius: 5px;
      border: none;
      color: #fff;
    }

    .btn-success {
      background-color: #28a745;
    }
  </style>


<div class="container">
	<div class="starter-template">
		<br>
		<br>
		<br>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">




          <?php
          //session_start();

          // Generar una ficha Anti-CSRF y almacenarla en la sesión
          if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
          }
          ?>

          <form action="registroCode.php" method="POST" role="form">
            <!-- Resto del código del formulario -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <legend>Registro de usuarios</legend>
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" name="txtNombre" class="form-control" id="nombre" autofocus required placeholder="Ingresa tu nombre">
							</div>

							<div class="form-group">
								<label for="email">E-mail</label>
								<input type="email" name="txtEmail" class="form-control" id="email" required placeholder="Ingresa tu dirección de e-mail">
							</div>

							<div class="form-group">
								<label for="usuario">Usuario</label>
								<input type="text" name="txtUsuario" class="form-control" id="usuario" autofocus required placeholder="usuario">
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="txtPassword" class="form-control" required id="password" placeholder="****">
							</div>
							
							<div class="form-group">
								<label for="privilegio">Rol</label>
								<select name="txtRol" class="form-control" required id="txtRol">
										<option value="cliente">Cliente</option>
										<option value="administrador">Administrador</option>
									</select>
							</div>

							<div class="form-group">
								<label for="secretCodigo">Llave secreta</label>
								<input type="text" name="txtCodigoSecreto" class="form-control" id="txtCodigoSecreto" placeholder="Llave secreta">
							</div>


							<button type="submit" class="btn btn-success">Registrar</button>
          </form>





							


							
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'partials/footer.php'; ?>