<?php
require_once "mainModel.php";

class servicioModel extends mainModel
{

    protected static function agregar_servicio_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        INSERT INTO servicios(
            se_nombre, 
            se_descripcion, 
            se_tipo_sistema, 
            us_id
        ) VALUES(
            :nombre, 
            :descripcion, 
            :tipo_sistema, 
            :usuario
        )
    ");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":descripcion", $datos['descripcion']);
        $sql->bindParam(":tipo_sistema", $datos['tipo_sistema']);
        $sql->bindParam(":usuario", $datos['usuario']);

        $sql->execute();
        return $sql;
    }

    protected static function listar_servicios_modelo($limite)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT s.se_id, s.se_nombre, s.se_descripcion, s.se_tipo_sistema, 
               s.se_creado_en, s.se_actualizado_en, s.se_estado, u.us_nombres, u.us_apellido_paterno
        FROM servicios s
        LEFT JOIN usuarios u ON s.us_id = u.us_id
        WHERE s.se_estado = 1
        ORDER BY s.se_nombre ASC
        $limite
        ");
        $sql->execute();
        return $sql;
    }

    protected static function contar_servicios_modelo()
    {
        $sql = mainModel::conectar()->prepare("
        SELECT COUNT(se_id) as total
        FROM servicios
        WHERE se_estado = 1
        ");
        $sql->execute();
        return $sql;
    }

    protected static function obtener_servicio_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT s.*, u.us_nombres, u.us_apellido_paterno
        FROM servicios s
        LEFT JOIN usuarios u ON s.us_id = u.us_id
        WHERE s.se_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    protected static function actualizar_servicio_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE servicios SET
            se_nombre = :nombre,
            se_descripcion = :descripcion,
            se_tipo_sistema = :tipo_sistema,
            se_actualizado_en = NOW()
        WHERE se_id = :id
        ");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":descripcion", $datos['descripcion']);
        $sql->bindParam(":tipo_sistema", $datos['tipo_sistema']);
        $sql->bindParam(":id", $datos['id']);

        $sql->execute();
        return $sql;
    }

    protected static function eliminar_servicio_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        DELETE FROM servicios WHERE se_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    protected static function desactivar_servicio_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE servicios SET
            se_estado = 0,
            se_actualizado_en = NOW()
        WHERE se_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar todos los servicios (incluyendo inactivos)----------------------------------- */
    protected static function listar_todos_servicios_modelo($limite)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT s.se_id, s.se_nombre, s.se_descripcion, s.se_tipo_sistema, 
               s.se_creado_en, s.se_actualizado_en, s.se_estado, u.us_nombres, u.us_apellido_paterno
        FROM servicios s
        LEFT JOIN usuarios u ON s.us_id = u.us_id
        ORDER BY s.se_nombre ASC
        $limite
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------contar todos los servicios----------------------------------- */
    protected static function contar_todos_servicios_modelo()
    {
        $sql = mainModel::conectar()->prepare("
        SELECT COUNT(se_id) as total FROM servicios
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------activar servicio----------------------------------- */
    protected static function activar_servicio_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE servicios SET
            se_estado = 1,
            se_actualizado_en = NOW()
        WHERE se_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }
}
