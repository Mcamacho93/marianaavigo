<?php
session_start();
if(isset($_SESSION['adminID'])){
	header("Location: ../");
	exit;
}
if(!isset($_SESSION['clientCode']) || !isset($_SESSION['email']) || !isset($_SESSION['verified'])){
	header("Location: ../");
	exit;
}
if($_SESSION['verified'] == 'y'){
	header("Location: index.php");
	exit;
}
include '../conexion.php';
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
	<link rel="stylesheet" href="../fonts/fonts.css">
	<link rel="stylesheet" href="../stylesheets/layout.css">
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

	<script src="../js/jquery-1.11.1.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	<script type="text/javascript" src="js/clientFunctions.js"></script>


	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="../images/favicon.ico">

</head>
<body>

<?php include("menu.php");?>

<section id="usuario">
<div class="container">
	<div class="fourteen columns offset-by-one">
		<h3>Bienvenido</h3>
		<h2><?php echo $_SESSION['name']; ?></h2>
		<label class="mons">ADMINISTRAR TU CUENTA</label>
		<div class="pedidos2">
			<div class="textovalidar">
				<h2>SU CUENTA NO EST&Aacute; VALIDADA</h2>
				<label class="msgcta" id="edoreenvio"></label>
				<label class="msgcta" id="reenviar">Revise su bandeja de entrada o correo no deseado, en caso de no haber recibido el correo de confirmación, reenvie el mensaje haciendo click <a href="" onclick="reenviarCorreoConfirmacion(event)">Aqu&iacute;</a></label>
				<label class="msgcta">Si el correo que proporcion&oacute; es erroneo puede cambiarlo, el correo proporcionado es: <?php
					$bd = new MYSQLIFunctions();
					$query = "select clientEmail from clients where clientCode = ".$_SESSION['clientCode']."";
					$queryexe = $bd->query($query);
					$colemail = $bd->fassoc($queryexe);
					echo $colemail['clientEmail'];
					?></label>
			</div>
			<div class="cuentanovalida">
				<ul id="opc">
					<li><a href="cambio.php?cont"  id="camcont"><label >Cambiar Contraseña</label></a></li>
					<li><a href="cambio.php?correo" id="camcor"><label>Cambiar Correo</label></a></li>
				</ul>
			</div>
		</div>
	</div>

</div>
</section>



<?php include("../footer.php");?>



</body>
</html>
