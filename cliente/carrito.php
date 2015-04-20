<?php
session_start();
if(isset($_SESSION['adminID'])){
    header("Location: .../");
    exit;
}
if(!isset($_SESSION['clientCode']) || !isset($_SESSION['email']) || !isset($_SESSION['verified'])){
    header("Location: ../");
    exit;
}
if($_SESSION['verified'] == 'n'){
    header("Location: novalidada.php");
    exit;
}

include '../conexion.php';
$bd = new MYSQLIFunctions();

?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    <title>Casa Laietana</title>
    <meta name="description" content="Sitio web dedicado a la venta y suministro de artículos para la cocina gourmet">
    <meta name="author" content="Casa Laietana">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="../stylesheets/base.css">
    <link rel="stylesheet" href="../stylesheets/skeleton1200.css">
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../stylesheets/layout.css">
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>
    
    <script src="../js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="js/clientFunctions.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="../images/favicon.ico">

</head>
<body>

<?php include("menu.php");?>

<section id="usuario">
<div class="container">
        <div class="sixteen columns" id="locali">
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="../tienda.php">TIEnda</a></li>
                        <li><a href="#">Carrito de compras</a></li>
                    </ul>
        </div>
        </div>
 <div class="container">
 <div class="sixteen columns titl">
    <h2 id="titl">COMPLETAR PEDIDO</h2>
</div></div>
<div class="container" id="carrodecompras">
    <?php

    if(!isset($_SESSION['carrito'])){
        ?>
        <div class="nine columns offset-by-one">
            <label>No hay art&iacute;culos en el carrito</label>
        </div>
        <?php
    }
    else{
        echo '<div class="nine columns alpha offset-by-one" id="listadeproductos">';
        foreach ($_SESSION['carrito'] as $key => $value) {
            ?>
                <hr>
                <div class="three columns omega">
                    <div class="carritoimg">
                    <img  src="../<?php echo $_SESSION['carrito'][$key]['img'] ?>">
                    </div>
                </div>
                <div class="four columns informac omega">
                    <h1><?php echo $_SESSION['carrito'][$key]['nombre'] ?></h1>
                    <h3><?php echo $_SESSION['carrito'][$key]['presentacion'] ?></h3>
                    <div class="cantidadcontador">
                    <button class="menos" onclick="subtotalBtnMenos($(this).next().val() , $(this).next().attr('id'))">-</button>
                    <input type="text" class="cantidad" id="<?php echo $_SESSION['carrito'][$key]['id'] ?>"  value="<?php echo $_SESSION['carrito'][$key]['cantidad'] ?>" onkeyup="subtotal(this.value, this.id)" onkeypress="validaentero(event)">
                    <button class="mas" onclick="subtotalBtnMas($(this).prev().val() , $(this).prev().attr('id'))">+</button>
                    </div>
                    <?php
                    $queryexistencia = "select existencia from products where productID = ".$_SESSION['carrito'][$key]['id']." ";
                    $exeexistencia = $bd->query($queryexistencia);
                    $datoexistencia = $bd->fassoc($exeexistencia);
                    ?>
                    <label>En existencia: <?php echo $datoexistencia['existencia'] ?></label>
                </div>
                <div class="two columns">
                    <label class="precio">
                        $&nbsp;&nbsp;<?php echo $_SESSION['carrito'][$key]['precio'] ?>
                    </label>
                    <label class="quitarr" id="l<?php echo $_SESSION['carrito'][$key]['id'] ?>" onclick="quitarDelCarrito(this.id)">Quitar</label>
                </div>
            <?php
            if(!isset($total))
                $total = 0;
            $total += $_SESSION['carrito'][$key]['total'];
        }
        echo '<hr>';
        echo "</div>";

    }

     ?>
     <div class="five columns">
     	<div class="cuadrogris">
            <h1>TU PEDIDO: </h1>
            <p>Total de productos: &nbsp;&nbsp;&nbsp;&nbsp;<?php if (isset($_SESSION['carrito']))echo count($_SESSION['carrito']); else echo "0"; ?></p>
            <br><p>Subtotal:</p>
            <label class="subtotal" id="subtotal">$&nbsp;&nbsp;<?php if (isset($total)) echo number_format($total, 2, '.', ','); else echo "0.00"; ?>&nbsp;MXN</label>
        </div>
    <br>
        <div class="cuadrogris">
            <?php

            $querydir = "select a.*, s.stateName from address a, state s where clientCode = ".$_SESSION['clientCode']." and idType = 2 and a.stateID = s.stateID order by addressDesc limit 1";
            $resultados = $bd->query($querydir);
            $valido = 0; //para saber si tiene alguna dirección agregada
            if($bd->rows($resultados)<= 0){
                ?>
                <label id="labenvio">
                    <h2>DATOS DE ENVIO:</h2>
                    No tiene ninguna direcci&oacute;n agregada, debe tener al menos una para poder completar su pedido, agreguela <a href="index.php#envioModal">Aquí</a>.
                </label>

                <?php
                $valido++;
            }
            while($direccion = $bd->fassoc($resultados)){
                ?>
                <label id="labenvio">
                    <h2>DATOS DE ENVIO:</h2>
                    <?php echo $direccion['street']; ?> <br>
                    <?php echo $direccion['zip']." ".$direccion['stateName']; ?> <br>
                    <?php echo $direccion['addressPhone']; ?><br>
                </label>
                <label id="change"><a href="#cambiardireccionenvio">Cambiar</a></label>
                <?php
                $iddedireccion = $direccion['addressID'];
            }

             ?>
        </div>
        <br>
        <div class="cuadrogris">
            <?php
            if(!isset($_SESSION['dirfacturacion'])){
                $bd = new MYSQLIFunctions();
                $querydir = "select a.*, s.stateName from address a, state s where clientCode = ".$_SESSION['clientCode']." and idType = 1 and a.stateID = s.stateID order by addressDesc limit 1";
                $resultados = $bd->query($querydir);
                if($bd->rows($resultados) <= 0){
                    ?>
                    <label id="labenvio">
                        <h2>DATOS DE FACTURACI&Oacute;N</h2>
                        No tiene ninguna direcci&oacute;n agregada, debe tener al menos una para poder completar su pedido, agreguela <a href="index.php#facturacionModal">Aquí</a>.
                    </label>

                    <?php
                    $valido++;

                }
                while($direccion = $bd->fassoc($resultados)){
                    $_SESSION['dirfacturacion'] = $direccion['addressID'];
                    ?>
                    <label id="labfacturacion">
                        <h2>DATOS DE FACTURACIÓN:</h2>
                        <?php echo $direccion['street']; ?> <br>
                        <?php echo $direccion['zip']." ".$direccion['stateName']; ?> <br>
                        <?php echo $direccion['addressPhone']; ?>
                    </label>
                    <label id="change"><a href="#cambiardireccionfacturacion">Cambiar</a></label>
                    <?php
                    $iddedireccion = $direccion['addressID'];
                }
            }
            else{
                $bd = new MYSQLIFunctions();
                $querydir = "select a.*, s.stateName from address a, state s where clientCode = ".$_SESSION['clientCode']." and addressID = ".$_SESSION['dirfacturacion']." and a.stateID = s.stateID order by addressDesc limit 1";
                $resultados = $bd->query($querydir);
                while($direccion = $bd->fassoc($resultados)){
                    ?>
                    <label id="labfacturacion">
                        <h2>DATOS DE FACTURACIÓN:</h2>
                        <?php echo $direccion['street']; ?> <br>
                        <?php echo $direccion['zip']." ".$direccion['stateName']; ?> <br>
                        <?php echo $direccion['addressPhone']; ?>
                    </label>
                    <label id="change"><a href="#cambiardireccionfacturacion">Cambiar</a></label>
                    <?php
                    $iddedireccion = $direccion['addressID'];
                }
            }

                 ?>
        </div>
        <?php
        if($valido == 0){
        ?>
            <button class="order" id="d<?php echo $iddedireccion ?>" onclick="ordenarAhora(this.id)">ORDENAR AHORA</button>
            <label id="msgpedido"></label>
        <?php
        }
        if($valido >0){
            ?>
            <button class="order" onclick="msgdedf()">ORDENAR AHORA</button>
            <label id="msgpedido"></label>
            <?php
        }

         ?>

     </div>

