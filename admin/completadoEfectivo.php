<?php

require 'config/config.php';
require 'config/database.php';
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
<br>
    <main> 
        <div class="container">

            <div class="row">
                <div class="col">
                </div>
            </div> 
            <div class="row">
                <div class="col">
                    <table class="table ">
                        <tbody>
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>Total del producto</th>
                                </tr>
                            </thead>
                                <tr>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class = "text-center"><b>Lista vacia </b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $longitud = 10; // Puedes ajustar la longitud según tus necesidades
                                        $bytes_aleatorios = random_bytes($longitud);
                                        $codigo_aleatorio = bin2hex($bytes_aleatorios);
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $subtotal = $cantidad * $precio;
                                        $total +=$subtotal ;
                                    ?>                           
                                <tr>
                                    <td>
                                    <div id="cantidad_<?php echo $_id; ?>" name="cantidad[]"><?php echo $cantidad; ?></div>
                                        
                                    </td>

                                    <td>    
                                        <?php echo $nombre?>              
                                    </td>
                                        
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA .$subtotal; ?></div>
                                    </td>

                                </tr>
                                
                            
                                <?php } ?>
                                </tr>

                        </tbody>
                    </table>

                    <thead>
                            <tr>
                                <b>Comprobante de compra:</b><?php echo $codigo_aleatorio;?><br>
                                <b>Fecha:</b><?php date_default_timezone_set('America/Santiago');echo "". date("d/m/Y");?><br>
                                <b>Hora:</b><?php echo "". date("h:i:sa");?><br>
                                <b>Total:</b><?php echo MONEDA.$total;?><br>
                                <b>Tiempo estimado de entrega: 15-20 minutos</b><br>
                            </tr>
                        </thead>
                </div>
                <?php } ?>
        </div>
    </main>
    
</body>
</html>