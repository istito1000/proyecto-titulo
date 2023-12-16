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
                    <div>
                        <a class="btn btn-primary" style="width: 100%;" href="completadoEfectivo.php">Pago con tarjeta al recibir</a>
                    </div>
                    <br>
                    <div>
                        <a class="btn btn-success" style="width: 100%;" href="completadoEfectivo.php">Pago en efectivo al recibir</a>
                    </div>
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
     <?php include 'footer.php';?>
    
    
</html>