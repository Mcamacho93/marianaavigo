<?php
session_start();
if(!isset($_SESSION['adminID']) && !isset($_SESSION['email'])){
    header("Location: ../");
    exit;
}
if(!isset($_GET['clientes']) && !isset($_GET['administradores'])){
    header("Location: index.php");
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

<section id="usuario">
<div class="container">
  <div class="sixteen columns" id="locali">
        <ul>
            <li><a href="javascript:history.back()">Inicio</a></li>
            <li><a href="index.php">Panel de Administrador</a></li>
        </ul>
    </div>
<br><br><br><!-- AQUÍ HAY UNOS CUANTOS BR -->


   <?php if(isset($_GET['clientes'])){ ?>
    <div class="seven columns offset-by-one">
        <h2>ADMINISTRAR CLIENTES</h2>
    </div>
    <div class="three columns offset-by-twelve">
      <form id="nomarg">
            <input type="text" id="buscarProd" placeholder="Buscar" onkeyup="buscarCtes(this.value)">
            <button id="search" type="submit"><img src="../images/amplif.png"></button>
        </form>
    </div>
    <br><br><br><!-- AHÍ HAY TRES BR's -->
        <div class="fourteen columns offset-by-one alpha" id="listactes">
        <hr>


    <?php
        $bd = new MYSQLIFunctions();
        $queryclientes = "select * from clients order by clientName ASC  limit 0,10";
        $querycteexe = $bd->query($queryclientes);
        if($bd->rows($querycteexe) <= 0){
            ?>
            <h3>SIN CLIENTES</h3>
            <?php
        }
        else{
            while($colcte = $bd->fassoc($querycteexe)){
                ?>
                   <div class="ten columns omega">
                        <ul class="adminUsuarios">
                            <li class="nombreus"><?php echo $colcte['clientName'] ?></li>
                            <li class="correous"><?php echo $colcte['clientEmail'] ?></li>
                        </ul>
                    </div>


                    <div class="four columns omega">
                      <ul class="adminUsuariosderecha">
                        <!--<div class="usseccion">-->
                        <li class="editarus"><a href="index.php" id="borrar<?php echo $colcte['clientCode'] ?>" onclick="borrarCte(event,this.id)">BORRAR</a></li>
                        <li class="editarus"><a href="#modalEditar" id="editar<?php echo $colcte['clientCode'] ?>" onclick="infoCte(this.id)">EDITAR</a></li>
                            <!--</div>-->
                        </ul>
                    </div>
                <hr>


                <?php
            }
        }
        ?>


        </div>
        <?php
        $querytotalp = "select * from clients";
        $totalp = $bd->query($querytotalp);
        $cont = $bd->rows($totalp);
        $rpp = 10;
        $total= ceil($cont/$rpp);
    if ($total > 1){ ?>
        <div class="fifteen columns">
            <div class="paginasus">
               <ul class="paginaul">
                   <li>P&Aacute;GINA</li>
                   <?php
                     for($i = 1; $i <= $total; $i++){
                    ?>
                   <li class="paginanumerito" id="<?php echo $i ?>" onclick="infoDeCtes(this.id)"><?php echo $i; ?></li>
                    <?php } ?>
               </ul>
            </div>
        </div>
        <?php } ?>
        <?php }
    if(isset($_GET['administradores'])){ ?>
    <div class="seven columns offset-by-one">
        <h2>ADMINISTRADORES</h2>
        &nbsp;&nbsp;&nbsp;<a href="#modalAgregarAdmin"><img src="../images/agregarus.png" class = "agregaradmin"></a>
    </div>
    <div class="three columns offset-by-twelve">
      <form id="nomarg">
            <input type="text" id="buscarProd" placeholder="Buscar" onkeyup="buscarAdmin(this.value)">
            <button id="search" type="submit"><img src="../images/amplif.png"></button>
        </form>
    </div>
    <br><br><br><!-- AHÍ HAY TRES BR's -->
        <div class="fourteen columns offset-by-one alpha" id="listactes">
        <hr>


    <?php
        $bd = new MYSQLIFunctions();
        $queryadmin = "select * from admin order by adminName ASC limit 0,10";
        $queryadminexe = $bd->query($queryadmin);
        if($bd->rows($queryadminexe) <= 0){
            ?>
            <h3>SIN ADMINISTRADORES</h3>
            <?php
        }
        else{
            while($coladmin = $bd->fassoc($queryadminexe)){
                ?>
                   <div class="ten columns omega">
                        <ul class="adminUsuarios">
                            <li class="nombreus"><?php echo $coladmin['adminName'] ?></li>
                            <li class="correous"><?php echo $coladmin['adminEmail'] ?></li>
                        </ul>
                    </div>


                    <div class="four columns omega">
                      <ul class="adminUsuariosderecha">
                        <!--<div class="usseccion">-->
                        <li class="editarus"><a href="#" id="borrar<?php echo $coladmin['adminID'] ?>" onclick="borrarAdministrador(event,this.id)">BORRAR</a></li>
                        <li class="editarus"><a href="#modalEditarAdministrador" id="editar<?php echo $coladmin['adminID'] ?>" onclick="infoAdministrador(this.id)">EDITAR</a></li>
                            <!--</div>-->
                        </ul>
                    </div>
                <hr>
                <?php
            }
        }
        ?>


        </div>
        <?php
        $querytotalp = "select * from admin";
        $totalp = $bd->query($querytotalp);
        $cont = $bd->rows($totalp);
        $rpp = 10;
        $total= ceil($cont/$rpp);
    if ($total > 1){ ?>
        <div class="fifteen columns">
            <div class="paginasus">
               <ul class="paginaul">
                   <li>P&Aacute;GINA</li>
                   <?php
                     for($i = 1; $i <= $total; $i++){
                    ?>
                   <li class="paginanumerito" id="<?php echo $i ?>" onclick="infoDeAdmin(this.id)"><?php echo $i; ?></li>
                    <?php } ?>
               </ul>
            </div>
        </div>
        <?php }

    } ?>

</div>


<!-- MODAL PARA EDICIÓN DE CLIENTE -->
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
    <div id="modalEditarAdministrador" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="formAdmin" class="modalEdicionAdmin" onsubmit="cambiosAdministrador(event, this.id, this.nombreAdminEditar.value, this.correoAdminEditar.value, this.telAdminEditar.value)">
            <label>Nombre: </label>
            <input type="text" id="nombreAdminEditar">
            <label>Correo: </label>
            <input type="email" id="correoAdminEditar">
            <label>Telefono: </label>
            <input type="number" id="telAdminEditar">
            <label id="edoeditadmin"></label>
            <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>


<div class="container">
    <div id="modalAgregarAdmin" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">x</a>
            <form id="formcte" onsubmit="nuevoAdmin(event, this.nombreAdmin.value, this.correoAdmin.value, this.telefonoAdmin.value, this.contrasenaAdmin.value, this.confcontrasenaAdmin.value, this.puesto.value)">
            <label>Nombre: </label>
            <input type="text" id="nombreAdmin">
            <label>Correo: </label>
            <input type="email" id="correoAdmin">
            <label>Tel&eacute;fono </label>
            <input type="number" id="telefonoAdmin">
            <label>Contrase&ntilde;a </label>
            <input type="password" id="contrasenaAdmin">
            <label>Confirmar Contrase&ntilde;a </label>
            <input type="password" id="confcontrasenaAdmin">
            <select id="puesto">
                <option value="1">Administrador</option>
                <option value="2">Empleado</option>
            </select>
            <label id="edoagregaradmin"></label>
            <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>

</section>



<?php include("../footer.php");?>



</body>
</html>
