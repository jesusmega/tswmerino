<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sistema Login</title>
  <style type="text/css">
    /* Estilos para la barra de navegación */
    .navbar {
      background-color: #944949; /* Cambiar el color de fondo según tus preferencias */
      color: #2025CB; /* Cambiar el color del texto según tus preferencias */
      font-size: 16px; /* Cambiar el tamaño de fuente según tus preferencias */
      padding: 10px; /* Añadir espacio de relleno según tus preferencias */
    }

    .navbar-brand {
      font-weight: bold; /* Cambiar el estilo de fuente según tus preferencias */
      color: #ffffff; /* Cambiar el color del texto del logo según tus preferencias */
    }

    .navbar-nav li {
      display: inline-block; /* Mostrar los elementos de la lista en línea */
    }

    .navbar-nav li a {
      color: #ffffff; /* Cambiar el color del enlace según tus preferencias */
      margin: 0 5px; /* Añadir margen entre los enlaces según tus preferencias */
      text-decoration: none; /* Quitar subrayado de los enlaces */
    }

    .navbar-nav li.active a {
      font-weight: bold; /* Cambiar el estilo de fuente para el enlace activo */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Sistema Login</a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class=""><a href="index.php">Inicio</a></li>
          <?php if (!isset($_SESSION["usuario"])) {?>
          <li><a href="login.php">Ingresar</a></li>
          <li><a href="registro.php">Registrarse</a></li>
          <?php } else {
            ?>
            <?php if ($_SESSION["usuario"]["privilegio"] == 1) {?>
            <li><a href="admin.php">Admin</a></li>
            <?php } else {?>
            <li><a href="usuario.php">Usuario</a></li>
            <?php }
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>
</body>
</html>
