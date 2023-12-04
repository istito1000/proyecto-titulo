<?php
require 'config/config.php';
require 'config/database.php';

$mensaje = ''; // Variable para almacenar mensajes

if (!empty($_POST["login"])) {
    if (empty($_POST["correo"]) || empty($_POST["clave"])) {
        $mensaje = '<div class="alert alert-danger">Datos vacíos</div>';
    } else {
        $correo = $_POST['correo'];
        $contraseña = $_POST['clave'];
        $sql = $conex->query("SELECT * FROM usuarios WHERE correo ='$correo' AND constraseña = '$contraseña'");
        if ($datos = $sql->fetch_object()) {
            $mensaje = '<div class="alert alert-success">Inicio de sesión exitoso</div>';
            header("location:productos.php");
            // Puedes realizar otras acciones aquí si es necesario
        } else {
            $mensaje = '<div class="alert alert-danger">Credenciales incorrectas</div>';
            header("location:login.php");
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login- JoseGasam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles.css">

    <style>
        body{
            background:#ffe259;
            background:linear-gradient(to right, #ff8001, #fbff02);
        
        }

        .bg{
            background-image:url(./img/producto1.png) ;
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
                    <a href="carrito.php" class="btn btn-primary">
                        Carrito <span id="num_cart" class="badge bg-secondary"></span>
                    </a>
                </div>
    </header>



    <div class="container w-75 bg-primary mt-5 rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

            </div>

            <div class="col bg-white p-5 rounded-end">
                    
                <h2 class="fw-bold text-center pt-5 mb-5">Bienvenido</h2>

                <?php echo $mensaje; ?>     
                <form class="formulario" action="login.php" method="POST">
                    <div class="mb-4">
                        <label for="usuario"  class="form-label">Usuario:</label>
                        <input type="email" id="usuario" name="usuario" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" name="clave" required>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="connected" class="form-check-input" id="">
                        <label for="connected" class="form-check-label">Mantenerme conectado</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" href="index.html" class="btn btn-primary" value="Login" name="login">Iniciar Sesion</button>
                    </div>


                    <div class="my-3">
                        <span>¿ No tienes cuenta? <a href="registro.php">Registrate</a></span>
                        <br>
                        <span> <a href="#">Recuperar Password</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
    

</html>