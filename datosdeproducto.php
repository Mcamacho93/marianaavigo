<?php 
if(!isset($_POST['IDP'])){
	echo "Error 404";
	exit();
}
else{
	include 'conexion.php';
	$bd = new MYSQLIFunctions();
	$id = $bd->escapestr($_POST['IDP']);
	$query = "select * from products where productID = ".$id."";
	$res = $bd->query($query);
	if($bd->rows($res) <= 0){
		echo "error 404";
		exit();
	}
	else{
		while($col = $bd->fassoc($res)){
			$nombreprod = $col['productName'];
			$precio = $col['price'];
			$marca = $col['brandID'];
			$categoria = $col['categoryID'];
		}
		$query2 = "select p.*, pr.presentName, b.brandName from products p, presentation pr, brand b  where p.productName = '".$nombreprod."' and p.brandID = ".$marca." and p.categoryID = ".$categoria." and p.brandID = b.brandID and p.presentID = pr.presentID order by presentName ASC";
		$productos = $bd->query($query2);
		if($bd->rows($productos) <= 0){
			echo "error 404";
			exit();
		}
		else{
			$productosarray = array();
			$i=0;
			while($colprod = $bd->fassoc($productos)){
				$productosarray['img'] = $colprod['img'];
				$productosarray['productName'] = $colprod['productName'];
				$productosarray['brandName'] = $colprod['brandName'];
				$productosarray['productDesc'] = $colprod['productDesc'];
				//$productosarray['presentName'][$i] = $colprod['presentName'];
				//$productosarray['presentName']['price'][$i] = $colprod['price'];
				$productosarray['presentName'][$colprod['presentName']] = $colprod['price'];
				$i++;
			}
			echo json_encode($productosarray);
		}

	}
}

 ?>

