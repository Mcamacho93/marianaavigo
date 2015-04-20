<?php
session_start();
date_default_timezone_set('America/Mexico_City');
if(!isset($_SESSION['clientCode'])){
    header("Location: ../");
    exit();
}
if(!isset($_SESSION['carrito'])){
    echo "No existen productos en el carrito";
    exit();
}
if(!isset($_POST['iddir'])){
    echo "¿Parámetro?";
    exit();
}
if($_POST['iddir'] == ""){
    echo "¿Parámetro?";
    exit();
}
else{
    include '../conexion.php';
    require ('../configuracionmail.php');
    $bd = new MYSQLIFunctions();
    $fecha = date('Y-m-d h:i:s', time());
    $codigocte = $_SESSION['clientCode'];
    $iddireccion = $bd->escapestr($_POST['iddir']);
    $querydir = "select * from address where addressID = ".$iddireccion."";
    $resdir = $bd->query($querydir);
    if($bd->rows($resdir) <= 0){
        echo "error1";
        exit;
    }
    else{
        $coldireccion = $bd->fassoc($resdir);
        $calle = $coldireccion['street'];
        $numero = $coldireccion['number'];
        $colonia = $coldireccion['colony'];
        $ciudad = $coldireccion['city'];
        $estado = $coldireccion['stateID'];
        $codigop = $coldireccion['zip'];
        $telefono = $coldireccion['addressPhone'];
        $totalProductos = count($_SESSION['carrito']);
        $dirdefacturacion = $_SESSION['dirfacturacion'];
        $estadoorden = 4;
        $total = 0;
        foreach ($_SESSION['carrito'] as $key => $value) {
            $total += $_SESSION['carrito'][$key]['total'];
        }
        $agregarorden = "insert into orders values ('', '".$fecha."', ".$codigocte.", '".$calle."', ".$numero.", '".$colonia."', '".$ciudad."', ".$estado.", ".$codigop.", '".$telefono."', ".$dirdefacturacion.", ".$totalProductos.", ".$total.", ".$estadoorden.")";
        if($bd->query($agregarorden)){
            $idinsert = $bd->lastid();
            $contador = 0;

            $query = "select o.*, c.clientEmail from orders o, clients c where o.clientCode = c.clientCode and o.orderID = ".$idinsert."";
            $exequery = $bd->query($query);
            include '../admin/correos.php';
            while($colorden = $bd->fassoc($exequery)){
                $correo -> charSet = "UTF-8";
                $correo->addAddress($colorden['clientEmail'], 'Casa Laietana');
                $correo->Subject = "Pedido Realizado";
                $numeropedido = $colorden['orderID'];
                /*$numceros = 7 - (strlen($numeropedido));
                $ccero = 0;
                $cadceros = "";
                while($ccero < $numceros){
                    $cadceros += "0";
                    $ccero++;
                }
                $folioDelPedido = $cadceros + $numeropedido;
                */
                $listapedidos = "";
                $totalapagar = 0;
                foreach($_SESSION['carrito'] as $key => $value){
                    $listapedidos .= '<tr>
                                    <td id="producto">'.$_SESSION['carrito'][$key]['nombre'].'</td>
                                    <td id="prec">'.number_format($_SESSION['carrito'][$key]['precio'], 2, '.', ',').'</td>
                                    <td id="cant">'.$_SESSION['carrito'][$key]['cantidad'].'</td>
                                    <td id="subt">'.number_format($_SESSION['carrito'][$key]['total'], 2, '.', ',').'</td>
                                </tr>';
                    $totalapagar += $_SESSION['carrito'][$key]['total'];
                }
                $folioDelPedido = str_pad($numeropedido, (8 - strlen($numeropedido)), "0", STR_PAD_LEFT);
                $fecha = $colorden['orderDate'];
                $correobj = new correos();
                $asunto = "Confirmación de Pedido";
                //$rec = "Su orden con folio ".$colorden['orderID']." realizada el ".$colorden['orderDate']." ha sido registrada, espere a que su solicitud sea atendida. <br> GRACIAS POR SU PREFERENCIA";
                $contenido = $correobj->pedido($asunto, $folioDelPedido, $fecha, $listapedidos, $totalapagar);
                $correo->MsgHTML($contenido);
                $correo->send();
            }


            foreach ($_SESSION['carrito'] as $key1 => $value1) {
                $idproducto = $_SESSION['carrito'][$key1]['id'];
                $unidades = $_SESSION['carrito'][$key1]['cantidad'];
                $precio = $_SESSION['carrito'][$key1]['precio'];
                $selectexistencia = "select existencia from products where productID = ".$idproducto." ";
                $exeex = $bd->query($selectexistencia);
                $existencia = $bd->fassoc($exeex);
                $existenciaprod = $existencia['existencia'];
                $existenciaactual = $existenciaprod - $unidades;
                $querydetalles = "insert into orderdetails values('', ".$idinsert.", ".$idproducto.", ".$unidades.", ".$precio.", '')";
                if($bd->query($querydetalles)){
                    $upddatequery = "update products set existencia = ".$existenciaactual." where productID = ".$idproducto." ";
                    $bd->query($upddatequery);
                    $contador++;
                }
                else{
                    echo "error2";
                    exit();
                }
            }
            unset($_SESSION['carrito']);
        }
        else{
            echo "error1";
            exit();
        }
        if($contador == $totalProductos)
            echo "ok";

    }
}


 ?>
