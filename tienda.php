<?php
session_start();
if(isset($_SESSION['adminID'])){
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    <title>Mariana Avigo Models</title>
    <meta name="description" content="Sitio web dedicado a la venta y suministro de artículos para la cocina gourmet">
    <meta name="author" content="Casa Laietana">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="stylesheets/base.css">
    <link rel="stylesheet" href="stylesheets/skeleton1200.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/slick.css"/><!-- Carrusel de imagenes -->
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>


    <script src="js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="js/slick.min.js"></script><!-- Carrusel de imagenes -->
    <script type="text/javascript" src="js/ajaxfunctions.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>

<?php include("menu.php");?>

<section id = "tienda">
<div class="cover3">
    <div class="container">
        <div class="sixteen columns">
            <h1>Catálogo</h1>
        </div>
    </div>
</div>





<div class="container">
    <div id="metrica">

            <form onsubmit="buscar(event, this.buscarProd.value)" id="nomarg">
                <input type="text" id="buscarProd" placeholder="Buscar">
                <button id="search" type="submit"><img src="images/amplif.png"></button>
            </form>
            <nav>
                <ul>
                <li>
                    <label class="catego">MARCA</label>
                </li>
                <li>
                    <?php
                    include('conexion.php');
                    $bd = new MYSQLIFunctions();
                    $qmarcas = "select * from brand order by brandName ASC";
                    $marcas = $bd->query($qmarcas);
                    while($colmarcas = $bd->fassoc($marcas)){
                        ?>
                        <label class="tiendaizquierda" id="m<?php echo $colmarcas['brandID'] ?>" onclick = "buscarporMarca(this.id)"><?php echo 							$colmarcas['brandName'] ?></label>
                        <?php
                        }
                     ?>
                </li>
                <li>
                     <label class="catego">PRODUCTO</label>
                </li>
                <li>
                     <?php
                     	$qcategoria = "select * from category order by categoryName ASC";
                        $categorias = $bd->query($qcategoria);
                        while($colcategorias = $bd->fassoc($categorias)){
                        ?>
                            <label class="tiendaizquierda" id="c<?php echo $colcategorias['categoryID'] ?>" onclick="buscarporCategoria(this.id)"><?php echo 					$colcategorias['categoryName'] ?></label>
                        <?php
                        }
                     ?>
                </li>
                <li>
                     <label class="catego">PRESENTACI&Oacute;N</label>
                </li>
                <li>
                     <?php
                     	$qpresentacion = "select * from presentation order by presentName ASC";
                        $presentaciones = $bd->query($qpresentacion);
                        while($colpresentaciones = $bd->fassoc($presentaciones)){
                        ?>
                            <label class="tiendaizquierda" id="p<?php echo $colpresentaciones['presentID'] ?>" onclick="buscarporPresentacion(this.id)"><?php echo $colpresentaciones['presentName'] ?></label>
                        <?php
                        }
                        ?>
                </li>
            </ul>
            </nav>
    </div>
    <div id="filters">
 Filtrar: <br>
            <select>
                <option>Marca</option>
                <option>Categoría</option>
                <option>Presentación</option>
            </select>
            <form onsubmit="buscar(event, this.buscarProd.value)" id="nomarg">
                <input type="text" id="buscarProd" placeholder="Buscar">
                <button id="search" type="submit"><img src="images/amplif.png"></button>
            </form>
    </div>
<!-- 	<?php
    if(isset($_SESSION['clientCode'])){
        if (isset($_SESSION['carrito'])){
    ?>
    <div class="thirteen columns">
        <div class="menucheck">
            <ul>
            <li><h1>TU PEDIDO:</h1></li>

            <li class="itemsmenu">ITEMS (<?php echo count($_SESSION['carrito']) ?>)</li>
            <li class="lismenucheck"><a href="cliente/carrito.php">CARRITO</a>
                <ul class="submenucheck">
                    <?php
                    foreach($_SESSION['carrito'] as $key => $val){
                        foreach($val as $skey => $sval){
                            //echo $skey."->".$sval;
                            $nombre = "";
                            $precio = "";
                            if($skey == "nombre"){
                                $nombre = $val["nombre"];
                                echo "<li>".$nombre;
                            }

                            if($skey == "precio"){
                                $precio = $val['precio'];
                                echo "<label class='numer'>$&nbsp;".$precio."</label></li><hr>";

                            }

                        }
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
    <?php
        }
        else{
        ?>
        <div class="thirteen columns">
            <div class="carritodecompras">
            <ul>
                <li><h1>TU PEDIDO: &nbsp;</h1></li>
                <li class="itemsmenu">ITEMS: (0)</li>
                <li class="checkout"><a href="cliente/carrito.php">CARRITO</a></li>
            </ul>
        </div>
        <?php
        }
    }

        ?> -->
    <div id="catalogodeproductos">
        <div id="productoscasal">
            <?php
            $qproductos = "select p.productID, p.img, p.price, p.productName, b.brandName, c.categoryName, pr.presentName from products p, brand b, category c, presentation pr
                where p.brandID = b.brandID and p.categoryID = c.categoryID and p.presentID = pr.presentID order by productName ASC limit 0,16";
            $productos = $bd->query($qproductos);
            //$arraycont = array();
            while($colproductos = $bd->fassoc($productos)){
                if(isset($nombredelprod)){
                    if($nombredelprod == $colproductos['productName'] && $marcadelprod == $colproductos['brandName']) continue;
                }
                //$arraycont[] = $colproductos['productName'];
            ?>

            <div class="proditem">

                <div class="photo">
                <?php
                if(!isset($_SESSION['clientCode'])){
                ?>
                <a href="#openModal" id="<?php echo $colproductos['productID'] ?>"><img src="<?php echo $colproductos['img'] ?>" class="prodimg" >
                    <div class="overlay">
                        <span id="plus">+</span>
                     </div>
                </a></div>
                <?php
                }
                else if(isset($_SESSION['clientCode'])){
                ?>
                <a href="#productoCL" id="<?php echo $colproductos['productID'] ?>" onclick="datosDeProducto(this.id)"><img src="<?php echo $colproductos['img'] ?>" class="prodimg" >
                    <div class="overlay">
                        <span id="plus">+</span>
                     </div>
                </a></div>
                <?php
                }
                ?>
                <label class="precios">$ <?php echo number_format($colproductos['price'], 2, '.', ','   ) ?></label>
                <label class="nombreP1"><?php echo $colproductos['productName'] ?></label>
                <label class="nombreP"><?php echo $colproductos['brandName'] ?></label>
             </div>


            <?php
            $nombredelprod = $colproductos['productName'];
            $marcadelprod = $colproductos['brandName'];
        }
        ?>

        </div>
    </div>

</div>
<br>

</section>
<?php
//$regtotales = count($arraycont);
$querytotalp = "select * from products";
$totalp = $bd->query($querytotalp);
$cont = $bd->rows($totalp);
$rpp = 16;
$total= ceil($cont/$rpp);
if ($cont > 1){ ?>
<div class="container">
    <div class="twelve columns offset-by-three">
        <div id="paginas">

            <ul class="pags">PÁGINA:
            <?php
            for($i = 1; $i <= $total; $i++){
                ?>
                <a href="<?php echo $i ?>" ><li id="<?php echo $i ?>" onclick="infoDeProductos(event, this.id)">
                    <?php echo $i; ?>
                </li></a>
                <?php
            }
             ?>
            </ul>
        </div>
    </div>
</div>
<?php } ?>


<div class="container">
    <div id="productoCL" class="modalDialogP">
        <div class="modalancho">
            <a href="#close" title="Close" class="close">x</a>
            <form id="productodesc">
        		<div class="cincuenta">
        			<div class="photo2">
        			<img id="imgprod" src="">
        			</div>
        		</div>
        		<div class="cincuenta">
        			<h1 id="nombrep"></h1>
        			<label id="marcaprod"></label>
        			<label class="txt">Descripci&oacute;n</label>
        			<label id="descripcion"></label>
        			<label class="txt">Presentaciones</label>
        			<ul>
        			<li id="presentacionesprod">

        			</li></ul>
        			<div id="presentacionescombo">
        				<!--<select id="listadepresentaciones"></select>-->
        				<label id="edoagregar"></label>
        				<label>

        				</label>
        				<?php if (!isset($_SESSION['clientCode'])){ ?>
        					<button id="agregaralcarro">Inicie Sesión para agregar al carrito</button>
                        <?php }
                                else{
                        ?>
                            <button id="agregaralcarro">Agregar al carrito</button>
                        <?php } ?>
        			</div>
        			<a href="cliente/carrito.php"><label class="miscompras">MIS COMPRAS</label></a>
        		</div>
        	</form>
        </div>
    </div>
</div>




<?php include("footer.php");?>





</body>
</html>
