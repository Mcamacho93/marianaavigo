<?php
if(isset($_POST['Name'])){
    include 'conexion.php';
    require ('configuracionmail.php');
    $name = $_POST['Name'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];
    $contrasena = bin2hex(hash('sha256', $_POST['PassworD']));
    $dbobj = new MYSQLIfunctions();

    $querymail = "select * from clients where clientEmail = '".$email."'";
    $correocte = $dbobj->query($querymail);

    if(($dbobj->rows($correocte)) > 0){
        echo "Ya existe un usuario con ese correo electrónico";
        exit();
    }
    else{
        $insert = "insert into clients values ('', '".$name."', '', '".$lastName."', '', '', '".$email."', '".$contrasena."', '', '', 1, '', '', '', '', 'n')";
        if($dbobj->query($insert)){
            $idcte = $dbobj->lastid();
            $idh = hash('sha256', $idcte);
            $correohash = hash('sha256', $email);
            $correo -> charSet = "UTF-8";
            $correo->addAddress($email, 'Casa Laietana');
            $correo->Subject = "Casa Laietana Verificar Cuenta";
                $rec = '<html>
                <head>
                   <link href="http://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
                   <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
                    <style>

                   body {width: 100%; padding: 0px; margin: 0px; background-color: #e6e6e6; padding: 20px 0px; }
                   p{font-family: "PT Sans", Helvetica, Arial, Sans-Serif}
                   .container{width: 600px; background-color: #fff; margin: 0 auto; }
                   .bienvenida{ padding: 0px 20px; text-align: center;}
                   .bienvenida h1{font-family: "Montserrat", tahoma, Century-Gothic, Sans-Serif; font-size: 26px; font-weight:bolder; color: #bce8f7; text-align: left;}
                   .prod{padding: 5px 0px; font-size: 0; }
                   .prod div{font-size: 1rem;display: inline-block; margin: 0px; padding: 0px;vertical-align: middle;}
                   .texto{height: 163px; font-family: "Montserrat", tahoma, Century-Gothic, Sans-Serif; color: #fff; font-weight:bolder; background: #bce8f7; width: 240px; margin: 0px;}
                   .texto h2{padding: 20px; font-size: 26px}
                   .imagen{height: 163px;}
                   .link{margin-top: 20px; text-align: center;}
                   .link p{margin-bottom: 40px;}
                   .link a{ background-color: #bce8f7; padding: 7px 15px; font-family: "Montserrat", tahoma, Century-Gothic, Sans-Serif; text-decoration: none; margin-top: 20px;  color: #000;}
                   .link h3{font-family: "PT Sans", Helvetica, Arial, Sans-Serif; color:#e6e6e6; font-size: 11px; margin-top: 30px; text-align: left; padding: 20px 10px; }
                   </style>
                </head>
                <body>
                   <div class="container">
                      <div class="header">
                         <img src="images/correo-header.jpg" alt="Casa Laietana">
                      </div>
                      <div class="bienvenida">
                         <h1>Bienvenido:</h1>
                         <p>Gracias por registrarte en Casa Laietana&#174;, tu almac&eacute;n de reposter&iacute;a fina.</p>
                         <p>La innovaci&oacute;n, calidad, variedad y servicio son los valores que representan a Casa Laietana&#174;, de esta forma llevamos el mejor sabor a su cocina.</p>
                         <p>Casa Laietana&#174;  podr&aacute;s encontrar una amplia gama de productos para la elaboraci&oacute;n y decoraci&oacute;n de reposter&iacute;a. </p>
                      </div>
                      <div class="prod">
                         <div class="texto">
                            <h2>Materias Primas e Ingredientes</h2>
                         </div>
                         <div class="imagen">
                            <img src="images/img1.jpg">
                         </div>
                      </div>
                       <div class="prod">
                         <div class="imagen">
                            <img src="images/img2.jpg">
                         </div>
                         <div class="texto">
                            <h2>Utensilios y Accesorios</h2>
                         </div>
                      </div>
                       <div class="prod">
                         <div class="texto">
                            <h2>Libros y Aprendizaje</h2>
                         </div>
                         <div class="imagen">
                            <img src="images/img3.jpg">
                         </div>
                      </div>
                      <div class="link">
                         <p>Puedes completar el registro en el siguiente enlace:</p>
                         <a href="http://www.lomas.mx/casalaietana/cliente/verificarcta.php?tid='.$idh.'&temp='.$correohash.'">COMPLETAR REGISTRO</a>
                         <h3>Usted ha recibido este mensaje al registrarse en CasaLaietana.com, si ha recibido este mensaje por error, favor de ignorar el mismo.</h3>
                      </div>
                   </div>
                </body>
                <html>';
                //$rec = "Para verificar su cuenta haga click en el siguiente enlace <br><a href='http://www.lomas.mx/casalaietana/cliente/verificarcta.php?tid=".$idh."&temp=".$correohash."'>Aquí</a>";
                $correo->MsgHTML($rec);
                if($correo->send()){
                        echo "Se le ha enviado un correo a la dirección proporcionada, revise su correo para validar su cuenta";

                }
                else
                    echo "Error: ".$correo->ErrorInfo;
        }

    }
}


?>
