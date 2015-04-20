<?php
session_start();
if(isset($_SESSION['adminID'])){
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    <title>Mariana Avigo</title>
    <meta name="description" content="Sitio web dedicado a la venta y suministro de artículos para la cocina gourmet">
    <meta name="author" content="Casa Laietana">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="stylesheets/base.css">
    <link rel="stylesheet" href="stylesheets/skeleton1200.css">
    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/slick.css"/>
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>


    <script src="js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="js/slick.min.js"></script>
    <script type="text/javascript" src="js/ajaxfunctions.js"></script>

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>

<?php include("menu.php");?>



<div class="cover2">
    <div class="container">
        <div class="sixteen columns">
            <h1>Modelamos tu imagen</h1>
        </div>
    </div>
</div>




<div class="about" id="sobre">
    <div class="container">
        <div class="title"><h2>&nbsp;Sobre nosotros&nbsp;</h2></div>
        <div class="seven columns aboutimg">
        </div>
        <div class="seven columns offset-by-one">
            <p>
                MarianaAvigo te hará sentir una grata experiencia de confianza.  Somos una empresa creada especialmente para cubrir tus necesidades de imagen y presencia, porque sabemos que lo más importante para tí como empresa y como marca,  es dejar plasmada tu escencia física, con una primera impresión impecable, manteniendo esta imagen positiva y admirable en cada uno de tus eventos y entre tus clientes. En Mariana Avigo te brindamos un excelente servicio presencial y contamos con  un amplio catálogo de Modelos, Gios y Edecanes con la mejor imagen, actitud y disposición, adaptándonos a tus ideas, a tu economía y a tus principales necesidades de imagen empresarial.
            </p>
            <p>Contamos con personal capacitado para tí en Aguascalientes, Querétaro, León y Guadalajara.</p>
        </div>
    </div>
</div>


<div class="clients" id="clientes">
    <div class="container">
        <div class="logos">
        <!-- 	<ul>
                <li><img src="images/logos/logo1.png"></li>
                <li><img src="images/logos/logo2.png"></li>
                <li><img src="images/logos/logo3.png"></li>
                <li><img src="images/logos/logo4.png"></li>
                <li><img src="images/logos/logo5.png"></li>
            </ul> -->
<!--             <div class="seven columns offset-by-one">
                <div class="title"><h2>&nbsp;Misión&nbsp;</h2></div>
                <p>Ser líderes en la comercialización y distribución de una gran variedad de productos, materias primas, equipo y utensilios especializados necesarios en el arte de la repostería, cumpliendo con los más altos estándares en calidad, innovación, servicio y atención al cliente.
                </p>

            </div>
            <div class="seven columns">
                <div class="title"><h2>&nbsp;Visión&nbsp;</h2></div>
                <p>Ser una empresa fuerte y líder en su ramo, reconocida a nivel nacional e internacional, por ofrecer las materias primas y productos especializados en el arte de la repostería de la más alta calidad, siendo la excelente calidad del servicio a sus clientes, la innovación y los precios competitivos los pilares sobre los que se sostenga.
                </p>
            </div> -->
        </div>
        <div class="boton">
        <div class="container">
            <div class="one-third column offset-by-five">
            <div class="button" id="dos"><a href="/tienda.php">Ver el catálogo</a></div>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="contact" id="contacto">
    <div class="container">
        <div class="title"><h2>&nbsp;Contáctanos&nbsp;</h2></div>
        <div class="six columns offset-by-one">
            <form id="contact"  method="post">
        	<label>
           		 <input id="nombre" type="text" required="" placeholder="Nombre" title="Usuario" name="user"/>
       		</label>
       		<label>
            	<input id="email" type="email" required="" placeholder="Email" title="Password" name="password"/>
       		</label>
       		<label>
           		 <textarea id="mensaje" required="" placeholder="Mensaje" title="Usuario" name="user"></textarea>
       		</label>
        	<button id="enviar" name="button" type="submit"> Enviar</button> </form>
        </div>
        <div class="five columns offset-by-one">
            <p><strong>OFICINAS</strong><br>
            Distribuidora Gastronómica Casa Laietana, S.A. de C.V.<br>
            Manuel M. Ponce 149-C1 <br>
            Colonia Guadalupe Inn, <br>
            Delegación Alvaro Obregón, <br>
            CP 01020 Distrito Federal, México <br>
             5651 83 84<br>
5523 60 72<br>
            <br>
            <strong>contacto@casalaietana.com.mx<br>
            ventas@casalaietana.com.mx</strong></p>
        </div>
<!-- <div class="four columns">
            <p><strong>ALMACÉN</strong> <br>
</p>
        </div> -->

    </div>
</div>





<?php include("footer.php");?>





</body>
</html>
