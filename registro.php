<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if(!empty($_POST)){
    $nombre = trim($_POST['nombre']);
    $rut = trim($_POST['rut']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $correo = trim($_POST['correo']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);


    if(esNulo([$nombre,$rut,$telefono, $direccion,$correo,$usuario,$password,$repassword])){
        $errors[] = "Debe de llenar todos los campos";
    }

    if(!esEmail($correo)){
        $errors[] = "La direccion de correo no es valida";
    }

    if(!validaPassword($password,$repassword)){
        $errors[] = "Las contraseñas no coinciden ";
    }


    if(usuarioExiste($usuario,$con)){
        $errors[] = "El nombre de usuario $usuario ya existe ";
    }

    if(correoExiste($correo,$con)){
        $errors[] = "El correo $correo ya existe ";
    }

    if(count($errors) == 0){
        $id= registraCliente([$nombre,$rut,$telefono,$direccion,$correo], $con);


        if($id > 0){
            $token  = generarToken();
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $idUsuario = registraUsuario([$usuario,$pass_hash,$token,$id],$con);

        }else{
            $errors[] = 'error al registrar cliente2';
        }
       

        
            
        }else{
            print_r($errors);
        }

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
    <div class="container w-75 bg-primary mt-5 rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg-white p-5 rounded">          
                <h2 class="fw-bold text-center pt-5 mb-5">Registro de usuario</h2>    
                <form class="formulario" action="registro.php" method="POST">
                    <?php mostrarMensajes($errors);  ?>
                    <div class="mb-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="rut" class="form-label">Rut:</label>
                        <input type="text" id="rut"class="form-control" name="rut" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="telefono" class="form-label">Telefono:</label>
                        <input type="text" id="telefono" class="form-control" name="telefono" requireda>
                    </div>


                    <div class="mb-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" id="direccion" class="form-control" name="direccion" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="correo" class="form-label">Correo electronico:</label>
                        <input type="email" id="correo" class="form-control" name="correo" requireda>
                        <span id="validaCorreo" class="text-danger" ></span>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="form-label">Constraseña:</label>
                        <input type="password" id="password" class="form-control" name="password" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="repassword" class="form-label">Repassword:</label>
                        <input type="password" id="repassword" class="form-control" name="repassword" requireda>
                    </div>

                    <div class="mb-6">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <input type="text" id="usuario" class="form-control" name="usuario" requireda>
                        <span id="validaUsuario" class="text-danger" ></span>
                    </div>
                    <i><b>Nota:</b>Los campos son obligatorios</i>
       
                    <div class="d-grid">
                    <br>
                        <button type="submit" href="./login.php" class="btn btn-primary" value="Registrar" name="registro">Registrar</button>
                    </div>

                </form>    
            </div>
            <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

            </div>


        </div>
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        let txtUsuario = document.getElementById('usuario')
        txtUsuario.addEventListener("blur", function(){
            existeUsuario(txtUsuario.value)
        },false)


        function existeUsuario(usuario){
            let url = "clases/clienteAjax.php"
            let formData= new FormData()
            formData.append("action","existeUsuario")
            formData.append("usuario",usuario)

            fetch(url,{
                method:'POST',
                body :formData
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    document.getElementById('usuario').value = ''
                    document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
                }else{
                    document.getElementById('validaUsuario').innerHTML = ''
                }


            })


        let txtCorreo = document.getElementById('correo')
        txtCorreo.addEventListener("blur", function(){
            existeCorreo(txtCorreo.value)
        },false)


        function existeCorreo(correo){
            let url = "clases/clienteAjax.php"
            let formData= new FormData()
            formData.append("action","existeCorreo")
            formData.append("correo",correo)

            fetch(url,{
                method:'POST',
                body :formData
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    document.getElementById('correo').value = ''
                    document.getElementById('validaCorreo').innerHTML = 'correo no disponible'
                }else{
                    document.getElementById('validaCorreo').innerHTML = ''
                }

            })

        
        }
    }
    </script>

</body>

</html>
    




