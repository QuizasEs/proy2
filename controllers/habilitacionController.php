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
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han llenado todos los campos obligatorios!",
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
                "Titulo" => "habilitacion registrada",
                "texto" => "la habilitacion se ha registrado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se ha podido registrar la habilitacion!",
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
        
        $totalRegistros = habilitacionModel::contar_habilitaciones_modelo()->fetch()['total'];
        $itemsPorPagina = 15;
        
        $limite = mainModel::obtener_limit($pagina, $itemsPorPagina);
        
        $lista_habilitaciones = habilitacionModel::listar_habilitaciones_modelo($limite);
        
        $url = SERVER_URL . "index.php?views=habilitaciones";
        
        $paginacion = mainModel::paginador($pagina, $totalRegistros, $url, $itemsPorPagina);
        
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
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han llenado todos los campos obligatorios!",
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
                "Titulo" => "habilitacion actualizada",
                "texto" => "los datos de la habilitacion se han actualizado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo actualizar la habilitacion!",
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
                "texto" => "no tienes permisos para eliminar habilitaciones!",
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
                "texto" => "no se pudo eliminar la habilitacion!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar = habilitacionModel::eliminar_habilitacion_modelo($id);

        if ($eliminar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "habilitacion eliminada",
                "texto" => "la habilitacion se ha eliminado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo eliminar la habilitacion!",
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
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo desactivar la habilitacion!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $desactivar = habilitacionModel::desactivar_habilitacion_modelo($id);

        if ($desactivar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "habilitacion desactivada",
                "texto" => "la habilitacion se ha desactivado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo desactivar la habilitacion!",
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
