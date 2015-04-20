<?php
session_start();
if(!isset($_SESSION['adminID']) && !isset($_SESSION['email'])){
    header("Location: ../");
    exit;
}

include '../conexion.php';
$bd = new MYSQLIFunctions();
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, state st, clients c where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID  and o.statusID = 4";
        $pedidos = $bd->query($query);
        if($bd->rows($pedidos)<=0){
            ?>
            <div class="container">
                <h2>SIN RESULTADOS</h2>
                <?php echo $query ?>
            </div>
            <?php
        }
        else{
            $arraypedidos = array();
            while($col = $bd->fassoc($pedidos)){
                $arraypedidos[$col['orderID']]['id'] = $col['orderID'];
                $arraypedidos[$col['orderID']]['clientCode'] = $col['clientCode'];
                $arraypedidos[$col['orderID']]['clientName'] = $col['clientName'];
                $arraypedidos[$col['orderID']]['orderDate'] = $col['orderDate'];
                $arraypedidos[$col['orderID']]['nombre'][] = $col['productName'];
                $arraypedidos[$col['orderID']]['unidades'][] = $col['units'];
                $arraypedidos[$col['orderID']]['presentacion'][] = $col['presentName'];
                $arraypedidos[$col['orderID']]['preciounit'][] = number_format($col['unitprice'], 2, '.', ',');
                $arraypedidos[$col['orderID']]['productostotales'] = $col['totalProducts'];
                $arraypedidos[$col['orderID']]['totalapagar'] = number_format($col['orderAmount'], 2, '.', ',');
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
 ?>
