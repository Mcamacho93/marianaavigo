<?php
session_start();
if(!isset($_SESSION['adminID'])){
    header("Location: index.php");
    exit;
}
if(!isset($_POST['Tipo'])){
    header("Location: index.php");
    exit;
}
else{
    include '../conexion.php';
    $bd = new MYSQLIFunctions();
    if($_POST['Tipo'] == "1"){
        $cadena = $bd->escapestr($_POST['Cadena']);
        if($cadena == "")
            $queryproductos = "select distinct p.*, pr.presentName, c.categoryName, b.brandName from products p, presentation pr, category c, brand b where p.presentID = pr.presentID and c.categoryID = p.categoryID and b.brandID = p.brandID order by productName ASC";
        else
            $queryproductos = "select distinct p.*, pr.presentName, c.categoryName, b.brandName from products p, presentation pr, category c, brand b where p.presentID = pr.presentID and c.categoryID = p.categoryID and b.brandID = p.brandID and productName like '%".$cadena."%' order by productName ASC";

        $productos = $bd->query($queryproductos);
        if($bd->rows($productos) <= 0){
            echo "NO";
            exit;
        }
        else{
            $jsonproductos = array();
            $i = 0;
            echo "OK#&@";
            while($col = $bd->fassoc($productos)){
                $jsonproductos[$col['productID']]['id'] = $col['productID'];
                $jsonproductos[$col['productID']]['productName'] = $col['productName'];
                $jsonproductos[$col['productID']]['productDesc'] = $col['productDesc'];
                $jsonproductos[$col['productID']]['price'] = $col['price'];
                $jsonproductos[$col['productID']]['presentID'] = $col['presentID'];
                $jsonproductos[$col['productID']]['categoryID'] = $col['categoryID'];
                $jsonproductos[$col['productID']]['brandID'] = $col['brandID'];
                $jsonproductos[$col['productID']]['existencia'] = $col['existencia'];
                $jsonproductos[$col['productID']]['img'] = $col['img'];
                $jsonproductos[$col['productID']]['presentName'] = $col['presentName'];
                $jsonproductos[$col['productID']]['categoryName'] = $col['categoryName'];
                $jsonproductos[$col['productID']]['brandName'] = $col['brandName'];
                $i++;
            }
            //echo count($jsonproductos);
            echo json_encode($jsonproductos);
        }
    }

    if($_POST['Tipo'] == "2"){
        $idproduct = $bd->escapestr($_POST['ID']);
        $queryproductos = "select distinct p.*, pr.presentName, c.categoryName, b.brandName from products p, presentation pr, category c, brand b where p.presentID = pr.presentID and c.categoryID = p.categoryID and b.brandID = p.brandID and productID = ".$idproduct." order by productName ASC";
        $productos = $bd->query($queryproductos);
        if($bd->rows($productos) <= 0){
            echo "NO";
            exit;
        }
        else{
            $jsonproductos = array();
            $i = 0;
            echo "OK#&@";
            while($col = $bd->fassoc($productos)){
                $jsonproductos[$col['productID']]['id'] = $col['productID'];
                $jsonproductos[$col['productID']]['productName'] = $col['productName'];
                $jsonproductos[$col['productID']]['productDesc'] = $col['productDesc'];
                $jsonproductos[$col['productID']]['price'] = $col['price'];
                $jsonproductos[$col['productID']]['presentID'] = $col['presentID'];
                $jsonproductos[$col['productID']]['categoryID'] = $col['categoryID'];
                $jsonproductos[$col['productID']]['brandID'] = $col['brandID'];
                $jsonproductos[$col['productID']]['existencia'] = $col['existencia'];
                $jsonproductos[$col['productID']]['img'] = $col['img'];
                $jsonproductos[$col['productID']]['presentName'] = $col['presentName'];
                $jsonproductos[$col['productID']]['categoryName'] = $col['categoryName'];
                $jsonproductos[$col['productID']]['brandName'] = $col['brandName'];
                $i++;
            }
            //echo count($jsonproductos);
            echo json_encode($jsonproductos);
        }

    }
}


?>
