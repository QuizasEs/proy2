<?php
require_once __DIR__ . "/../models/passwordRecoveryModel.php";

class passwordRecoveryController extends passwordRecoveryModel
{
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

        $verificar_email = passwordRecoveryModel::verificar_email_model($email);

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

        $codigo = passwordRecoveryModel::generar_codigo_recuperacion();

        $actualizar_token = passwordRecoveryModel::actualizar_token_model($email, $codigo);

        if ($actualizar_token) {
            $enviado = passwordRecoveryModel::enviar_codigo_email($email, $codigo);

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

        $verificar_token = passwordRecoveryModel::verificar_token_model($email, $codigo);

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

        $actualizar_password = passwordRecoveryModel::actualizar_password_model($email, $password);

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