<?php
require_once "c:/xampp/htdocs/proy2/config/SERVER.php";

/* -------------------------------------------------clase principal main model------------------------------------- */
class mainModel
{

    /* ------------------funcion de conexion a la base de datos usandos variables de server.php ----------------*/
    protected static function Conectar()
    {
        try {
            $conexion = new PDO(SGBD . ";charset=utf8", USER, PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die(" Error de conexión: " . $e->getMessage());
        }
    }


    /* ----------------------------------------funcion que ejecuta consultas simples---------------------------------------------- */
    protected static function ejecutar_consulta_simple($consulta)
    {
        $sql = self::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }

    /* ---------------------------------------funcion de encriptado---------------------------------------------- */
    public static function encryption($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    /* -------------------------------------- funcion de desncritar------------------------------------------------ */
    protected static function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
    /* -------------------------------------genera codigos aleatorios------------------------------------------------- */
    protected static function generar_codigo_aleatorio($letra, $longitud, $numero)
    {
        for ($i = 0; $i < $longitud; $i++) {
            $aleatorio = rand(0, 9);
            $letra .= $aleatorio;
        }
        return $letra . "-" . $numero;
    }

    /* ----------------------------------------funcion para limpiar cadenas---------------------------------------------- */
    protected static function limpiar_cadena($cadena)
    {
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src", "", $cadena);
        $cadena = str_ireplace("<script type=", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("DROP TABLE", "", $cadena);
        $cadena = str_ireplace("DROP DATABASE", "", $cadena);
        $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_ireplace("SHOW TABLES", "", $cadena);
        $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena = str_ireplace("<?php", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace(">", "", $cadena);
        $cadena = str_ireplace("<", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(";", "", $cadena);
        $cadena = str_ireplace("::", "", $cadena);
        $cadena = stripslashes($cadena);
        $cadena = trim($cadena);
        return $cadena;
    }
    /* --------------------------------------funcion que verifica los datos------------------------------------------------ */
 		protected static function verificar_datos($filtro,$cadena){
 			if(preg_match("/^".$filtro."$/", $cadena)){
 				return false;
 			}else{
 				return true;
 			}
 		}

    /* -----------------------------------funcion para verificar las fechas --------------------------------------------------- */
    protected static function verificar_fecha($fecha)
    {
        $valor = explode('-', $fecha);
        if ((count($valor)) == 3 && checkdate($valor[1], $valor[2], $valor[0])) {
            return false;
        } else {
            return true;
        }
    }
    /* -----------------------------------------funcion paginador de tablas--------------------------------------------- */
    protected static function paginador_tablas($pagina, $Npaginas, $url, $botones)
    {
        $tabla = '<nav aria-label="Page navigation example">
                        <ul class="custom-pagination">';
        if ($pagina == 1) {
            $tabla .= '<li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>';
        } else {
            $tabla .= '<li class="page-item">
                            <a class="page-link" href="' . $url . '&pagina=' . ($pagina - 1) . '" tabindex="-1">Previous</a>
                        </li>
                        
                        ';
        }


        $ci = 0;
        for ($i = $pagina; $i <= $Npaginas; $i++) {
            if ($i >= $botones) {
                break;
            }

            if ($pagina == $i) {
                $tabla .= '<li class="page-item active"><a class="page-link" href="' . $url . '&pagina=' . $i . '">' . $i . '</a></li>';
            } else {
                $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . '&pagina=' . $i . '">' . $i . '</a></li>';
            }
            $ci++;
        }

        if ($pagina == $Npaginas) {
            $tabla .= '<li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Next</a>
                        </li>';
        } else {
            $tabla .= '<li class="page-item">
                            <a class="page-link" href="' . $url . '&pagina=' . ($pagina + 1) . '" tabindex="-1">Next</a>
                        </li>
                        
                        ';
        }
        $tabla .= ' </ul>
                    </nav>';
        return $tabla;
    }

    /* -----------------------------------------funcion paginador(15 items por pagina)--------------------------------------------- */

    protected static function paginador($pagina, $totalRegistros, $url, $itemsPorPagina = 15)
    {
        // validacion: pagina debe ser un entero positivo
        $pagina = (int) $pagina;
        if ($pagina < 1) {
            $pagina = 1;
        }

        // validacion: itemsporpagina debe ser positivo
        $itemsPorPagina = (int) $itemsPorPagina;
        if ($itemsPorPagina < 1) {
            $itemsPorPagina = 15;
        }

        // calcular total de paginas
        $totalPaginas = ceil($totalRegistros / $itemsPorPagina);
        
        // validacion: si no hay registros, mostrar paginacion vacia
        if ($totalRegistros == 0) {
            return '<div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: var(--space-3) 0;">
                        <span class="pagination-info">Mostrando 0 de 0 registros</span>
                        <div class="pagination-nx"></div>
                    </div>';
        }

        // validacion: si la pagina excede el total, ajustar
        if ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }

        // calcular el rango de registros que se muestran
        $inicio = ($pagina - 1) * $itemsPorPagina + 1;
        $fin = $pagina * $itemsPorPagina;
        if ($fin > $totalRegistros) {
            $fin = $totalRegistros;
        }

        // construir html de paginacion estilo nexus-dashboard
        $tabla = '<div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="padding: var(--space-3) 0;">';
        
        // informacion de registros
        $tabla .= '<span class="pagination-info">Mostrando ' . $inicio . '-' . $fin . ' de ' . $totalRegistros . ' registros</span>';
        
        // contenedor de botones
        $tabla .= '<div class="pagination-nx">';

        // boton anterior (disabled en primera pagina)
        if ($pagina == 1) {
            $tabla .= '<button class="page-btn" disabled>
                        <ion-icon name="chevron-back-outline"></ion-icon>
                       </button>';
        } else {
            $tabla .= '<button class="page-btn" onclick="window.location.href=\'' . $url . '&pagina=' . ($pagina - 1) . '\'">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                       </button>';
        }

        // determinar que paginas mostrar
        $botonesMostrados = 5;
        $inicioRango = 1;
        $finRango = $totalPaginas;

        if ($totalPaginas > $botonesMostrados) {
            $mitad = floor($botonesMostrados / 2);
            $inicioRango = $pagina - $mitad;
            $finRango = $pagina + $mitad;

            if ($inicioRango < 1) {
                $inicioRango = 1;
                $finRango = $botonesMostrados;
            }

            if ($finRango > $totalPaginas) {
                $finRango = $totalPaginas;
                $inicioRango = $totalPaginas - $botonesMostrados + 1;
            }
        }

        // primera pagina y ellipsis si es necesario
        if ($inicioRango > 1) {
            $tabla .= '<button class="page-btn" onclick="window.location.href=\'' . $url . '&pagina=1\'">1</button>';
            if ($inicioRango > 2) {
                $tabla .= '<span style="color: var(--color-text-muted); font-size: var(--text-sm);">...</span>';
            }
        }

        // botones de paginas intermedias
        for ($i = $inicioRango; $i <= $finRango; $i++) {
            if ($i == $pagina) {
                $tabla .= '<button class="page-btn active">' . $i . '</button>';
            } else {
                $tabla .= '<button class="page-btn" onclick="window.location.href=\'' . $url . '&pagina=' . $i . '\'">' . $i . '</button>';
            }
        }

        // ultima pagina y ellipsis si es necesario
        if ($finRango < $totalPaginas) {
            if ($finRango < $totalPaginas - 1) {
                $tabla .= '<span style="color: var(--color-text-muted); font-size: var(--text-sm);">...</span>';
            }
            $tabla .= '<button class="page-btn" onclick="window.location.href=\'' . $url . '&pagina=' . $totalPaginas . '\'">' . $totalPaginas . '</button>';
        }

        // boton siguiente (disabled en ultima pagina)
        if ($pagina == $totalPaginas) {
            $tabla .= '<button class="page-btn" disabled>
                        <ion-icon name="chevron-forward-outline"></ion-icon>
                       </button>';
        } else {
            $tabla .= '<button class="page-btn" onclick="window.location.href=\'' . $url . '&pagina=' . ($pagina + 1) . '\'">
                        <ion-icon name="chevron-forward-outline"></ion-icon>
                       </button>';
        }

        $tabla .= '</div></div>';

        return $tabla;
    }

    /* -----------------------------------------funcion para obtener limit sql para paginacion--------------------------------------------- */

    protected static function obtener_limit($pagina, $itemsPorPagina = 15)
    {
        $pagina = (int) $pagina;
        if ($pagina < 1) {
            $pagina = 1;
        }

        $itemsPorPagina = (int) $itemsPorPagina;
        if ($itemsPorPagina < 1) {
            $itemsPorPagina = 15;
        }

        $inicio = ($pagina - 1) * $itemsPorPagina;
        return "LIMIT $itemsPorPagina OFFSET $inicio";
    }

    /* -----------------------------------------funcion para validar pagina--------------------------------------------- */

    protected static function validar_pagina($pagina, $totalPaginas = 0)
    {
        if (!is_numeric($pagina)) {
            return 1;
        }

        $pagina = (int) $pagina;

        if ($pagina < 1) {
            return 1;
        }

        if ($totalPaginas > 0 && $pagina > $totalPaginas) {
            return $totalPaginas;
        }

        return $pagina;
    }


    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
}
