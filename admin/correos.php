<?php
class correos{
    public function pedido($asunto, $folioDelPedido, $fecha, $listapedidos, $totalapagar){
        $rec = '<html lang="es">
                <head>
                   <link href="http://fonts.googleapis.com/css?family=Montserrat|Open+Sans:300,400" rel="stylesheet" type="text/css">
                   <style>
                            *{font-size: 0;font-size: 1rem;}
                           body {width: 100%; padding: 0px; margin: 0px; background-color: #bce8f7; padding: 20px 0px; }
                           p, tr, td{font-family: "Open Sans", arial, helvetica ; font-weight: 300; text-align: left; font-size: 14px; line-height: 15px;}
                           .container{width: 600px; background-color: #fff; margin: 0 auto;}
                           .header{height: 95px; background: #e6e6e6; padding: 10px; padding-bottom: 0px;}
                           .header h1{ text-align: right; font-family: "Montserrat", tahoma, Sans-Serif; font-size: 18px; width: 390px; display: inline-block; vertical-align:-webkit-baseline-middle; padding: 0px; margin: 0px;}
                           .header img{margin-left: 10px;}
                           .content {font-family: "Open Sans", arial, helvetica; font-size: 12px; padding: 20px 20px; text-align: left;}
                           .content h2{text-align: center; font-size: 17px; font-weight: 300;}
                           .content strong{font-family: "Montserrat", tahoma, Sans-Serif; }
                           table, th, td {border: 0px; padding: 4px 5px;}
                           th{font-family: "Montserrat", tahoma, Sans-Serif; font-size: 14px;}
                           #producto{width: 380px;} #prec, #cant, #subt {width: 60px; text-align: center;}
                           .totals {text-align: right; margin-left: 320px;}
                           .totals th{text-align: right}
                           .totals tr{text-align: right}
                           .two{border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; padding: 10px 0px; margin: 10px 0px; }
                           .two p{text-align: center;}
                           #left, #right{width: 45%; display: inline-block;}
                           .two a{ background-color: #bce8f7; padding: 4px 10px; font-family: "Montserrat", tahoma, Sans-Serif; text-decoration: none; color: #000; font-size: 14px;}
                           .footer p{text-align: center; color: #b3b3b3; padding-bottom: 10px;}
                            .totalapagar{text-align: right;}
                </style>
                </head>
                <body>
                   <div class="container">
                      <div class="header">
                         <img src="../images/logocorreo.png">
                         <h1>'.$asunto.'</h1>
                      </div>
                      <div class="content">
                          <h2>Gracias por tu compra</h2>
                          <p><strong>Pedido n&uacute;mero: &nbsp;</strong>'.$folioDelPedido.'</p>
                         <p><strong>Pedido n&uacute;mero: &nbsp;</strong>'.$folioDelPedido.'</p>
                         <p><strong>Fecha del pedido: &nbsp;</strong>'.$fecha.'</p>
                         <br>
                         <p>Tu pedido ha sido registrado, espere a que tu solicitud sea atendida.<p><br>
                         <strong>Detalles del Pedido: </strong>
                         <table>
                           <tr>
                             <th id="producto">Producto</th>
                             <th id="prec">Precio</th>
                             <th id="cant">Cantidad</th>
                             <th id="subt">Subtotal</th>
                           </tr>';
                            $rec .= $listapedidos;

                           $rec .= '
                         </table>
                         <table class="totals">
                            <tr class="totalapagar">
                                <hr>
                                <th>Total</th>
                                <td>'.number_format($totalapagar, 2, '.', ',').'</td>
                            </tr>
                         </table>

                      <div class="two">
                         <div id="left">
                            <p>Si tienes alguna pregunta o comentario sobre tu pedido</p>
                            <a href="">Cont&aacute;ctanos</a>
                         </div>
                         <div id="right"><p>Tambi&eacute;n puedes verificar el estado de tu orden accesando a </p>
                            <a href="">Tu Cuenta</a>
                         </div>
                      </div>
                      </div>
                      <div class="footer">
                         <img src="../images/photo.jpg">
                         <p>&#174; Copyright  2015 CasaLaietana.com</p>
                      </div>
                   </div>
                </body>
                <html>';
        return $rec;
    }

}

?>
