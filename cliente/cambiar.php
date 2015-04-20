<?php
session_start();

if(!isset($_SESSION['clientCode']))
    header("Location: ../");
if(!isset($_POST['tipo'])){
    echo "Error 404";
}
else{
    include '../conexion.php';
    $bd = new MYSQLIFunctions();
    if($_POST['tipo'] == 1){
        if(!isset($_POST['ContAnterior']) || !isset($_POST['ContrasenaNueva'])){
            echo "No omita ningun campo";
        }
        else{
            if($_POST['tipo'] == 1){
            $contAnterior = $bd->escapestr(bin2hex(hash('sha256', $_POST['ContAnterior'])));
            $contNueva = $bd->escapestr(bin2hex(hash('sha256', $_POST['ContrasenaNueva'])));
            $idcte = $bd->escapestr($_SESSION['clientCode']);

            $querycompcontrasena = "select * from clients where clientCode = '".$idcte."' and clientPass = '".$contAnterior."'";
            $validarcont = $bd->query($querycompcontrasena);
            if($bd->rows($validarcont) <= 0){
                echo "La contraseña ingresada no coincide con la contrasena actual";
            }
            else{
                $querycambioc = "update clients set clientPass = '".$contNueva."' where clientCode = ".$idcte."";
                if($bd->query($querycambioc)){
                    echo "OK";
                }
            }


            }
        }
    }
    else if ($_POST['tipo'] == 2){
        if(!isset($_POST['correoAnterior']) || !isset($_POST['correoNuevo'])){
            echo "No omita ningun campo";
        }
        else{
            if($_POST['tipo'] == 2){
            $correoAnterior = $bd->escapestr($_POST['correoAnterior']);
            $correoNuevo = $bd->escapestr($_POST['correoNuevo']);
            $idcte = $bd->escapestr($_SESSION['clientCode']);
            $querycompcorreo = "select * from clients where clientEmail = '".$correoAnterior."' and clientCode = ".$idcte."";
            $validarcorreo = $bd->query($querycompcorreo);
            if($bd->rows($validarcorreo) <= 0){
                echo "El correo ingresado no coincide con el correo actual";
            }
            else{
                $querycorreoexiste = "select * from clients where clientEmail = '".$correoNuevo."'";
                $correoexiste = $bd->query($querycorreoexiste);
                if($bd->rows($correoexiste) > 0){
                    echo "El correo electrónico ya está en uso";
                }
                else{
                    $querycambiocorreo = "update clients set clientEmail = '".$correoNuevo."' where clientCode = ".$idcte."";
                    if($bd->query($querycambiocorreo)){
                        echo "OK";
                    }
                }
            }
            }
        }
    }
    else if($_POST['tipo'] == 3){
        $nombre = $bd->escapestr($_POST['value']);
        $queryup = "update clients set clientName = '".$nombre."'";
        if($bd->query($queryup)){
            echo $_POST['value'];
            $_SESSION['name'] = $_POST['value'];
        }
        else{
            echo "Error al actualizar la informaci&oacute;n";
        }
    }

    else if($_POST['tipo'] == 4){
        $nombre2 = $bd->escapestr($_POST['value']);
        $queryup = "update clients set clientName2 = '".$nombre2."'";
        if($bd->query($queryup)){
            echo $_POST['value'];
        }
        else{
            echo "Error al actualizar la informaci&oacute;n";
        }
    }

    else if($_POST['tipo'] == 5){
        $appaterno = $bd->escapestr($_POST['value']);
        $queryup = "update clients set clientLastName = '".$appaterno."'";
        if($bd->query($queryup)){
            echo $_POST['value'];
        }
        else{
            echo "Error al actualizar la informaci&oacute;n";
        }
    }

    else if($_POST['tipo'] == 6){
        $apmaterno = $bd->escapestr($_POST['value']);
        $queryup = "update clients set clientLastName2 = '".$apmaterno."'";
        if($bd->query($queryup)){
            echo $_POST['value'];
        }
        else{
            echo "Error al actualizar la informaci&oacute;n";
        }
    }

    else if($_POST['tipo'] == 7){
        $compania = $bd->escapestr($_POST['value']);
        $queryup = "update clients set clientCompany = '".$compania."'";
        if($bd->query($queryup)){
            echo $_POST['value'];
        }
        else{
            echo "Error al actualizar la informaci&oacute;n";
        }
    }

    else if($_POST['tipo'] == 8){
        $telefono = $bd->escapestr($_POST['value']);
        $queryup = "update clients set officePhone = '".$telefono."'";
        if($bd->query($queryup)){
            echo $_POST['value'];
        }
        else{
            echo "Error al actualizar la informaci&oacute;n";
        }
    }

}
?>
