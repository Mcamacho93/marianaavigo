<?php
	require ('configuracionmail.php');
		if ( strlen($_POST['Email']) == 0 || !filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)){
			echo "Revise la informacion proporcionada";

		}
		else{
	
			$Nombre ="Nombre: ".$_POST['Nombre'];
			$Email = "Correo: ".$_POST['Email'];
			$Telefono = "Telefono: ".$_POST['Msg'];


			$Info = $Nombre."<br>".$Email."<br>".$Telefono;

			//echo $Todo;
			
			$correo->addAddress('prueba@lomas.mx', $_POST['Nombre']);
			$correo->Subject = "Contacto Casa Laietana";
			$body = $Info;
			$correo->MsgHTML($body);

			if($correo->send()){
				echo "Correo Enviado";

			}	
			else{
				echo "Intente Nuevamente";
			}
		
		}
	
	
		
		?>

