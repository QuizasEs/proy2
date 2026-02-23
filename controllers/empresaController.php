<?php
if ($peticionAjax) {
    require_once "../models/empresaModel.php";
} else {
    require_once "./models/empresaModel.php";
}

class empresaController extends empresaModel
{

    /* -----------------------------------controlador para agregar empresa------------------------------------------ */
    public function agregar_empresa_controller()
    {
        session_start(['name' => 'SMP']);
        $nombre = mainModel::limpiar_cadena($_POST['nombre']);
        $celular = mainModel::limpiar_cadena($_POST['celular']);
        $nit = mainModel::limpiar_cadena($_POST['nit']);
        $comision = mainModel::limpiar_cadena($_POST['comision']);
        $usuario = $_SESSION['id_smp'];

        if ($nombre == "" || $nit == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // verificar nit unico
        $check_nit = mainModel::ejecutar_consulta_simple("SELECT em_id FROM empresas WHERE em_nit = '$nit'");
        if ($check_nit->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "el nit ya se encuentra registrado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos = [
            "nombre" => $nombre,
            "celular" => $celular,
            "nit" => $nit,
            "comision" => $comision,
            "usuario" => $usuario
        ];

        $agregar = empresaModel::agregar_empresa_modelo($datos);

        if ($agregar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "empresa registrada",
                "texto" => "la empresa se ha registrado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se ha podido registrar la empresa!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para listar empresas------------------------------------------ */
    public function listar_empresas_controller()
    {
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $pagina = mainModel::validar_pagina($pagina);
        
        $totalRegistros = empresaModel::contar_empresas_modelo()->fetch()['total'];
        $itemsPorPagina = 15;
        
        $limite = mainModel::obtener_limit($pagina, $itemsPorPagina);
        
        $lista_empresas = empresaModel::listar_empresas_modelo($limite);
        
        $url = SERVER_URL . "index.php?views=empresas";
        
        $paginacion = mainModel::paginador($pagina, $totalRegistros, $url, $itemsPorPagina);
        
        return array(
            'datos' => $lista_empresas,
            'paginacion' => $paginacion,
            'total' => $totalRegistros
        );
    }

    /* -----------------------------------controlador para obtener empresa------------------------------------------ */
    public function obtener_empresa_controller($id)
    {
        $id = mainModel::decryption($id);
        $datos = empresaModel::obtener_empresa_modelo($id);
        return $datos;
    }

    /* -----------------------------------controlador para actualizar empresa------------------------------------------ */
    public function actualizar_empresa_controller()
    {
        $id = mainModel::decryption($_POST['empresa_id']);
        $nombre = mainModel::limpiar_cadena($_POST['nombre']);
        $celular = mainModel::limpiar_cadena($_POST['celular']);
        $nit = mainModel::limpiar_cadena($_POST['nit']);
        $comision = mainModel::limpiar_cadena($_POST['comision']);

        if ($id == "" || $nombre == "" || $nit == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // verificar nit unico (excepto esta empresa)
        $check_nit = mainModel::ejecutar_consulta_simple("SELECT em_id FROM empresas WHERE em_nit = '$nit' AND em_id != '$id'");
        if ($check_nit->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "el nit ya se encuentra registrado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos = [
            "nombre" => $nombre,
            "celular" => $celular,
            "nit" => $nit,
            "comision" => $comision,
            "id" => $id
        ];

        $actualizar = empresaModel::actualizar_empresa_modelo($datos);

        if ($actualizar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "empresa actualizada",
                "texto" => "los datos de la empresa se han actualizado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo actualizar la empresa!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para eliminar empresa------------------------------------------ */
    public function eliminar_empresa_controller()
    {
        $id = mainModel::decryption($_POST['id']);

        if ($id == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo eliminar la empresa!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar = empresaModel::eliminar_empresa_modelo($id);

        if ($eliminar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "empresa eliminada",
                "texto" => "la empresa se ha eliminado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo eliminar la empresa!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }
}
