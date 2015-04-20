<div class="footer">
    <div class="container">
        <div class="three columns">
            <h4>Inicio</h4>
            <ul>
                <li><a href="about.php">Sobre Nosotros</a></li>
                <li><a href="about.php#clientes">Misi&oacute;n/Visi&oacute;n</a></li>
                <li><a href="tienda.php">Tienda</a></li>
                <li><a href="about.php#contacto">Contacto</a></li>
            </ul>
        </div>
        <div class="three columns">
            <h4>Categor&iacute;as</h4>
            <ul>
               <?php
                require_once 'conexion.php';
                if(!isset($bd))
                    $bd = new MYSQLIFunctions();
                $querycat = "select categoryName from category order by categoryName ASC limit 0,1";
                $cat = $bd->query($querycat);
                while($c = $bd->fassoc($cat)){
                    ?>
                    <li><a href="tienda.php"><?php echo $c['categoryName'] ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="three columns">
            <ul>
                <li><br><br></li>
                <?php
                if(!isset($bd))
                    $bd = new MYSQLIFunctions();
                $querycat = "select categoryName from category order by categoryName ASC limit 1, 1";
                $cat = $bd->query($querycat);
                while($c = $bd->fassoc($cat)){
                    ?>
                    <li><a href="tienda.php"><?php echo $c['categoryName'] ?></a></li>
                    <?php
                }
                ?>
                <li><a href="#"><br></a></li>

            </ul>
        </div>
        <div class="six columns">
            <h4>Contacto</h4>
            <p>
            Distribuidora Gastronómica Casa Laietana, S.A. de C.V.<br>
            Manuel M. Ponce 149-C1 <br>
            Colonia Guadalupe Inn,
            Delegación Alvaro Obregón, <br>
            CP 01020 Distrito Federal, México <br>
             5651 83 84<br>
5523 60 72<br>
            <br>
            <strong>contacto@casalaietana.com.mx<br>
            ventas@casalaietana.com.mx</strong>
            </p>
        </div>
    </div></div>
<footer>
    <div class="rights">
        <div class="container">
            © Casa Laietana. Todos los derechos reservados 2014 | <a href="aviso.html" style="color: black;"> Aviso de Privacidad </a>
        </div>
    </div>

</footer>
