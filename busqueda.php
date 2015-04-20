<?php
session_start();
if(!isset($_POST['tipo'])){
    header("Location: tienda.php");
    exit();
}
else{
    include 'conexion.php';
    $bd = new MYSQLIFunctions();
    if($_POST['tipo'] == 1){
        $idm = $bd->escapestr($_POST['idmarca']);
        $querymarca = "select p.*, b.brandName, c.categoryName, pr.presentName from products p, brand b, category c, presentation pr where p.brandID = ".$idm." and p.brandID = b.brandID and p.categoryID = c.categoryID and p.presentID = pr.presentID";
        $productos = $bd->query($querymarca);
        if($bd->rows($productos) <= 0){
            echo "error";
            exit();
        }
        else{
            $productomarca = array();
            $i = 0;
            while($producto = $bd->fassoc($productos)){
                $productomarca[] = $producto;
                if($i == 0)
                    echo $producto['brandName']."$%&";
                $i++;
            }
            $_SESSION['registros'] = count($productomarca);
            echo json_encode($productomarca);
        }
    }
    if($_POST['tipo'] == 2){
        $idc = $bd->escapestr($_POST['idcategoria']);
        $querymarca = "select p.*, b.brandName, c.categoryName, pr.presentName from products p, brand b, category c, presentation pr where p.categoryID = ".$idc." and p.brandID = b.brandID and p.categoryID = c.categoryID and p.presentID = pr.presentID";
        $productos = $bd->query($querymarca);
        if($bd->rows($productos) <= 0){
            echo "error";
            exit();
        }
        else{
            $productomarca = array();
            $i = 0;
            while($producto = $bd->fassoc($productos)){
                $productomarca[] = $producto;
                if($i == 0)
                    echo $producto['categoryName']."$%&";
                $i++;
            }
            $_SESSION['registros'] = count($productomarca);
            echo json_encode($productomarca);
        }
    }
    if($_POST['tipo'] == 3){
        $idp = $bd->escapestr($_POST['idpresentacion']);
        $querymarca = "select p.*, b.brandName, c.categoryName, pr.presentName from products p, brand b, category c, presentation pr where p.presentID = ".$idp." and p.brandID = b.brandID and p.categoryID = c.categoryID and p.presentID = pr.presentID";
        $productos = $bd->query($querymarca);
        if($bd->rows($productos) <= 0){
            echo "error";
            exit();
        }
        else{
            $productomarca = array();
            $i = 0;
            while($producto = $bd->fassoc($productos)){
                $productomarca[] = $producto;
                if($i == 0)
                    echo $producto['presentName']."$%&";
                $i++;
            }
            $_SESSION['registros'] = count($productomarca);
            echo json_encode($productomarca);
        }
    }
    if($_POST['tipo'] == 4){
        $busqueda = $bd->escapestr($_POST['busqueda']);
        $querymarca = "select p.*, b.brandName, c.categoryName, pr.presentName from products p, brand b, category c, presentation pr where p.productName like '".$busqueda."%' and p.brandID = b.brandID and p.categoryID = c.categoryID and p.presentID = pr.presentID";
        $productos = $bd->query($querymarca);
        if($bd->rows($productos) <= 0){
            echo "error";
            exit();
        }
        else{
            $productomarca = array();
            $i = 0;
            while($producto = $bd->fassoc($productos)){
                $productomarca[] = $producto;
                if($i == 0)
                    echo $busqueda  ."$%&";
                $i++;
            }
            $_SESSION['registros'] = count($productomarca);
            echo json_encode($productomarca);
        }
    }

    if($_POST['tipo'] == 5){
        $querymarca = "select p.*, b.brandName, c.categoryName, pr.presentName from products p, brand b, category c, presentation pr where p.brandID = b.brandID and p.categoryID = c.categoryID and p.presentID = pr.presentID order by productName ASC limit 0,16";
        $productos = $bd->query($querymarca);
        if($bd->rows($productos) <= 0){
            echo "error";
            exit();
        }
        else{
            $productomarca = array();
            $i = 0;
            while($producto = $bd->fassoc($productos)){
                $productomarca[] = $producto;
                if($i == 0)
                    echo $busqueda  ."$%&";
                $i++;
            }
            $_SESSION['registros'] = count($productomarca);
            echo json_encode($productomarca);
        }
    }
}


 ?>
