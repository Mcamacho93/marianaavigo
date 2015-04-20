<?php
session_start();
if(!isset($_SESSION['clientCode']) && !isset($_SESSION['email']))
	header("Location: ../");
include '../conexion.php';
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
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

	<script src="../js/jquery-1.11.1.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	<script type="text/javascript" src="js/productos.js"></script>



	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="../images/favicon.ico">
	
</head>
<body>
	
<?php include("menu.php");?>

<section id="usuario">
<div class="container">

	<div class="seven columns offset-by-one">
		<h3>Bienvenido</h3>
		<h2><?php echo $_SESSION['name']; ?></h2>
				
	</div>
	<div class="seven columns offset-by-one">
		<a href="../tienda.php" class="button">Ir a la tienda</a>
		
	</div>
	
</div>

<div class="container">
	<hr>
	<div class="seven columns">
		<form id="agregarProd" onsubmit="agregarProducto(event, this.nombre.value, this.descripcion.value, this.precio.value, this.presentacion.value,
		 this.categoria.value, this.marca.value, this.img.value)">
			<label>
		    	<input id="nombre" name="nombre" type="text" required="" placeholder="Nombre" title="Nombre" />
		   	</label>
		   	<label>
		    	<textarea maxlength="500" id="descripcion" name="descripcion" required="" placeholder="Descripci&oacute;n" title="descripci&oacute;n"></textarea>
		   	</label>
		   	<label>
		    	<input id="precio" name="precio" type="text" required="" placeholder="Precio" title="Precio" onkeypress="validadecimal(event)" />
		   	</label>
		   	<a href="#modalPres"><label>Agregar Presentaci&oacute;n</label></a>
		   	<select id="presentacion" name="presentacion">
		   		<?php
		   		$bd = new MYSQLIFunctions(); 
		   		$querypresent = "select * from presentation order by presentName ASC";
		   		$presentaciones  = $bd->query($querypresent);
		   		if($bd->rows($presentaciones)<=0){
		   			?>
					<option value="0">No hay presentaciones</option>
		   			<?php
		   		}
		   		else{
		   			while($colpresentaciones = $bd->fassoc($presentaciones)){
		   				?>
						<option value="<?php echo $colpresentaciones['presentID'] ?>"><?php echo $colpresentaciones['presentName'] ?></option>
		   				<?php
		   			}
		   		}	
		   		
		   		 ?>
		   	</select>

		   <a href="#modalCategoria"><label>Agregar Categor&iacute;a</label></a>
		   	<select id="categoria" name="categoria">
		   		<?php
		   		$querycategoria = "select * from category order by categoryName ASC";
		   		$categorias  = $bd->query($querycategoria);
		   		if($bd->rows($categorias)<=0){
		   			?>
					<option value="0">No hay categor&iacute;as</option>
		   			<?php
		   		}
		   		else{
		   			while($colcategorias = $bd->fassoc($categorias)){
		   				?>
						<option value="<?php echo $colcategorias['categoryID'] ?>"><?php echo $colcategorias['categoryName'] ?></option>
		   				<?php
		   			}
		   		}			   		
		   		 ?>
		   	</select>

		   	<a href="#modalMarca"><label>Agregar Marca</label></a>
		   	<select id="marca" name="marca">
		   		<?php 
		   		$querymarca = "select * from brand order by brandName ASC";
		   		$marcas  = $bd->query($querymarca);
		   		if($bd->rows($marcas)<=0){
		   			?>
					<option value="0">No hay marcas</option>
		   			<?php
		   		}
		   		else{
		   			while($colmarca = $bd->fassoc($marcas)){
		   				?>
						<option value="<?php echo $colmarca['brandID'] ?>"><?php echo $colmarca['brandName'] ?></option>
		   				<?php
		   			}
		   		}	
		   		
		   		 ?>
		   	</select>
		   	<label>
		    	<input id="existencia" name="existencia" type="number" required="" placeholder="Existencia" title="Existencia" onkeypress="validaentero(event)" />
		   	</label><br>
		   	<label>
		   		<input type="file" accept="image/*" id="img" name="img" onchange="validaImg()"><br><br> <!-- ja -->
		   	</label>
		   	<label id="imgdisplay" >Vista Previa</label>
		   	<label id="estadoProducto" style="display:none"></label>
		   	<input type="submit" id="nuevoprod" value="Agregar">
		   	
		</form>
	</div>
	
</div>

</section>

<div class="container">
	<div id="modalPres" class="modalDialog">
		<div>
			<a href="#close" title="Close" class="close">x</a>	
			<form id="formPresentacion" onsubmit="agregarPresentacion(event, this.presentNueva.value);">
			<label>Nueva Presentaci&oacute;n</label>
	    	<label>
	       		 <input id="presentNueva" type="text" required="" placeholder="Descripci&oacute;n" title="Descripci&oacute;n de la presentaci&oacute;n"/>
	   		</label>
	   		<label id="estadoPres" style="display:none"></label>
	    	<button type="submit" id="nuevaPres" >Agregar</button>
	    	</form>
		</div>
	</div>
</div>

<div class="container">
	<div id="modalCategoria" class="modalDialog">
		<div>
			<a href="#close" title="Close" class="close">x</a>	
			<form id="formCategoria" onsubmit="agregarCategoria(event, this.catNueva.value);">
			<label>Nueva Categor&iacute;a</label>
	    	<label>
	       		 <input id="catNueva" type="text" required="" placeholder="Descripci&oacute;n" title="Descripci&oacute;n de la categor&iacute;a"/>
	   		</label>
	   		<label id="estadoCat" style="display:none"></label>
	    	<button type="submit" id="nuevaCategoria" >Agregar</button>
	    	</form>
		</div>
	</div>
</div>

<div class="container">
	<div id="modalMarca" class="modalDialog">
		<div>
			<a href="#close" title="Close" class="close">x</a>	
			<form id="formMarca" onsubmit="agregarMarca(event, this.marcaNueva.value);">
			<label>Nueva Marca</label>
	    	<label>
	       		 <input id="marcaNueva" type="text" required="" placeholder="Descripci&oacute;n" title="Nombre de la marca"/>
	   		</label>
	   		<label id="estadoMarca" style="display:none"></label>
	    	<button type="submit" id="nuevaMarca" >Agregar</button>
	    	</form>
		</div>
	</div>
</div>

<?php include("../footer.php");?>



    
 

</body>
</html>