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
    $qadmin = "select * from admin order by adminName ASC limit 0,10";

}
else{
    $qadmin = "select * from admin order by adminName ASC limit ".$pactual.", ".$porpagina."";
}
$admins = $bd->query($qadmin);
$jsonadmin = array();
$i = 0;
while($coladmin = $bd->fassoc($admins)){

    $jsonadmin[$i]['id'] = $coladmin['adminID'];
    $jsonadmin[$i]['nombre'] = $coladmin['adminName'];
    $jsonadmin[$i]['email'] = $coladmin['adminEmail'];
    $i++;
}
echo json_encode($jsonclientes);




 ?>
