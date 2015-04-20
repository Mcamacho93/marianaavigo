<?php
session_start();
if(!isset($_SESSION['adminID']) && !isset($_SESSION['email'])){
    header("Location: ../");
    exit;
}
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
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>

    <script src="../js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="js/admin.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="../images/favicon.ico">

</head>
<body>
<?php include("menu.php");?>

<section id="usuario">
<div class="container">
  <div class="sixteen columns" id="locali">
        <ul>
            <li><a href="javascript:history.back()">Inicio</a></li>
            <li><a href="index.php">Panel de Administrador</a></li>
            <li><a href="">Listado de Productos</a></li>
        </ul>
    </div>
<br><br><br><!-- AQUÍ HAY UNOS CUANTOS BR -->


    <div class="seven columns offset-by-one">
        <h2>PRODUCTOS</h2>
    </div>
    <div class="three columns offset-by-twelve">
      <form id="nomarg">
            <input type="text" id="buscarProd" placeholder="Buscar" onkeyup="buscarProducto(this.value)">
            <button id="search" type="submit"><img src="../images/amplif.png"></button>
        </form>
    </div>
    <br><br><br><!-- AHÍ HAY TRES BR's -->
        <div class="fourteen columns offset-by-one alpha" id="listaDeProductos">
        <hr>


    <?php
        $bd = new MYSQLIFunctions();
        $queryproductos = "select distinct p.*, pr.presentName, c.categoryName, b.brandName from products p, presentation pr, category c, brand b where p.presentID = pr.presentID and c.categoryID = p.categoryID and b.brandID = p.brandID order by productName ASC";
        $queryprodsexe = $bd->query($queryproductos);
        if($bd->rows($queryprodsexe) <= 0){
            ?>
            <h3>SIN PRODUCTOS</h3>
            <?php
        }
        else{
            while($colprods = $bd->fassoc($queryprodsexe)){
                ?>
                   <div class="ten columns omega">
                        
                        <ul class="listadeproductostabla">
                            <img src="../<?php echo $colprods['img'] ?>">
                            <li class="aguacate"><?php echo $colprods['productName'] ?></li><br>
                            <li class="descripciondelproductodelalista"><?php echo $colprods['categoryName'] ?></li>
                            <li class="descripciondelproductodelalista"><?php echo $colprods['brandName'] ?></li>
                            <li class="descripciondelproductodelalista"><?php echo $colprods['presentName'] ?></li>
                            <li class="descripciondelproductodelalista"><?php echo $colprods['existencia'] ?></li>
                            <li class="descripciondelproductodelalista">$ <?php echo $colprods['price'] ?></li>
                        </ul>
                    </div>


                    <div class="four columns omega">
                      <ul class="adminUsuariosderecha">
                        <!--<div class="usseccion">-->
                        <li class="editarus"><a href="index.php" id="borrar<?php echo $colprods['productID'] ?>" onclick="borrarProducto(event,this.id)">BORRAR</a></li>
                        <li class="editarus"><a href="#modalEditar" id="editar<?php echo $colprods['productID'] ?>" onclick="infoProd(this.id)">EDITAR</a></li>
                            <!--</div>-->
                        </ul>
                    </div>
                <hr>


                <?php
            }
        }
        ?>


        </div>
        <?php
        $querytotalp = "select * from products";
        $totalp = $bd->query($querytotalp);
        $cont = $bd->rows($totalp);
        $rpp = 10;
        $total= ceil($cont/$rpp);
    if ($total > 1){ ?>
        <div class="fifteen columns">
            <div class="paginasus">
               <ul class="paginaul">
                   <li>P&Aacute;GINA</li>
                   <?php
                     for($i = 1; $i <= $total; $i++){
                    ?>
                   <li class="paginanumerito" id="<?php echo $i ?>" onclick="infoDeCtes(this.id)"><?php echo $i; ?></li>
                    <?php } ?>
               </ul>
            </div>
        </div>
        <?php }
        ?>
</div>

<div class="container">
    <div id="modalEditar" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="form" onsubmit="cambiosProducto(event, this.id, this.nombreProducto.value, this.descripcionProducto.value, this.precioProducto.value, this.presentacionProducto.value, this.categoriaProducto.value, this.marcaProducto.value, this.existenciaProducto.value)">
            <label>NOMBRE: </label>
            <input type="text" id="nombreProducto">
            <label>DESCRIPCIÓN: </label>
            <input type="text" id="descripcionProducto">
            <label>PRECIO: </label>
            <input type="text" id="precioProducto">
            <label>PRESENTACI&Oacute;N: </label>
                <select type="text" id="presentacionProducto">
                   <?php
                    $querypresentaciones = "select * from presentation order by presentName ASC";
                    $presentaciones = $bd->query($querypresentaciones);
                    while($colpresentacion = $bd->fassoc($presentaciones)){
                        ?>
                        <option value="<?php echo $colpresentacion['presentID'] ?>"><?php echo $colpresentacion['presentName'] ?></option>
                        <?php
                    }
                    ?>

                </select>
            <label>CATEGOR&iacute;A: </label>
                <select type="text" id="categoriaProducto">
                    <?php
                    $querycategorias = "select * from category order by categoryName ASC";
                    $categorias = $bd->query($querycategorias);
                    while($colcategorias = $bd->fassoc($categorias)){
                        ?>
                        <option value="<?php echo $colcategorias['categoryID'] ?>"><?php echo $colcategorias['categoryName'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            <label>MARCA: </label>
                <select type="text" id="marcaProducto">
                    <?php
                    $querymarca = "select * from brand order by brandName ASC";
                    $marcas = $bd->query($querymarca);
                    while($colmarca = $bd->fassoc($marcas)){
                        ?>
                        <option value="<?php echo $colmarca['brandID'] ?>"><?php echo $colmarca['brandName'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            <label>EXISTENCIA: </label>
            <input type="text" id="existenciaProducto">
            <label id="edoprod"></label>
            <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>
</section>



<?php include("../footer.php");?>



</body>
</html>
