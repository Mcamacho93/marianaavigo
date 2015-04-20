<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
if(!isset($_SESSION['clientCode'])){
	header("Location: ../");
	exit();
}
else{
	if(!isset($_POST)){
		echo "Error 404";
		exit();
	}
	else{
		include '../conexion.php';
		$bd = new MYSQLIFunctions();
		if(isset($_POST['tipo'])){
			if ($_POST['tipo'] == 1){
				$nombrePresentacion = $bd->escapestr($_POST['Nombre']);
				$queryPres = "insert into presentation values('', '".$nombrePresentacion."')";
				$validaPresentacion = "select * from presentation where presentName = '".$nombrePresentacion."'";
				$vp = $bd->query($validaPresentacion);
				if($bd->rows($vp)>0)
					echo "errorp";
				else{
					if($bd->query($queryPres)){
						$arraypres = array();
						$queryPresent = "select * from presentation order by presentName ASC";
						$presentaciones = $bd->query($queryPresent);
						while($resPresentaciones = $bd->fassoc($presentaciones)){
							$arraypres[] = $resPresentaciones;
						}
						echo json_encode($arraypres);
					}
				}
			}
			else if($_POST['tipo'] == 2){
				$nombreCategoria = $bd->escapestr($_POST['Nombre']);
				$queryCategoria = "insert into category values('', '".$nombreCategoria."')";
				$validaCategoria = "select * from category where categoryName = '".$nombreCategoria."'";
				$vc = $bd->query($validaCategoria);
				if($bd->rows($vc)>0)
					echo "errorc";
				else{
					if($bd->query($queryCategoria)){
						$arrayCat = array();
						$queryCat = "select * from category order by categoryName ASC";
						$categorias = $bd->query($queryCat);
						while($resCategorias = $bd->fassoc($categorias)){
							$arrayCat[] = $resCategorias;
						} 
						echo json_encode($arrayCat);
					}
				}
			}
			else if($_POST['tipo'] == 3){
				$nombreMarca = $bd->escapestr($_POST['Nombre']);
				$queryMarca = "insert into brand values('', '".$nombreMarca."')";
				$validaMarca = "select * from brand where brandName = '".$nombreMarca."'";
				$vm = $bd->query($validaMarca);
				if($bd->rows($vm)>0)
					echo "errorm";
				else{
					if($bd->query($queryMarca)){
						$arrayMarca = array();
						$queryMarca = "select * from brand order by brandName ASC";
						$marcas = $bd->query($queryMarca);
						while($resMarca = $bd->fassoc($marcas)){
							$arrayMarca[] = $resMarca;
						} 
						echo json_encode($arrayMarca);
					}
				}
			}
		}
		else{
			$nombreProducto = $bd->escapestr($_POST['nombre']);
			$descripcion = $_POST['descripcion'];
			$precio = $_POST['precio'];
			$presentacion =$_POST['presentacion'];
			$categoria = $_POST['categoria'];
			$marca = $_POST['marca'];
			$existencia = $_POST['existencia'];
			$imgdir = "images/product/";
			$queryProducto = "insert into products values('', '".$nombreProducto."', '".$descripcion."', ".$precio.", ".$presentacion.", ".$categoria.", 
				".$marca.", ".$existencia.", '".$imgdir."')";
			$queryprodexiste = "select * from products where productName = '".$nombreProducto."' and price = ".$precio." and presentID = ".$presentacion."
			and categoryID = ".$categoria." and brandID = ".$marca."";
			$prodexiste = $bd->query($queryprodexiste);
			if($bd->rows($prodexiste) > 0){
				echo "El producto ya se encuentra registrado";
			}
			else{
				if($bd->query($queryProducto)){
					//$idinsert = $bd->lastid($queryProducto);
					$idinsert = $bd->lastid();
					$dir = "../images/product/";
					$imagename = $dir.$idinsert.".jpg";
					$imgsql = $imgdir.$idinsert.".jpg";
					if(exif_imagetype($_FILES['img']['tmp_name']) != IMAGETYPE_JPEG && exif_imagetype($_FILES['img']['tmp_name']) != IMAGETYPE_PNG){
						echo "Solo se admiten formatos .jpg y .png";
					}
					else{
						if(move_uploaded_file($_FILES['img']['tmp_name'], $imagename)){
							$update = "update products set img = '".$imgsql."' where productID = ".$idinsert."";
							if($bd->query($update))
								echo "Producto Agregado";
						}
						else
							echo "Producto Agregado, pero fallo la subida de la imagen";
					}
					
				}
			}
		}

	}
}


 ?>