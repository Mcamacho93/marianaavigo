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
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

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
    <div class="seven columns offset-by-one">
        <h3>Bienvenido</h3>
        <h2><?php echo $_SESSION['name']; ?></h2>
            <label class="mons">PEDIDOS PENDIENTES</label>
            <?php
            $db = new MYSQLIFunctions();
            $querypedidos = "select o.*, os.statusName from orders o, orderstatus os where o.statusID=os.statusID and o.statusID = 4";
            $pedidos = $db->query($querypedidos);
            if($db->rows($pedidos) <= 0){
                ?>
                <div class="pedidos">
                    <ul class="resumendepedidos">
                        <li><label class="nerd">No tienes pedidos a&uacute;n</label></li>
                    </ul>
                </div>
                <?php
            }
            else{
                echo '<div class="pedidos">';
                while($pedido = $db->fassoc($pedidos)){
                ?>
                <ul class="resumendepedidos">
                    <a href="pedidos.php" id="<?php echo $pedido['orderID'] ?>"><li><label > <?php echo $pedido['orderDate'] ?> </label></li>
                    <li><label><?php echo "Pedido #".$pedido['orderID']; ?></label></li>
                    <li><label><?php echo $pedido['statusName']; ?></label></li>
                    </a>
                </ul>
                <?php
                }
                echo '<a href="pedidos.php"><label>Ver m&aacute;s</label></a></div>';
            }
             ?>

    </div>
<br><br> <!-- AQUÍ HAY 2 BR's-->
    <div class="seven columns offset-by-one">
        <label class="mons">CUENTA</label>
        <div class="pedidos2">
            <div class="cuenta">
                <ul id="opc">
                    <li><a href="cambio.php?cont"  id="camcont"><label >Cambiar Contraseña</label></a></li>
                    <li><a href="cambio.php?correo" id="camcor"><label>Cambiar Correo</label></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">


    <div class="seven columns offset-by-one">
        <label class="mons">CLIENTES</label>
        <div class="pedidos2">
            <div class="clientesadmin" id="cteadmin">
            <?php
            $queryusuarios = "select * from clients order by clientName ASC";
            $usuarios = $db->query($queryusuarios);
            while($colusuarios = $db->fassoc($usuarios)){
            ?>
                <ul class="cliente">
                    <div class="three columns alpha">
                    <li>Nombre: <?php echo $colusuarios['clientName'] ?></li>
                    <li>Correo: <?php echo $colusuarios['clientEmail'] ?></li>
                    </div>
                    <div class="three columns alpha">
                    <a href="#modalEditar" id="editar<?php echo $colusuarios['clientCode'] ?>" onclick="infoCte(this.id)"><li>Editar</li></a><br>
                    <a href="" id="borrar<?php echo $colusuarios['clientCode'] ?>" onclick="borrarCte(event,this.id)"><li>Borrar</li></a>
                    </div>
                </ul>
                <hr>
        <?php } ?>

            </div>
        </div>
    </div>

<?php if(isset($_SESSION['rango']) == 1){ ?>
    <div class="seven columns offset-by-one">
        <label class="mons">ADMINISTRADORES</label>
        <div class="pedidos2">
            <div class="clientesadmin" id="admins">
            <?php
            $queryadmin = "select * from admin order by adminName ASC";
            $admins = $db->query($queryadmin);
            while($coladmin = $db->fassoc($admins)){
            ?>
                <ul class="cliente">
                    <div class="three columns alpha">
                    <li>Nombre: <?php echo $coladmin['adminName'] ?></li>
                    <li>Correo: <?php echo $coladmin['adminEmail'] ?></li>
                    </div>
                    <div class="three columns alpha">
                    <a href="#modalEditarAdmin" id="editarad<?php echo $coladmin['adminID'] ?>" onclick="infoAdmin(this.id)"><li>Editar</li></a><br>
                    <a href="" id="borrarAdm<?php echo $coladmin['adminID'] ?>" onclick="borrarAdmin(event,this.id)"><li>Borrar</li></a>
                    </div>
                </ul>
                <hr>
        <?php } ?>

            </div>
        </div>
    </div>
    <?php } ?>

       <div class="seven columns offset-by-one">
            <label class="mons">HISTORIAL DE PEDIDOS</label>
            <?php
            $db = new MYSQLIFunctions();
            $querypedidos = "select o.*, os.statusName from orders o, orderstatus os where o.statusID=os.statusID and o.statusID <> 4";
            $pedidos = $db->query($querypedidos);
            if($db->rows($pedidos) <= 0){
                ?>
                <div class="pedidos">
                    <ul class="resumendepedidos">
                        <li><label class="nerd">No tienes pedidos a&uacute;n</label></li>
                    </ul>
                </div>
                <?php
            }
            else{
                echo '<div class="pedidos">';
                while($pedido = $db->fassoc($pedidos)){
                ?>
                <ul class="resumendepedidos">
                    <a href="pedidos.php?pedido=<?php echo $pedido['orderID'] ?>" id="<?php echo $pedido['orderID'] ?>"><li><label > <?php echo $pedido['orderDate'] ?> </label></li>
                    <li><label><?php echo "Pedido #".$pedido['orderID']; ?></label></li>
                    <li><label><?php echo $pedido['statusName']; ?></label></li>
                    </a>
                </ul>
                <?php
                }
                echo '<a href="pedidos.php"><label>Ver m&aacute;s</label></a></div>';
            }
             ?>

    </div>

    <div class="seven columns offset-by-one">
        <label class="mons">PRODUCTOS</label>
        <div class="pedidos">
            <ul class="resumendepedidos">
                <a href="producto.php"><li><label class="nerd">Agregar</label></li></a><br><!-- BR!!!!!!!!!!!!!! -->
                <a href="productos.php"><li><label class="nerd">Ver m&aacute;s</label></li></a>
            </ul>
        </div>
    </div>

</div>
<div class="container">
    <div id="modalEditar" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="formcte" onsubmit="cambiosCliente(event, this.id, this.nombreCte.value, this.correoCte.value)">
            <label>Nombre: </label>
            <input type="text" id="nombreCte">
            <label>Correo: </label>
            <input type="email" id="correoCte">
            <label id="edocte"></label>
            <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div id="modalEditarAdmin" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="formadmin" onsubmit="cambiosAdmin(event, this.id, this.nombreAdmin.value, this.correoAdmin.value, this.telAdmin.value, this.rangoAdmin.value)">
            <label>Nombre: </label>
            <input type="text" id="nombreAdmin">
            <label>Correo: </label>
            <input type="text" id="correoAdmin">
            <label>Tel&eacute;fono: </label>
            <input type="text" id="telAdmin">
            <select id="rangoAdmin">
                <?php
                $queryrol = "select * from role order by roleName ASC";
                $rangos = $db->query($queryrol);
                while($colrol = $db->fassoc($rangos)){
                    ?>
                    <option value="<?php echo $colrol['roleID'] ?>"><?php echo $colrol['roleName'] ?></option>
                    <?php
                }
                ?>
            </select>
            <label id="edoadmin"></label>
            <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

</div>




</section>



<?php include("../footer.php");?>



</body>
</html>
