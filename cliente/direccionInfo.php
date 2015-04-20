<?php 
session_start();
if(!isset($_SESSION['clientCode']))
	header("Location: ../");
else{
	include '../conexion.php';
	$bd = new MYSQLIFunctions();
	$id = $bd->escapestr($_POST['ID']);
	$idcte = $bd->escapestr($_SESSION['clientCode']);

	$query = "select * from address where addressID = ".$id." and clientCode = ".$idcte."";
	$res = $bd->query($query);
	$arraydir = array();

	while ($col = $bd->fassoc($res)){
		$arraydir[] = $col;
	}

	echo json_encode($arraydir);


}
 ?>
