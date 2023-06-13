<?php
include 'partials/head.php';
if (isset($_SESSION["usuario"])) {
	if ($_SESSION["usuario"]["privilegio"] == 2) {
		header("location:usuario.php");
	}
} else {
	header("location:login.php");
}
?>

<?date_default_timezone_set('America/Mexico_City');?>


<?php include 'partials/menu.php'; ?>

<style type="text/css">
    /* Estilos generales */
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 2px;
    }

    /* Estilos para el jumbotron */
    .jumbotron {
      background-color: #403434;
      color: #ffffff;
      padding: 40px;
      border-radius: 10px;
    }

    .jumbotron h1 {
      font-size: 40px;
    }

    .jumbotron .lead {
      font-size: 20px;
      margin-bottom: 30px;
    }

    .jumbotron .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }

    /* Estilos para el badge */
    .badge {
      font-size: 14px;
      padding: 8px 12px;
      border-radius: 20px;
      font-weight: bold;
    }

    .badge.bg-info {
      background-color: #17a2b8;
      color: #ffffff;
    }
  </style>

<div class="container">
	<div class="starter-template">
		<br>
		<br>
		<br>
		<div class="jumbotron">
			<div class="container text-center">
				
				<h1><strong>Bienvenido</strong> <?php echo $_SESSION["usuario"]["nombre"]; ?></h1>
				<p>Has ingresado como: | <span class="label label-info"><?php echo $_SESSION["usuario"]["privilegio"] == 1 ? 'Admin' : 'Cliente'; ?></span></p>
				<p>
					<a href="cerrar-sesion.php" class="btn btn-primary btn-lg">Cerrar sesión</a>
				</p>
			</div>
		</div>
	</div>
</div>




<?php include 'partials/footer.php'; ?>
