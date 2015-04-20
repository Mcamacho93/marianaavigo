<?php
session_start();
if(!isset($_SESSION['adminID'])){
	header("Location: ../");
	exit;
}
if(!isset($_SESSION['clientCode']) || !isset($_SESSION['email'])){
	header("Location: ../");
	exit;
}

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


	<link rel="stylesheet" href="../stylesheets/base.css">
	<link rel="stylesheet" href="../stylesheets/skeleton1200.css">
	<link rel="stylesheet" href="../stylesheets/layout.css">
	<link rel="stylesheet" href="../fonts/fonts.css">
	<link rel="stylesheet" type="text/css" href="../stylesheets/slick.css"/>
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>


	<script src="../js/jquery-1.11.1.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	<script type="text/javascript" src="../js/slick.min.js"></script>
	<script type="text/javascript" src="js/admin.js"></script>


	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">


</head>
<body>

<?php include "menu.php";
if(isset($_GET['cont'])){
	?>
	<div class="registro" id="cambiarcontrasena">
	<div class="container">
		<div class="six columns offset-by-one">
			<form id="cambiarcont" class="formrec" onsubmit="cambiarContrasena(event, this.contanterior.value, this.nuevacont.value, this.confirmarcont.value)">
	    	<label>No omita ningun campo</label>
	    	<label>
	        	<input id="contanterior" type="password" required="" placeholder="Contrase&ntilde;a Anterior" title="Contrase&ntilde;a Anterior"/>
	   		</label>
			<label>
	        	<input id="nuevacont" type="password" required="" placeholder="Nueva Contrase&ntilde;a" title="Nueva Contrase&ntilde;a"/>
	   		</label>
	   		<label>
	        	<input id="confirmarcont" type="password" required="" placeholder="Confirmar Contrase&ntilde;a" title="Confirmar Contrase&ntilde;a"/>
	   		</label>
	   		<label id="msgcc" style="display:none"></label>
	   		<button id="cambiarCont"  type="submit">Cambiar Contrase&ntilde;a</button>
	   		</form>
		</div>
	</div>
</div>

	<?php
}

if(isset($_GET['correo'])){
	?>
		<div class="registro" id="cambiarcorr">
		<div class="container">
			<div class="six columns offset-by-one">
				<form id="cambiarcorreo" class="formrec">
		    	<label id="campos">No omita ningun campo</label>
		    	<label>
		        	<input id="correoanterior" type="email" required="" placeholder="Correo Anterior" title="Correo Anterior"/>
		   		</label>
				<label>
		        	<input id="nuevocorreo" type="email" required="" placeholder="Correo Nuevo" title="Correo Nuevo"/>
		   		</label>
		   		<label>
		        	<input id="confirmarcorreo" type="email" required="" placeholder="Confirmar Correo" title="Confirmar Correo"/>
		   		</label>
		   		<label id="msgcco" style="display:none"></label>
		   		<button id="cambiarCorreoE"  type="submit">Cambiar Correo</button>
		   		</form>
			</div>
		</div>
	</div>

	<?php
}
?>






<?php include("../footer.php");?>





</body>
</html>
