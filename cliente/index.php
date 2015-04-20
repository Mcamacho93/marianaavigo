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
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>
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

<section id="usuario">
<div class="container">

        <div class="sixteen columns" id="locali">
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="">Panel de Usuario</a></li>
                    <ul>
                </div>
    <div class="seven columns offset-by-one">
        <h3>Bienvenido</h3>
        <h2><?php echo $_SESSION['name']; ?></h2>
            <label class="mons">MIS PEDIDOS</label>
            <?php
            $db = new MYSQLIFunctions();
            $querypedidos = "select o.*, os.statusName from orders o, orderstatus os where clientCode = ".$_SESSION['clientCode']." and o.statusID=os.statusID";
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
                    <li><label class="letraroja"><?php echo $pedido['statusName']; ?></label></li>
                    </a>
                </ul>
                <?php
                }
                echo '<a href="pedidos.php"><label>Ver m&aacute;s</label></a></div>';
            }
             ?>

    </div>

    <div class="seven columns offset-by-one">
        <a href="../tienda.php" class="button" id="adminis">Ir a la tienda</a>
        <label class="mons">ADMINISTRAR TU CUENTA</label>
        <div class="pedidos2">
            <div class="cuenta">
                <ul id="opc">
                    <li><a href="cambio.php?perfil" id="camper">Modificar Perfil</a></li>
                    <li><a href="cambio.php?cont"  id="camcont">Cambiar Contraseña</a></li>
                    <li><a href="cambio.php?correo" id="camcor">Cambiar Correo</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="seven columns offset-by-one">
        <div class="facturacion">
            <h2>DATOS DE FACTURACI&Oacute;N</h2>
            <div id="direccionesDeFacturacion">
            <?php

            $selectdirfact = "select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$_SESSION['clientCode']." and idType = 1";
            $DFs = $db->query($selectdirfact);
            if($db->rows($DFs) <= 0){
                ?>
                <label class="nerd">A&uacute;n no hay datos de facturaci&oacute;n</label>
                <?php
            }
            else{
                while($direcciones = $db->fassoc($DFs)){
                 ?>
                <label class="nerd">
                    <?php echo $direcciones['addressDesc'] ?><br>
                    <?php echo $direcciones['street'].", ".$direcciones['colony'] ?><br>
                    <?php echo $direcciones['zip']." ".$direcciones['stateName'] ?><br>
                    <?php echo $direcciones['addressPhone'] ?>
                </label>
                <div class="cuenta2">
                <ul>
                <li><a href="#editarModal" id="edit"><label onclick="editarDireccion(this.id)" id="<?php echo $direcciones['addressID']?>">Editar</label></a></li>
                <li><label class="<?php echo $direcciones['addressID'] ?>" onclick="eliminarDF(this.className)" id="">Eliminar</label></li></ul></div>
                <hr>
            <?php
                }
            }
             ?>
            </div>

        </div><a href="#facturacionModal"><label class="derecha">AGREGAR</label></a>
    </div>



    <div class="seven columns offset-by-one">
    <div class="facturacion">
            <h2>DATOS DE ENV&Iacute;O</h2>
            <div id="direccionesDeEnvio">
            <?php
            $db =new MYSQLIFunctions();
            $selectdirfact = "select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$_SESSION['clientCode']." and idType = 2";
            $DFs = $db->query($selectdirfact);
            if($db->rows($DFs) <= 0){
                ?>
                <label class="nerd">A&uacute;n no hay datos de env&iacute;o</label>
                <?php
            }
            else{
                while($direcciones = $db->fassoc($DFs)){
                 ?>
                <label class="nerd"><?php echo $direcciones['addressDesc'] ?><br>
                <?php echo $direcciones['street'].", ".$direcciones['colony'] ?><br>
                <?php echo $direcciones['zip']." ".$direcciones['stateName'] ?><br>
                <?php echo $direcciones['addressPhone'] ?></label>
                <div class="cuenta2">
                <ul>
                <li><a href="#editarDE"><label onclick="editarDireccionEn(this.id)" id="<?php echo $direcciones['addressID']?>">Editar</label></a></li>
                <li><label class="<?php echo $direcciones['addressID'] ?>" onclick="eliminarDE(this.className)" >Eliminar</label></li></ul></div>
                <hr>
            <?php
                }
            }
             ?>
            </div>

        </div><a href="#envioModal"><label class="derecha">AGREGAR</label></a>
    </div>



    </div>




