<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';


$db = new Database();
$con = $db->conectar();


$token = generarToken();
$_SESSION['token'] = $token;
$id_cliente = $_SESSION ['user_cliente'];
$id_cliente1 = $_SESSION ['user_name'];


$sql = $con->prepare("SELECT id_transaccion,fecha,status,total,estado FROM compra WHERE id_cliente=? ORDER BY DATE(fecha) DESC");
$sql ->execute([$id_cliente]);

$sql1 = $con->prepare("SELECT id_transaccion,fecha,status,total,estado FROM compra WHERE id_cliente=? ORDER BY DATE(fecha) DESC");
$sql1 ->execute([$id_cliente1]);




//session_destroy();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras- JoseGasam</title>
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
        <br>
        <h4>Mis compras</h4>
        <hr>

        <?php while($row= $sql->fetch(PDO::FETCH_ASSOC)){?>

            <div class="card mb-3 border-primary">
                <div class="card-header">
                    <?php echo $row['fecha'];?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Folio:<?php echo $row['id_transaccion'];?></h5>
                    <p class="card-text">Total:<?php echo MONEDA.number_format($row['total'], 0, ',', '.'); ?></p>
                    <p>Estado:<?php echo $row['estado'] ;?></p>
                    
                    <a href="detalle_compra.php?orden=<?php echo $row['id_transaccion'];?>&token=<?php echo $token;?>" class="btn btn-primary">Detalle de compra</a>
                </div>
            </div>
            

        <?php }?>

        <?php while($row1= $sql1->fetch(PDO::FETCH_ASSOC)){?>

        <div class="card mb-3 border-primary">
            <div class="card-header">
                <?php echo $row1['fecha'];?>
            </div>
            <div class="card-body">
                <h5 class="card-title">Folio:<?php echo $row1['id_transaccion'];?></h5>
                <p class="card-text">Total:<?php echo MONEDA.number_format($row1['total'], 0, ',', '.'); ?></p>
                <p>Estado:<?php echo $row1['estado'] ;?></p>
                <h5>Pagado con tarjeta en el sistema.</h5>
                
                <a href="detalle_compra.php?orden=<?php echo $row1['id_transaccion'];?>&token=<?php echo $token;?>" class="btn btn-primary">Detalle de compra</a>
            </div>
        </div>


        <?php }?>


        
        <div class="d-flex justify-content-center align-items-center">
            <a href="index.php" class="btn btn-primary">Volver atrás</a>
        </div>
    </div>
        
        
</main>
    
</body>
<?php include 'footer.php';?>
</html>
    
