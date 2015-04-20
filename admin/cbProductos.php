<?php
//Archivo en el que se realizan modificaciones a la tabla productos(cambios, bajas)
session_start(); //Iniciamos la sesión
if(!isset($_SESSION['adminID'])){ //Validamos que sea sesión de administrador
    header("Location: ../"); //en caso de no ser admin lo regresamos a la página de inicio
    exit; //y finalizamos la ejecución
}
if(!isset($_POST['Tipo'])){ //Se valida que la petición contenga parámetros con una variable que contengan ambas funciones
    header("Location: index.php"); //como sabemos que la sesión es de administrador solo regresamos al panel de administrador en caso de no recibir parámetros
    exit; //y finalizamos la ejecución
}
else{ //en este punto sabemos que si se existen parámetros.
    include '../conexion.php'; //se incluye el archivo de conexión
    $bd = new MYSQLIFunctions(); //se crea una instancia de la clase del archivo conexion.php
    if($_POST['Tipo'] == "1"){//Aquí debido a que ya comprobamos que existe la variable "Tipo" solo queda asignarla a la condición, 1 es para modificar, 2 es para borrar
        //Escapamos todos los caracteres para evitar inyecciones SQL, para esto se hace uso de mysqli_real_escape_string, solo que asignado a otro método de la clase conexión, llamado "escapestr"
        $Id = $bd->escapestr($_POST['ID']);
        $Nombre = $bd->escapestr($_POST['Nombre']);
        $Descripcion = $bd->escapestr($_POST['Descripcion']);
        $Precio = $bd->escapestr($_POST['Precio']);
        $Presentacion = $bd->escapestr($_POST['Presentacion']);
        $Categoria = $bd->escapestr($_POST['Categoria']);
        $Marca = $bd->escapestr($_POST['Marca']);
        $Existencia = $bd->escapestr($_POST['Existencia']);
        //Se crea la consulta, sin olvidar el WHERE
        $updateprod = "update products set productName = '".$Nombre."', productDesc = '".$Descripcion."', price = '".$Precio."', presentID = ".$Presentacion.", categoryID = ".$Categoria.", brandID = ".$Marca.", existencia = ".$Existencia." where productID = ".$Id." ";
       //Se valida que el producto no exista en la base de datos
        $validarproducto = "select * from products where productName = '".$Nombre."' and price = ".$Precio." and presentID = ".$Presentacion." and categoryID = ".$Categoria." and brandID = ".$Marca." ";
        $valido = $bd->query($validarproducto);
        if($bd->rows($valido) > 0){
            echo "error";
            exit;
        }
        else{
            if($bd->query($updateprod)){ //Si se actualiza la información devolveremos un json con los datos de los productos actualizado para cargarlos dinámicamente
                $queryproducto = "select p.*, pr.presentName, c.categoryName, b.brandName from products p, presentation pr, category c, brand b where p.presentID = pr.presentID and c.categoryID = p.categoryID and b.brandID = p.brandID order by productName ASC";
                $productos = $bd->query($queryproducto);
                $jsonproductos = array();
                echo "OK#&@";
                $i = 0;
                while($col = $bd->fassoc($productos)){

                    $jsonproductos[$i]['id'] = $col['productID'];
                    $jsonproductos[$i]['productName'] = $col['productName'];
                    $jsonproductos[$i]['productDesc'] = $col['productDesc'];
                    $jsonproductos[$i]['price'] = $col['price'];
                    $jsonproductos[$i]['presentID'] = $col['presentID'];
                    $jsonproductos[$i]['categoryID'] = $col['categoryID'];
                    $jsonproductos[$i]['brandID'] = $col['brandID'];
                    $jsonproductos[$i]['existencia'] = $col['existencia'];
                    $jsonproductos[$i]['img'] = $col['img'];
                    $jsonproductos[$i]['presentName'] = $col['presentName'];
                    $jsonproductos[$i]['categoryName'] = $col['categoryName'];
                    $jsonproductos[$i]['brandName'] = $col['brandName'];
                    $i++;
                }
                echo json_encode($jsonproductos);
            }
        }
    }

    if($_POST['Tipo'] == "2"){//Aquí debido a que ya comprobamos que existe la variable "Tipo" solo queda asignarla a la condición, 1 es para modificar, 2 es para borrar
        //Escapamos todos los caracteres para evitar inyecciones SQL, para esto se hace uso de mysqli_real_escape_string, solo que asignado a otro método de la clase conexión, llamado "escapestr"
        $Id = $bd->escapestr($_POST['ID']);
        //Se crea la consulta, sin olvidar el WHERE
        $deleteprod = "delete from products where productID = ".$Id." ";
        if($bd->query($deleteprod)){ //Si se actualiza la información devolveremos un json con los datos de los productos actualizado para cargarlos dinámicamente
            $queryproducto = "select p.*, pr.presentName, c.categoryName, b.brandName from products p, presentation pr, category c, brand b where p.presentID = pr.presentID and c.categoryID = p.categoryID and b.brandID = p.brandID order by productName ASC";
            $productos = $bd->query($queryproducto);
            $jsonproductos = array();
            echo "OK#&@";
            $i = 0;
            while($col = $bd->fassoc($productos)){
                $jsonproductos[$i]['id'] = $col['productID'];
                $jsonproductos[$i]['productName'] = $col['productName'];
                $jsonproductos[$i]['productDesc'] = $col['productDesc'];
                $jsonproductos[$i]['price'] = $col['price'];
                $jsonproductos[$i]['presentID'] = $col['presentID'];
                $jsonproductos[$i]['categoryID'] = $col['categoryID'];
                $jsonproductos[$i]['brandID'] = $col['brandID'];
                $jsonproductos[$i]['existencia'] = $col['existencia'];
                $jsonproductos[$i]['img'] = $col['img'];
                $jsonproductos[$i]['presentName'] = $col['presentName'];
                $jsonproductos[$i]['categoryName'] = $col['categoryName'];
                $jsonproductos[$i]['brandName'] = $col['brandName'];
                $i++;
            }
            echo json_encode($jsonproductos);
        }
    }
}



?>
