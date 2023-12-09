<?php
require __DIR__ . '/vendor/autoload.php';

use MercadoPago\Client\Preference\MercadoPagoItem;
use MercadoPago\MercadoPagoPreference;
use MercadoPago\SDK;
use MercadoPago\MercadoPagoPayer;

          // Cria um objeto de preferência
$preference = new MercadoPagoPreference();

$item = new MercadoPagoItem();
// Set item details
$preference->items = array($item);

$payer = new MercadoPagoPayer();
// Set payer details
$preference->payer = $payer;

$back_urls = array(
    'success' => 'https://www.success.com',
    'failure' => 'http://www.failure.com',
    'pending' => 'http://www.pending.com'
);
$preference->back_urls = $back_urls;


$preference->notification_url = 'https://www.your-site.com/ipn';
$preference->statement_descriptor = 'MEUNEGOCIO';
$preference->external_reference = 'Reference_1234';
$preference->expires = true;
$preference->expiration_date_from = '2016-02-01T12:00:00.000-04:00';
$preference->expiration_date_to = '2016-02-28T12:00:00.000-04:00';
    
$preference->save();

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

