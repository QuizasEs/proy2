<?php
$peticionAjax = true;
require_once "../config/APP.php";

header('Content-Type: application/json; charset=utf-8');

if (isset($_POST['agregar_servicio']) && isset($_POST['nombre'])) {
    require_once "../controllers/servicioController.php";
    $ins_servicio = new servicioController();
    echo $ins_servicio->agregar_servicio_controller();
    exit();
}

if (isset($_POST['actualizar_servicio']) && isset($_POST['id'])) {
    require_once "../controllers/servicioController.php";
    $ins_servicio = new servicioController();
    echo $ins_servicio->actualizar_servicio_controller();
    exit();
}

if (isset($_POST['eliminar_servicio']) && isset($_POST['id'])) {
    require_once "../controllers/servicioController.php";
    $ins_servicio = new servicioController();
    echo $ins_servicio->eliminar_servicio_controller();
    exit();
}

if (isset($_POST['desactivar_servicio']) && isset($_POST['id'])) {
    require_once "../controllers/servicioController.php";
    $ins_servicio = new servicioController();
    echo $ins_servicio->desactivar_servicio_controller();
    exit();
}

if (isset($_POST['activar_servicio']) && isset($_POST['id'])) {
    require_once "../controllers/servicioController.php";
    $ins_servicio = new servicioController();
    echo $ins_servicio->activar_servicio_controller();
    exit();
}

if (isset($_POST['obtener_servicio']) && isset($_POST['id'])) {
    require_once "../controllers/servicioController.php";
    $ins_servicio = new servicioController();
    $resultado = $ins_servicio->obtener_servicio_controller();
    $datos = $resultado->fetch();
    echo json_encode($datos);
    exit();
}

$alerta = [
    "Alerta" => "simple",
    "Titulo" => "Ocurrio un error inesperado",
    "texto" => "no se pudo procesar la solicitud!",
    "Tipo" => "error"
];
echo json_encode($alerta);
exit();
