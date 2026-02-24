<?php
require_once "mainModel.php";

class empresaModel extends mainModel
{

    /* -------------------------------registrar empresa----------------------------------- */
    protected static function agregar_empresa_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        INSERT INTO empresas(
            em_nombre, 
            em_celular, 
            em_nit, 
            em_comision, 
            us_id
        ) VALUES(
            :nombre, 
            :celular, 
            :nit, 
            :comision, 
            :usuario
        )
    ");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":celular", $datos['celular']);
        $sql->bindParam(":nit", $datos['nit']);
        $sql->bindParam(":comision", $datos['comision']);
        $sql->bindParam(":usuario", $datos['usuario']);

        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar empresas----------------------------------- */
    protected static function listar_empresas_modelo($limite)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT e.em_id, e.em_nombre, e.em_celular, e.em_nit, e.em_comision, 
               e.em_creado_en, e.em_estado, u.us_nombres, u.us_apellido_paterno
        FROM empresas e
        LEFT JOIN usuarios u ON e.us_id = u.us_id
        WHERE e.em_estado = 1
        ORDER BY e.em_nombre ASC
        $limite
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------contar empresas----------------------------------- */
    protected static function contar_empresas_modelo()
    {
        $sql = mainModel::conectar()->prepare("
        SELECT COUNT(em_id) as total
        FROM empresas
        WHERE em_estado = 1
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------obtener empresa----------------------------------- */
    protected static function obtener_empresa_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT e.*, u.us_nombres, u.us_apellido_paterno
        FROM empresas e
        LEFT JOIN usuarios u ON e.us_id = u.us_id
        WHERE e.em_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------actualizar empresa----------------------------------- */
    protected static function actualizar_empresa_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE empresas SET
            em_nombre = :nombre,
            em_celular = :celular,
            em_nit = :nit,
            em_comision = :comision,
            em_actualizado_en = NOW()
        WHERE em_id = :id
        ");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":celular", $datos['celular']);
        $sql->bindParam(":nit", $datos['nit']);
        $sql->bindParam(":comision", $datos['comision']);
        $sql->bindParam(":id", $datos['id']);

        $sql->execute();
        return $sql;
    }

    /* -------------------------------eliminar empresa----------------------------------- */
    protected static function eliminar_empresa_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        DELETE FROM empresas WHERE em_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------desactivar empresa----------------------------------- */
    protected static function desactivar_empresa_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE empresas SET
            em_estado = 0,
            em_actualizado_en = NOW()
        WHERE em_id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar todas las empresas (incluyendo inactivas)----------------------------------- */
    protected static function listar_todas_empresas_modelo($limite)
    {
        $sql = mainModel::conectar()->prepare("
        SELECT e.em_id, e.em_nombre, e.em_celular, e.em_nit, e.em_comision, 
               e.em_creado_en, e.em_estado, u.us_nombres, u.us_apellido_paterno
        FROM empresas e
        LEFT JOIN usuarios u ON e.us_id = u.us_id
        ORDER BY e.em_nombre ASC
        $limite
        ");
        $sql->execute();
        return $sql;
    }

    /* -------------------------------contar todas las empresas----------------------------------- */
    protected static function contar_todas_empresas_modelo()
    {
        $sql = mainModel::conectar()->prepare("
        SELECT COUNT(em_id) as total FROM empresas
        ");
        $sql->execute();
        return $sql;
    }
}
