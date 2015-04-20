<?php
session_start();
if(isset($_SESSION['adminID'])){
    header("Location: ../");
    exit;
}
if(!isset($_SESSION['clientCode']) || !isset($_SESSION['email']) || !isset($_SESSION['verified'])){
    header("Location: ../");
    exit;
}
if($_SESSION['verified'] == 'n'){
    header("Location: novalidada.php");
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
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <script src="../js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="js/clientFunctions.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="../images/favicon.ico">

</head>
<body>

<?php include("menu.php");?>

<div class="container">
        <div class="sixteen columns" id="locali">
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="index.php">TU CUENTA</a></li>
                        <li><a href="#">Pedidos</a></li>
                    </ul>
        </div>
        </div>

<section id="usuario">
    <?php
    if(isset($_GET['pedido'])){
        $bd = new MYSQLIFunctions();
        $idorden = $bd->escapestr($_GET['pedido']);
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName from orders o, orderdetails od, products p, orderstatus s, presentation pr where clientCode = ".$_SESSION['clientCode']." and o.orderID = ".$idorden." and o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID";
        $pedidos = $bd->query($query);
        if($bd->rows($pedidos)<=0){
            ?>
            <div class="container">
                <h2>SIN RESULTADOS</h2>
                <?php echo $query ?>
            </div>
            <?php
        }
        else{
            while($col = $bd->fassoc($pedidos)){
                if (!isset($numeropedido)){
                    $numeropedido = $col['orderID'];
                    if($numeropedido != ""){
                        ?>
                        <div class="container">
             				<h2>PEDIDO NO.<?php echo str_pad($numeropedido, (8 - strlen($numeropedido)), "0", STR_PAD_LEFT) ?></h2>
                        </div>
                        <div class="container">
                        <div class="ten columns offset-by-one">
                        <?php
                    }
                }
                ?>

                <hr>
                <ul class="detallesdepedido">
                    <li><label><?php echo $col['units'] ?></label></li>
                    <li><label><?php echo $col['productName'] ?></label></li>
                    <li><label>(<?php echo $col['presentName'] ?>)</label></li>
                    <li><label>$ <?php echo number_format($col['unitprice'], 2, '.', ',') ?></label></li>
                </ul>
                <?php
                if(!isset($totalPr))
                    $totalProds = $col['units'];
                    $totalapagar = $col['orderAmount'];
                    $status = $col['statusName'];
            }
            echo "</div>";
            ?>
            <div class="four columns">
                <label>
                    TU PEDIDO: <br>
                    Total de productos: <?php echo $totalProds ?> <br>
                    Total: <br>
                    $ <?php echo number_format($totalapagar, 2, '.', ',') ?>
                </label>
                <br>
                <label>Pedido <strong><?php echo $status ?></strong></label>
            </div></div>
            <?php
        }
    }
    else{
        ?>
    <div id="todoslospedidos">

        </div>
        <script type="text/javascript">
        $(document).ready(function(){
            $.getJSON('jsonpedido.php', function(json){
                console.log(json);
                $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<hr><ul class='detallesdepedido'><li>"+ unidades[i] +"</li>";
                        li += "<li>"+ nombre[i] +"</li>";
                        li += "<li>"+ presentacion[i] +"</li>";
                        li += "<li>$ "+ preciounitario[i] +"</li></ul>";
                    }
                    var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;
                        //alert(li);
                    $('#todoslospedidos').append('<div class="container"><h2>PEDIDO NO. '+ folioDelPedido +' </h2></div><div class="container"><div class="ten columns offset-by-one">' + li +'</div> <div class="four columns"><label>TU PEDIDO:<br>Total de productos: '+ val['productostotales'] +' <br>Total: <br><strong>$ '+ val['totalapagar'] +'MXN</strong></label><br><label>PEDIDO '+ val['estado'] +'</label></div></div><br>');

                })

            });
        });
        </script>
        <?php


    }


     ?>
</section>



<?php include("../footer.php");?>



</body>
</html>
