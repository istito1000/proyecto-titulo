<?php
require 'vendor/autoload.php';
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPago;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken("TEST-5620071132151801-110811-21bf02f64693ed4a0a12cea3a4994cd0-241483663");

$client = new PreferenceClient();
$preference = $client->create([
    "items"=> [
        [
            "title" => "Producto 1",
            "quantity" => 1,
            "currency_id" => "CLP",
            "unit_price" => 13900
        ]
    ],
    "back_urls" => [
        "success" => "http://localhost/definitivo/captura.php",
        "failure" => "http://localhost/definitivo/fallo.php",
    ],
    "auto_return" => "approved",
    "binary_mode" => true
]);

$preferenceId = $preference->id;

 // Aquí deberías acceder directamente al atributo 'id' que contiene el ID de la preferencia        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoseGasam</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
    <div id="wallet_container"></div>


</body>
<script>
    const mp = new MercadoPago('TEST-3c41cc32-2cbd-42ad-82c5-c8ee9f4173ed');
    const bricksBuilder = mp.bricks();

        
    mp.bricks().create("wallet", "wallet_container", {
    initialization: {
        preferenceId: "<?php echo $preferenceId; ?>",
    },
    customization: {
       checkout: {
           theme: {
               elementsColor: "#4287F5",
               headerColor: "#4287F5",
           },
       },
   },
});

</script>
</html>

