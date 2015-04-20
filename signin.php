<?php
session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    <title>Casa Laietana</title>
    <meta name="description" content="Sitio web dedicado a la venta y suministro de artículos para la cocina gourmet">
    <meta name="author" content="Casa Laietana">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="stylesheets/base.css">
    <link rel="stylesheet" href="stylesheets/skeleton1200.css">
    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/slick.css"/>
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>


    <script src="js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="js/slick.min.js"></script>
    <script type="text/javascript" src="js/ajaxfunctions.js"></script>
    <script src = "js/sha256.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>

<?php include("menu.php");?>




<div class="registro" id="contacto">
    <div class="container">
        <div class="six columns offset-by-one">
            <form id="registros" onsubmit="signUp(event, registros.user.value, this.lastname.value, this.email.value, this.confemail.value, this.password.value, this.cpassword.value)">
        	<label>
           		 <input id="user" type="text" required="" placeholder="Nombre" title="Usuario" required/>
       		</label>
       		<label>
           		 <input id="lastname" type="text" required="" placeholder="Apellidos" title="Apellidos" required />
       		</label>
       		<label>
            	<input id="email" type="email" required="" placeholder="Correo" title="Correo" name="Email" required/>
       		</label>
       		<label>
            	<input id="confemail" type="email" required="" placeholder="Confirme Correo" title="Correo" name="confemail" required/>
       		</label>
            <label>
            	<input id="password" type="password" required="" placeholder="Contraseña" title="Password" required/>
       		</label>
       		<label>
            	<input id="cpassword" type="password" required="" placeholder="Confirmar contraseña" title="Password" required/>
       		</label>
       		<p>Al crear una cuenta acepto los términos del servicio y la polìtica de privacidad del sitio</P>
            <button id="enviar" name="button" type="submit"> Enviar</button> </form>
       </div>
    </div>
</div>


<?php include("footer.php");?>

</body>
</html>
