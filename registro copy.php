<?php
require 'config/config.php';
require 'config/database.php';

$mensaje = '';

if (!empty($_POST["registro"])) {
    $nombre = $_POST['nombre'];
    $rut = $_POST['rut'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    // Verificar si el correo electrónico ya existe
    $verificar_correo = mysqli_query($conex, "SELECT * FROM clientes WHERE correo = '$correo'");
    if (mysqli_num_rows($verificar_correo) > 0) {
        $mensaje = '<div class="alert alert-danger">Este correo ya existe, intente con otro diferente</div>';
        header("location:registro.php");
    } else {
        // Validar el formato del correo electrónico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $mensaje = '<div class="alert alert-danger">Formato de correo electrónico no válido</div>';
            header("location:registro.php");
        } else {
            // Utilizar password_hash() para almacenar la contraseña de manera segura
            $clave_hash = password_hash($clave, PASSWORD_BCRYPT);

            // Insertar los datos del usuario en la base de datos
            $query = "INSERT INTO clientes(nombre, rut, telefono, direccion, correo, constraseña) 
            VALUES ('$nombre', '$rut', '$telefono', '$direccion', '$correo', '$clave_hash')";

            $ejecutar = mysqli_query($conex, $query);

            if ($ejecutar) {
                $mensaje = '<div class="alert alert-success">Usuario creado correctamente</div>';
                header("location:login.php");
            } else {
                $mensaje = '<div class="alert alert-danger">Error al registrar usuario</div>';
                header("location:registro.php");
                // Imprimir el mensaje de error de la base de datos para depurar
                // echo mysqli_error($conex);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro- JoseGasam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles.css">

    <style>
        body{
            background:linear-gradient(to right, #fbff02, #ff8001);
        
        }

        .bg{
            background-image:url(./img/abastibleRegistro.png) ;
            background-position: center center; 
        }
    </style>
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark ">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-start">
                    <img src="./img/logo.jpg" alt="Logo" width="45" height="45" class="d-inline-block align-text-top">
                    <br>
                    <strong>JoseGasam</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="inicio.php" class="nav-link active">Inicio</a>
                        </li>

                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">Productos</a>
                        </li>

                        <li class="nav-item">
                            <a href="sobre_nosotros.php" class="nav-link active">Sobre nosotros</a>
                        </li>

                        <li class="nav-item">
                            <a href="login.php" class="nav-link active">Iniciar sesión</a>
                        </li>

                        <li class="nav-item">
                            <a href="registro.php" class="nav-link active">Registro</a>
                        </li>


                    </ul>
                    <a href="checkout.php" class="btn btn-primary">
                        Carrito <span id="num_cart" class="badge bg-secondary"></span>
                    </a>
                </div>
    </header>


    <div class="container w-75 bg-primary mt-5 rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg-white p-5 rounded">          
                <h2 class="fw-bold text-center pt-5 mb-5">Registro de usuario</h2>    
                <form class="formulario" action="registro.php" method="POST">
                    <div class="mb-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" required>
                    </div>

                    <div class="mb-6">
                        <label for="rut" class="form-label">Rut:</label>
                        <input type="text" id="nombre"class="form-control" name="rut" required>
                    </div>

                    <div class="mb-6">
                        <label for="telefono" class="form-label">Telefono:</label>
                        <input type="text" id="nombre" class="form-control" name="telefono" required>
                    </div>


                    <div class="mb-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" id="nombre" class="form-control" name="direccion" required>
                    </div>

                    <div class="mb-6">
                        <label for="correo" class="form-label">Correo electronico:</label>
                        <input type="email" id="nombre" class="form-control" name="correo" required>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="form-label">Constraseña:</label>
                        <input type="password" id="nombre" class="form-control" name="password" required>
                    </div>

                    <div class="mb-6">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <input type="text" id="usuario" class="form-control" name="usuario" required>
                    </div>

                    <i><b>Nota:</b>Los campos son obligatorios</i>

                    
                    <div class="d-grid">
                        <button type="submit" href="login.php" class="btn btn-primary" value="Registrar" name="registro">Registrar</button>
                    </div>

                </form>    
            </div>
            <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
    




