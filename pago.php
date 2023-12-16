<?php

require 'config/config.php';
require 'config/database.php';
require 'vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPago;
use MercadoPago\MercadoPagoConfig;
MercadoPagoConfig::setAccessToken("TEST-5620071132151801-110811-21bf02f64693ed4a0a12cea3a4994cd0-241483663");


$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


$lista_carrito = array();


if ($productos != null) {
    foreach ($productos as $clave=> $cantidad) {
        $sql = $con->prepare("SELECT id,nombre,precio, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1 ");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);


    }
}else{
    header("Location: index.php");
    exit;
}   


$total = 0;
foreach ($lista_carrito as $producto) {
    $_id = $producto['id'];
    $nombre = $producto['nombre'];
    $precio = $producto['precio'];
    $cantidad = $producto['cantidad'];
    $subtotal = $cantidad * $precio;
    $total +=$subtotal ;


}

$client = new PreferenceClient();
$preference = $client->create([
    "items"=> [
        [
            "title" => $nombre,
            "quantity" => 1,        
            "unit_price" => $total
        ]
    ],
]);

$preferenceId = $preference->id;

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/estilos.css">

    <title>JoseGasam-inicio</title>

    <style>
        body{
            background:linear-gradient(to right, #fbff02, #ff8001);
        
        }
    </style>
 
</head>
<body>
    <?php include 'menu.php';?>

    <main> 
        <div class="container">   
            <div class="row">
                <div class="col-6">
                    <h1>Metodos de pago</h1>
                    <br>
                    <div id="paypal-button-container"></div>
                    <div id="wallet_container"></div>
                </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>                    
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class = "text-center"><b>Lista vacia </b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $subtotal = $cantidad * $precio;
                                        $total +=$subtotal ;

                                    ?>                           
                                <tr>
                                    <td>
                                        <?php echo $nombre?>
                                    </td>

                                    <td>    
                                                         
                                        <div id="cantidad_<?php echo $_id; ?>" name="cantidad[]"><?php echo $cantidad; ?></div>
                                    </td>

                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA.number_format($subtotal, 0, ',', '.'); ?></div>
                                    </td>

                                </tr>
                                
                            
                                <?php } ?>

                                    <tr>
                                        <td colspan="5">
                                            <p class="h3 text-end" id="total">Total:<?php echo MONEDA.number_format($total, 0, ',', '.'); ?></p>
                                        </td>
                                    </tr>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>              
                    </div>
                </div>    
            </div>
        </div>    
    </main>
        <!-- Modal -->
      
</body>
      
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENTE_ID; ?>&currency=<?php echo CURRENCY; ?> "></script>      
    <script src="https://sdk.mercadopago.com/js/v2"></script>  
    <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color:  'blue',
                shape:  'pill',
                label:  'paypal'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $total; ?>
                        }
                    }]
                });
            },

            onApprove:function(data, actions){
                let URL = 'clases/captura.php'
                actions.order.capture().then(function(detalles){
                    console.log(detalles)
                    let url = 'clases/captura.php'
                    return fetch(url,{
                        method: 'post',
                        headers:{
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })


                    }).then(function(response){
                        window.location.href ="completado.php?key=" + detalles['id'];
                    })
                });
            },

            onCancel: function(data){
                alert("Pago cancelado")
                console.log(data);
            }

        }).render('#paypal-button-container');
    </script>

    <script>

        const mp = new MercadoPago('TEST-3c41cc32-2cbd-42ad-82c5-c8ee9f4173ed');
        const bricksBuilder = mp.bricks();

            
        mp.bricks().create("wallet", "wallet_container", {
        initialization: {
        preferenceId: "<?php echo $preferenceId; ?>",
        },
        });

    </script>

     <?php include 'footer.php';?> 
    
</html>