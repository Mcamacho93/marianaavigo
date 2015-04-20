<?php
if(!isset($_SESSION['clientCode'])){
?>
<div class="menu">
    <div class="container">
        <nav>
            <div class="four columns"><a href="index.php"><img src="images/logo.png"></a></div>
            <div class="twelve columns">
                <ul id="menu" class="nonn">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="about.php">Sobre Nosotros</a></li>
                    <li><a href="about.php#clientes">Misión/Visión</a></li>
                    <li><a href="about.php#contacto">Contacto</a></li>
                    <li><a href="tienda.php">Tienda</a></li>
                    <li>
                        <div class="buttn" id="login">
                                <p><a href="#openModal"  id="login">Iniciar sesión</a></p>
                                <ul>
                                    <li><a href="signin.php" id="login">O Registrate</a></li>
                                </ul>
                        </div>
                    </li>
                </ul>
            </div>

        </nav>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    $('#menu').slicknav({
        closeOnClick: true,
});
    });
</script>





<div class="container">
    <div id="openModal" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="login" onsubmit="login(event, this.user.value, this.password.value)">
        	<label>
           		 <input id="user" type="email" required="" placeholder="Correo Electr&oacute;nico" title="Usuario" name="user"/>
       		</label>
       		<label>
            	<input id="password" type="password" required="" placeholder="Contraseña" title="Password" name="password"/>
       		</label>
       		<label id="estado" style="display:none"></label>
        	<button type="submit" id="button" name="button"> iniciar sesión</button>
        	<a class="button" id="signin" href="signin.php">Registrarse</a>
        	<a class="button" id="signin2" href="recuperarc.php"> olvidé mi contraseña</a>
        	</form>
        </div>
    </div>
</div>
<?php }


if (isset($_SESSION['rol'])){
    if($_SESSION['rol'] == "cliente"){
?>
        <div class="menu">
            <div class="container">
                <nav>
                    <div class="four columns"><a href="index.php"><img src="images/logo.png"></a></div>
                    <div class="twelve columns">
                        <ul id="menu" class="nonn">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="about.php">Sobre Nosotros</a></li>
                            <li><a href="about.php#clientes">Misión/Visión</a></li>
                            <li><a href="about.php#contacto">Contacto</a></li>
                            <li><a href="tienda.php">Tienda</a></li>
                            <li>
                                <div class="usuarios" id="login">
                                    <p><?php echo $_SESSION['name'] ?></p>
                                    <ul>
                                        <li><a href="cliente/index.php">Mi Cuenta</a></li>
                                        <li><a href="cliente/cerrars.php">Cerrar Sesi&oacute;n</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>


    <?php
    if(isset($_SESSION['clientCode'])){
        if (isset($_SESSION['carrito'])){
    ?>

    <div class="carte">
        <div class="menucheck">
            <ul>
                <li class="lismenucheck"><img src="images/cart.png"><span class="itemsmenu">(<?php echo count($_SESSION['carrito']) ?>)</span>
                     <ul class="submenucheck">

                        <?php
                        $sumatoria = 0;
                        foreach($_SESSION['carrito'] as $key => $val){
                            foreach($val as $skey => $sval){
                                //echo $skey."->".$sval;
                                if(!isset($cantidad)){
                                    $cantidad = "";
                                    $nombre = "";
                                    $precio = "";
                                    $total = "";

                                }
                                if($skey == "nombre"){
                                    $nombre = $val['nombre'];
                                    echo "<li class='liitemsc'><label id= 'names'>".$nombre."</label><br>";

                                }

                                if($skey == "cantidad"){
                                    $cantidad = $val['cantidad'];
                                    $sumatoria += $val['precio'];
                                    echo "<label id='cant'>".$cantidad."</label><label id = 'prec'>$ ".number_format($val['precio'], 2, '.', ',')."</label>";
                                }
                                //if($skey == "")
                                /*if($skey == "cantidad"){
                                    $cantidad = $val['cantidad'];
                                    $total = $precio * $cantidad;
                                    $sumatoria += $total;
                                    //echo "  c ".$cantidad." * ".$precio;
                                    echo "<label>".$cantidad."</label>$&nbsp;".number_format($total, 2, '.', ',')."</label></li><hr>";
                                }

                                if($skey == "nombre"){
                                    $nombre = $val["nombre"];
                                    echo "<li class='liitemsc'><label>".$nombre."</label>";
                                }

                                if($skey == "precio"){
                                    $precio = $val['precio'];
                                    echo "<label class='numer'>$&nbsp;".number_format($precio, 2, '.', ',')."</label>";

                                }*/
                                /*if($nombre != "" && $precio != "")
                                    echo "<li>".$nombre."</li>";*/
                            }
                        }
                        ?>
                        <li class="litotalcarrito"><label><hr><strong>TOTAL: $ <?php echo  number_format($sumatoria, 2, '.', ',') ?> </strong></label></li>

                    </ul>
                    </li>
                        <li class="button" id="typo"><a href="cliente/carrito.php">Ordenar</a></li>
                </ul>
        </div>
    </div>

    <?php
        }
        else{
        ?>
        <div class="carte">
            <div class="carritodecompras">
                <ul>
                    <li class="lismenucheck"><img src="images/cart.png">&nbsp;<span class="itemsmenu">(0)</span>
                        <ul class="submenucheck">
                            <li>No ha agregado ning&uacute;n producto</li>

                        </ul>
                    </li>
                    <li class="button" id="typo"><a href="cliente/carrito.php">Ordenar</a></li>
                </ul>
            </div>
        </div>
        <?php
        }
    }

        ?>

   </div>
   </div>
</div>



<script type="text/javascript">
     $(document).ready(function(){
     $('#menu').slicknav({
                closeOnClick: true,
        });
            });
</script>





<!-- Usuario Admin  -->
<?php }
    if($_SESSION['rol'] == "admin"){
        ?>
        <div class="menu">
            <div class="container">
                <nav>
                    <div class="four columns"><a href="index.php"><img src="images/logo.png"></a></div>
                    <div class="twelve columns">
                        <ul id="menu" class="nonn">
                            <li><a href="index.php">Inicio</a></li>
                            <li><div class="usuarios" id="login">
                                <p><?php echo $_SESSION['name'] ?></p>
                                <ul>
                                    <li><a href="admin/index.php">Mi Cuenta</a></li>
                                    <li><a href="cliente/cerrars.php">Cerrar Sesi&oacute;n</a></li>
                                </ul>
                            </div></li>
                        </ul>

                    </div>

                </nav>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
            $('#menu').slicknav({
                closeOnClick: true,
        });
            });
        </script>



        <?php
    }
}
?>