</div>

<div class="container">
    <div id="facturacionModal" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="datosFacturacion" onsubmit="agregarDir(event, this.descripcionF.value, this.calleNF.value, this.numeroNF.value, this.colF.value, this.delF.value, this.estadoF.value, this.cityF.value, this.cpF.value, this.rfcF.value, this.telF.value, this.telAltF.value, this.correoF.value)">
        	<label>
           		 <input id="descripcionF" type="text" required="" placeholder="Empresa" title="Descripci&oacute;n de la direcci&oacute;n"/>
       		</label>
       		<label>
            	<input id="calleNF" type="text" placeholder="Calle" title="Calle"/>
       		</label>
       		<label>
            	<input id="numeroNF" type="text" placeholder="N&uacute;mero" onkeypress = "validaentero(event)" title="N&uacute;mero"/>
       		</label>
       		<label>
           		 <input id="colF" type="text" placeholder="Colonia" title="Colonia" />
       		</label>
       		<label>
           		 <input id="delF" type="text" placeholder="Delegaci&oacute;n" title="Delegaci&oacute;n" />
       		</label>
       		<label>
           		 <input id="cityF" type="text" placeholder="Ciudad" title="Ciudad" />
       		</label>
       		<label>
       			<select id="estadoF">
       				<?php
       				$db = new MYSQLIFunctions();
       				$queryestado = $db->escapestr("select * from state");
       				$estados = $db->query($queryestado);
       				if($db->rows($estados) <= 0){
       					?>
                        <option value="0">No hay estados registrados</option>
       					<?php
       					}
       				else{
       					while($col = $db->fassoc($estados)){
       						?>
                            <option value="<?php echo $col['stateID'] ?>"><?php echo $col['stateName']; ?></option>
       						<?php
       					}
       				}
       				 ?>
       			</select>

       		</label>
       		<label>
           		 <input id="cpF" type="text" placeholder="C&oacute;digo Postal" onkeypress = "validaentero(event)" title="C&oacute;digo Postal"/>
       		</label>
       		<div class="three columns">
       		<label>
           		 <input id="rfcF" type="text" required="" placeholder="RFC" title="RFC" onchange="comrfcgen(this.value)" />
       		</label>
       		</div>
       		<label class="rfcgenerico"><img src="../images/okicon2.png" alt="Ok" class="autorfc" title="Click para usar un RFC genérico" onclick="rfcgenerico()"></label>
       		<label>
           		 <input id="telF" type="text" placeholder="Tel&eacute;fono" onkeypress = "validaentero(event)" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="telAltF" type="text" placeholder="Tel&eacute;fono Alterno" onkeypress = "validaentero(event)" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="correoF" type="email" placeholder="Correo Electr&oacute;nico" title="Correo Electr&oacute;nico"/>
       		</label>
       		<label class="checkfacturacion">
      		   <div class = "one column omega">
       		   <input type="checkbox" id="checkboxfacturacion" name = "checkboxfacturacion">
       		   </div>
       		   <div class="three columns">
       		       <span>Usar esta direcci&oacute;n como direcci&oacute;n de env&iacute;o</span>
       		   </div>
       		</label>
       		<label id="estadodirfact" style="display:none"></label>
        	<button type="submit" id="button" name="button"> Agregar</button>
        	</form>
        </div>
    </div>
</div>


