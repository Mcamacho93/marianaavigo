<?php
if(!isset($_SESSION['clientCode'])){
?>
<div class="menu">
    <div class="container">
        <nav>
            <div class="four columns"><a href="index.php"><img src="../images/logo.png"></a></div>
            <div class="twelve columns">
                <ul id="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="about.php">Sobre Nosotros</a></li>
                    <li><a href="about.php#clientes">Nuestros Clientes</a></li>
                    <li><a href="about.php#contacto">Contacto</a></li>
                    <li><a href="../tienda.php">Tienda</a></li>
                    <li>
                        <a href="signin.php" class="button" id="registro">Registrarse</a>
                    </li>
                    <li>
                        <a href="#openModal" class="button" id="login">Iniciar sesión</a>
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
<?php
}

if (isset($_SESSION['rol'])){
    if($_SESSION['rol'] == "cliente"){
?>
        <div class="menu">
            <div class="container">
                <nav>
                    <div class="four columns"><a href="index.php"><img src="../images/logo.png"></a></div>
                    <div class="twelve columns">
                        <ul id="menu" class="nonn">
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="pedidos.php">Pedidos</a></li>
                            <li><a href="carrito.php">Carrito</a></li>
                            <li><a href="../tienda.php">Tienda</a></li>
                            <li><div class="usuarios" id="login">
                                <p><?php echo $_SESSION['name'] ?></p>
                                <ul>
                                    <li><a href="index.php">Cuenta</a></li>
                                    <li><a href="cerrars.php">Cerrar Sesi&oacute;n</a></li>
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

    <?php }
}
?>




