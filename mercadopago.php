<?php
// Importar la SDK de MercadoPago
require __DIR__ .  '/vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

// Resto de tu código...




MercadoPago\SDK::setAccessToken("TEST-27191301-4365146-2535599");

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->title = "Producto 1";
$item->quantity = 1;
$item->unit_price = 1000;
$item->currency_id = "CLP";

$preference->items = array($item);


$preference->save();
$preference->back_url = array(
    "success" => "http://localhost/definitivo/captura.php",
    "failure" => "http://localhost/definitivo/fallo.php",
);

$preference->auto_return = "approved";
$preference->binary_mode = true;

$preference->save();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>