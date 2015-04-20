<?php
session_start();
if(!isset($_SESSION['carrito']) && !isset($_SESSION['clientCode'])){
    header("Location: ../");
    exit();
}
if(!isset($_POST['tipo'])){
    echo "Error 404";
    exit();
}
else{
    if($_POST['tipo'] == 1){
        $cantidad = $_POST['Cantidad'];
        $id = $_POST['Id'];
        if($cantidad == 0)
            exit;
        include '../conexion.php';
        $bd = new MYSQLIFunctions();
        $comprobarexistencia = "select existencia from products where productID = ".$id." ";
        $exeex = $bd->query($comprobarexistencia);
        $existencia = $bd->fassoc($exeex);
        if($cantidad > $existencia['existencia']){
            echo "excede%&=";
            echo $existencia['existencia']."%&=";
            echo $id."%&=";
            exit;
        }
        $total = 0;
        foreach ($_SESSION['carrito'] as $key => $value) {
            if($_SESSION['carrito'][$key]['id'] == $id){
                $_SESSION['carrito'][$key]['cantidad'] = $cantidad;
                $_SESSION['carrito'][$key]['total'] = $_SESSION['carrito'][$key]['cantidad'] * $_SESSION['carrito'][$key]['precio'];
            }
            $total += $_SESSION['carrito'][$key]['total'];
            if(!isset($estadoorden)){
                $estadoorden = "ok%&=";
                echo $estadoorden;
            }

        }
        echo number_format($total, 2, '.', ',');
    }
    else if($_POST['tipo'] == 2){
        $id= $_POST['IDP'];
        foreach ($_SESSION['carrito'] as $key => $value) {
            if($_SESSION['carrito'][$key]['id'] == $id){
                unset($_SESSION['carrito'][$key]);
            }
            //$total += $_SESSION['carrito'][$key]['total'];
        }
        echo "eliminado";

    }
}


 ?>
