<?php

include '../datos/UsuarioDao.php';

class UsuarioControlador
{

    public static function login($usuario, $password)
    {
        $obj_usuario = new Usuario();
        $obj_usuario->setUsuario($usuario);
        $obj_usuario->setPassword($password);

        $login_exitoso = UsuarioDao::login($obj_usuario);

        if ($login_exitoso) {
            // Registrar el inicio de sesión exitoso en el log
            self::registrarIntento($usuario, true);
        } else {
            // Registrar el intento fallido en el log
            self::registrarIntento($usuario, false);
        }

        return $login_exitoso;
        //return UsuarioDao::login($obj_usuario);
    }

    //metodo para reistrar los intentos en el log de la base de datos
    private static function registrarIntento($usuario, $exito)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $navegador = $_SERVER['HTTP_USER_AGENT'];
        $fecha = date('Y-m-d H:i:s');
        $sistemaOperativo = self::obtenerSistemaOperativo($navegador);
        $intentos = $exito ? 'exitoso' : 'fallido';

        // Insertar los datos del intento en el log
        $con = Conexion::conectar();
        $stmt = $con->prepare("INSERT INTO log (usuario, ip, navegador, fecha, sistema_operativo, intentos) VALUES (:usuario, :ip, :navegador, :fecha, :sistemaOperativo, :intentos)");
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':ip', $ip);
        $stmt->bindValue(':navegador', $navegador);
        $stmt->bindValue(':fecha', $fecha);
        $stmt->bindValue(':sistemaOperativo', $sistemaOperativo);
        $stmt->bindValue(':intentos', $intentos);
        $stmt->execute();
    }


    private static function obtenerSistemaOperativo($userAgent) {
        $sistemasOperativos = array(
            '/windows nt 11/i'      => 'Windows 11',
            '/windows nt 10/i'      => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile'
        );

        foreach ($sistemasOperativos as $regex => $sistemaOperativo) {
            if (preg_match($regex, $userAgent)) {
                    return $sistemaOperativo;
                }
        }

            return 'Desconocido';
    }


    public static function getUsuario($usuario, $password)
    {
        $obj_usuario = new Usuario();
        $obj_usuario->setUsuario($usuario);
        $obj_usuario->setPassword($password);

        return UsuarioDao::getUsuario($obj_usuario);
    }

    public static function registrar($nombre, $email, $usuario, $password, $privilegio)
    {
        $obj_usuario = new Usuario();
        $obj_usuario->setNombre($nombre);
        $obj_usuario->setUsuario($usuario);
        $obj_usuario->setEmail($email);
        $obj_usuario->setPrivilegio($privilegio);
        $obj_usuario->setPassword($password);

        return UsuarioDao::registrar($obj_usuario);
    }

}

?>