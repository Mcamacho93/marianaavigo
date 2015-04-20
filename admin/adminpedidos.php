<?php
session_start();
if(!isset($_SESSION['adminID'])){
    header("Location: ../");
    exit;
}
if(!isset($_POST['tipo']))
    die("Error 404");
else{
    include '../conexion.php';
    include 'correos.php';
    require ('../configuracionmail.php');
    $bd = new MYSQLIFunctions();
    if($_POST['tipo'] == 1){
        $idorden = $bd->escapestr($_POST['ID']);
        $updatequery = "update orders set statusID = 1 where orderID = ".$idorden."";
        $querymail = "select o.*, c.clientName, c.clientEmail from orders o, clients c where c.clientCode = o.clientCode and o.orderID = ".$idorden." ";
        $mailexe = $bd->query($querymail);
        $orderarray = $bd->fassoc($mailexe);
        $email = $orderarray['clientEmail'];
        $idor = $orderarray['orderID'];
        $fechaorden = $orderarray['orderDate'];
        $totalpago = $orderarray['orderAmount'];
        $correobj = new correos();
        $selectlista = "select od.*, p.productName from orderdetails od, products p where od.productID = p.productID and orderID =  ".$idor." ";
        $conslista = $bd->query($selectlista);
        $listapedidos = "";
        $totalapagar = 0;
        while($lista = $bd->fassoc($conslista)){
            $subtotal = $lista['unitprice'] * $lista['units'];
            $listapedidos .= '<tr>
                            <td id="producto">'.$lista['productName'].'</td>
                            <td id="prec">'.number_format($lista['unitprice'], 2, '.', ',').'</td>
                            <td id="cant">'.$lista['units'].'</td>
                            <td id="subt">'.number_format($subtotal, 2, '.', ',').'</td>
                            </tr>';
                    $totalapagar += $subtotal;
        }
        $asunto = "Su pedido ha sido autorizado, favor de hacer el pago correspondiente";
        $folioDelPedido = str_pad($idor, (8 - strlen($idor)), "0", STR_PAD_LEFT);
        $contenido = $correobj->pedido($asunto, $folioDelPedido, $fechaorden, $listapedidos, $totalapagar);
        //$msg = "Su orden con folio ".$idor." realizada el ".$fechaorden." ha sido autorizada, favor de hacer el pago correspondiente de $ ".$totalpago." para realizar en envío <br> GRACIAS POR SU PREFERENCIA";
        $correo->charSet = "UTF-8";
        $correo->addAddress($email, 'Casa Laietana');
        $correo->Subject = "Pedido Autorizado";
        $correo->MsgHTML($contenido);
        $correo->send();

        if($bd->query($updatequery)){
            		$querypedidos = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, state st, clients c where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID  and o.statusID = 4";
            $pedidos = $bd->query($querypedidos);
            if($bd->rows($pedidos)<=0){
                ?>
                <div class="container">
                    <h2>SIN RESULTADOS</h2>
                    <?php echo $querypedidos ?>
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
                        if(!isset($estado)){
                        $estado = "OK#&@";
                        echo $estado;
                    }

                }
                // foreach ($arraypedidos as $key => $value) {
                // 	echo $key."=>".$value;
                // }
                echo json_encode($arraypedidos);
            }
        }
    }
    //PEDIDO A ENVIAR
    if($_POST['tipo'] == 2){  //Cuando el pedido se haya autorizado y este por enviarse
        $idorden = $bd->escapestr($_POST['ID']);
        $updatequery = "update orders set statusID = 2 where orderID = ".$idorden."";
        $querymail = "select o.*, c.clientName, c.clientEmail from orders o, clients c where c.clientCode = o.clientCode and o.orderID = ".$idorden." ";
        $mailexe = $bd->query($querymail);
        $orderarray = $bd->fassoc($mailexe);
        $email = $orderarray['clientEmail'];
        $idor = $orderarray['orderID'];
        $fechaorden = $orderarray['orderDate'];
        $totalpago = $orderarray['orderAmount'];
        $correobj = new correos();
        $selectlista = "select od.*, p.productName from orderdetails od, products p where od.productID = p.productID and orderID =  ".$idor." ";
        $conslista = $bd->query($selectlista);
        $listapedidos = "";
        $totalapagar = 0;
        while($lista = $bd->fassoc($conslista)){
            $subtotal = $lista['unitprice'] * $lista['units'];
            $listapedidos .= '<tr>
                            <td id="producto">'.$lista['productName'].'</td>
                            <td id="prec">'.number_format($lista['unitprice'], 2, '.', ',').'</td>
                            <td id="cant">'.$lista['units'].'</td>
                            <td id="subt">'.number_format($subtotal, 2, '.', ',').'</td>
                            </tr>';
                    $totalapagar += $subtotal;
        }
        $asunto = "Su ha sido enviado a la direcci&oacute;n proporcionada";
        $folioDelPedido = str_pad($idor, (8 - strlen($idor)), "0", STR_PAD_LEFT);
        $contenido = $correobj->pedido($asunto, $folioDelPedido, $fechaorden, $listapedidos, $totalapagar);
        $msg = "Su orden con folio ".$idor." realizada el ".$fechaorden." está en proceso de envío. <br> GRACIAS POR SU COMPRA";
        $correo->charSet = "UTF-8";
        $correo->addAddress($email, 'Casa Laietana');
        $correo->Subject = "Pedido Enviado";
        $correo->MsgHTML($contenido);
        $correo->send();

        if($bd->query($updatequery)){
            $querypedidos = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, state st, clients c where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID  and o.statusID <> 4";
            $pedidos = $bd->query($querypedidos);
            if($bd->rows($pedidos)<=0){
                ?>
                <div class="container">
                    <h2>SIN RESULTADOS</h2>
                    <?php echo $querypedidos ?>
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
                    if(!isset($estado)){
                        $estado = "OK#&@";
                        echo $estado;
                    }

                }
                // foreach ($arraypedidos as $key => $value) {
                // 	echo $key."=>".$value;
                // }
                echo json_encode($arraypedidos);
            }
        }
    }

    //PEDIDO RECHAZADO
     if($_POST['tipo'] == 3){
        $idorden = $bd->escapestr($_POST['ID']);
        $motivo = $_POST['Motivo'];
        $updatequery = "update orders set statusID = 3 where orderID = ".$idorden."";
        $querymail = "select o.*, c.clientName, c.clientEmail from orders o, clients c where c.clientCode = o.clientCode and o.orderID = ".$idorden." ";
        $mailexe = $bd->query($querymail);
        $orderarray = $bd->fassoc($mailexe);
        $email = $orderarray['clientEmail'];
        $idor = $orderarray['orderID'];
        $fechaorden = $orderarray['orderDate'];
        $totalpago = $orderarray['orderAmount'];
        $correobj = new correos();
        $selectlista = "select od.*, p.productName from orderdetails od, products p where od.productID = p.productID and orderID =  ".$idor." ";
        $conslista = $bd->query($selectlista);
        $listapedidos = "";
        $totalapagar = 0;
        while($lista = $bd->fassoc($conslista)){
            $subtotal = $lista['unitprice'] * $lista['units'];
            $listapedidos .= '<tr>
                            <td id="producto">'.$lista['productName'].'</td>
                            <td id="prec">'.number_format($lista['unitprice'], 2, '.', ',').'</td>
                            <td id="cant">'.$lista['units'].'</td>
                            <td id="subt">'.number_format($subtotal, 2, '.', ',').'</td>
                            </tr>';
                    $totalapagar += $subtotal;
        }
        $asunto = "Su pedido ha sido rechazado por el siguiente motivo <br>".$motivo."<br> Lamentamos los inconvenientes que esto pueda ocasionarle";
        $folioDelPedido = str_pad($idor, (8 - strlen($idor)), "0", STR_PAD_LEFT);
        $contenido = $correobj->pedido($asunto, $folioDelPedido, $fechaorden, $listapedidos, $totalapagar);
        //$msg = "Su orden con folio ".$idor." realizada el ".$fechaorden." ha sido rechazado por el siguiente motivo: <br> ".$motivo." <br> Lamentamos los inconvenientes que esto pueda causarle.";
        $correo->charSet = "UTF-8";
        $correo->addAddress($email, 'Casa Laietana');
        $correo->Subject = "Pedido Rechazado";
        $correo->MsgHTML($contenido);
        $correo->send();

        if($bd->query($updatequery)){
            $querypedidos = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, state st, clients c where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID  and o.statusID = 4";
            $pedidos = $bd->query($querypedidos);
            if($bd->rows($pedidos)<=0){
                ?>
                    <?php echo $querypedidos ?>
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
                    if(!isset($estado)){
                        $estado = "OK#&@";
                        echo $estado;
                    }

                }
                // foreach ($arraypedidos as $key => $value) {
                // 	echo $key."=>".$value;
                // }
                echo json_encode($arraypedidos);
            }

        }

    }

    if($_POST['tipo'] == "4"){
        $idorden = $bd->escapestr($_POST['ID']);
        $updatequery = "update orders set statusID = 1 where orderID = ".$idorden."";
        $querymail = "select o.*, c.clientName, c.clientEmail from orders o, clients c where c.clientCode = o.clientCode and o.orderID = ".$idorden." ";
        $mailexe = $bd->query($querymail);
        $orderarray = $bd->fassoc($mailexe);
        $email = $orderarray['clientEmail'];
        $idor = $orderarray['orderID'];
        $fechaorden = $orderarray['orderDate'];
        $totalpago = $orderarray['orderAmount'];
        $msg = "Su orden con folio ".$idor." realizada el ".$fechaorden." ha sido autorizada, favor de hacer el pago correspondiente de $ ".$totalpago." para realizar en envío <br> GRACIAS POR SU PREFERENCIA";
        $correo->charSet = "UTF-8";
        $correo->addAddress($email, 'Casa Laietana');
        $correo->Subject = "Pedido Autorizado";
        $correo->MsgHTML($msg);
        $correo->send();

        if($bd->query($updatequery)){
            $querypedidos = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, state st, clients c where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID  and o.statusID <> 4";
            $pedidos = $bd->query($querypedidos);
            if($bd->rows($pedidos)<=0){
                ?>
                <div class="container">
                    <h2>SIN RESULTADOS</h2>
                    <?php echo $querypedidos ?>
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
                    if(!isset($estado)){
                        $estado = "OK#&@";
                        echo $estado;
                    }

                }
                // foreach ($arraypedidos as $key => $value) {
                // 	echo $key."=>".$value;
                // }
                echo json_encode($arraypedidos);
            }
        }
    }

    if($_POST['tipo'] == "5"){
        $idorden = $bd->escapestr($_POST['ID']);
        $motivo = $_POST['Motivo'];
        $updatequery = "update orders set statusID = 3 where orderID = ".$idorden."";
        $querymail = "select o.*, c.clientName, c.clientEmail from orders o, clients c where c.clientCode = o.clientCode and o.orderID = ".$idorden." ";
        $mailexe = $bd->query($querymail);
        $orderarray = $bd->fassoc($mailexe);
        $email = $orderarray['clientEmail'];
        $idor = $orderarray['orderID'];
        $fechaorden = $orderarray['orderDate'];
        $totalpago = $orderarray['orderAmount'];
        $msg = "Su orden con folio ".$idor." realizada el ".$fechaorden." ha sido rechazado por el siguiente motivo: <br> ".$motivo." <br> Lamentamos los inconvenientes que esto pueda causarle.";
        $correo->charSet = "UTF-8";
        $correo->addAddress($email, 'Casa Laietana');
        $correo->Subject = "Pedido Rechazado";
        $correo->MsgHTML($msg);
        $correo->send();

        if($bd->query($updatequery)){
            $querypedidos = "select o.*, od.*, p.productName, s.statusName, pr.presentName, c.clientName, st.stateName from orders o, orderdetails od, products p, orderstatus s, presentation pr, state st, clients c where o.orderID = od.orderID and od.productID = p.productID and o.statusID = s.statusID and p.presentID = pr.presentID and c.clientCode = o.clientCode and st.stateID = o.stateID  and o.statusID = 4";
            $pedidos = $bd->query($querypedidos);
            if($bd->rows($pedidos)<=0){
                ?>
                    <?php echo "SIN RESULTADOS" ?>
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
                    if(!isset($estado)){
                        $estado = "OK#&@";
                        echo $estado;
                    }

                }
                // foreach ($arraypedidos as $key => $value) {
                // 	echo $key."=>".$value;
                // }
                echo json_encode($arraypedidos);
            }

        }
    }
}

?>
