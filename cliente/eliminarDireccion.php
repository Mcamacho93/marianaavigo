<?php 
session_start();
if(!isset($_SESSION['clientCode']))
	header("Location: ../");
if(!isset($_POST['IDDF']))
	echo "Error 404";
else{
	include '../conexion.php';
	$bd = new MYSQLIFunctions();
	$idad = $bd->escapestr($_POST['IDDF']);
	$tipo = $bd->escapestr($_POST['tipo']);
	$clc = $bd->escapestr($_SESSION['clientCode']);
	$query = "delete from address where clientCode = ".$clc." and addressID = ".$idad."";
	if($bd->query($query)){
		$querydireccion = $bd->escapestr("select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$clc." and idType=".$tipo."");
		$direccion = $bd->query($querydireccion);
		$direccionarray = array();
		while($col = $bd->fassoc($direccion)){
			$direccionarray[] = $col;
		}
		echo json_encode($direccionarray);

	}

}

 ?>
