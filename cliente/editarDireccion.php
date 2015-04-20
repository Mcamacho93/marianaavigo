<?php
session_start();
if(!isset($_SESSION['clientCode']))
	header("Location: ../");
if(!isset($_POST['Descripcion'])){
	echo "Favor de llenar todos los campos";
	exit;
}
if(!isset($_POST['Tipo'])){
	header: "Location: index.php";
	exit;
}
else{
	include '../conexion.php';
	$db = new MYSQLIFunctions();
	if($_POST['Tipo'] == "1"){
		$codigocte = $db->escapestr($_SESSION['clientCode']);
		$descripcion = $db->escapestr($_POST['Descripcion']);
		$calleno = $db->escapestr($_POST['Calle']);
		$numero = $db->escapestr($_POST['Numero']);
		$colonia = $db->escapestr($_POST['Colonia']);
		$delegacion = $db->escapestr($_POST['Delegacion']);
		$ciudad = $db->escapestr($_POST['Ciudad']);
		$estado = $db->escapestr($_POST['Estado']);
		$codigopostal = $db->escapestr($_POST['CodigoPostal']);
		$RFC = $db->escapestr($_POST['RFC']);
		$telefono = $db->escapestr($_POST['Tel']);
		$telefonoalterno = $db->escapestr($_POST['TelAlterno']);
		$email = $db->escapestr($_POST['Email']);
		$iddir = $db->escapestr($_POST['IDdir']);
		$tipo = $db->escapestr($_POST['Tipo']);
		$updatequery  = "update address set addressDesc = '".$descripcion."', street = '".$calleno."', number = ".$numero.", colony = '".$colonia."', delegation = '".$delegacion."', stateID = ".$estado.", city = '".$ciudad."', zip = '".$codigopostal."', RFC = '".$RFC."', addressPhone = '".$telefono."', addressPhone2 = '".$telefonoalterno."', email = '".$email."'  where clientCode = ".$codigocte." and addressID = ".$iddir."";
		if($db->query($updatequery)){
			$querydireccion = $db->escapestr("select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$codigocte." and idType=".$tipo."");
			$direccion = $db->query($querydireccion);
			$direccionarray = array();
			echo "OK$%&";
			while($col = $db->fassoc($direccion)){
				$direccionarray[] = $col;
			}
			echo json_encode($direccionarray);
		}
	}

	if($_POST['Tipo'] == "2"){
		$codigocte = $db->escapestr($_SESSION['clientCode']);
		$descripcion = $db->escapestr($_POST['Descripcion']);
		$calleno = $db->escapestr($_POST['Calle']);
		$numero = $db->escapestr($_POST['Numero']);
		$colonia = $db->escapestr($_POST['Colonia']);
		$delegacion = $db->escapestr($_POST['Delegacion']);
		$ciudad = $db->escapestr($_POST['Ciudad']);
		$estado = $db->escapestr($_POST['Estado']);
		$codigopostal = $db->escapestr($_POST['CodigoPostal']);
		$telefono = $db->escapestr($_POST['Tel']);
		$telefonoalterno = $db->escapestr($_POST['TelAlterno']);
		$email = $db->escapestr($_POST['Email']);
		$iddir = $db->escapestr($_POST['IDdir']);
		$tipo = $db->escapestr($_POST['Tipo']);
		$updatequery  = "update address set addressDesc = '".$descripcion."', street = '".$calleno."', number = ".$numero.", colony = '".$colonia."', delegation = '".$delegacion."', stateID = ".$estado.", city = '".$ciudad."', zip = '".$codigopostal."', addressPhone = '".$telefono."', addressPhone2 = '".$telefonoalterno."', email = '".$email."'  where clientCode = ".$codigocte." and addressID = ".$iddir."";
		if($db->query($updatequery)){
			$querydireccion = $db->escapestr("select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$codigocte." and idType=".$tipo."");
			$direccion = $db->query($querydireccion);
			$direccionarray = array();
			echo "OK$%&";
			while($col = $db->fassoc($direccion)){
				$direccionarray[] = $col;
			}
			echo json_encode($direccionarray);
		}
	}
}

 ?>

