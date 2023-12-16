<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rut = $_POST['rut'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];

    $sql = "UPDATE clientes SET nombre=:nombre, rut=:rut, telefono=:telefono, direccion=:direccion, correo=:correo WHERE id=:id";

    try {
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':rut', $rut);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

$sql = "SELECT * FROM clientes";
try {
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
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
            background-image:url(img/user2.jpg) ;
            background-position: center center; 
        }
    </style>
</head>

<body>
<?php include 'menu.php';?>

<main>
    <div class="container w-75 bg-primary mt-5 rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg-white p-5 rounded">          
                <h2 class="fw-bold text-center pt-5 mb-5">Datos del usuario</h2>
                <?php foreach ($clientes as $cliente) {
                //echo "ID: " . $cliente['id'] . " - Nombre: " . $cliente['nombre'] . $cliente['rut']. "<br>";
                // Mostrar otros datos del cliente según la estructura de la tabla
                }{?>    
                <form class="formulario" action="./modificar.php" method="POST">
                    <div class="mb-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" value="<?php echo $cliente['nombre']?>" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="rut" class="form-label">Rut:</label>
                        <input type="text" id="rut"class="form-control" name="rut" value="<?php echo $cliente['rut']?>" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="telefono" class="form-label">Telefono:</label>
                        <input type="text" id="telefono" class="form-control" name="telefono" value="<?php echo $cliente['telefono']?>" requireda>
                    </div>


                    <div class="mb-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" id="direccion" class="form-control" name="direccion" value="<?php echo $cliente['direccion']?>" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="correo" class="form-label">Correo electronico:</label>
                        <input type="email" id="correo" class="form-control" name="correo" value="<?php echo $cliente['correo']?>" requireda>
                        <span id="validaCorreo" class="text-danger" ></span>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center align-items-center mb-6">
                        <a href="index.php" class="btn btn-primary">Volver atrás</a>
                    </div>
                </form>   
                <?php }?> 
            </div>
            <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">
            </div>

        </div>
    </div>
</main>
     <?php include 'footer.php';?>

    
</body>
</html>