</div>


</section>

<div class="container">
    <div id="cambiardireccionenvio" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="formEnvio" onsubmit="cambiaDireccionEnvio(event, this.direnvio.value)">
            <label>Seleccione el nombre de la direcci&oacute;n a usar</label>
            <?php
            $queryenvio = "select addressID, addressDesc from address where clientCode = ".$_SESSION['clientCode']." and idType= 2";
            $direccionesdeenvio = $bd->query($queryenvio);
            if($bd->rows($direccionesdeenvio) <= 0){
                ?>
                <label>No hay direcciones registradas, agregue una <a href="index.php">aqu&iacute;</a></label>
                <?php
            }
            else{
                echo "<select id='direnvio'>";
                while($dirs = $bd->fassoc($direccionesdeenvio)){
                    ?>
                    <option value="<?php echo $dirs['addressID'] ?>"><?php echo $dirs['addressDesc'] ?></option>
                    <?php
                }
                echo "</select>";
            }

             ?>

       		<label id="estadoCambiodf" style="display:none"></label>
        	<button type="submit" id="dirfacturacion" >Cambiar</button>
        	</form>
        </div>
    </div>
</div>

<div class="container">
    <div id="cambiardireccionfacturacion" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="formFacturacion" onsubmit="cambiaDireccionFacturacion(event, this.dirfact.value)">
            <label>Seleccione el nombre de la direcci&oacute;n a usar</label>
            <?php
            $queryfacturacion = "select addressID, addressDesc from address where clientCode = ".$_SESSION['clientCode']." and idType= 1";
            $direccionesdefacturacion = $bd->query($queryfacturacion);
            if($bd->rows($direccionesdefacturacion) <= 0){
                ?>
                <label>No hay direcciones registradas, agregue una <a href="index.php">aqu&iacute;</a></label>
                <?php
            }
            else{
                echo "<select id='dirfact'>";
                while($dirsfa = $bd->fassoc($direccionesdefacturacion)){
                    ?>
                    <option value="<?php echo $dirsfa['addressID'] ?>"><?php echo $dirsfa['addressDesc'] ?></option>
                    <?php
                }
                echo "</select>";
            }
             ?>
       		<label id="estadoCambiodf" style="display:none"></label>
        	<button type="submit" id="dirfacturacion" >Cambiar</button>
        	</form>
        </div>
    </div>
</div>

<?php include("../footer.php");?>






</body>
</html>
