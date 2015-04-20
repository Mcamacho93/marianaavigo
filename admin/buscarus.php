<?php
session_start();
if(!isset($_SESSION['adminID'])){
    header("Location: ../");
    exit;
}
if(!isset($_POST['tipo'])){
    header("Location: index.php");
    exit;
}
if($_POST['tipo'] == 1){
    include '../conexion.php';
    $bd = new MYSQLIFunctions();
    $cadena = $bd->escapestr($_POST['Cadena']);
    if($cadena == ""){
        $querybusqueda = "select * from clients order by clientName ASC";
        $busqueda = $bd->query($querybusqueda);
        if($bd->rows($busqueda) <= 0){
            echo "Sin resultados";
        }
        else{
            $json = array();
            $i = 0;
            while($res = $bd->fassoc($busqueda)){
                $json[$i]['id'] = $res['clientCode'];
                $json[$i]['nombre'] = $res['clientName'];
                $json[$i]['email'] = $res['clientEmail'];
                $i++;
            }
            echo json_encode($json);
        }
    }
    else{
        $querybusqueda = "select * from clients where clientName like '%".$cadena."%' order by clientName ASC";
        $busqueda = $bd->query($querybusqueda);
        if($bd->rows($busqueda) <= 0){
            echo "Sin resultados";
        }
        else{
            $json = array();
            $i = 0;
            while($res = $bd->fassoc($busqueda)){
                $json[$i]['id'] = $res['clientCode'];
                $json[$i]['nombre'] = $res['clientName'];
                $json[$i]['email'] = $res['clientEmail'];
                $i++;
            }
            echo json_encode($json);
        }
    }
}

//Busqueda Administradores
if($_POST['tipo'] == 2){
    include '../conexion.php';
    $bd = new MYSQLIFunctions();
    $cadena = $bd->escapestr($_POST['Cadena']);
    if($cadena == ""){
        $querybusqueda = "select * from admin order by adminName ASC";
        $busqueda = $bd->query($querybusqueda);
        if($bd->rows($busqueda) <= 0){
            echo "Sin resultados";
        }
        else{
            $json = array();
            $i = 0;
            while($res = $bd->fassoc($busqueda)){
                $json[$i]['id'] = $res['adminID'];
                $json[$i]['nombre'] = $res['adminName'];
                $json[$i]['email'] = $res['adminEmail'];
                $i++;
            }
            echo json_encode($json);
        }
    }
    else{
        $querybusqueda = "select * from admin where adminName like '%".$cadena."%' order by adminName ASC";
        $busqueda = $bd->query($querybusqueda);
        if($bd->rows($busqueda) <= 0){
            echo "Sin resultados";
        }
        else{
            $json = array();
            $i = 0;
            while($res = $bd->fassoc($busqueda)){
                $json[$i]['id'] = $res['adminID'];
                $json[$i]['nombre'] = $res['adminName'];
                $json[$i]['email'] = $res['adminEmail'];
                $i++;
            }
            echo json_encode($json);
        }
    }
}

?>
