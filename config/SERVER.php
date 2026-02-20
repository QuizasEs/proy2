<?php
    /* Configuración inicial para la base de datos (local) */
    const SERVER = "localhost";
    const DB = "proy2";
    const USER = "root";
    const PASS = "";

    /* Inicializa la conexión con la base de datos */
    define("SGBD", "mysql:host=" . SERVER . ";dbname=" . DB);

    /* Configuración de encriptación */
    const METHOD = "AES-256-CBC"; /* método de cifrado */
    const SECRET_KEY = '$farm@2025'; /* clave personalizada */
    const SECRET_IV = "037970"; /* vector de inicialización */

    /* Configuración de SMTP para PHPMailer */
    const SMTP_HOST = "smtp.gmail.com";
    const SMTP_USER = "zetaconde@gmail.com";
    const SMTP_PASS = "tu_contraseña_de_aplicacion";
    const SMTP_PORT = 587;
?>
