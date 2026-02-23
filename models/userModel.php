<?php
require_once "mainModel.php";

class userModel extends mainModel
{



    /* -------------------------------registrar usuario----------------------------------- */
    protected static function agregar_usuario_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        INSERT INTO usuarios(
            us_nombres, 
            us_apellido_paterno, 
            us_apellido_materno, 
            us_numero_carnet, 
            us_telefono, 
            us_correo, 
            us_direccion, 
            us_username, 
            us_password_hash, 
            ro_id
        ) VALUES(
            :nombres, 
            :apellido_paterno, 
            :apellido_materno, 
            :carnet, 
            :telefono, 
            :correo, 
            :direccion, 
            :username, 
            :password, 
            :rol
        )
    ");

        $sql->bindParam(":nombres", $datos['Nombres']);
        $sql->bindParam(":apellido_paterno", $datos['ApellidoPaterno']);
        $sql->bindParam(":apellido_materno", $datos['ApellidoMaterno']);
        $sql->bindParam(":carnet", $datos['Carnet']);
        $sql->bindParam(":telefono", $datos['Telefono']);
        $sql->bindParam(":correo", $datos['Correo']);
        $sql->bindParam(":direccion", $datos['Direccion']);
        $sql->bindParam(":username", $datos['UsuarioName']);
        $sql->bindParam(":password", $datos['Password']);
        $sql->bindParam(":rol", $datos['Rol']);

        $sql->execute();
        return $sql;
    }

    /* -------------------------------actualizar perfil----------------------------------- */
    protected static function actualizar_perfil_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("
        UPDATE usuarios SET
            us_nombres = :nombres,
            us_apellido_paterno = :apellido_paterno,
            us_apellido_materno = :apellido_materno,
            us_numero_carnet = :carnet,
            us_telefono = :telefono,
            us_correo = :correo,
            us_direccion = :direccion,
            us_actualizado_en = NOW()
        WHERE us_id = :id
        ");

        $sql->bindParam(":nombres", $datos['Nombres']);
        $sql->bindParam(":apellido_paterno", $datos['ApellidoPaterno']);
        $sql->bindParam(":apellido_materno", $datos['ApellidoMaterno']);
        $sql->bindParam(":carnet", $datos['Carnet']);
        $sql->bindParam(":telefono", $datos['Telefono']);
        $sql->bindParam(":correo", $datos['Correo']);
        $sql->bindParam(":direccion", $datos['Direccion']);
        $sql->bindParam(":id", $datos['Id']);

        $sql->execute();
        return $sql;
    }

    /* -------------------------------obtener datos usuario----------------------------------- */
    protected static function obtener_usuario_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE us_id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------obtener datos usuario publico----------------------------------- */
    public static function obtener_usuario($id)
    {
        return self::obtener_usuario_modelo($id);
    }

    /* -------------------------------actualizar credenciales usuario----------------------------------- */
    protected static function actualizar_credenciales_modelo($datos)
    {
        if ($datos['NuevoPassword'] != "") {
            $sql = mainModel::conectar()->prepare("
            UPDATE usuarios SET
                us_username = :username,
                us_password_hash = :password,
                us_actualizado_en = NOW()
            WHERE us_id = :id
            ");
            $sql->bindParam(":password", $datos['NuevoPassword']);
        } else {
            $sql = mainModel::conectar()->prepare("
            UPDATE usuarios SET
                us_username = :username,
                us_actualizado_en = NOW()
            WHERE us_id = :id
            ");
        }

        $sql->bindParam(":username", $datos['NuevoUsuario']);
        $sql->bindParam(":id", $datos['Id']);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------verificar nombre de usuario----------------------------------- */
    protected static function verificar_usuario_modelo($usuario, $id)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE us_username = :usuario AND us_id != :id");
        $sql->bindParam(":usuario", $usuario);
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar todo el personal----------------------------------- */
    protected static function listar_personal_modelo($limite)
    {
        $id_actual = $_SESSION['id_smp'];
        $sql = mainModel::conectar()->prepare("
        SELECT u.us_id, u.us_nombres, u.us_apellido_paterno, u.us_apellido_materno, 
               u.us_numero_carnet, u.us_telefono, u.us_correo, u.us_direccion, 
               u.us_username, u.us_estado, u.us_creado_en, r.ro_id, r.ro_nombre
        FROM usuarios u
        LEFT JOIN roles r ON u.ro_id = r.ro_id
        WHERE u.us_id != :id_actual
        ORDER BY u.us_nombres ASC, u.us_apellido_paterno ASC
        $limite
        ");
        $sql->bindParam(":id_actual", $id_actual);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------contar personal----------------------------------- */
    protected static function contar_personal_modelo()
    {
        $id_actual = $_SESSION['id_smp'];
        $sql = mainModel::conectar()->prepare("
        SELECT COUNT(us_id) as total
        FROM usuarios
        WHERE us_id != :id_actual
        ");
        $sql->bindParam(":id_actual", $id_actual);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------actualizar usuario----------------------------------- */
    protected static function actualizar_usuario_modelo($datos)
    {
        // Si hay password nueva, actualizar; si no, no incluir en el query
        $sql_password = "";
        if ($datos['password'] !== null && !empty($datos['password'])) {
            $sql_password = ", us_password_hash = :password ";
        }
        
        $sql = mainModel::conectar()->prepare("
        UPDATE usuarios SET
            us_nombres = :nombres,
            us_apellido_paterno = :apellido_paterno,
            us_apellido_materno = :apellido_materno,
            us_numero_carnet = :carnet,
            us_telefono = :telefono,
            us_correo = :correo,
            us_direccion = :direccion,
            us_username = :username,
            ro_id = :rol,
            us_estado = :estado,
            us_actualizado_en = NOW()
            $sql_password
        WHERE us_id = :id
        ");

        $sql->bindParam(":nombres", $datos['nombres']);
        $sql->bindParam(":apellido_paterno", $datos['apellido_paterno']);
        $sql->bindParam(":apellido_materno", $datos['apellido_materno']);
        $sql->bindParam(":carnet", $datos['carnet']);
        $sql->bindParam(":telefono", $datos['telefono']);
        $sql->bindParam(":correo", $datos['correo']);
        $sql->bindParam(":direccion", $datos['direccion']);
        $sql->bindParam(":username", $datos['username']);
        $sql->bindParam(":rol", $datos['rol']);
        $sql->bindParam(":estado", $datos['estado']);
        $sql->bindParam(":id", $datos['id']);
        
        if ($datos['password'] !== null && !empty($datos['password'])) {
            $sql->bindParam(":password", $datos['password']);
        }

        $sql->execute();
        return $sql;
    }

    /* -------------------------------eliminar usuario----------------------------------- */
    protected static function eliminar_usuario_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("DELETE FROM usuarios WHERE us_id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    /* -------------------------------listar roles----------------------------------- */
    protected static function listar_roles_modelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM roles WHERE ro_estado = 1");
        $sql->execute();
        return $sql;
    }
}
