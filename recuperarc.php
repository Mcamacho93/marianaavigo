<?php 
session_start();
if(isset($_SESSION['clientCode']))
	header("Location: index.php");
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


	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	<script type="text/javascript">
 	
		function cambiarContRC(evccrc, nueva, confirmar){
			evccrc.preventDefault();
				var id = "<?php echo $_GET['tid'] ?>";
			
			if($.trim(nueva) == "" || $.trim(confirmar) == ""){
				$('#msgcambio').fadeIn(300);
				setTimeout(function(){
					$('#msgcambio').fadeOut(300);
				},3000)
				$('#msgcambio').html('Llene todos los campos');
				return;
			}
			if($.trim(nueva) != $.trim(confirmar)){
				$('#msgcambio').fadeIn(300);
				setTimeout(function(){
					$('#msgcambio').fadeOut(300);
				},3000)
				$('#msgcambio').html('Las contrase\u00f1as no coinciden');
			}
			if($.trim(nueva.length) <= 6 || $.trim(confirmar.length) <= 6){
				$('#msgcambio').fadeIn(300);
				setTimeout(function(){
					$('#msgcambio').fadeOut(300);
				},3000)
				$('#msgcambio').html('La contrase\u00f1a debe tener m\u00e1s de 6 caracteres');
				return;
			}
			else{
				$.ajax({
					beforeSend: function(){
						$('#cambiar').attr('disabled', true);
						$('#cambiar').html('Espere...');
						$('#msgcambio').fadeOut(300);
					},
					url: 'cambiarcont.php',
					type: 'POST',
					data: {NuevaCont: nueva, Id:id},
					success: function(rescc){
						$('#cambiar').html('CAMBIAR CONTRASE\u00f1A');
						$('#cambiar').attr('disabled', false);
						if(rescc == "OK"){
							window.location = 'recuperarc.php';
							alert('Contrase\u00f1a cambiada con \u00e9xito');
						}
						else{
							$('#msgcambio').fadeIn(300);
							$('#msgcambio').html(rescc);
						}
					}
				});
			}
		}
	</script>

</head>
<body>
	
<?php include "menu.php";
if (isset($_GET['temp']) && isset($_GET['tid'])){
	include 'conexion.php';
	$bd = new MYSQLIFunctions();
	$t1 = $bd->escapestr($_GET['tid']);
	$t2 = $bd->escapestr($_GET['temp']);
	$queryrecuperar = "select * from clients where SHA2(clientCode,256) = '".$t1."' and clientPass = '".$t2."'";
	$cliente = $bd->query($queryrecuperar);
	if($bd->rows($cliente) <= 0){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=recuperarc.php">';
	}
	else{
		?>
		<div class="registro" id="nuevac">
			<div class="container">
				<div class="six columns offset-by-one">
					<form id="nuevacont" class="formrec" onsubmit="cambiarContRC(event, this.nuevacon.value , this.repetirc.value)">
			    	<label>
			       		 <input id="nuevacon" type="password" required="" placeholder="Nueva Contrase&ntilde;a" title="Nueva Contrase&ntilde;a" />
			   		</label>
			   		<label>
			       		 <input id="repetirc" type="password" required="" placeholder="Repetir Contrase&ntilde;a" title="Repetir Contrase&ntilde;a" />
			   		</label>
			   		<label id="msgcambio" style="display:none"></label>
			   		<button id="cambiar" name="cambiar" type="submit">Cambiar Contrase&ntilde;a</button> </form>
				</div>
			</div>
		</div>
		<?php
	}

}
else{
	?>

<div class="registro" id="recuperar">
	<div class="container">
		<div class="six columns offset-by-one">
			<form id="recuperar" class="formrec" onsubmit="recuperarC(event, this.correoR.value)">
	    	<label>Ingrese el correo electr&oacute;nico con el cual se registr&oacute;</label>
	    	<label>
	        	<input id="correoR" type="email" required="" placeholder="Correo electr&oacute;nico" title="Correo electr&oacute;nico"/>
	   		</label>
	   		<label id="msgr" style="display:none"></label>
	   		<button id="enviarC" name="enviarC" type="submit">Enviar</button> </form>
		</div>
	</div>
</div>


	<?php
}


?>




<?php include("footer.php");?>





</body>
</html>