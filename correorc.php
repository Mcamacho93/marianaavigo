<?php
	require ('configuracionmail.php');
		if ( strlen($_POST['Correo']) == 0 || !filter_var($_POST['Correo'], FILTER_VALIDATE_EMAIL)){
			echo "Revise la informacion proporcionada";
		}
		else{
			include 'conexion.php';
			$bd = new MYSQLIFunctions();
			$email = $bd->escapestr($_POST['Correo']);
			$queryusuario = "select SHA2(clientCode, 256) as idhash, clientPass from clients where clientEmail = '".$email."'";
			$usuario = $bd->query($queryusuario);
			if($bd->rows($usuario) <= 0){
				echo "No existe ningun usuario registrado con ese correo electrónico";
			}
			else{

				while($colrc = $bd->fassoc($usuario)){
					$idh = $colrc['idhash'];
					$cp = $colrc['clientPass'];
				}
				$correo -> charSet = "UTF-8";
				$rec = "Para recuperar tu contraseña da click en el siguiente enlace <br>"." <a href='http://www.lomas.mx/casalaietana/recuperarc.php?tid=".$idh."&temp=".$cp."'>Aquí</a>";
				$correo->addAddress($email, 'Casa Laietana');
				$correo->Subject = "Casa Laietana Recuperar Contraseña";
				$body = $rec;
				$correo->MsgHTML($body);
				if($correo->send()){
					echo "Te hemos enviado un correo electrónico con las indicaciones para cambiar tu contraseña";

				}
				else{
					echo "Intente Nuevamente";
				}

			}


		}



		?>

