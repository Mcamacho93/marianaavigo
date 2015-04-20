<?php
session_start();
if(!isset($_SESSION['adminID'])){
   header("Location: ../");
   exit;
}
if(!isset($_POST['ID'])){
   header("Location: index.php");
   exit;
}
else{
   include '../conexion.php';
   $bd = new MYSQLIFunctions();
   $id = $bd->escapestr($_POST['ID']);
   $queryorden = "select o.*, s.stateName from orders o, state s where o.stateID = s.stateID and o.orderID = ".$id." ";
   $orden = $bd->query($queryorden);
   if($bd->rows($orden) <= 0){
      echo "error";
      exit;
   }
   else{
      echo "OK#&@";
      $jsonorden = array();
      while($colorden = $bd->fassoc($orden)){
         $jsonorden = $colorden;
      }
      echo json_encode($jsonorden);
   }
}

?>
