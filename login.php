<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$proceso = isset($_GET['pago']) ? 'pago' :'login';

$errors = [];

if(!empty($_POST)){

    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $proceso = $_POST['proceso'] ?? 'login';


    if(esNulo([$usuario,$password])){
        $errors[] = "Debe de llenar todos los campos";
    }

    if(count($errors) == 0){
        $errors[] = login($usuario, $password, $con, $proceso); 
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


    <style>
        body{
            background:#ffe259;
            background:linear-gradient(to right, #ff8001, #fbff02);
        
        }

        .bg{
            background-image:url(img/Menu.jpg) ;
            background-position: center center; 
        }
    </style>
</head>

<body>
<?php include 'menu.php';?>



    <div class="container w-75 bg-primary mt-5 rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">
            </div>

            <div class="col bg-white p-5 rounded-end">
                    
                <h2 class="fw-bold text-center pt-5 mb-5">Bienvenido</h2> 
                <?php mostrarMensajes($errors);  ?> 
                <form class="formulario" action="login.php" method="POST">
                
                    <input type="hidden" name="proceso" value ="<?php echo $proceso;  ?> " >
                    <div class="mb-4">
                        <label for="usuario"  class="form-label">Usuario:</label>
                        <input type="usuario" id="usuario" name="usuario" class="form-control" required>
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