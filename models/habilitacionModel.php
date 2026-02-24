<?php
require_once "mainModel.php";

class habilitacionModel extends mainModel
{

    /* -------------------------------registrar habilitacion----------------------------------- */
    protected static function agregar_habilitacion_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        INSERT INTO habilitaciones(
            se_id, 
            em_id, 
            ha_link_sistema, 
            ha_tipo_suscripcion, 
            ha_sucursal,
            us_id
        ) VALUES(
            :servicio, 
            :empresa, 
            :link, 
            :tipo_suscripcion, 
            :sucursal,
            :usuario
        )
    ");

        $sql->bindParam(":servicio", $datos['servicio']);
        $sql->bindParam(":empresa", $datos['empresa']);
        $sql->bindParam(":link", $datos['link']);
        $sql->bindParam(":tipo_suscripcion", $datos['tipo_suscripcion']);
        $sql->bindParam(":sucursal", $datos['sucursal']);
        $sql->bindParam(":usuario", $datos['usuario']);

        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar habilitaciones----------------------------------- */
    protected static function listar_habilitaciones_modelo($limite)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT h.ha_id, h.ha_link_sistema, h.ha_tipo_suscripcion, h.ha_sucursal, 
               h.ha_creado_en, h.ha_actualizado_en, h.ha_estado,
               s.se_id, s.se_nombre, s.se_tipo_sistema,
               e.em_id, e.em_nombre, e.em_nit,
               u.us_nombres, u.us_apellido_paterno
        FROM habilitaciones h
        LEFT JOIN servicios s ON h.se_id = s.se_id
        LEFT JOIN empresas e ON h.em_id = e.em_id
        LEFT JOIN usuarios u ON h.us_id = u.us_id
        WHERE h.ha_estado = 1
        ORDER BY h.ha_id DESC
        $limite
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------contar habilitaciones----------------------------------- */
    protected static function contar_habilitaciones_modelo()
    {
        $sql = mainModel::conectar()->prepare("
        SELECT COUNT(ha_id) as total
        FROM habilitaciones
        WHERE ha_estado = 1
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------obtener habilitacion----------------------------------- */
    protected static function obtener_habilitacion_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT h.*, 
               s.se_nombre, s.se_tipo_sistema,
               e.em_nombre, e.em_nit,
               u.us_nombres, u.us_apellido_paterno
        FROM habilitaciones h
        LEFT JOIN servicios s ON h.se_id = s.se_id
        LEFT JOIN empresas e ON h.em_id = e.em_id
        LEFT JOIN usuarios u ON h.us_id = u.us_id
        WHERE h.ha_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------actualizar habilitacion----------------------------------- */
    protected static function actualizar_habilitacion_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE habilitaciones SET
            se_id = :servicio,
            em_id = :empresa,
            ha_link_sistema = :link,
            ha_tipo_suscripcion = :tipo_suscripcion,
            ha_sucursal = :sucursal,
            ha_actualizado_en = NOW()
        WHERE ha_id = :id
        ");

        $sql->bindParam(":servicio", $datos['servicio']);
        $sql->bindParam(":empresa", $datos['empresa']);
        $sql->bindParam(":link", $datos['link']);
        $sql->bindParam(":tipo_suscripcion", $datos['tipo_suscripcion']);
        $sql->bindParam(":sucursal", $datos['sucursal']);
        $sql->bindParam(":id", $datos['id']);

        $sql->execute();
        return $sql;
    }

    /* -------------------------------eliminar habilitacion----------------------------------- */
    protected static function eliminar_habilitacion_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        DELETE FROM habilitaciones WHERE ha_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------desactivar habilitacion----------------------------------- */
    protected static function desactivar_habilitacion_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE habilitaciones SET
            ha_estado = 0,
            ha_actualizado_en = NOW()
        WHERE ha_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar empresas para select----------------------------------- */
    protected static function listar_empresas_modelo()
    {
        $sql = mainModel::conectar()->prepare("
        SELECT em_id, em_nombre, em_nit
        FROM empresas
        ORDER BY em_nombre ASC
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar servicios para select----------------------------------- */
    protected static function listar_servicios_modelo()
    {
        $sql = mainModel::conectar()->prepare("
        SELECT se_id, se_nombre, se_tipo_sistema
        FROM servicios
        ORDER BY se_nombre ASC
        ");
        $sql->execute();
        return $sql;
    }
}
