<?php 
if(!isset($_POST['NuevaCont'])){
	echo "error 404";
}
else{
	include 'conexion.php';
	$bd = new MYSQLIFunctions();
	$contrasena = $bd->escapestr(bin2hex(hash('sha256', $_POST['NuevaCont'])));
	$id = $bd->escapestr($_POST['Id']);
	$querycon = "update clients set clientPass = '".$contrasena."' where SHA2(clientCode, 256) = '".$id."'";
	if($bd->query($querycon))
		echo "OK";

}

 ?>