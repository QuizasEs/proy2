<?php
if ($peticionAjax) {
    require_once "../models/userModel.php";
} else {
    require_once "./models/userModel.php";
}

class userController extends userModel
{

    /* -----------------------------------controlador para agregar usuarios------------------------------------------ */
    public function get_user_controller()
    {
        session_start(['name' => 'SMP']);
        $rol = $_SESSION['rol_smp'];

        if ($rol != 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Acceso denegado",
                "texto" => "no tienes permisos para agregar usuarios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /* datos personales */
        $nombres = mainModel::limpiar_cadena($_POST['Nombres_reg']);
        $apellido_paterno = mainModel::limpiar_cadena($_POST['ApellidoPaterno_reg']);
        $apellido_materno = mainModel::limpiar_cadena($_POST['ApellidoMaterno_reg']);
        $carnet =   mainModel::limpiar_cadena($_POST['Carnet_reg']);
        $telefono =  mainModel::limpiar_cadena($_POST['Telefono_reg']);
        $correo = mainModel::limpiar_cadena($_POST['Correo_reg']);
        $direccion = mainModel::limpiar_cadena($_POST['Direccion_reg']);


        /* datos de usuario */
        $usuarioName = mainModel::limpiar_cadena($_POST['UsuarioName_reg']);
        $password = mainModel::limpiar_cadena($_POST['Password_reg']);
        $password_confirm = mainModel::limpiar_cadena($_POST['PasswordConfirm_reg']);
        $rol = mainModel::limpiar_cadena($_POST['Rol_reg']);
        $rol = (int)$rol;


        /* combertimos enteros los campos */


        /* comprobar que los campos obligatorios no esten vacios */
        if ($nombres == "" || $apellido_paterno == "" || $apellido_materno == "" || $usuarioName == "" || $password == "" || $password_confirm == "" || $rol == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "No se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        /* verificar la integridad de los datos (patern) */
        /* nombres */
        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,100}", $nombres)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El NOMBRE no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        /* apellido paterno */
        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,100}", $apellido_paterno)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El APELLIDO PATERNO no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        /* apellido materno */
        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,100}", $apellido_materno)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El APELLIDO MATERNO no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        /* numero de carnet */
        if (mainModel::verificar_datos("[0-9]{6,20}", $carnet)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El Carnet no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        /* telefono vacio */
        if ($telefono != "") {
            if (mainModel::verificar_datos("[0-9]{6,20}", $telefono)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "El Telefono no coincide con el formato solicitado!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            };
        };
        /* nombre de usaurio */
        if (mainModel::verificar_datos("^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_]{3,100}$", $usuarioName)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El USERNAME no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        /* contraseñas */
        if (
            mainModel::verificar_datos("[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@$!%*?&._#]{3,100}", $password) ||
            mainModel::verificar_datos("[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@$!%*?&._#]{3,100}", $password_confirm)
        ) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "Las Contraseñas no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };


        /* comprobar que no hayan datos repetidos  */
        /* carnet */
        $check_carnet = mainModel::ejecutar_consulta_simple("SELECT us_numero_carnet FROM usuarios WHERE us_numero_carnet = '$carnet'");
        if ($check_carnet->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El NUMERO DE CARNET ya se encuentra registrado, por favor ingrese otro!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        /* nombre de usuario */
        $check_usuario = mainModel::ejecutar_consulta_simple("SELECT us_username FROM usuarios WHERE us_username = '$usuarioName'");
        if ($check_usuario->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El USUARIO ya se encuentra registrado, por favor ingrese otro!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        /* comprobar correo */
        if ($correo != "") {
            if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $check_correo = mainModel::ejecutar_consulta_simple("SELECT us_correo FROM usuarios WHERE us_correo = '$correo'");
                if ($check_correo->rowCount() > 0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "ocurrio un error inesperado",
                        "texto" => "El correo ya se encuentra registrado, por favor ingrese otro!",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                };
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "Has ingresado un correo no valido!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        /* comprobar contraseñas */

        if ($password != $password_confirm) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "Las CONTRASEÑAS no coinciden, intente nuevamente!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $password_hash = mainModel::encryption($password);
        };

        if ($rol < 1 || $rol > 3) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El ROL seleccionado no es valido!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        };
        $datos_usuario_reg = [
            "Nombres" => $nombres,
            "ApellidoPaterno" => $apellido_paterno,
            "ApellidoMaterno" => $apellido_materno,
            "Carnet" => $carnet,
            "Telefono" => $telefono,
            "Correo" => $correo,
            "Direccion" => $direccion,
            "UsuarioName" => $usuarioName,
            "Password" => $password_hash,
            "Rol" => $rol
        ];
        $agregar_usuario = userModel::agregar_usuario_modelo($datos_usuario_reg);

        if ($agregar_usuario->rowCount() == 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Usuario registrado correctamente",
                "texto" => "El USUARIO se ha registrado con exito",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "No se ha podido registrar el usuario, por favor intente nuevamente!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }
    /* -----------------------------------controlador para paginar usuarios------------------------------------------ */
    public function paginado_user_controller($pagina, $registros, $privilegio, $id, $url, $busqueda)
    {
        /* limpiamos cadenas para evitar injeccion */
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $privilegio = mainModel::limpiar_cadena($privilegio);
        $id = mainModel::limpiar_cadena($id);
        $url = mainModel::limpiar_cadena($url);
        $url = SERVER_URL . "index.php?views=" . $url;
        $busqueda = mainModel::limpiar_cadena($busqueda);

        $tabla = "";

        /* validamos que el valor ingresado por url sea un numero */
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {
            /* busqueda */
            $consulta = "
                SELECT 
                    SQL_CALC_FOUND_ROWS 
                    u.*, 
                    r.ro_nombre AS rol_nombre, 
                    s.su_nombre AS sucursal_nombre
                FROM usuarios AS u
                LEFT JOIN roles AS r ON u.ro_id = r.ro_id
                LEFT JOIN sucursales AS s ON u.su_id = s.su_id
                WHERE (u.us_id != '$id' AND u.us_id != '5')
                AND (
                    u.us_numero_carnet LIKE '%$busqueda%' OR
                    u.us_nombres LIKE '%$busqueda%' OR
                    u.us_apellido_paterno LIKE '%$busqueda%' OR
                    u.us_apellido_materno LIKE '%$busqueda%' OR
                    u.us_telefono LIKE '%$busqueda%' OR
                    u.us_correo LIKE '%$busqueda%' OR
                    u.us_direccion LIKE '%$busqueda%' OR
                    u.us_username LIKE '%$busqueda%' OR
                    r.ro_nombre LIKE '%$busqueda%' OR
                    s.su_nombre LIKE '%$busqueda%'
                )
                ORDER BY u.us_nombres ASC 
                LIMIT $inicio, $registros
            ";

        } else {
            /* evitamos que el usuario actual y el usuario principal sean visibles y accesibles */
            $consulta = "
                SELECT 
                    SQL_CALC_FOUND_ROWS 
                    u.*, 
                    r.ro_nombre AS rol_nombre, 
                    s.su_nombre AS sucursal_nombre
                FROM usuarios AS u
                LEFT JOIN roles AS r ON u.ro_id = r.ro_id
                LEFT JOIN sucursales AS s ON u.su_id = s.su_id
                WHERE u.us_id != '$id' 
                AND u.us_id != '5'
                ORDER BY u.us_nombres ASC 
                LIMIT $inicio, $registros
            ";
        }

        /* realizamos la peticion a la base de datos */
        $conexion = mainModel::conectar();
        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        /* obtenemos la cantidad total de registro */
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        /* numero de paginas por registros */
        $Npaginas = ceil($total / $registros);

        /* inicio de tabla */
        $tabla .= '
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>NOMBRES</th>
                                <th>APELLIDO PATERNO</th>
                                <th>APELLIDO MATERMNO</th>
                                <th>N° CARNET</th>
                                <th>N° TELEFONO</th>
                                <th>CORREO</th>
                                <th>DIRECCION</th>
                                <th>NOMBRE DE USUARIO</th>
                                <th>CREADO EN</th>
                                <th>ACTUALIZADO EN</th>
                                <th>ROL</th>
                                <th>SUCURSAL</th>
                                <th>ESTADO</th>
                                <th>
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody>
        ';

        if ($pagina <= $Npaginas && $total >= 1) {
            $contador = $inicio + 1;

            foreach ($datos as $rows) {
                $tabla .= '
                    <tr>
                        <td>' . $contador . '</td>
                        <td>' . $rows["us_nombres"] . '</td>
                        <td>' . $rows["us_apellido_paterno"] . '</td>
                        <td>' . $rows["us_apellido_materno"] . '</td>
                        <td>' . $rows["us_numero_carnet"] . '</td>
                        <td>' . $rows["us_telefono"] . '</td>
                        <td>' . $rows["us_correo"] . '</td>
                        <td>' . $rows["us_direccion"] . '</td>
                        <td>' . $rows["us_username"] . '</td>
                        <td>' . $rows["us_creado_en"] . '</td>
                        <td>' . $rows["us_actualizado_en"] . '</td>
                        <td>' . $rows["rol_nombre"] . '</td>
                        <td>' . $rows["sucursal_nombre"] . '</td>
                        <td>' . ($rows["us_estado"] == 1 ? '<span class="active">Activo</span>' : '<span class="in-active">Inactivo</span>') . '</td>
                        <td><a href="" class="btn-editar">Editar</a></td>
                    </tr>
                ';
                $contador++;
            }
        } else {


            if ($total >= 1) {
                /* en caso que la url no sea valida de una pagina con registros mostrara  */
                $tabla .= ' <tr><td colspan="15">  <a class="btn-primary" href="' . $url . '"> Recargar </a></td></tr> ';
            } else {
                /* en caso que no tenga registrados ni un registro en la base de datos mostrara  */
                $tabla .= ' <tr><td colspan="15"> No hay registros</td></tr> ';
            }
        }

        /* final de talbla */
        $tabla .= '
                        </tbody>
                    </table>
                </div>
        ';

        if($pagina <= $Npaginas && $total >= 1){
            $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
        }

        /* devolvemos tabla */
        return $tabla;
    }


    /* -----------------------------------controlador para actualizar perfil------------------------------------------ */
    public function actualizar_perfil_controller()
    {
        $id = mainModel::decryption($_POST['Usuario_id_up']);
        $nombres = mainModel::limpiar_cadena($_POST['Nombres_up']);
        $apellido_paterno = mainModel::limpiar_cadena($_POST['ApellidoPaterno_up']);
        $apellido_materno = mainModel::limpiar_cadena($_POST['ApellidoMaterno_up']);
        $carnet = mainModel::limpiar_cadena($_POST['Carnet_up']);
        $telefono = mainModel::limpiar_cadena($_POST['Telefono_up']);
        $correo = mainModel::limpiar_cadena($_POST['Correo_up']);
        $direccion = mainModel::limpiar_cadena($_POST['Direccion_up']);

        if ($nombres == "" || $apellido_paterno == "" || $apellido_materno == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "No se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,100}", $nombres)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El NOMBRE no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,100}", $apellido_paterno)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El APELLIDO PATERNO no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,100}", $apellido_materno)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El APELLIDO MATERNO no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if ($carnet != "") {
            if (mainModel::verificar_datos("[0-9]{6,20}", $carnet)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "El Carnet no coincide con el formato solicitado!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        if ($telefono != "") {
            if (mainModel::verificar_datos("[0-9]{6,20}", $telefono)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "El Telefono no coincide con el formato solicitado!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        if ($correo != "") {
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "Has ingresado un correo no valido!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        $datos_perfil = [
            "Nombres" => $nombres,
            "ApellidoPaterno" => $apellido_paterno,
            "ApellidoMaterno" => $apellido_materno,
            "Carnet" => $carnet,
            "Telefono" => $telefono,
            "Correo" => $correo,
            "Direccion" => $direccion,
            "Id" => $id
        ];

        $actualizar_perfil = userModel::actualizar_perfil_modelo($datos_perfil);

        if ($actualizar_perfil->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Perfil actualizado",
                "texto" => "El perfil se ha actualizado con exito",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "No se ha podido actualizar el perfil, por favor intente nuevamente!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para actualizar credenciales------------------------------------------ */
    public function actualizar_credenciales_controller()
    {
        $id = mainModel::decryption($_POST['Usuario_id_up']);
        $nuevo_usuario = mainModel::limpiar_cadena($_POST['NuevoUsuario_up']);
        $password_actual = mainModel::limpiar_cadena($_POST['Password_actual_up']);
        $nuevo_password = mainModel::limpiar_cadena($_POST['NuevoPassword_up']);
        $confirmar_password = mainModel::limpiar_cadena($_POST['ConfirmarPassword_up']);

        if ($nuevo_usuario == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se ha ingresado el nuevo nombre de usuario!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_]{3,50}", $nuevo_usuario)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "el nombre de usuario no coincide con el formato solicitado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $verificar_usuario = userModel::verificar_usuario_modelo($nuevo_usuario, $id);

        if ($verificar_usuario->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "el nombre de usuario ya esta en uso por otro usuario!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_usuario = userModel::obtener_usuario($id);
        $usuario_actual = $datos_usuario->fetch();

        $password_actual_hash = $usuario_actual['us_password_hash'];

        if ($nuevo_password != "" || $confirmar_password != "") {
            if ($password_actual == "") {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "debe ingresar la contraseña actual para cambiar la contraseña!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $password_actual_encrypted = mainModel::encryption($password_actual);

            if ($password_actual_encrypted != $password_actual_hash) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "la contraseña actual es incorrecta!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if ($nuevo_password != $confirmar_password) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "las nuevas contraseñas no coinciden!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@$!%*?&._#]{3,100}", $nuevo_password)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "ocurrio un error inesperado",
                    "texto" => "la nueva contraseña no coincide con el formato solicitado!",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $nuevo_password = mainModel::encryption($nuevo_password);
        }

        $datos_credenciales = [
            "NuevoUsuario" => $nuevo_usuario,
            "NuevoPassword" => $nuevo_password ?? "",
            "Id" => $id
        ];

        $actualizar_credenciales = userModel::actualizar_credenciales_modelo($datos_credenciales);

        if ($actualizar_credenciales->rowCount() == 1) {
            $_SESSION['usuario_smp'] = $nuevo_usuario;
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "credenciales actualizadas",
                "texto" => "las credenciales se han actualizado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han realizado cambios en las credenciales!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }


    /* -----------------------------------controlador para listar personal------------------------------------------ */
    public function listar_personal_controller()
    {
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $pagina = mainModel::validar_pagina($pagina);
        
        // Contar total de registros
        $totalRegistros = userModel::contar_personal_modelo()->fetch()['total'];
        $itemsPorPagina = 15;
        
        // Obtener limite SQL
        $limite = mainModel::obtener_limit($pagina, $itemsPorPagina);
        
        // Obtener datos
        $lista_personal = userModel::listar_personal_modelo($limite);
        
        // Obtener URL base - usar la ruta correcta
        $url = SERVER_URL . "index.php?views=personal";
        
        // Generar paginacion
        $paginacion = mainModel::paginador($pagina, $totalRegistros, $url, $itemsPorPagina);
        
        return array(
            'datos' => $lista_personal,
            'paginacion' => $paginacion,
            'total' => $totalRegistros
        );
    }

    /* -----------------------------------controlador para obtener personal------------------------------------------ */
    public function obtener_personal_controller($id)
    {
        $id = mainModel::decryption($id);
        $datos = userModel::obtener_usuario_modelo($id);
        return $datos;
    }

    /* -----------------------------------controlador para actualizar usuario------------------------------------------ */
    public function actualizar_usuario_controller()
    {
        session_start(['name' => 'SMP']);
        $rol = $_SESSION['rol_smp'];

        if ($rol != 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Acceso denegado",
                "texto" => "no tienes permisos para actualizar usuarios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $id = mainModel::decryption($_POST['Usuario_id_up']);
        $nombres = mainModel::limpiar_cadena($_POST['nombres']);
        $apellido_paterno = mainModel::limpiar_cadena($_POST['apellido_paterno']);
        $apellido_materno = mainModel::limpiar_cadena($_POST['apellido_materno']);
        $carnet = mainModel::limpiar_cadena($_POST['carnet']);
        $telefono = mainModel::limpiar_cadena($_POST['telefono']);
        $correo = mainModel::limpiar_cadena($_POST['correo']);
        $direccion = mainModel::limpiar_cadena($_POST['direccion']);
        $username = mainModel::limpiar_cadena($_POST['username']);
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        $rol = mainModel::limpiar_cadena($_POST['rol']);
        $estado = mainModel::limpiar_cadena($_POST['estado']);

        if ($id == "" || $nombres == "" || $apellido_paterno == "" || $apellido_materno == "" || $username == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se han llenado todos los campos obligatorios!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Verificar si el username ya existe (excepto para este usuario)
        $check_usuario = mainModel::ejecutar_consulta_simple("SELECT us_id FROM usuarios WHERE us_username = '$username' AND us_id != '$id'");
        if ($check_usuario->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "El USUARIO ya se encuentra registrado!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Si hay password, encriptarla
        $password_hash = null;
        if (!empty($password)) {
            $password_hash = mainModel::encryption($password);
        }

        $datos = [
            "nombres" => $nombres,
            "apellido_paterno" => $apellido_paterno,
            "apellido_materno" => $apellido_materno,
            "carnet" => $carnet,
            "telefono" => $telefono,
            "correo" => $correo,
            "direccion" => $direccion,
            "username" => $username,
            "password" => $password_hash,
            "rol" => $rol,
            "estado" => $estado,
            "id" => $id
        ];

        $actualizar = userModel::actualizar_usuario_modelo($datos);

        if ($actualizar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "usuario actualizado",
                "texto" => "los datos del usuario se han actualizado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo actualizar el usuario!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para eliminar usuario------------------------------------------ */
    public function eliminar_usuario_controller()
    {
        session_start(['name' => 'SMP']);
        $rol = $_SESSION['rol_smp'];

        if ($rol != 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Acceso denegado",
                "texto" => "no tienes permisos para eliminar usuarios!",
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
                "texto" => "no se ha especificado el usuario a eliminar!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar = userModel::eliminar_usuario_modelo($id);

        if ($eliminar->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "usuario eliminado",
                "texto" => "el usuario se ha eliminado exitosamente!",
                "Tipo" => "success"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ocurrio un error inesperado",
                "texto" => "no se pudo eliminar el usuario!",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /* -----------------------------------controlador para listar roles------------------------------------------ */
    public function listar_roles_controller()
    {
        $roles = userModel::listar_roles_modelo();
        return $roles;
    }

    /* -----------------------------------controlador para paginar usuarios------------------------------------------ */
    /* -----------------------------------controlador para paginar usuarios------------------------------------------ */
    /* -----------------------------------controlador para paginar usuarios------------------------------------------ */
    /* -----------------------------------controlador para paginar usuarios------------------------------------------ */
    /* -----------------------------------controlador para paginar usuarios------------------------------------------ */
}
