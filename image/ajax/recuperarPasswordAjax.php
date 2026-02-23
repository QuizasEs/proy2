<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['Email_recovery'])) {
    require_once "../controllers/loginController.php";
    $ins_recuperar = new loginController();

    if (isset($_POST['Password_new']) && isset($_POST['Password_confirm'])) {
        echo $ins_recuperar->cambiar_password_controller();
    } elseif (isset($_POST['Codigo_recovery'])) {
        echo $ins_recuperar->verificar_codigo_recuperacion_controller();
    } else {
        echo $ins_recuperar->enviar_codigo_recuperacion_controller();
    }
} else {
    session_start(['name' => 'SMP']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL . "index.php?views=login");
    exit();
}