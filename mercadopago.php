<?php
// Importar la SDK de MercadoPago
require __DIR__ . '/vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\SDK;
use MercadoPago\Item;

$access_token='';

// Create a new MercadoPago client
MercadoPagoConfig::setAccessToken($access_token);
$preference=new PreferenceClient();
$preference->$back_url = array(
    "success" => "http://localhost/definitivo/captura.php",
    "failure" => "http://localhost/definitivo/fallo.php",
);

$productos=[];
$item = new Item();
$item->title = "Producto 1";
$item->quantity = 1;
$item->unit_price = 1000;
$item->currency_id = "CLP";
array_push($productos,$item);

$preference ->items = $productos; 
$preference->save();



$preference->auto_return = "approved";
$preference->binary_mode = true;



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h3>MercadoPago</h3>
    <div class="checkout-btn"></div>
    <script>
        const mp = new MercadoPago("TEST-5620071132151801-110811-21bf02f64693ed4a0a12cea3a4994cd0",{
            locale: 'es-CL'
        });

        mp.checkout({
            preference: {
                id: "<?php echo $preference->id; ?>"
            },
            render: {
                container: ".checkout-btn",
                label:'pagar con mp'
            }
        })
    </script>
</body>
</html>