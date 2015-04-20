<?php 
session_start();
if(!isset($_SESSION['clientCode'])){
	header("Location: ../");
	exit();
}
if(!isset($_POST['tipo']))
	exit();
else{
	include '../conexion.php';
	$bd = new MYSQLIFunctions();
	$codigocte = $bd->escapestr($_SESSION['clientCode']);
	if($_POST['tipo'] == 1){
		$idfacturacion = $bd->escapestr($_POST['idf']);

		$querydf = "select a.*, s.stateName from address a, state s  where addressID = ".$idfacturacion." and clientCode = ".$codigocte." and a.stateID = s.stateID";
		$direccionf = $bd->query($querydf);
		if($bd->rows($direccionf) <= 0){
			echo "no";
			exit();
		}
		else{
			$arraydf = array();
			while($direccion = $bd->fassoc($direccionf)){
				$_SESSION['dirfacturacion'] = $direccion['addressID'];
				$arraydf = $direccion;
			}
			echo json_encode($arraydf);			
		}
	}
	if($_POST['tipo'] == 2){
		$idenvio = $bd->escapestr($_POST['ide']);

		$queryde = "select a.*, s.stateName from address a, state s where addressID = ".$idenvio." and clientCode = ".$codigocte." and a.stateID = s.stateID";
		$direccione = $bd->query($queryde);
		if($bd->rows($direccione) <= 0){
			echo "no";
			exit();
		}
		else{
			$arrayde = array();
			while($direccionen = $bd->fassoc($direccione)){
				$arrayde = $direccionen;
			}
			echo json_encode($arrayde);			
		}
	}
}


 ?>