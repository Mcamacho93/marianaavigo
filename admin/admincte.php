<?php
session_start();
if(!isset($_SESSION['adminID'])){
    header: ("Location: ../");
    exit;
}
else{
    if(!isset($_POST['tipo'])){
        echo "Error";
        exit;
    }
    else{
        include '../conexion.php';
        $bd = new MYSQLIFunctions();
        if($_POST['tipo'] == 1){
            $id = $bd->escapestr($_POST['ID']);
            $querycte = "select * from clients where clientCode = ".$id."";
            $cliente = $bd->query($querycte);
            if($bd->rows($cliente) <= 0)
                exit;
            else{
                $arraycte = array();
                while($colcte = $bd->fassoc($cliente)){
                    $arraycte[] = $colcte;
                }
                echo json_encode($arraycte);
            }
        }
        if($_POST['tipo'] == 2){
            $idcte = $bd->escapestr($_POST['Id']);
            $nombre = $bd->escapestr($_POST['Nombre']);
            $correo = $bd->escapestr($_POST['Correo']);
            $queryinfocte = "update clients set clientName = '".$nombre."', clientEmail = '".$correo."' where clientCode = ".$idcte."";
            if($bd->query($queryinfocte)){
                $queryclientes = "select * from clients order by clientName ASC";
                $clientes = $bd->query($queryclientes);
                $arrayclientes = array();
                while ($colclientes = $bd->fassoc($clientes)){
                    $arrayclientes[] = $colclientes;
                }
                echo "OK#&@";
                echo json_encode($arrayclientes);
            }
        }
        if($_POST['tipo'] == 3){
            $id = $bd->escapestr($_POST['Id']);
            $queryeliminar = "delete from clients where clientCode = ".$id."";
            if($bd->query($queryeliminar)){
                $queryclientes = "select * from clients order by clientName ASC";
                $clientes = $bd->query($queryclientes);
                $arrayclientes = array();
                while ($colclientes = $bd->fassoc($clientes)){
                    $arrayclientes[] = $colclientes;
                }
                echo "OK#&@";
                echo json_encode($arrayclientes);
            }
        }
        if($_POST['tipo'] == 4){
            $id = $bd->escapestr($_POST['ID']);
            $queryadmin = "select * from admin where adminID = ".$id."";
            $admin = $bd->query($queryadmin);
            if($bd->rows($admin) <= 0)
                exit;
            else{
                $arrayadmin = array();
                while($coladmin = $bd->fassoc($admin)){
                    $arrayadmin[] = $coladmin;
                }
                echo json_encode($arrayadmin);
            }
        }
        if($_POST['tipo'] == 5){
            $idadmin = $bd->escapestr($_POST['Id']);
            $nombre = $bd->escapestr($_POST['Nombre']);
            $correo = $bd->escapestr($_POST['Correo']);
            $telefono = $bd->escapestr($_POST['Telefono']);
            $rol = $bd->escapestr($_POST['Rol']);
            $queryinfoadmin = "update admin set adminName = '".$nombre."', adminEmail = '".$correo."', adminPhone = ".$telefono.", roleID = ".$rol." where adminID = ".$idadmin."";
            if($bd->query($queryinfoadmin)){
                $queryadmin = "select * from admin order by adminName ASC";
                $administrador = $bd->query($queryadmin);
                $arrayadmins = array();
                while ($coladmin = $bd->fassoc($administrador)){
                    $arrayadmins[] = $coladmin;
                }
                echo "OK#&@";
                echo json_encode($arrayadmins);
            }
        }
        if($_POST['tipo'] == 6){
            $id = $bd->escapestr($_POST['Id']);
            $queryeliminar = "delete from admin where adminID = ".$id."";
            if($bd->query($queryeliminar)){
                $queryadmin = "select * from admin order by adminName ASC";
                $admin = $bd->query($queryadmin);
                $arrayadmin = array();
                while ($coladmin = $bd->fassoc($admin)){
                    $arrayadmin[] = $coladmin;
                }
                echo "OK#&@";
                echo json_encode($arrayadmin);
            }
        }
    }
}

?>
