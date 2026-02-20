<?php
    class viewsModel{
        
        /* -------------------------------------------Obtener vistas-------------------------------------------------- */
        protected static function get_views_model($vistas){
            $listaBlanca=[
                "dashboard","registroUsuario",
                "categoriaLista","laboratorioLista",
                "presentacionLista","usuarioLista"
            ];

            if(in_array($vistas,$listaBlanca)){
                /* preguntamos si la vista a la que se quiere acceder existe dentro de los archivos */
                if(is_file("./views/content/".$vistas."-view.php")){
                    /* si existe asignamos la variable contenido la ruta de la vista */
                    $contenido = "./views/content/".$vistas."-view.php";
                } else{
                    /* si no mandamos ERROR */
                    $contenido = "./views/content/404-view.php";
                }
            } elseif($vistas=="login" || $vistas=="index" || $vistas=="recuperarPassword"){
                /* preguntamos que si la vista a la que se esta intentado ingresar es login, index o recuperarPassword */
                /* SI es cualquiera de estas devolvemos la misma vista o login por defecto */
                if($vistas=="recuperarPassword"){
                    $contenido = "./views/content/recuperarPassword-view.php";
                }elseif($vistas=="login" || $vistas=="index"){
                    $contenido = "./views/content/login-view.php";
                }else{
                    $contenido = "./views/content/login-view.php";
                }

                /* si la vista a la que se intenta acceder esta fuera de la lista de vistas permitidas votar ERROR */
            } else{
                $contenido = "./views/content/404-view.php";
            }

            /* como la vista a la que se intenta acceder no pertenece a login o index pero si esta dentro de la lista de 
            vistas permiticas devolvemos la misma vista  */
            return $contenido;
        }



        /* -------------------------------------------Obtener vistas-------------------------------------------------- */
        /* -------------------------------------------Obtener vistas-------------------------------------------------- */
        /* -------------------------------------------Obtener vistas-------------------------------------------------- */
        /* -------------------------------------------Obtener vistas-------------------------------------------------- */
        /* -------------------------------------------Obtener vistas-------------------------------------------------- */
        /* -------------------------------------------Obtener vistas-------------------------------------------------- */
    }
?>