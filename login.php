<?php
if(!isset($_POST['Mail']) && !isset($_POST['Contrasena'])){
	echo "LLene todos los campos";
}
else{
	include 'conexion.php';
	$db= new MYSQLIfunctions();
	$user = $db->escapestr($_POST['Mail']);
	$password = $db->escapestr($_POST['Contrasena']);
	//$email = $db->escapestr($_POST['User']);
	$con = $db->escapestr(bin2hex(hash('sha256',$_POST['Contrasena'])));
	$selectadmin = "select * from admin where adminEmail = '".$user."' and adminPassword = '".$con."'";
	$admin = $db->query($selectadmin);
	if($db->rows($admin) <= 0){
		$select = "select * from clients where clientEmail = '".$user."' and clientPass = '".$con."'";
		$user = $db->query($select);
		if($db->rows($user) <= 0){
			echo "Datos Erroneos";
		}
		else{
			while($patricia = $db->fassoc($user)){
				session_start();
				$_SESSION['rol'] = "cliente";
				$_SESSION['clientCode'] = $patricia['clientCode'];
				$_SESSION['name'] = $patricia['clientName'];
				$_SESSION['email'] = $patricia['clientEmail'];
				$_SESSION['verified'] = $patricia['verified'];
				$_SESSION['registros'] = "";
				echo "OKCTE";
			}
		}
	}
	else{
		while ($admincol = $db->fassoc($admin)){
			session_start();
			$_SESSION['rol'] = "admin";
			$_SESSION['rango'] = $admincol['roleID'];
			$_SESSION['adminID'] = $admincol['adminID'];
			$_SESSION['clientCode'] = $admincol['adminID'];
			$_SESSION['name'] = $admincol['adminName'];
			$_SESSION['email'] = $admincol['adminEmail'];
			$_SESSION['registros'] = "";
			echo "OKADMIN";
		}
	}

}

?>
