<!DOCTYPE html>
<html lang="es" data-theme="light">
<script>
    // Aplica el tema ANTES de que el navegador pinte — evita parpadeo
    try {
        var t = localStorage.getItem('nexus-theme');
        if (t) document.documentElement.setAttribute('data-theme', t);
    } catch (e) {}
</script>

<?php include "inc/head.php"; ?>


<body>
    <div class="app-shell">
        <?php
        $peticionAjax = false;
        require_once __DIR__ . "/../controllers/viewsController.php";

        $IV = new viewsController();
        $vistas = $IV->get_views_controller();

        if (strpos($vistas, "login-view.php") !== false || strpos($vistas, "404-view.php") !== false || strpos($vistas, "recuperarPassword-view.php") !== false) {
            require_once $vistas;
        } else {
            /* inicializa sesion */
            session_start(['name' => 'SMP']);
            

            /* obtener numero de pagina desde query string */
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

            require_once "./controllers/loginController.php";
            $lc = new loginController();
            if (
                !isset($_SESSION['token_smp']) ||
                !isset($_SESSION['nombre_smp']) ||
                !isset($_SESSION['usuario_smp'])
            ) {
                echo $lc->forzar_cierre_sesion_controller();
                exit();
            }
        ?>
            <?php include_once "inc/sidebar.php"; ?>
            <main class="main-content" id="mainContent">
                <?php include_once "inc/navbar.php"; ?>
                <!---------------------------------------------Cuerpo principal--------------------------------------------------->
                
                    <!--------------------------------------------- contenido de platillas y vistas--------------------------------------------------->
                    <?php
                    if (file_exists($vistas)) {
                        include_once $vistas;
                    } else {
                        include_once "./views/content/404-view.php";
                    }
                    ?>


                </div>

            </main>


            <!---------------- -----------------------------Script--------------------------------------------------->

        <?php

        }
        include_once "inc/script.php";
        ?>
    </div>



</body>

</html>