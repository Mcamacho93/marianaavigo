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
    <link rel="stylesheet" href="../stylesheets/layout.css">
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/slick.css"/>
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>


    <script src="../js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="../js/slick.min.js"></script>
    <script type="text/javascript" src="js/clientFunctions.js"></script>
    <script src="http://www.appelsiini.net/download/jquery.jeditable.mini.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

    <script>
        $(document).ready(function() {
    $('#nombreedit').editable('cambiar.php', {
        id: 'aidi',
        submitdata: {tipo: "3"},
        indicator : '<img src="../images/ajax-loader.gif">',
        onblur : 'submit',
        tooltip: 'Click para editar',
        style   : 'display: inline',
        placeholder: '<label class="editable">Click para agregar información</label>',

    });

    $('#segundonedit').editable('cambiar.php', {
        id: 'aidi',
        submitdata: {tipo: "4"},
        indicator : '<img src="../images/ajax-loader.gif">',
        onblur : 'submit',
        tooltip: 'Click para editar',
        style   : 'display: inline',
        placeholder: '<label class="editable">Click para agregar información</label>',

    });

    $('#apedit').editable('cambiar.php', {
        id: 'aidi',
        submitdata: {tipo: "5"},
        indicator : '<img src="../images/ajax-loader.gif">',
        onblur : 'submit',
        tooltip: 'Click para editar',
        style   : 'display: inline',
        placeholder: '<label class="editable">Click para agregar información</label>',

    });

    $('#amedit').editable('cambiar.php', {
        id: 'aidi',
        submitdata: {tipo: "6"},
        indicator : '<img src="../images/ajax-loader.gif">',
        onblur : 'submit',
        tooltip: 'Click para editar',
        style   : 'display: inline',
        placeholder: '<label class="editable">Click para agregar información</label>',

    });

    $('#companiaedit').editable('cambiar.php', {
        id: 'aidi',
        submitdata: {tipo: "7"},
        indicator : '<img src="../images/ajax-loader.gif">',
        onblur : 'submit',
        tooltip: 'Click para editar',
        style   : 'display: inline',
        placeholder: '<label class="editable">Click para agregar información</label>',

    });

    $('#telefonoedit').editable('cambiar.php', {
        id: 'aidi',
        submitdata: {tipo: "8"},
        indicator : '<img src="../images/ajax-loader.gif">',
        onblur : 'submit',
        tooltip: 'Click para editar',
        style   : 'display: inline',
        placeholder: '<label class="editable">Click para agregar información</label>',

    });

 });
    </script>
</head>
<body>

<?php include "menu.php";
if(isset($_GET['cont'])){
    ?>
    <div class="registro" id="cambiarcontrasena">
    <div class="container">
        <div class="six columns offset-by-one">
            <form id="cambiarcont" class="formrec" onsubmit="cambiarContrasena(event, this.contanterior.value, this.nuevacont.value, this.confirmarcont.value)">
        	<label>No omita ningun campo</label>
        	<label>
            	<input id="contanterior" type="password" required="" placeholder="Contrase&ntilde;a Anterior" title="Contrase&ntilde;a Anterior"/>
       		</label>
            <label>
            	<input id="nuevacont" type="password" required="" placeholder="Nueva Contrase&ntilde;a" title="Nueva Contrase&ntilde;a"/>
       		</label>
       		<label>
            	<input id="confirmarcont" type="password" required="" placeholder="Confirmar Contrase&ntilde;a" title="Confirmar Contrase&ntilde;a"/>
       		</label>
       		<label id="msgcc" style="display:none"></label>
       		<button id="cambiarCont"  type="submit">Cambiar Contrase&ntilde;a</button>
       		</form>
        </div>
    </div>
</div>

    <?php
}

if(isset($_GET['correo'])){
    ?>
        <div class="registro" id="cambiarcorr">
        <div class="container">
            <div class="six columns offset-by-one">
                <form id="cambiarcorreo" class="formrec">
            	<label id="campos">No omita ningun campo</label>
            	<label>
                	<input id="correoanterior" type="email" required="" placeholder="Correo Anterior" title="Correo Anterior"/>
           		</label>
                <label>
                	<input id="nuevocorreo" type="email" required="" placeholder="Correo Nuevo" title="Correo Nuevo"/>
           		</label>
           		<label>
                	<input id="confirmarcorreo" type="email" required="" placeholder="Confirmar Correo" title="Confirmar Correo"/>
           		</label>
           		<label id="msgcco" style="display:none"></label>
           		<button id="cambiarCorreoE"  type="submit">Cambiar Correo</button>
           		</form>
            </div>
        </div>
    </div>

    <?php
}
if(isset($_GET['perfil'])){
    include '../conexion.php';
    $bd = new MYSQLIFunctions();
    ?>
     <div class="registro">
        <div class="container">
                    <div class="sixteen columns" id="locali">
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="../cliente/index.php">Panel de Usuario</a></li>
                        <li><a href="">Editar Perfil</a></li>
                    </ul>
                </div>
            <div class="sixteen columns" id="cambiarperfil2">
                 <h1>PERFIL</h1>
              <p>(Click para editar)</p><br>
            </div>
            <div class="three columns">
                 <div class="profilepic">
                     <div id="overlaypp">
                            <span id="camb">cambiar</span>
                    </div>
                    <img src="1.jpg">
                </div>
            </div>
            <div class="five columns" id="cambiarperfil">
                <h2>Cliente: </h2>
               <?php
                $query = "select * from clients where clientCode = '".$_SESSION['clientCode']."'";
                $queryexe = $bd->query($query);
                while($datos = $bd->fassoc($queryexe)){
                    ?>
                    <span><label class="editable" id="nombreedit"><?php echo $datos['clientName'] ?></label><strong>Nombre</strong></span>
                    <span><label class="editable" id="segundonedit"><?php echo $datos['clientName2'] ?></label><strong>Segundo Nombre</strong></span>
                    <span><label class="editable" id="apedit"><?php echo $datos['clientLastName'] ?></label><strong>Apellido Paterno</strong></span>
                    <span><label class="editable" id="amedit"><?php echo $datos['clientLastName2'] ?></label><strong>Apellido Materno</strong></span>
                    <span><label class="editable" id="telefonoedit"><?php echo $datos['officePhone'] ?></label><strong>Tel&eacute;fono</strong></span>
                    <?php
                }
                ?>
            </div>
            <div class="three columns">
                 <div class="profilepic">

                     <div id="overlaypp">
                            <span id="camb">cambiar</span>
                    </div>
                    <img src="2.jpg">
                </div>
            </div>
             <div class="five columns " id="cambiarperfil">
                    <h2>Empresa: </h2>
               <?php
                $query = "select * from clients where clientCode = '".$_SESSION['clientCode']."'";
                $queryexe = $bd->query($query);
                while($datos = $bd->fassoc($queryexe)){
                    ?>
                    <span><label class="editable" id="companiaedit"><?php echo $datos['clientCompany'] ?></label><strong>Nombre de la Compa&ntilde;ia</strong></span>
                    <?php
                }
                ?>
             </div>
        </div>
    </div>
    <?php
}
?>






<?php include("../footer.php");?>





</body>
</html>