<div class="container">
    <div id="envioModal" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="datosDeEnvio" onsubmit="agregarDirEn(event, this.descripcionE.value, this.calleE.value, this.numeroE.value, this.colE.value, this.delE.value, this.estadoE.value, this.cityE.value, this.cpE.value, this.telE.value, this.telAltE.value, this.correoE.value)">
        	<label>
           		 <input id="descripcionE" type="text" required="" placeholder="Empresa" title="Descripci&oacute;n de la direcci&oacute;n"/>
       		</label>
       		<label>
            	<input id="calleE" type="text" required="" placeholder="Calle" title="Calle"/>
       		</label>
       		<label>
            	<input id="numeroE" type="text" required="" placeholder="N&uacute;mero" onkeypress = "validaentero(event)" title="N&uacute;mero"/>
       		</label>
       		<label>
           		 <input id="colE" type="text" required="" placeholder="Colonia" title="Colonia" />
       		</label>
       		<label>
           		 <input id="delE" type="text" required="" placeholder="Delegaci&oacute;n" title="Delegaci&oacute;n" />
       		</label>
       		<label>
           		 <input id="cityE" type="text" required="" placeholder="Ciudad" title="Ciudad" />
       		</label>
       		<label>
       			<select id="estadoE">
       				<?php
       				$db = new MYSQLIFunctions();
       				$queryestado = $db->escapestr("select * from state");
       				$estados = $db->query($queryestado);
       				if($db->rows($estados) <= 0){
       					?>
                        <option value="0">No hay estados registrados</option>
       					<?php
       					}
       				else{
       					while($col = $db->fassoc($estados)){
       						?>
                            <option value="<?php echo $col['stateID'] ?>"><?php echo $col['stateName']; ?></option>
       						<?php
       					}
       				}
       				 ?>
       			</select>

       		</label>
       		<label>
           		 <input id="cpE" type="text" required="" placeholder="C&oacute;digo Postal" onkeypress = "validaentero(event)" title="C&oacute;digo Postal"/>
       		</label>
       		<label>
           		 <input id="telE" type="text" required="" placeholder="Tel&eacute;fono" onkeypress = "validaentero(event)" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="telAltE" type="text" required="" placeholder="Tel&eacute;fono Alterno" onkeypress = "validaentero(event)" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="correoE" type="email" required="" placeholder="Correo Electr&oacute;nico" title="Correo Electr&oacute;nico"/>
       		</label>
       		<label id="estadodirenvio" style="display:none"></label>
        	<button type="submit" id="button" name="button"> Agregar</button>
        	</form>
        </div>
    </div>
</div>

<!-- MODAL DATOS DE DIRECCIÓN DE FACTURACIÓN -->
<div class="container">
    <div id="editarModal" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="editarDir">
        	<label>
           		 <input id="editarDesc" type="text" required="" placeholder="Descripci&oacute;n" title="Descripci&oacute;n de la direcci&oacute;n"/>
       		</label>
       		<label>
            	<input id="editarCalle" type="text" required="" placeholder="Calle" title="Calle"/>
       		</label>
       		<label>
            	<input id="editarNumero" type="number" required="" placeholder="N&uacute;mero" title="N&uacute;mero"/>
       		</label>
       		<label>
           		 <input id="editarCol" type="text" required="" placeholder="Colonia" title="Colonia" />
       		</label>
       		<label>
           		 <input id="editarDel" type="text" required="" placeholder="Delegaci&oacute;n" title="Delegaci&oacute;n" />
       		</label>
       		<label>
           		 <input id="editarCiudad" type="text" required="" placeholder="Ciudad" title="Ciudad" />
       		</label>
       		<label>
       			<select id="editarEstado">
       				<?php
       				$db = new MYSQLIFunctions();
       				$queryestado = $db->escapestr("select * from state");
       				$estados = $db->query($queryestado);
       				if($db->rows($estados) <= 0){
       					?>
                        <option value="0">No hay estados registrados</option>
       					<?php
       					}
       				else{
       					while($col = $db->fassoc($estados)){
       						?>
                            <option value="<?php echo $col['stateID'] ?>"><?php echo $col['stateName']; ?></option>
       						<?php
       					}
       				}
       				 ?>
       			</select>

       		</label>
       		<label>
           		 <input id="editarCp" type="number" required="" placeholder="C&oacute;digo Postal" title="C&oacute;digo Postal"/>
       		</label>
       		<label>
           		 <input id="editarRFC" type="text" required="" placeholder="RFC" title="RFC"/>
       		</label>
       		<label>
           		 <input id="editarTel" type="number" required="" placeholder="Tel&eacute;fono" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="editarTelAlt" type="number" required="" placeholder="Tel&eacute;fono" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="editarEmail" type="email" required="" placeholder="Correo Electr&oacute;nico" title="Correo Electr&oacute;nico"/>
       		</label>
       		<label id="idDir" style="display:none"></label>
       		<label id="estadoEditDF" style="display:none"></label>
        	<button type="submit" id="guardarCambios" name="button"> Guardar Cambios</button>
        	</form>
        </div>
    </div>
