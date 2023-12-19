<?php
require_once 'config/config.php';
require_once 'config/database.php';

try {
    $conexion = new PDO("mysql:host=localhost;dbname=josegasam", "root", "");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conexion->prepare("SELECT * FROM compra WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        // Aquí deberías imprimir un formulario prellenado con los valores actuales y permitir la edición
        // Puedes usar algo como: echo '<input type="text" name="nombre" value="' . $fila['nombre'] . '">';
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
        // Procesar el formulario de edición y actualizar la base de datos
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $status = $_POST['status'];
        // Recoge otros campos del formulario y actualiza la base de datos

        // Actualiza la base de datos usando una sentencia UPDATE
        $stmt = $conexion->prepare("UPDATE compra SET estado = :estado, status = :status WHERE id = :id");
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Después de actualizar, redirige a la página principal o muestra un mensaje de éxito
        header("Location: ventasTotales.php");
        exit();
    }
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Editar-jose gasam</title>

    <style>
        body {
            background: #ffe259;
            background: linear-gradient(to right, #ff8001, #fbff02);
        }

        .bg {
            background-image: url(img/prueba1.jpg);
            background-position: center center;
        }

        .container-cola {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <?php include 'menu.php';?>
    <div class="container-cola">
        <form method="post" action="">
            <h2>Editar Estado de Venta</h2>
            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
            <div class="mb-3">
                <label for="estado">Estado:</label>
                <select name="estado" class="form-select">
                    <option value="Procesando" <?php echo ($fila['estado'] == 'Procesando') ? 'selected' : ''; ?>>Procesando</option>
                    <option value="Entregado" <?php echo ($fila['estado'] == 'Entregado') ? 'selected' : ''; ?>>Entregado</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status">Status:</label>
                <select name="status" class="form-select">
                    <option value="Pendiente" <?php echo ($fila['status'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Pagado" <?php echo ($fila['status'] == 'Pagado') ? 'selected' : ''; ?>>Pagado</option>
                </select>
            </div>
            <input type="submit" name="guardar" value="Guardar cambios" class="btn btn-primary">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>



