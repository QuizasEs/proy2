<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['Usuario_reg']) || isset($_POST['Usuario_id_up']) || isset($_POST['eliminar_usuario']) || isset($_POST['listar_personal']) || isset($_POST['obtener_personal'])) {
    require_once "../controllers/userController.php";
    $ins_usuario = new userController();

    if (isset($_POST['Usuario_reg']) && isset($_POST['Password_reg'])) {
        echo $ins_usuario->get_user_controller();
    } elseif (isset($_POST['Usuario_id_up']) && isset($_POST['UsuarioName_up'])) {
        echo $ins_usuario->actualizar_usuario_controller();
    } elseif (isset($_POST['Usuario_id_up']) && isset($_POST['nombres'])) {
        echo $ins_usuario->actualizar_usuario_controller();
    } elseif (isset($_POST['NuevoUsuario_up'])) {
        echo $ins_usuario->actualizar_credenciales_controller();
    } elseif (isset($_POST['eliminar_usuario'])) {
        echo $ins_usuario->eliminar_usuario_controller();
    } elseif (isset($_POST['obtener_personal'])) {
        $datos = $ins_usuario->obtener_personal_controller($_POST['id']);
        echo json_encode($datos->fetch());
    } else {
        echo $ins_usuario->actualizar_perfil_controller();
    }
} else {
    session_start(['name' => 'SMP']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL . "index.php?views=login");
    exit();
}