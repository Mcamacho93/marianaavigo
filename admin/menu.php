<?php
if(!isset($_SESSION['adminID'])){
    header("Location: ../");
    exit;
}
?>
        <div class="menu">
            <div class="container">
                <nav>
                    <div class="four columns"><a href="index.php"><img src="../images/logo.png"></a></div>
                    <div class="twelve columns">
                        <ul id="menu" class="nonn">
                            <li><a href="../index.php">Inicio</a></li>
                            <li class="trig">Pedidos
                                <ul class="submenuadmin">
                                    <a href="index.php"><li>Pendientes</li></a>
                                    <a href="pedidos.php"><li>Por Enviar</li></a>
                                    <a href="historialpedidos.php"><li>Historial de Pedidos</li></a>
                                </ul>
                            </li>
                            <li><a href="productos.php">Productos</a>
                            </li>

                            <li><div class="usuarios" id="login">
                                <p><?php echo $_SESSION['name'] ?></p>
                                <ul>
                                    <li><a href="index.php">Mi Cuenta</a></li>
                                    <li><a href="../cliente/cerrars.php">Cerrar Sesi&oacute;n</a></li>
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

            $('.trig').hover(function(){
                $('.submenuadmin').slideToggle(100);
            });
        });


        </script>






