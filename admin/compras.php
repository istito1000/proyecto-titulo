<?php

require 'config/config.php';
require 'config/database.php';
require 'clasesA/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

//print_r($_SESSION);
$id_cliente = $_SESSION ['user_cliente'];

$sql = $con->prepare("SELECT id_transaccion,fecha,status,total FROM compra WHERE id_cliente=? ORDER BY date(fecha) DESC");
$sql ->execute([$id_cliente]);

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
        <br>
        <h4>Mis compras</h4>


        <div class="card mb-3">
            <div class="card-header">
                Venta1
        </div>
        <div class="card-body">
            <h5 class="card-title">Folio:</h5>
            <p class="card-text">Total:</p>
            <a href="#" class="btn btn-primary">Detalles</a>
        </div>

        
</main>
    
</body>

</html>
    
