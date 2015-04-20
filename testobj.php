<?php
//echo $_POST['OBJ'];
foreach($_POST['OBJ'] as $index => $valor){
  echo "INDEX: ".$index."=>".$valor."\n";
}
echo "NOMBRE: ".$_POST['Nombre'];
?>
