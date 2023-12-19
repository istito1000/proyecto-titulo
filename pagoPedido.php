<?php
require 'config/config.php';
require 'config/database.php';
require 'vendor/autoload.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE id=? AND activo=1 ");
        $sql->execute([$clave]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);
        $producto['cantidad'] = $cantidad;
        $lista_carrito[] = $producto;
    }
} else {
    header("Location: index.php");
    exit;
}

// Después de calcular el total
$total = 0;
foreach ($lista_carrito as $producto) {
    $precio = $producto['precio'];
    $cantidad = $producto['cantidad'];
    $subtotal = $cantidad * $precio;
    $total += $subtotal;
}

// Obtener datos del usuario
$id_cliente = $_SESSION['user_cliente'];  // Asumo que 'user_id' es el campo que almacena el ID del cliente en la sesión

try {
    // Obtener el correo del cliente desde la base de datos
    $sqlCorreo = $con->prepare("SELECT correo FROM clientes WHERE id=?");
    $sqlCorreo->execute([$id_cliente]);
    $cliente = $sqlCorreo->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $correo = $cliente['correo'];
        $id_transaccion = generarIdTransaccion();
        date_default_timezone_set('America/Santiago');
        $fecha = date('Y-m-d H:i:s');
        $status = 'Pendiente';
        $metodo_pago = 'Efectivo o tarjeta';  // Ajusta según tu lógica

        // Insertar datos en la tabla compra
        $sqlCompra = $con->prepare("INSERT INTO compra (id_transaccion, fecha, status, correo, id_cliente, total, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sqlCompra->execute([$id_transaccion, $fecha, $status, $correo, $id_cliente, $total, $metodo_pago]);

        // Obtener el ID de la compra recién insertada
        $id_compra = $con->lastInsertId();

        // Iterar sobre los productos y agregar detalles a la tabla detalle_compra
        foreach ($lista_carrito as $producto) {
            $id_producto = $producto['id'];
            $nombre = $producto['nombre'];
            $precio_producto = $producto['precio'];
            $cantidad_producto = $producto['cantidad'];

            // Calcular ganancia (ajusta según tus necesidades)
            $ganancia = 3000*$cantidad_producto; // Por ejemplo, una ganancia del 10%

            // Calcular ganancia total

            $ganancia_total_total = $ganancia ;

            // Insertar datos en la tabla detalle_compra
            $sqlDetalleCompra = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad, ganancia, ganancia_total) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sqlDetalleCompra->execute([$id_compra, $id_producto, $nombre, $precio_producto, $cantidad_producto, $ganancia, $ganancia_total_total]);
        }

        // Limpiar la sesión del carrito

    } else {
        echo "No se pudo obtener el correo del usuario.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Función para generar ID de transacción (ajusta según tus necesidades)
function generarIdTransaccion()
{
    return 'GAS' . date('YmdHis') . rand(100, 999);
}
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
                        <a class="btn btn-primary" style="width: 100%;" href="completadoEfectivo.php">Pago con tarjeta o efectivo al recibir</a>
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