<?php
// Antes de enviar cualquier cookie, configura la bandera HttpOnly
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_httponly', 1);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self'">
  <!-- Resto de las etiquetas head -->
    <!-- Aquí se pueden agregar otros metadatos y enlaces a archivos CSS -->
</head>
<body>
    <!-- Contenido de la página -->
</body>
</html>



<?php 
include 'partials/head.php'; 
include 'partials/menu.php'; 
//session_start();
$segundosRestantes = isset($_SESSION["bloqueo"]) ? $_SESSION["bloqueo"] - time() : 0;
$bloqueado = $segundosRestantes > 0;
?>
<?date_default_timezone_set('America/Mexico_City');?>


<style>
    .container {
        margin-top: 0.5px;
    }

    .starter-template {
        padding: 30px 15px;
        text-align: center;
    }

    .panel {
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .panel-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .g-recaptcha {
        margin-top: 10px;
    }

    #mensaje-intentos {
        color: red;
        margin-bottom: 10px;
    }

    #submit-button {
        width: 100%;
        padding: 10px;
        background-color: #519DDE;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #submit-button:hover {
        background-color: #2ECC71;
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

                        <form id="loginForm" action="../vista/validarCodigo.php" method="POST" role="form">
                        <!-- Resto del código del formulario -->
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                            <legend>Iniciar sesión</legend>

                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input type="text" name="txtUsuario" class="form-control" id="usuario" autofocus required placeholder="usuario">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="txtPassword" class="form-control" required id="password" placeholder="****">
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LdSWxkmAAAAAF5WzIvjfOf7iv2KEOlkhZd9lGnk"></div>
                            </div>

                            <div id="mensaje-intentos" style="color: red;"></div>

                            <button type="submit" class="btn btn-success" id="submit-button">Ingresar</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	
	var segundosRestantes = <?php echo $segundosRestantes; ?>;
    if (segundosRestantes > 0) {
        setTimeout(function() {
            $("#usuario").prop("disabled", false);
            $("#password").prop("disabled", false);
            $("#submit-button").prop("disabled", false);
        }, segundosRestantes * 1000);
        $("#mensaje-intentos").text("Por favor, intente nuevamente después de " + segundosRestantes + " segundos.");
    }

$(document).ready(function() {
    $("#loginForm").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: $(this).serialize(),
            success: function(response) {
                if (response.bloqueado) {
                    $("#usuario").prop("disabled", true);
                    $("#password").prop("disabled", true);
                    $("#submit-button").prop("disabled", true);
                    setTimeout(function() {
                        $("#usuario").prop("disabled", false);
                        $("#password").prop("disabled", false);
                        $("#submit-button").prop("disabled", false);
                    }, response.segundosRestantes * 1000);
                    $("#mensaje-intentos").text(response.mensaje);
                } else {
                    if (!response.estado) {
                        var mensaje = response.intentosRestantes > 0 ? "Te resta " + response.intentosRestantes + " intento más. Después de eso, espera 90 segundos." : response.mensaje;
                        $("#mensaje-intentos").text(mensaje);
                    } else {
                        window.location.href = "../vista/admin.php";
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    });
});
</script>
