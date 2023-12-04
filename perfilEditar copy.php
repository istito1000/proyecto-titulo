<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();


$sql = "SELECT * from clientes";
try {
    // Preparar la consulta
    $stmt = $con->prepare($sql);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener resultados
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar los resultados
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

//session_destroy();

//print_r($_SESSION);


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

        .bg{
            background-image:url(img/Menu.jpg) ;
            background-position: center center; 
        }
    </style>
</head>

<body>
<?php include 'menu.php';?>

<main>
    <h1>usuarios</h1>
    <a href="">Nuevos alumnos</a>
    <tbody>
        <?php foreach ($clientes as $cliente) {
        echo "ID: " . $cliente['id'] . " - Nombre: " . $cliente['nombre'] . $cliente['rut']. "<br>";
        // Mostrar otros datos del cliente según la estructura de la tabla
        }{?>
        <tr>
            <td><?php echo $cliente['nombre']?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php }?>
    </tbody>
</main>
</body>
</html>