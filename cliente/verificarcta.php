<?php
session_start();
if(isset($_SESSION['verified'])){
    if($_SESSION['verified'] != 'n'){
        header("Location: index.php");
        exit;
    }
}
if(!isset($_GET['tid']) || !isset($_GET['temp'])){
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
    <script type="text/javascript" src="js/clientFunctions.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="../images/favicon.ico">

</head>
<body>

<?php include("menu.php"); ?>

<section id="usuario">
<div class="container">
    <div class="fourteen columns offset-by-one">
        <h3>Bienvenido</h3>
        <?php
        $bd = new MYSQLIFunctions();
        $idcte = $bd->escapestr($_GET['tid']);
        $email = $bd->escapestr($_GET['temp']);
        $querycte = "select * from clients where sha2(clientCode, 256) = '".$idcte."' and sha2(clientEmail, 256) = '".$email."' ";
        $cteexe = $bd->query($querycte);
        if($bd->rows($cteexe) <= 0){
            header("Location: ../");
            exit;
        }
        else{
            $updateval = "update clients set verified = 's' where sha2(clientCode,256) = '".$idcte."'  and sha2(clientEmail, 256) = '".$email."'";
            if($bd->query($updateval)){
                $querydatoscte = "select * from clients where sha2(clientCode, 256) = '".$idcte."' and sha2(clientEmail, 256) = '".$email."'";
                $datoscteexe = $bd->query($querydatoscte);
                while($patricia = $bd->fassoc($datoscteexe)){
                    $_SESSION['rol'] = "cliente";
                    $_SESSION['clientCode'] = $patricia['clientCode'];
                    $_SESSION['name'] = $patricia['clientName'];
                    $_SESSION['email'] = $patricia['clientEmail'];
                    $_SESSION['verified'] = $patricia['verified'];
                    $_SESSION['registros'] = "";
                }
            }
        }
        ?>
        <h2><?php echo $_SESSION['name']; ?></h2>
        <label class="mons">CUENTA</label>
        <div class="pedidos2">

            <div class="textovalidar">
                <h2>CUENTA VALIDADA CON &Eacute;XITO</h2>
                <label class="msgcta">Su cuenta ha sido validada, puede ir a inicio pulsando <a href="index.php">Aqu&iacute;</a></label>

            </div>
            <div class="cuentanovalida">
                <ul id="opc">
                    <li><a href="cambio.php?cont"  id="camcont"><label >Cambiar Contraseña</label></a></li>
                    <li><a href="cambio.php?correo" id="camcor"><label>Cambiar Correo</label></a></li>
                </ul>
            </div>
        </div>
    </div>

</div>
</section>



<?php include("../footer.php"); ?>



</body>
</html>
