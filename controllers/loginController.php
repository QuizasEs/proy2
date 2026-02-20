<?php
if ($peticionAjax) {
    require_once "../models/loginModel.php";
} else {
    require_once "./models/loginModel.php";
}

class loginController extends loginModel
{
    /* controlador para iniciar sesion */
    public function iniciar_sesion_controller()
    {
        $usuario = mainModel::limpiar_cadena($_POST['Usuario_log']);
        $contraseña = mainModel::limpiar_cadena($_POST['Password_log']);

        /* == comprobar que los campos no se encuentren vacios == */
        if ($usuario == "" || $contraseña == "") {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "No se han llenado todos los campos obligatorios!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        /* =verificar la integridad de los datos== */
        if (mainModel::verificar_datos("^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_]{3,100}", $usuario)) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "El NOMBRE DE USUARIO no coincide con el formato solicitado!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        };
        if (mainModel::verificar_datos("[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@$!%*?&._#]{3,100}", $contraseña)) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "La CONTRASEÑA no coincide con el formato solicitado!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        };
        $contraseña = mainModel::encryption($contraseña);

        $datos_login = [
            "usuario" => $usuario,
            "password" => $contraseña
        ];
        $datos_cuenta = loginModel::iniciar_sesion_model($datos_login);

        if ($datos_cuenta->rowCount() == 1) {
            /* =============iniciamos las variables de session=============== */
            $row = $datos_cuenta->fetch();

            session_start(['name' => 'SMP']);

            $_SESSION['id_smp'] = $row['us_id'];
            $_SESSION['nombre_smp'] = $row['us_nombres'];
            $_SESSION['usuario_smp'] = $row['us_username'];
            $_SESSION['rol_smp'] = $row['ro_id'];
            $_SESSION['token_smp'] = md5(uniqid(mt_rand(), true));
            return header("Location: " . SERVER_URL . "index.php?views=dashboard");
        } else {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "El USUARIO o CONTRASEÑA son incorrectos o su cuenta no esta activada!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
            exit();
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
    /* controlador que nos permite secarra secion */
    public function cerrar_sesion_controller()
    {
        session_start(['name' => 'SMP']);
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
                "Texto" => "No se pudo serrar la sesion del sistema",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }

    public function enviar_codigo_recuperacion_controller()
    {
        $email = mainModel::limpiar_cadena($_POST['Email_recovery']);

        if ($email == "") {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "No se ha ingresado el correo electronico!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $email)) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "El formato del correo electronico no es valido!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        $verificar_email = loginModel::verificar_email_model($email);

        if ($verificar_email->rowCount() == 0) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "El correo electronico no esta registrado en el sistema!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        $codigo = loginModel::generar_codigo_recuperacion();

        $actualizar_token = loginModel::actualizar_token_model($email, $codigo);

        if ($actualizar_token) {
            $enviado = loginModel::enviar_codigo_email($email, $codigo);

            if ($enviado) {
                echo '
                        <script>
                            Swal.fire({
                                title: "Codigo enviado",
                                text: "Se ha enviado un codigo de 6 digitos a tu correo electronico!",
                                icon: "success",
                                confirmButtonText: "Aceptar"
                            }).then(function() {
                                mostrarFormularioCodigo();
                            });
                        </script>
                    ';
            } else {
                echo '
                        <script>
                            Swal.fire({
                                title: "Ocurrio un error inesperado",
                                text: "No se pudo enviar el correo electronico. Intenta nuevamente!",
                                icon: "error",
                                confirmButtonText: "Aceptar"
                            });
                        </script>
                    ';
            }
        } else {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "No se pudo generar el codigo de recuperacion!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
        }
    }

    public function verificar_codigo_recuperacion_controller()
    {
        $email = mainModel::limpiar_cadena($_POST['Email_recovery']);
        $codigo = mainModel::limpiar_cadena($_POST['Codigo_recovery']);

        if ($email == "" || $codigo == "") {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "No se han llenado todos los campos obligatorios!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $email)) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "El formato del correo electronico no es valido!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        if (mainModel::verificar_datos("^[0-9]{6}$", $codigo)) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "El codigo debe tener exactamente 6 digitos!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        $verificar_token = loginModel::verificar_token_model($email, $codigo);

        if ($verificar_token->rowCount() == 1) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Codigo verificado",
                            text: "El codigo es correcto. Ahora puedes cambiar tu contraseña!",
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        }).then(function() {
                            mostrarFormularioPassword();
                        });
                    </script>
                ';
        } else {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "El codigo es incorrecto o ha expirado!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
        }
    }

    public function cambiar_password_controller()
    {
        $email = mainModel::limpiar_cadena($_POST['Email_recovery']);
        $password = mainModel::limpiar_cadena($_POST['Password_new']);
        $password_confirm = mainModel::limpiar_cadena($_POST['Password_confirm']);

        if ($email == "" || $password == "" || $password_confirm == "") {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "No se han llenado todos los campos obligatorios!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        if (mainModel::verificar_datos("[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@$!%*?&._#]{3,100}", $password)) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "La contraseña no coincide con el formato solicitado!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        if ($password != $password_confirm) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "Las contraseñas no coinciden!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            exit();
        }

        $password = mainModel::encryption($password);

        $actualizar_password = loginModel::actualizar_password_model($email, $password);

        if ($actualizar_password) {
            echo '
                    <script>
                        Swal.fire({
                            title: "Contraseña actualizada",
                            text: "Tu contraseña ha sido actualizada exitosamente!",
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        }).then(function() {
                            window.location.href = "' . SERVER_URL . 'index.php?views=login";
                        });
                    </script>
                ';
        } else {
            echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrio un error inesperado",
                            text: "No se pudo actualizar la contraseña!",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
        }
    }
}
