<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id_transaccion = isset($_GET['key']) ? $_GET['key'] :0;

$error = '';

if($id_transaccion == 0){
    $error = 'Error al procesar';
}else{
    $sql = $con->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?");
    $sql->execute([$id_transaccion,'COMPLETED']);

    if ($sql->fetchColumn() > 0) {
        $sql = $con->prepare("SELECT id, fecha, correo,total FROM compra WHERE id_transaccion=? 
        AND status=? LIMIT 1");
        $sql->execute(([$id_transaccion,'COMPLETED']));
        $row = $sql->fetch(PDO::FETCH_ASSOC);


        $id_compra = $row['id'];
        $total = $row['total'];
        $fecha = $row['fecha'];

        $sqlDet = $con->prepare("SELECT nombre, precio, cantidad from detalle_compra WHERE id_compra = ?");
        $sqlDet->execute([$id_compra]);

    }else{
        $error = 'error al comprobar pedido';
   

    }
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
        <?php if(strlen($error) > 0) { ?>
            <div class="row">
                <div class="col">
                    <h3><?php echo $error;?></h3>
                </div>
            </div>

            <?php }else { ?>
    
            <div class="row">
                <div class="col">
                    <table class="table ">
                        <thead>
                            <tr>
                                <b>Comprobante de compra:</b><?php echo $id_transaccion;?><br>
                                <b>Fecha:</b><?php date_default_timezone_set('America/Santiago');echo "". date("d/m/Y") . " hora: ". date("h:i:sa");?><br>
                                <b>Total:</b><?php echo MONEDA.$total;?><br>
                                <b>Tiempo estimado de entrega: 15-20 minutos</b>
                                <th>Cantidad</th>
                                <th>Producto</th>
                                <th>Total del producto</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)){
                                $importe= $row_det['precio'];?>
                                <tr>
                                    <td><?php echo $row_det['cantidad'];?></td>
                                    <td><?php echo $row_det['nombre'];?></td>
                                    <td><?php echo $row_det['precio']* $row_det['cantidad'];?></td>
                                </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </main>
    
</body>
</html>

                    