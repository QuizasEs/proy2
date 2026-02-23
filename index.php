<?php
    $peticionAjax = false;
    require_once "./config/APP.php";
    
    if(isset($_POST['Usuario_log']) && isset($_POST['Password_log'])){
        require_once "./controllers/loginController.php";
        $ins_login = new loginController();
        $resultado = $ins_login->iniciar_sesion_controller();
        
        if ($resultado === 'ok') {
            echo '<script>window.location.href="' . SERVER_URL . 'index.php?views=dashboard";</script>';
            exit();
        }
    }
    
    require_once "./controllers/viewsController.php";
    $plantilla = new viewsController();
    $plantilla->get_plantilla_controller();
