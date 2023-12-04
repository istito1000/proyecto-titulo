<?php
// Incluye la SDK de MercadoPago
require 'vendor/autoload.php'; // Ajusta la ruta correcta hacia autoload.php

// Configura el Access Token de MercadoPago
MercadoPago\SDK::setAccessToken("TU_ACCESS_TOKEN");

// Crea la preferencia de pago
$preference = new MercadoPago\Preference();

// Crea un ítem para la compra
$item = new MercadoPago\Item();
$item->title = "Producto Ejemplo";
$item->quantity = 1;
$item->unit_price = 100; // El precio en la moneda especificada por MercadoPago
$item->currency_id = "USD"; // La moneda en la que se realiza la transacción

// Agrega el ítem a la preferencia
$preference->items = array($item);

// Guarda la preferencia
$preference->save();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con MercadoPago</title>
</head>
<body>

<!-- Botón de pago -->
<a href="<?php echo $preference->sandbox_init_point; ?>" name="MP-Checkout" class="btn btn-primary">Pagar con MercadoPago</a>
<script src="https://www.mercadopago.com/v2/security.js" view="home"></script>

</body>
</html>
