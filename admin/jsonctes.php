<?php
session_start();
if(!isset($_SESSION['adminID'])){
    header("Location: ../");
    exit;
}
if(!isset($_POST['Actual'])){
    header("Location: index.php");
    exit;
}
include '../conexion.php';
$bd = new MYSQLIFunctions();
$porpagina = 10;
$pagactual = $_POST['Actual'];
$actual = $porpagina * $pagactual;
$pactual = $actual/2;
if($pactual == 5)
    $pactual = 0;
if($pactual == 0){
    $qclientes = "select * from clients order by clientName ASC limit 0,10";

}
else{
    $qclientes = "select * from clients order by clientName ASC limit ".$pactual.", ".$porpagina."";
}
$clientes = $bd->query($qclientes);
$jsonclientes = array();
$i = 0;
while($colclientes = $bd->fassoc($clientes)){

    $jsonclientes[$i]['id'] = $colclientes['clientCode'];
    $jsonclientes[$i]['nombre'] = $colclientes['clientName'];
    $jsonclientes[$i]['email'] = $colclientes['clientEmail'];
    $i++;
}
echo json_encode($jsonclientes);




 ?>