</div>


<!-- MODAL DATOS DE DIRECCIÓN DE ENVÍO -->
<div class="container">
    <div id="editarDE" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="editarDirEn">
        	<label>
           		 <input id="editarDescE" type="text" required="" placeholder="Descripci&oacute;n" title="Descripci&oacute;n de la direcci&oacute;n"/>
       		</label>
       		<label>
            	<input id="editarCalleE" type="text" required="" placeholder="Calle y N&uacute;mero" title="Calle y N&uacute;mero"/>
       		</label>
       		<label>
            	<input id="editarNumeroE" type="number" required="" placeholder="N&uacute;mero" title="N&uacute;mero"/>
       		</label>
       		<label>
           		 <input id="editarColE" type="text" required="" placeholder="Colonia o Delegaci&oacute;n" title="Colonia o Delegaci&oacute;n" />
       		</label>
       		<label>
           		 <input id="editarDelE" type="text" required="" placeholder="Delegaci&oacute;n" title="Delegaci&oacute;n" />
       		</label>
       		<label>
           		 <input id="editarCiudadE" type="text" required="" placeholder="Ciudad" title="Ciudad" />
       		</label>
       		<label>
       			<select id="editarEstadoE">
       				<?php
       				$db = new MYSQLIFunctions();
       				$queryestado = $db->escapestr("select * from state");
       				$estados = $db->query($queryestado);
       				if($db->rows($estados) <= 0){
       					?>
                        <option value="0">No hay estados registrados</option>
       					<?php
       					}
       				else{
       					while($col = $db->fassoc($estados)){
       						?>
                            <option value="<?php echo $col['stateID'] ?>"><?php echo $col['stateName']; ?></option>
       						<?php
       					}
       				}
       				 ?>
       			</select>

       		</label>
       		<label>
           		 <input id="editarCpE" type="number" required="" placeholder="C&oacute;digo Postal" title="C&oacute;digo Postal"/>
       		</label>
       		<label>
           		 <input id="editarTelE" type="number" required="" placeholder="Tel&eacute;fono" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="editarTelAltE" type="number" required="" placeholder="Tel&eacute;fono" title="Tel&eacute;fono"/>
       		</label>
       		<label>
           		 <input id="editarEmailE" type="email" required="" placeholder="Correo Electr&oacute;nico" title="Correo Electr&oacute;nico"/>
       		</label>
       		<label id="idDirE"  style="display: none"></label>
       		<label id="estadoEditEn" style="display:none"></label>
        	<button type="submit" id="guardarCambios" name="button"> Guardar Cambios</button>
        	</form>
        </div>
    </div>
</div>
</section>



<?php include("../footer.php");?>



</body>
</html>
