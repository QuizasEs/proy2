<?php
if ($peticionAjax) {
    require_once "../models/servicioModel.php";
} else {
    require_once "./models/servicioModel.php";
}

class servicioController extends servicioModel
{

    public function agregar_servicio_controller()
    {
        session_start(['name' => 'SMP']);
        $nombre = mainModel::limpiar_cadena($_POST['nombre']);
        $descripcion = mainModel::limpiar_cadena($_POST['descripcion']);
        $tipo_sistema = mainModel::limpiar_cadena($_POST['tipo_sistema']);
        $usuario = $_SESSION['id_smp'];

        if ($nombre == "" || $tipo_sistema == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos = [
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "tipo_sistema" => $tipo_sistema,
            "usuario" => $usuario
        ];

        $agregar = servicioModel::agregar_servicio_modelo($datos);

        if ($agregar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "servicio registrado",
                "texto" => "el servicio se ha registrado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se ha podido registrar el servicio!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    public function listar_servicios_controller()
    {
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $pagina = mainModel::validar_pagina($pagina);
        
        // verificar si se deben mostrar todos los servicios
        $verTodas = isset($_GET['ver']) && $_GET['ver'] == 'todos';
        
        if ($verTodas) {
            $totalRegistros = servicioModel::contar_todos_servicios_modelo()->fetch()['total'];
            $limite = mainModel::obtener_limit($pagina, 15);
            $lista_servicios = servicioModel::listar_todos_servicios_modelo($limite);
        } else {
            $totalRegistros = servicioModel::contar_servicios_modelo()->fetch()['total'];
            $limite = mainModel::obtener_limit($pagina, 15);
            $lista_servicios = servicioModel::listar_servicios_modelo($limite);
        }
        
        // mantener el filtro al cambiar de pagina
        $verParam = $verTodas ? "&ver=todos" : "";
        $url = SERVER_URL . "index.php?views=servicios" . $verParam;
        
        $paginacion = mainModel::paginador($pagina, $totalRegistros, $url, 15);
        
        return array(
            'datos' => $lista_servicios,
            'paginacion' => $paginacion,
            'total' => $totalRegistros
        );
    }

    public function obtener_servicio_controller()
    {
        $id = mainModel::decryption($_POST['id']);
        
        return servicioModel::obtener_servicio_modelo($id);
    }

    public function actualizar_servicio_controller()
    {
        session_start(['name' => 'SMP']);
        $id = mainModel::decryption($_POST['id']);
        $nombre = mainModel::limpiar_cadena($_POST['nombre']);
        $descripcion = mainModel::limpiar_cadena($_POST['descripcion']);
        $tipo_sistema = mainModel::limpiar_cadena($_POST['tipo_sistema']);

        if ($id == "" || $nombre == "" || $tipo_sistema == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos = [
            "id" => $id,
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "tipo_sistema" => $tipo_sistema
        ];

        $actualizar = servicioModel::actualizar_servicio_modelo($datos);

        if ($actualizar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "servicio actualizado",
                "texto" => "el servicio se ha actualizado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se ha podido actualizar el servicio!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    public function eliminar_servicio_controller()
    {
        session_start(['name' => 'SMP']);
        $rol = $_SESSION['rol_smp'];

        if ($rol == 2) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Acceso denegado",
                "texto" => "no tienes permisos para eliminar servicios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $id = mainModel::decryption($_POST['id']);

        if ($id == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo eliminar el servicio!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar = servicioModel::eliminar_servicio_modelo($id);

        if ($eliminar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "servicio eliminado",
                "texto" => "el servicio se ha eliminado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo eliminar el servicio!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    public function desactivar_servicio_controller()
    {
        $id = mainModel::decryption($_POST['id']);

        if ($id == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo desactivar el servicio!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $desactivar = servicioModel::desactivar_servicio_modelo($id);

        if ($desactivar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "servicio desactivado",
                "texto" => "el servicio se ha desactivado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo desactivar el servicio!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }
}
