<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';



//print_r($_SESSION);
$token_session= $_SESSION ['token'];
$orden = $_GET['orden'] ?? null;
$token = $_GET['token'] ?? null;

if($orden==null || $token==null || $token !=$token_session){
    header( "Location: compras.php" ) ;
    exit;

}

$db = new Database();
$con = $db->conectar();

$sqlCompra = $con->prepare("SELECT id, id_transaccion, fecha,estado, total FROM compra WHERE id_transaccion=? LIMIT 1");
$sqlCompra->execute([$orden]);
$rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
$idCompra = $rowCompra['id'];


$fecha = new DateTime($rowCompra['fecha']);
$fecha = $fecha->format('d/m/Y H:i:s');

$sqlDetalle =$con->prepare("SELECT id, id_compra, nombre, precio, cantidad FROM detalle_compra WHERE id_compra=? ");
$sqlDetalle->execute([$idCompra]);






//session_destroy();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro- JoseGasam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

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
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Detalle de la compra</strong>
                </div>
                <div class="card-body">
                    <p><strong>Fecha:</strong><?php echo $fecha ;?></p>
                    <p><strong>Orden:</strong><?php echo $rowCompra['id_transaccion'] ;?></p>
                    <p><strong>Total:</strong><?php echo MONEDA.number_format($rowCompra['total'], 0, ',', '.'); ?></p>
                    <p><strong>Estado:</strong><?php echo $rowCompra['estado']  ;?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th> 
                        </tr>
                        
                    </thead>
                    <tbody>
                        <?php while($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)){
                            $precio = $row['precio'];
                            $cantidad = $row['cantidad'];
                            $subtotal = $precio * $cantidad;
                            ?>
                        <tr>
                            <td><?php echo $row['nombre'];?></td>
                            <td><?php echo MONEDA.number_format($precio, 0, ',', '.');?></td>
                            <td><?php echo $cantidad;?></td>
                            <td><?php echo MONEDA.number_format($subtotal, 0, ',', '.');?></td>
                        </tr>

                        <?php }?>

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center align-items-center">
            <a href="compras.php" class="btn btn-primary">Volver atrás</a>
        </div>
        </div>
    </div>
    </div>
        
</main>
    
</body>
<?php include 'footer.php';?>
</html>