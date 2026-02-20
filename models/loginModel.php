<?php
require_once "mainModel.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class loginModel extends mainModel
{
    /* modelo para iniciar session */
    protected static function iniciar_sesion_model($datos)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE us_username = :Usuario AND us_password_hash = :Password AND us_estado = 1");
        $sql->bindParam(":Usuario", $datos['usuario']);
        $sql->bindParam(":Password", $datos['password']);
        $sql->execute();
        return $sql;
    }

    protected static function verificar_email_model($email)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE us_correo = :Email AND us_estado = 1");
        $sql->bindParam(":Email", $email);
        $sql->execute();
        return $sql;
    }

    protected static function actualizar_token_model($email, $token)
    {
        $sql = mainModel::conectar()->prepare("UPDATE usuarios SET us_token_recuperacion = :Token, us_token_expiracion = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE us_correo = :Email");
        $sql->bindParam(":Token", $token);
        $sql->bindParam(":Email", $email);
        $sql->execute();
        return $sql;
    }

    protected static function verificar_token_model($email, $token)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE us_correo = :Email AND us_token_recuperacion = :Token AND us_token_expiracion > NOW()");
        $sql->bindParam(":Email", $email);
        $sql->bindParam(":Token", $token);
        $sql->execute();
        return $sql;
    }

    protected static function actualizar_password_model($email, $password)
    {
        $sql = mainModel::conectar()->prepare("UPDATE usuarios SET us_password_hash = :Password, us_token_recuperacion = NULL, us_token_expiracion = NULL WHERE us_correo = :Email");
        $sql->bindParam(":Password", $password);
        $sql->bindParam(":Email", $email);
        $sql->execute();
        return $sql;
    }

    protected static function generar_codigo_recuperacion()
    {
        return sprintf("%06d", mt_rand(0, 999999));
    }

    protected static function enviar_codigo_email($email, $codigo)
    {
        require_once __DIR__ . "/../lib/PHPMailer/src/PHPMailer.php";
        require_once __DIR__ . "/../lib/PHPMailer/src/SMTP.php";
        require_once __DIR__ . "/../lib/PHPMailer/src/Exception.php";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'quizaes@gmail.com'; // Reemplaza con tu email
            $mail->Password = 'lghlhrsvhwahdfwo'; // Reemplaza con tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(SMTP_USER, COMPANY);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Codigo de recuperacion de contraseña";
            $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background-color: #00305A; color: white; padding: 20px; text-align: center; }
                            .content { padding: 30px 20px; background-color: #f9f9f9; }
                            .code { font-size: 32px; font-weight: bold; color: #00305A; text-align: center; padding: 20px; background-color: #e8f4f8; border-radius: 5px; margin: 20px 0; }
                            .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>Recuperacion de Contraseña</h2>
                            </div>
                            <div class='content'>
                                <p>Hola,</p>
                                <p>Has solicitado recuperar tu contraseña. Utiliza el siguiente codigo de 6 digitos para continuar:</p>
                                <div class='code'>" . $codigo . "</div>
                                <p>Este codigo expirara en 15 minutos.</p>
                                <p>Si no solicitaste esta recuperacion, ignora este mensaje.</p>
                            </div>
                            <div class='footer'>
                                <p>" . COMPANY . " - Sistema de Gestion</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
