<?php

date_default_timezone_set('America/Mexico_City');

require 'phpmailer/PHPMailerAutoload.php';

$correo = new PHPMailer();
$correo->isSMTP();
$correo->Host = "ls95.tusite.com";
$correo->SMTPAuth = true;
$correo->SMTPSecure = "ssl";
$correo->Username = "prueba@lomas.mx";
$correo->Password = "lomas4529aeie";
$correo->Port = 465;
$correo->setFrom('prueba@lomas.mx', 'Casa Laietana');
$correo->addReplyTo('prueba@lomas.mx', 'Casa Laietana');

?>