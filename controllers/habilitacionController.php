<?php
if ($peticionAjax) {
    require_once "../models/habilitacionModel.php";
} else {
    require_once "./models/habilitacionModel.php";
}

class habilitacionController extends habilitacionModel
{

    /* -----------------------------------controlador para agregar habilitacion------------------------------------------ */
    public function agregar_habilitacion_controller()
    {
        session_start(['name' => 'SMP']);
        $servicio = mainModel::limpiar_cadena($_POST['servicio']);
        $empresa = mainModel::limpiar_cadena($_POST['empresa']);
        $link = mainModel::limpiar_cadena($_POST['link']);
        $tipo_suscripcion = mainModel::limpiar_cadena($_POST['tipo_suscripcion']);
        $sucursal = mainModel::limpiar_cadena($_POST['sucursal']);
        $usuario = $_SESSION['id_smp'];

        if ($servicio == "" || $empresa == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos = [
            "servicio" => $servicio,
            "empresa" => $empresa,
            "link" => $link,
            "tipo_suscripcion" => $tipo_suscripcion,
            "sucursal" => $sucursal,
            "usuario" => $usuario
        ];

        $agregar = habilitacionModel::agregar_habilitacion_modelo($datos);

        if ($agregar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Habilitación registrada",
                "texto" => "La habilitación se ha registrado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se ha podido registrar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para listar habilitaciones------------------------------------------ */
    public function listar_habilitaciones_controller()
    {
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $pagina = mainModel::validar_pagina($pagina);
        
        // verificar si se deben mostrar todas las habilitaciones
        $verTodas = isset($_GET['ver']) && $_GET['ver'] == 'todos';
        
        if ($verTodas) {
            $totalRegistros = habilitacionModel::contar_todas_habilitaciones_modelo()->fetch()['total'];
            $limite = mainModel::obtener_limit($pagina, 15);
            $lista_habilitaciones = habilitacionModel::listar_todas_habilitaciones_modelo($limite);
        } else {
            $totalRegistros = habilitacionModel::contar_habilitaciones_modelo()->fetch()['total'];
            $limite = mainModel::obtener_limit($pagina, 15);
            $lista_habilitaciones = habilitacionModel::listar_habilitaciones_modelo($limite);
        }
        
        // mantener el filtro al cambiar de pagina
        $verParam = $verTodas ? "&ver=todos" : "";
        $url = SERVER_URL . "index.php?views=habilitaciones" . $verParam;
        
        $paginacion = mainModel::paginador($pagina, $totalRegistros, $url, 15);
        
        return array(
            'datos' => $lista_habilitaciones,
            'paginacion' => $paginacion,
            'total' => $totalRegistros
        );
    }

    /* -----------------------------------controlador para obtener habilitacion------------------------------------------ */
    public function obtener_habilitacion_controller($id)
    {
        $id = mainModel::decryption($id);
        $datos = habilitacionModel::obtener_habilitacion_modelo($id);
        return $datos;
    }

    /* -----------------------------------controlador para actualizar habilitacion------------------------------------------ */
    public function actualizar_habilitacion_controller()
    {
        $id = mainModel::decryption($_POST['habilitacion_id']);
        $servicio = mainModel::limpiar_cadena($_POST['servicio']);
        $empresa = mainModel::limpiar_cadena($_POST['empresa']);
        $link = mainModel::limpiar_cadena($_POST['link']);
        $tipo_suscripcion = mainModel::limpiar_cadena($_POST['tipo_suscripcion']);
        $sucursal = mainModel::limpiar_cadena($_POST['sucursal']);

        if ($id == "" || $servicio == "" || $empresa == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos = [
            "servicio" => $servicio,
            "empresa" => $empresa,
            "link" => $link,
            "tipo_suscripcion" => $tipo_suscripcion,
            "sucursal" => $sucursal,
            "id" => $id
        ];

        $actualizar = habilitacionModel::actualizar_habilitacion_modelo($datos);

        if ($actualizar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Habilitación actualizada",
                "texto" => "Los datos de la habilitación se han actualizado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo actualizar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para eliminar habilitacion------------------------------------------ */
    public function eliminar_habilitacion_controller()
    {
        session_start(['name' => 'SMP']);
        $rol = $_SESSION['rol_smp'];

        if ($rol != 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Acceso denegado",
                "texto" => "No tienes permisos para eliminar habilitaciones!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $id = mainModel::decryption($_POST['id']);

        if ($id == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo eliminar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar = habilitacionModel::eliminar_habilitacion_modelo($id);

        if ($eliminar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Habilitación eliminada",
                "texto" => "La habilitación se ha eliminado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo eliminar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para desactivar habilitacion------------------------------------------ */
    public function desactivar_habilitacion_controller()
    {
        $id = mainModel::decryption($_POST['id']);

        if ($id == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo desactivar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $desactivar = habilitacionModel::desactivar_habilitacion_modelo($id);

        if ($desactivar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Habilitación desactivada",
                "texto" => "La habilitación se ha desactivado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo desactivar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para activar habilitacion------------------------------------------ */
    public function activar_habilitacion_controller()
    {
        $id = mainModel::decryption($_POST['id']);

        if ($id == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo activar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $activar = habilitacionModel::activar_habilitacion_modelo($id);

        if ($activar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Habilitación activada",
                "texto" => "La habilitación se ha activado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo activar la habilitación!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para listar empresas------------------------------------------ */
    public function listar_empresas_controller()
    {
        $empresas = habilitacionModel::listar_empresas_modelo();
        return $empresas;
    }

    /* -----------------------------------controlador para listar servicios------------------------------------------ */
    public function listar_servicios_controller()
    {
        $servicios = habilitacionModel::listar_servicios_modelo();
        return $servicios;
    }
}
