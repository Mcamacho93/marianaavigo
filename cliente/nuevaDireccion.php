<?php
session_start();
if(!isset($_SESSION['clientCode']))
    exit();
if(!isset($_POST['Descripcion'])){
    echo "Favor de llenar todos los campos";
    exit;
}
if(!isset($_POST['Tipo'])){
    header("Location: index.php");
    exit;
}
else{
    include '../conexion.php';
    $db = new MYSQLIFunctions();
    if($_POST['Tipo'] == "1"){
        $codigocte = $db->escapestr($_SESSION['clientCode']);
        $descripcion = $db->escapestr($_POST['Descripcion']);
        $calleno = $db->escapestr($_POST['Calle']);
        $numero = $db->escapestr($_POST['Numero']);
        $colonia = $db->escapestr($_POST['Colonia']);
        $delegacion = $db->escapestr($_POST['Delegacion']);
        $estado = $db->escapestr($_POST['Estado']);
        $ciudad = $db->escapestr($_POST['Ciudad']);
        $codigopostal = $db->escapestr($_POST['CodigoPostal']);
        $RFC = $db->escapestr($_POST['RFC']);
        $telefono = $db->escapestr($_POST['Tel']);
        $telefono2 = $db->escapestr($_POST['TelAlterno']);
        $email = $db->escapestr($_POST['Email']);
        $tipo = $db->escapestr($_POST['Tipo']);
        $query = "insert into address values ('', ".$codigocte.", '".$descripcion."', '".$calleno."', ".$numero.", '".$colonia."', '".$delegacion."', ".$estado.", '".$ciudad."', '".$codigopostal."', '".$RFC."', '".$telefono."', '".$telefono2."', '".$email."', ".$tipo.")";
        if($db->query($query)){
            $querydireccion = $db->escapestr("select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$codigocte." and idType=".$tipo."");
            $direccion = $db->query($querydireccion);
            $direccionarray = array();
            echo "OK$%&";
            while($col = $db->fassoc($direccion)){
                $direccionarray[] = $col;
            }
            echo json_encode($direccionarray);
        }
    }
    if($_POST['Tipo'] == "2"){
        $codigocte = $db->escapestr($_SESSION['clientCode']);
        $descripcion = $db->escapestr($_POST['Descripcion']);
        $calleno = $db->escapestr($_POST['Calle']);
        $numero = $db->escapestr($_POST['Numero']);
        $colonia = $db->escapestr($_POST['Colonia']);
        $delegacion = $db->escapestr($_POST['Delegacion']);
        $estado = $db->escapestr($_POST['Estado']);
        $ciudad = $db->escapestr($_POST['Ciudad']);
        $codigopostal = $db->escapestr($_POST['CodigoPostal']);
        $telefono = $db->escapestr($_POST['Tel']);
        $telefono2 = $db->escapestr($_POST['TelAlterno']);
        $email = $db->escapestr($_POST['Email']);
        $tipo = $db->escapestr($_POST['Tipo']);
        $query = "insert into address values ('', ".$codigocte.", '".$descripcion."', '".$calleno."', ".$numero.", '".$colonia."', '".$delegacion."', ".$estado.", '".$ciudad."', '".$codigopostal."', '', '".$telefono."', '".$telefono2."', '".$email."', ".$tipo.")";
        if($db->query($query)){
            $querydireccion = $db->escapestr("select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$codigocte." and idType=".$tipo."");
            $direccion = $db->query($querydireccion);
            $direccionarray = array();
            echo "OK$%&";
            while($col = $db->fassoc($direccion)){
                $direccionarray[] = $col;
            }
            echo json_encode($direccionarray);
        }
    }

    if($_POST['Tipo'] == "3"){
        $codigocte = $db->escapestr($_SESSION['clientCode']);
        $descripcion = $db->escapestr($_POST['Descripcion']);
        $calleno = $db->escapestr($_POST['Calle']);
        $numero = $db->escapestr($_POST['Numero']);
        $colonia = $db->escapestr($_POST['Colonia']);
        $delegacion = $db->escapestr($_POST['Delegacion']);
        $estado = $db->escapestr($_POST['Estado']);
        $ciudad = $db->escapestr($_POST['Ciudad']);
        $codigopostal = $db->escapestr($_POST['CodigoPostal']);
        $telefono = $db->escapestr($_POST['Tel']);
        $telefono2 = $db->escapestr($_POST['TelAlterno']);
        $email = $db->escapestr($_POST['Email']);
        $tipo = $db->escapestr($_POST['Tipo']);
        $query = "insert into address values ('', ".$codigocte.", '".$descripcion."', '".$calleno."', ".$numero.", '".$colonia."', '".$delegacion."', ".$estado.", '".$ciudad."', '".$codigopostal."', '', '".$telefono."', '".$telefono2."', '".$email."', 1)";
        $query2 = "insert into address values ('', ".$codigocte.", '".$descripcion."', '".$calleno."', ".$numero.", '".$colonia."', '".$delegacion."', ".$estado.", '".$ciudad."', '".$codigopostal."', '', '".$telefono."', '".$telefono2."', '".$email."', 2)";
        if($db->query($query)){
            if($db->query($query2)){
                 $querydireccion = $db->escapestr("select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$codigocte." and idType= 1 ");
                 $direccion = $db->query($querydireccion);
                 $querydireccionEn = $db->escapestr("select a.*, s.stateName from address a, state s where a.stateID = s.stateID and clientCode = ".$codigocte." and idType=2 ");
                 $direccionEn = $db->query($querydireccionEn);
                 $direccionarray = array();
                 $direccionEnArray = array();
                 echo "OK$%&";
                 while($col = $db->fassoc($direccion)){
                    $direccionarray[] = $col;
                 }
                 while($col2 = $db->fassoc($direccionEn)){
                    $direccionEnArray[] = $col2;
                 }
                 echo json_encode($direccionarray);
                 echo "$%&";
                 echo json_encode($direccionEnArray);
            }
        }
    }
}

 ?>
