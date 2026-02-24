<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['agregar_habilitacion']) || isset($_POST['actualizar_habilitacion']) || isset($_POST['eliminar_habilitacion']) || isset($_POST['obtener_habilitacion']) || isset($_POST['desactivar_habilitacion'])) {
    require_once "../controllers/habilitacionController.php";
    $ins_habilitacion = new habilitacionController();

    if (isset($_POST['agregar_habilitacion'])) {
        echo $ins_habilitacion->agregar_habilitacion_controller();
    } elseif (isset($_POST['actualizar_habilitacion'])) {
        echo $ins_habilitacion->actualizar_habilitacion_controller();
    } elseif (isset($_POST['eliminar_habilitacion'])) {
        echo $ins_habilitacion->eliminar_habilitacion_controller();
    } elseif (isset($_POST['desactivar_habilitacion'])) {
        echo $ins_habilitacion->desactivar_habilitacion_controller();
    } elseif (isset($_POST['obtener_habilitacion'])) {
        $datos = $ins_habilitacion->obtener_habilitacion_controller($_POST['id']);
        echo json_encode($datos->fetch());
    }
} else {
    session_start(['name' => 'SMP']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL . "index.php?views=login");
    exit();
}
