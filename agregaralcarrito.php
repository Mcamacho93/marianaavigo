<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(isset($_SESSION['adminID'])){
    echo "Solo clientes pueden agregar al carrito";
    exit;
}
if(!isset($_SESSION['clientCode'])){
    echo "Debe iniciar sesión para agregar artículos al carrito";
    exit();
}
if(!isset($_POST['Nombre']) || !isset($_POST['Marca'])){
    echo "Error 404";
    exit();
}
else{
    include 'conexion.php';
    $bd = new MYSQLIFunctions();
    $nombre = $bd->escapestr($_POST['Nombre']);
    $marca = $bd->escapestr($_POST['Marca']);
    //$presentacion = $bd->escapestr($_POST['Presentacion']);
    $prescant = $_POST['Info'];

    //echo $id;

    foreach($prescant as $index => $valor){
        $idpresentacion = "select presentID from presentation where presentName = '".$index."'";
        $res = $bd->query($idpresentacion);
        $colid = $bd->fassoc($res);
        $id = $colid['presentID'];
        $qidmarca = "select * from brand where brandName = '".$marca."'";
        $resmarca = $bd->query($qidmarca);
        $colmarca = $bd->fassoc($resmarca);
        $idmarca = $colmarca['brandID'];
        $verificapres = "select * from products where presentID = ".$id."";
        $presentaciones = $bd->query($verificapres);
        if($bd->rows($presentaciones) <= 0){
            echo "Presentación Erronea";
            exit();
        }
        else{
            $queryproducto = "select p.*, b.brandName, pr.presentName from products p, brand b, presentation pr  where p.productName = '".$nombre."' and p.presentID = ".$id." and p.brandID = ".$idmarca." and p.brandID = b.brandID and p.presentID = pr.presentID ";
            $prods = $bd->query($queryproducto);
            $auxarray = array();
            $direccionfact = "select addressID from address where clientCode = ".$_SESSION['clientCode']." and idType = 1 limit 1";
            $dirf = $bd->query($direccionfact);
            $coldf = $bd->fassoc($dirf);
            $_SESSION['dirfacturacion'] = $coldf['addressID'];
            if(!isset($_SESSION['carrito']))
                $_SESSION['carrito'] = array();
            $i = 0;
            //$error = 'n';
            while($colprod = $bd->fassoc($prods)){
                // foreach ($_SESSION['carrito'] as $key => $value) {
                // 	if($colprod['productID'] == $_SESSION['carrito'][$key]['id']){
                // 	echo "El artículo ya se encuentra agregado al carrito";
                // 	exit();
                // }
                // }
                if($valor > $colprod['existencia']){
                    $valor = $colprod['existencia'];
              //      $error = 'y';
                }

                if($valor == 0)continue;
                    //$valor = 1;
                $_SESSION['carrito'][$colprod['productID']]['id'] = $colprod['productID'];
                $_SESSION['carrito'][$colprod['productID']]['nombre'] = $colprod['productName'];
                $_SESSION['carrito'][$colprod['productID']]['presentacion'] = $colprod['presentName'];
                $_SESSION['carrito'][$colprod['productID']]['marca'] = $colprod['brandName'];
                $_SESSION['carrito'][$colprod['productID']]['precio'] = $colprod['price'];
                $_SESSION['carrito'][$colprod['productID']]['img'] = $colprod['img'];
                $_SESSION['carrito'][$colprod['productID']]['cantidad'] = $valor;
                $_SESSION['carrito'][$colprod['productID']]['total'] = $colprod['price'] * $_SESSION['carrito'][$colprod['productID']]['cantidad'];
                //  $_SESSION['carrito']['error'] = $error;


            }

            //echo json_encode($_SESSION['carrito']);
        }
    }
    echo "ok&@&";
    echo json_encode($_SESSION['carrito']);

}

 ?>
