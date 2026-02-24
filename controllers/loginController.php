<?php
require_once __DIR__ . "/../models/loginModel.php";

class loginController extends loginModel
{
    /* controlador para iniciar sesion */
    public function iniciar_sesion_controller()
    {
        session_start(['name' => 'SMP']);
        
        $usuario = mainModel::limpiar_cadena($_POST['Usuario_log']);
        $contraseña = mainModel::limpiar_cadena($_POST['Password_log']);

        /* == comprobar que los campos no se encuentren vacios == */
        if ($usuario == "" || $contraseña == "") {
            $_SESSION['error_login'] = 'No se han llenado todos los campos obligatorios!';
            return 'error';
        }

        /* =verificar la integridad de los datos== */
        /*if (mainModel::verificar_datos("^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_]{3,100}", $usuario)) {
            $_SESSION['error_login'] = 'El NOMBRE DE USUARIO no coincide con el formato solicitado!';
            return 'error';
        };
        if (mainModel::verificar_datos("[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@$!%*?&._#]{3,100}", $contraseña)) {
            $_SESSION['error_login'] = 'La CONTRASEÑA no coincide con el formato solicitado!';
            return 'error';
        };*/
        $contraseña = mainModel::encryption($contraseña);

        $datos_login = [
            "usuario" => $usuario,
            "password" => $contraseña
        ];
        $datos_cuenta = loginModel::iniciar_sesion_model($datos_login);

        if ($datos_cuenta->rowCount() == 1) {
            /* =============iniciamos las variables de session=============== */
            $row = $datos_cuenta->fetch();

            $_SESSION['id_smp'] = $row['us_id'];
            $_SESSION['nombre_smp'] = $row['us_nombres'];
            $_SESSION['usuario_smp'] = $row['us_username'];
            $_SESSION['rol_smp'] = $row['ro_id'];
            $_SESSION['token_smp'] = md5(uniqid(mt_rand(), true));
            return 'ok';
        } else {
            $_SESSION['error_login'] = 'El USUARIO o CONTRASEÑA son incorrectos o su cuenta no esta activada!';
            return 'error';
        }
    }

    /* controlador para forzar el cierre de sesion */
    public function forzar_cierre_sesion_controller()
    {
        session_unset();
        session_destroy();
        if (headers_sent()) {
            return "<script>window.location.href='" . SERVER_URL . "index.php?views=login';</script>";
        } else {
            return header("Location: " . SERVER_URL . "index.php?views=login");
        }
    }
    /* controlador que nos permite cerrar sesion */
    public function cerrar_sesion_controller()
    {
        session_start(['name' => 'SMP']);
        
        if (!isset($_SESSION['token_smp']) || !isset($_SESSION['usuario_smp'])) {
            $alerta = [
                "Alerta" => "redireccionar",
                "URL" => SERVER_URL . "index.php?views=login",
            ];
            echo json_encode($alerta);
            return;
        }
        
        $token = mainModel::decryption($_POST['token']);
        $usuario = mainModel::decryption($_POST['usuario']);

        if ($token == $_SESSION['token_smp'] && $usuario == $_SESSION['usuario_smp']) {
            session_unset();
            session_destroy();
            $alerta = [
                "Alerta" => "redireccionar",
                "URL" => SERVER_URL . "index.php?views=login",
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No se pudo cerrar la sesion del sistema",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }
}
