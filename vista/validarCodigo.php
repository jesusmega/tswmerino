
<?php


include '../controlador/UsuarioControlador.php';
include '../helps/helps.php';

session_start();

header('Content-type: application/json');
$resultado = array();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["txtUsuario"]) && isset($_POST["txtPassword"])) {

        if (isset($_POST["g-recaptcha-response"])) {
            $recaptcha_secret = '6LdSWxkmAAAAAEk3vlIc7g54jC_tQT_poNqNuPHy';
            $recaptcha_response = $_POST['g-recaptcha-response'];
            // Aquí definimos la URL de verificación y los datos a enviar
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $data = [
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_response
            ];
            // Hacer una solicitud POST a la API de Google
            $options = array(
                'http' => array(
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $response_data = json_decode($response, true);

            // Si reCAPTCHA es inválido, detener aquí
            if (!$response_data['success']) {
                $resultado = array("estado" => "false", "mensaje" => "Invalid reCAPTCHA");
                echo json_encode($resultado);
                exit();
            }

            $txtUsuario  = validar_campo($_POST["txtUsuario"]);
            $txtPassword = validar_campo($_POST["txtPassword"]);

            // Verificar si la variable de sesión "intentos" no está definida
            if (!isset($_SESSION["intentos"])) {
                $_SESSION["intentos"] = 1;
            } else {
                // Incrementar el contador de intentos
                $_SESSION["intentos"]++;
            }

            $maxIntentos = 3;
            $intentosRestantes = $maxIntentos - $_SESSION["intentos"];
            $resultado['intentosRestantes'] = $intentosRestantes > 0 ? $intentosRestantes : 0;    
            
            // Verificar si se han superado los dos intentos
            if ($_SESSION["intentos"] >= $maxIntentos) {
                // Verificar si ha pasado menos de 2 minutos desde el último intento
                if (isset($_SESSION["bloqueo"]) && (time() - $_SESSION["bloqueo"]) < 60) {
                    $segundosRestantes = 60 - (time() - $_SESSION["bloqueo"]);
                    $resultado = array("estado" => "false", "mensaje" => "Demasiados intentos. Por favor, intente nuevamente después de " . $segundosRestantes . " segundos.", "bloqueado" => true, "segundosRestantes" => $segundosRestantes, "intentosRestantes" => 0);
                } else {
                    // Restablecer el contador de intentos y marcar el tiempo de bloqueo
                    $_SESSION["intentos"] = 1;
                    $_SESSION["bloqueo"] = time() + 60;
                    $resultado = array("estado" => "false", "mensaje" => "Demasiados intentos. Intenta de nuevo más tarde.", "bloqueado" => true, "segundosRestantes" => 60);
                }
            } else {
                // Intento de inicio de sesión normal
                if (UsuarioControlador::login($txtUsuario, $txtPassword)) {
                    $usuario             = UsuarioControlador::getUsuario($txtUsuario, $txtPassword);
                    $_SESSION["usuario"] = array(
                        "id"         => $usuario->getId(),
                        "nombre"     => $usuario->getNombre(),
                        "usuario"    => $usuario->getUsuario(),
                        "email"      => $usuario->getEmail(),
                        "privilegio" => $usuario->getPrivilegio()
                    );

                    //$resultado = array("estado" => "true");
                    // Redirigir al usuario a la página admin.php
                    header("Location: ../vista/admin.php");
                    exit();
                } else {
                    // Incrementar el contador de intentos fallidos
                    $_SESSION["intentos"]++;
                    $resultado = array("estado" => "false", "mensaje" => "Credenciales incorrectas.");
                }
            }
            echo json_encode($resultado);
        } else {
            $resultado = array("estado" => "false", "mensaje" => "No reCAPTCHA response found");
            echo json_encode($resultado);
            exit();
        }
    }
}
?>