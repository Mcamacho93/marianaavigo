<?php
include '../conexion.php';
$bd = new MYSQLIFunctions();
$porpagina = 16;
$pagactual = $_POST['Actual'];
$actual = $porpagina * $pagactual;
$pactual = $actual/2;
if($pactual == 8)
	$pactual = 1;
$qproductos = "select distinct p.productID, p.img, p.price, p.productName, b.brandName, c.categoryName, pr.presentName from products p, brand b, category c, presentation pr where p.brandID = b.brandID and p.categoryID = c.categoryID and p.presentID = pr.presentID order by productName ASC limit ".$pactual.", ".$porpagina."";
//$ptotales = $bd->query($querytotalp);
//$totalreg = array();
$productos = $bd->query($qproductos);
$jsonproductos = array();
$i = 0;
while($colproductos = $bd->fassoc($productos)){

	$jsonproductos[$i]['id'] = $colproductos['productID'];
	$jsonproductos[$i]['img'] = $colproductos['img'];
	$jsonproductos[$i]['productName'] = $colproductos['productName'];
	$jsonproductos[$i]['price'] = $colproductos['price'];
	$jsonproductos[$i]['brandName'] = $colproductos['brandName'];
	$jsonproductos[$i]['categoryName'] = $colproductos['categoryName'];
	$jsonproductos[$i]['presentName'] = $colproductos['presentName'];
	$nombredelprod = $colproductos['productName'];
	$marcadelprod = $colproductos['brandName'];
	$i++;
}
echo json_encode($jsonproductos);




 ?>
