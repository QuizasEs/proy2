<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['agregar_empresa']) || isset($_POST['actualizar_empresa']) || isset($_POST['eliminar_empresa']) || isset($_POST['obtener_empresa']) || isset($_POST['desactivar_empresa'])) {
    require_once "../controllers/empresaController.php";
    $ins_empresa = new empresaController();

    if (isset($_POST['agregar_empresa'])) {
        echo $ins_empresa->agregar_empresa_controller();
    } elseif (isset($_POST['actualizar_empresa'])) {
        echo $ins_empresa->actualizar_empresa_controller();
    } elseif (isset($_POST['eliminar_empresa'])) {
        echo $ins_empresa->eliminar_empresa_controller();
    } elseif (isset($_POST['desactivar_empresa'])) {
        echo $ins_empresa->desactivar_empresa_controller();
    } elseif (isset($_POST['obtener_empresa'])) {
        $datos = $ins_empresa->obtener_empresa_controller($_POST['id']);
        echo json_encode($datos->fetch());
    }
} else {
    session_start(['name' => 'SMP']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL . "index.php?views=login");
    exit();
}
