<?php
session_start();
if(!isset($_SESSION['adminID'])){
    header("Location: index.php");
    exit;
}
if(!isset($_POST['tipo'])){
    header("Location: index.php");
    exit;
}
else{
    include '../conexion.php';
    $bd = new MYSQLIFunctions();
    if($_POST['tipo'] == "1"){
        $nombre = $bd->escapestr($_POST['Nombre']);
        $correo = $bd->escapestr($_POST['Correo']);
        $telefono = $bd->escapestr($_POST['Telefono']);
        $contrasena = $bd->escapestr($_POST['Contrasena']);
        $contrasenahash = bin2hex(hash('sha256', $contrasena));
        $puesto = $bd->escapestr($_POST['Puesto']);
        $queryverificar = "select * from admin where adminEmail = '".$correo."' ";
        $verificar = $bd->query($queryverificar);
        if($bd->rows($verificar) > 0){
            echo "error1";
            exit;
        }
        else{
            $query = "insert into admin values ('', '".$nombre."', '".$correo."', '".$contrasenahash."', '".$telefono."', ".$puesto.")";
            if($bd->query($query)){
                $queryadmins = "select * from admin order by adminName ASC";
                $administradores = $bd->query($queryadmins);
                $arrayadmins = array();
                $i = 0;
                echo "OK#&@";
                while($coladmin = $bd->fassoc($administradores)){
                    $arrayadmins[$i]['adminID'] = $coladmin['adminID'];
                    $arrayadmins[$i]['adminName'] = $coladmin['adminName'];
                    $arrayadmins[$i]['adminEmail'] = $coladmin['adminEmail'];
                    $arrayadmins[$i]['adminPassword'] = $coladmin['adminPassword'];
                    $arrayadmins[$i]['adminPhone'] = $coladmin['adminPhone'];
                    $arrayadmins[$i]['roleID'] = $coladmin['roleID'];
                    $i++;
                }
                echo json_encode($arrayadmins);
            }
        }


    }

    //Otro tipo
    if($_POST['tipo'] == "2"){
        $id = $bd->escapestr($_POST['ID']);
        $query = "select * from admin where adminID = ".$id." ";
        $administrador = $bd->query($query);
        $jsonadmin = array();
        echo "OK#&@";
        while($coladmin = $bd->fassoc($administrador)){
            $jsonadmin = $coladmin;
        }
        echo json_encode($jsonadmin);
    }

    if($_POST['tipo'] == "3"){
        $ID = $bd->escapestr($_POST['ID']);
        $Nombre = $bd->escapestr($_POST['Nombre']);
        $Correo = $bd->escapestr($_POST['Correo']);
        $Telefono = $bd->escapestr($_POST['Telefono']);

        $query = "update admin set adminName = '".$Nombre."', adminEmail = '".$Correo."', adminPhone = '".$Telefono."' where adminID = ".$ID." ";
        if($bd->query($query)){
            echo "OK";
        }
    }

    if($_POST['tipo'] == "4"){
        $ID = $bd->escapestr($_POST['ID']);
        $query = "delete from admin where adminID = ".$ID." ";
        if($bd->query($query)){
            echo "OK#&@";
        }
    }
}
?>
