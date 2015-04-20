<?php
session_start();
if(!isset($_SESSION['adminID'])){
	header("Location: ../");
	exit;
}
else{
	if($_POST['tipo'] == 1){
		if(!isset($_POST['ContAnterior']) || !isset($_POST['ContrasenaNueva'])){
			echo "No omita ningun campo";
		}
		else{
			include '../conexion.php';
			if($_POST['tipo'] == 1){
			$bd = new MYSQLIFunctions();
			$contAnterior = $bd->escapestr(bin2hex(hash('sha256', $_POST['ContAnterior'])));
			$contNueva = $bd->escapestr(bin2hex(hash('sha256', $_POST['ContrasenaNueva'])));
			$idadmn = $bd->escapestr($_SESSION['adminID']);

			$querycompcontrasena = "select * from admin where adminID = '".$idadmn."' and adminPassword = '".$contAnterior."'";
			$validarcont = $bd->query($querycompcontrasena);
			if($bd->rows($validarcont) <= 0){
				echo "La contraseña ingresada no coincide con la contrasena actual";
			}
			else{
				$querycambioc = "update admin set adminPassword = '".$contNueva."' where adminID = ".$idadmn."";
				if($bd->query($querycambioc)){
					echo "OK";
				}
			}


			}
		}
	}
	else if ($_POST['tipo'] == 2){
		if(!isset($_POST['correoAnterior']) || !isset($_POST['correoNuevo'])){
			echo "No omita ningun campo";
		}
		else{
			include '../conexion.php';
			if($_POST['tipo'] == 2){
			$bd = new MYSQLIFunctions();
			$correoAnterior = $bd->escapestr($_POST['correoAnterior']);
			$correoNuevo = $bd->escapestr($_POST['correoNuevo']);
			$idadmn = $bd->escapestr($_SESSION['adminID']);
			$querycompcorreo = "select * from admin where adminEmail = '".$correoAnterior."' and adminID = ".$idadmn."";
			$validarcorreo = $bd->query($querycompcorreo);
			if($bd->rows($validarcorreo) <= 0){
				echo "El correo ingresado no coincide con el correo actual";
			}
			else{
				$querycorreoexiste = "select * from admin where adminEmail = '".$correoNuevo."'";
				$correoexiste = $bd->query($querycorreoexiste);
				if($bd->rows($correoexiste) > 0){
					echo "El correo electrónico ya está en uso";
				}
				else{
				$querycambiocorreo = "update admin set adminEmail = '".$correoNuevo."' where adminID = ".$idadmn."";
				if($bd->query($querycambiocorreo)){
					echo "OK";
				}
				}
			}
			}
		}
	}
}
?>
