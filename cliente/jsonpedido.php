<?php
session_start();
include '../conexion.php';
$bd = new MYSQLIFunctions();
        $query = "select o.*, od.*, p.productName, s.statusName, pr.presentName from orders o, orderdetails od, products p, orderstatus s, presentation pr where clientCode = ".$_SESSION['clientCode']." and o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID";
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
                $arraypedidos[$col['orderID']]['nombre'][] = $col['productName'];
                $arraypedidos[$col['orderID']]['unidades'][] = $col['units'];
                $arraypedidos[$col['orderID']]['presentacion'][] = $col['presentName'];
                $arraypedidos[$col['orderID']]['preciounit'][] = number_format($col['unitprice'], 2, '.', ',');
                $arraypedidos[$col['orderID']]['productostotales'] = $col['totalProducts'];
                $arraypedidos[$col['orderID']]['totalapagar'] = number_format($col['orderAmount'], 2, '.', ',');
                $arraypedidos[$col['orderID']]['estado'] = $col['statusName'];

            }
            // foreach ($arraypedidos as $key => $value) {
            // 	echo $key."=>".$value;
            // }
            echo json_encode($arraypedidos);

        }
 ?>
