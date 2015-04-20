<?php
session_start();
if(!isset($_SESSION['adminID']) && !isset($_SESSION['email'])){
    header("Location: ../");
    exit;
}

if(!isset($_POST['tipo'])){
    header("Location: index.php");
    exit;
}

include '../conexion.php';
$bd = new MYSQLIFunctions();
if($_POST['tipo'] == 1){
    $id = $bd->escapestr($_POST['ID']);
    if($id == "0"){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by o.orderID ASC";
    }
    else{
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID = ".$id." order by o.orderID ASC";
    }

            $pedidos = $bd->query($query);
            if($bd->rows($pedidos)<=0){
                echo "NO";
            }
            else{
                $arraypedidos = array();
                echo "OK#&@";
                while($col = $bd->fassoc($pedidos)){
                    $arraypedidos[$col['orderID']]['id'] = $col['orderID'];
                    $arraypedidos[$col['orderID']]['clientCode'] = $col['clientCode'];
                    $arraypedidos[$col['orderID']]['clientName'] = $col['clientName'];
                    $arraypedidos[$col['orderID']]['orderDate'] = $col['orderDate'];
                    $arraypedidos[$col['orderID']]['nombre'][] = $col['productName'];
                    $arraypedidos[$col['orderID']]['unidades'][] = $col['units'];
                    $arraypedidos[$col['orderID']]['presentacion'][] = $col['presentName'];
                    $arraypedidos[$col['orderID']]['preciounit'][] = $col['unitprice'];
                    $arraypedidos[$col['orderID']]['productostotales'] = $col['totalProducts'];
                    $arraypedidos[$col['orderID']]['totalapagar'] = $col['orderAmount'];
                    $arraypedidos[$col['orderID']]['estado'] = $col['statusName'];
                    $arraypedidos[$col['orderID']]['colonia'] = $col['orderColony'];
                    $arraypedidos[$col['orderID']]['calle'] = $col['orderStreet'];
                    $arraypedidos[$col['orderID']]['numero'] = $col['orderNumber'];
                    $arraypedidos[$col['orderID']]['ciudad'] = $col['orderCity'];
                    $arraypedidos[$col['orderID']]['estadoorden'] = $col['stateName'];
                    $arraypedidos[$col['orderID']]['codigopostal'] = $col['orderZip'];
                    $arraypedidos[$col['orderID']]['telefono'] = $col['orderPhone'];

                }
                // foreach ($arraypedidos as $key => $value) {
                // 	echo $key."=>".$value;
                // }
                echo json_encode($arraypedidos);
            }
}

if($_POST['tipo'] != 1){
    if($_POST['tipo'] == 2){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by o.orderID ASC";
    }

    if($_POST['tipo'] == 3){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by c.clientName ASC";
    }

    if($_POST['tipo'] == 4){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by o.orderDate ASC";
    }

    if($_POST['tipo'] == 5){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by o.orderDate ASC";
    }

    if($_POST['tipo'] == 6){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by o.totalProducts ASC";
    }

    if($_POST['tipo'] == 7){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by o.orderAmount ASC";
    }

    if($_POST['tipo'] == 8){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by o.orderColony ASC";
    }

    if($_POST['tipo'] == 9){
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, clients c, state st  where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID and o.statusID <> 4 order by s.statusName ASC";
    }

    $pedidos = $bd->query($query);
            if($bd->rows($pedidos)<=0){
                echo "NO";
            }
            else{
                $arraypedidos = array();
                echo "OK#&@";
                $i = 0;
                while($col = $bd->fassoc($pedidos)){
                    $arraypedidos[$i]['id'] = $col['orderID'];
                    $arraypedidos[$i]['clientCode'] = $col['clientCode'];
                    $arraypedidos[$i]['clientName'] = $col['clientName'];
                    $arraypedidos[$i]['orderDate'] = $col['orderDate'];
                    $arraypedidos[$i]['nombre'][] = $col['productName'];
                    $arraypedidos[$i]['unidades'][] = $col['units'];
                    $arraypedidos[$i]['presentacion'][] = $col['presentName'];
                    $arraypedidos[$i]['preciounit'][] = $col['unitprice'];
                    $arraypedidos[$i]['productostotales'] = $col['totalProducts'];
                    $arraypedidos[$i]['totalapagar'] = $col['orderAmount'];
                    $arraypedidos[$i]['estado'] = $col['statusName'];
                    $arraypedidos[$i]['colonia'] = $col['orderColony'];
                    $arraypedidos[$i]['calle'] = $col['orderStreet'];
                    $arraypedidos[$i]['numero'] = $col['orderNumber'];
                    $arraypedidos[$i]['ciudad'] = $col['orderCity'];
                    $arraypedidos[$i]['estadoorden'] = $col['stateName'];
                    $arraypedidos[$i]['codigopostal'] = $col['orderZip'];
                    $arraypedidos[$i]['telefono'] = $col['orderPhone'];
                    $i++;

                }
                // foreach ($arraypedidos as $key => $value) {
                // 	echo $key."=>".$value;
                // }
                echo json_encode($arraypedidos);
            }
}


 ?>
