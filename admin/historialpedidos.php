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



<section id="adminPedidos">

<div class="container">
                <div class="sixteen columns" id="locali">
                    <ul>
                        <li><a href="../">Inicio</a></li>
                        <li><a href="index.php">Panel de Administrador</a></li>
                        <li><a href="#">Administrar pedidos</a></li>
                    </ul>
                </div>
<div class="three columns">
    <h2>PEDIDOS</h2>
</div>
<div class="eight columns offset-by-five">
    <div class="two columns">
        <h2>Filtrar por:</h2>
    </div>
    <div class="five columns">
        <select id="combofiltro" onchange="filtrarPedidos(this.value)">
        <option value="0">MOSTRAR TODO</option>
        <?php
        $bd = new MYSQLIFunctions();
        $queryestados = "select * from orderstatus where statusID <> 4 order by statusName ASC";
        $estatus = $bd->query($queryestados);
        while($colestatus = $bd->fassoc($estatus)){
            ?>
            <option value="<?php echo $colestatus['statusID'] ?>"><?php echo $colestatus['statusName'] ?></option>
            <?php
        }
        ?>
    </select>
    </div>

</div>
</div>
<!--
    <select><option value="1">gatos</option>
    <option value="2">perros</option>
    <option value="3">venados</option>
    <option value="4">tejones</option></select>
-->
  <div class="container">
      <div class="offset-by-one">
            <ul class="encabezadohistorialpedidos">
                <li class="lihpedido" onclick="filtroPedidos('2')">No. Pedido</li>
                <li class="lihnombre" onclick="filtroPedidos('3')">Cliente</li>
                <li class="lihfecha" onclick="filtroPedidos('4')">Fecha</li>
                <li class="lihhora" onclick="filtroPedidos('5')">Hora</li>
                <li class="lihitems" onclick="filtroPedidos('6')">Items</li>
                <li class="lihtotal" onclick="filtroPedidos('7')">Total</li>
                <li class="lihcolonia" onclick="filtroPedidos('8')">Colonia</li>
                <li class="lihestatus" onclick="filtroPedidos('9')">Estatus</li>
            </ul>
        </div>
  </div>

    <div id="todoslospedidos">
            <img src="">
    </div>

</div>

        <script type="text/javascript">

        $(document).ready(function(){
            $.getJSON('jsonpedidoshistorial.php', function(json){
                console.log("El json: " + json);
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
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
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

                    if (val['estado'] == "Enviado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br> <br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');


                    else if (val['estado'] == "Cancelado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoHP(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');

                    else if(val['estado'] == "Autorizado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><a href="#datosDeEnvio"><button class="full-width env" id="aut'+ val['id'] +'" onclick="obtenerInfoDatosDeEnvio(this.id)">ENVIAR PEDIDO <img src="../images/check.png"></button></a><br><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');

                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });

            });
        });


        </script>

<div class="container">
    <div id="pedidoRechazado" class="modalDialog">
        <div>
            <a href="#close" title="Close" id="cerrarRechazado" class="close">x</a>
            <form id="textRechazo" class="ninguna" onsubmit="rechazarPedidoHP(event, this.id, this.motivoRechazo.value)">
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

<div class="container">
    <div id="datosDeEnvio" class="modalDialog">
        <div class="modaldedatosdeenvio">
            <a href="#close" title="Close" id="cerrarRechazado" class="close">x</a>
            <h2>DIRECCI&Oacute;N DE ENV&Iacute;O</h2>

            <label id="calle"></label>
            <label id="colonia"></label>
            <label id="estado"></label>
            <label id="codigoPostal"></label>
            <label id="telefono"></label>
            <button id="envioDePedido" class="botonconclase" onclick="enviarPedido(event, this.id)">Enviar Pedido</button>
        </div>
    </div>
</div>


</section>



<?php include("../footer.php");?>



</body>
</html>
