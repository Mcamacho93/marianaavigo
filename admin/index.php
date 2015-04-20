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
    <meta name="description" content="Sitio web dedicado a la venta y suministro de art鱈culos para la cocina gourmet">
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
        <div id="locali">

            <ul>
                <li><a href="javascript:history.back()">Inicio</a></li>
                <li><a href="">Panel de Administrador</a></li>
            </ul>
        </div>

        <div class="four columns">
            <h3>Bienvenido <?php if($_SESSION['rango'] == "1") echo " Administrador";  ?></h3>
            <h2><?php echo $_SESSION['name']; ?></h2>
        </div>
            <?php
            $db = new MYSQLIFunctions();
            $notasquery = "select * from orders where statusID = 4";
            $notas = $db->query($notasquery);
            if($db->rows($notas) <= 0){
                ?>
                <label></label>
                <?php
            }
            else if ($db->rows($notas) == 1){
                ?>
                <div class="thirteen columns notification"> <label>Tienes <strong><?php echo $db->rows($notas) ?></strong> pedido pendiente</label>
                <?php
            }
            else{
                ?>
            <div class="twelve columns notification"> <label>Tienes <strong><?php echo $db->rows($notas) ?></strong> pedidos pendientes</label></div>
                <?php
            }
            ?>
    </div>
    <div class="container">
            <div class="eleven columns offset-by-one omega">

            <label class="mons">PEDIDOS PENDIENTES</label>
            <ul class="encabezadopedidos">
                <li class="lipedido">No. Pedido</li>
                <li class="linombre">Usuario</li>
                <li class="lifecha">Fecha</li>
                <li class="lihora">Hora</li>
                <li class="liitems">Items</li>
                <li class="litotal">Total</li>
                <li class="licolonia">Colonia</li>
            </ul>
            <div id="todoslospedidos"></div>
            </div>

    <script type="text/javascript">

            $(document).ready(function(){
                $.getJSON('jsonpedidos.php', function(json){
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
                            li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                            li += "<li><div class='three columns omega'>"+ nombre[i] +"</div></li>";
                            li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                            li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
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

                        var fechahora = val['orderDate'].split(" ");
                        var fechaPedido = fechahora[0];
                        var horaPedido = fechahora[1];

                        $('#todoslospedidos').append('<div class="itemss"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span></h2><hr></div><div class="listapedido"><div class="seven columns offset-by-one omega">' + li +'</div> <div class="three columns omega"><label>TOTAL: $'+ val['totalapagar'] +'</label><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoIndex(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estado'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div><br>');

                    });
                    $('#todoslospedidos').find('.triglista').click(function(){
                        $(this).parent().next().slideToggle(200);
                    });

                });
            });
     </script>


        <div class="four columns omega dashbo">
           <div class="dash" >
                <img src="../images/cuenta.png" alt="Cuenta">
                <div class="button full-width" onclick="toggle_visibility('opc1')">Cuenta</div>
                <div id="opc1">
                <ul>
                    <li><a href="cambio.php?cont">Cambiar Contraseña</a></li>
                    <li><a href="cambio.php?correo">Cambiar Correo</a></li>
                </ul>
            </div>
            </div>
            <div class="dash">
                <img src="../images/pedidos.png" alt="Pedidos">
                <div class="button full-width" onclick="toggle_visibility('opc2')">Pedidos</div>
                <div id="opc2">
                    <ul>
                    <li><a href="pedidos.php">Pendientes de Env&iacute;o</a></li>
                    <li><a href="historialpedidos.php">Historial de pedidos</a></li>
                </ul>
                </div>
            </div>
            <div class="dash">
                <img src="../images/usuarios.png" alt="Usuarios">
                <div class="button full-width" onclick="toggle_visibility('opc3')">Usuarios</div>
                <div id="opc3">
                <ul>
                    <li><a href="usuarios.php?clientes">Clientes</a></li>
                    <li><a href="usuarios.php?administradores">Administradores</a></li>
                </ul>
            </div>
            </div>
            <div class="dash">
                <img src="../images/productos.png" alt="Productos">
                <div class="button full-width" onclick="toggle_visibility('opc4')">Productos</div>
                <div id="opc4">
                    <ul>
                    <li><a href="producto.php">A&ntilde;adir producto</a></li>
                    <li><a href="productos.php">Listado de Productos</a></li>
                </ul>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
    function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'none' || e.style.display=='') {
        e.style.display = 'block';
        $('.button').addClass('on');
        }
    else {
        e.style.display = 'none';
        $('.button').removeClass('on');
        }
};
     </script>

<div class="container">
    <div id="pedidoRechazado" class="modalDialog">
        <div>
            <a href="#close" title="Close" id="cerrarRechazado" onclick="regresarID()" class="close">x</a>
            <form id="textRechazo" class="ninguna" onsubmit="rechazarPedido(event, this.id, this.motivoRechazo.value)">
            <label>¿CU&Aacute;L ES EL MOTIVO POR EL QUE RECHAZA EL PEDIDO?</label>
        	<label>
                 	<textarea id="motivoRechazo"></textarea>
       		</label>
       		<label id="estadoRechazado" style="display:none"></label>
        	<button type="submit" id="nuevaPres">Agregar</button>
        	</form>
        </div>
    </div>
</div>

</section>

    <!-- <section class="dash">
        <div class="container">
            <div class="five columns offset-by-one">
                <img src="../images/pedidos.png" alt="Pedidos">
                <div class="button" id="dashb">Administrar pedidos</div>
                <ul>
                    <li><a href="pedidos.php">Pedidos Pendientes</a></li>
                    <li><a href="historialpedidos.php">Historial de pedidos</a></li>
                </ul>
            </div>
             <div class="five columns">
                <img src="../images/usuarios.png" alt="Usuarios">
                <div class="button" id="dashb">Administrar usuarios</div>
                <ul>
                    <li><a href="usuarios.php?clientes">Usuarios</a></li>
                    <li><a href="usuarios.php?administradores">Administradores</a></li>
                </ul>
            </div>
             <div class="five columns">
                <img src="../images/productos.png" alt="productos">
                <div class="button" id="dashb">Administrar productos</a></div>
                <ul>
                    <li><a href="producto.php">A単adir producto</a></li>
                    <li><a href="productos.php">Listado de Productos</a></li>
                </ul>
            </div>
        </div>
    </section> -->



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





<?php include("../footer.php");?>



</body>
</html>
