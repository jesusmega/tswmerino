<?php
// Antes de enviar cualquier cookie, configura la bandera HttpOnly
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_httponly', 1);



?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self'">
  <!-- Resto de las etiquetas head -->
    <!-- Aquí se pueden agregar otros metadatos y enlaces a archivos CSS -->
</head>
<body>
    <!-- Contenido de la página -->
</body>
</html>
<?php

include '../controlador/UsuarioControlador.php';
include '../helps/helps.php';

session_start();

header('Content-type: application/json');
$resultado = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["txtUsuario"]) && isset($_POST["txtPassword"])) {

        $txtUsuario  = validar_campo($_POST["txtUsuario"]);
        $txtPassword = validar_campo($_POST["txtPassword"]);

        // Verificar si la variable de sesión "intentos" no está definida
        if (!isset($_SESSION["intentos"])) {
            $_SESSION["intentos"] = 1;
        } else {
            // Incrementar el contador de intentos
            $_SESSION["intentos"]++;
        }

        // Verificar si se han superado los dos intentos
        if ($_SESSION["intentos"] > 2) {
            // Verificar si ha pasado menos de 2 minutos desde el último intento
            if (isset($_SESSION["bloqueo"]) && (time() - $_SESSION["bloqueo"]) < 120) {
                //$resultado = array("estado" => "false", "mensaje" => "Demasiados intentos. Por favor, intente nuevamente después de 2 minutos.");
                $resultado = array(header("Location: login.php"));
            } else {
                // Restablecer el contador de intentos y marcar el tiempo de bloqueo
                $_SESSION["intentos"] = 1;
                $_SESSION["bloqueo"] = time();
                $resultado = array(header("Location: limites.php"));
                //$resultado = array("estado" => "false", "mensaje" => "Demasiados intentos. Por favor, intente nuevamente después de 2 minutos.");
            }
        } else {
            // Intento de inicio de sesión normal
            $resultado = array("estado" => "true");

            if (UsuarioControlador::login($txtUsuario, $txtPassword)) {
                $usuario             = UsuarioControlador::getUsuario($txtUsuario, $txtPassword);
                $_SESSION["usuario"] = array(
                    "id"         => $usuario->getId(),
                    "nombre"     => $usuario->getNombre(),
                    "usuario"    => $usuario->getUsuario(),
                    "email"      => $usuario->getEmail(),
                    "privilegio" => $usuario->getPrivilegio()
                );
                
                // Redirigir al usuario a la página admin.php
                header("Location: admin.php");
                exit();
            } else {
                // Incrementar el contador de intentos fallidos
                $_SESSION["intentos"]++;
                //$resultado = array("estado" => "false", "mensaje" => "Credenciales inválidas. Intento " . $_SESSION["intentos"]);
                $resultado = array(header("Location: limites.php"));
                
            }
        }

        echo json_encode($resultado);
    }
}
