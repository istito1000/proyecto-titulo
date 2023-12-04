<?php
require 'config/config.php';
require 'config/database.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - JoseGasam</title>
    <link rel="stylesheet" href="css/estilo_sobre_nosotros.css">

</head>
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
            background-image:url(img/prueba1.jpg) ;
            background-position: center center; 
        }


        .container-cola {
        background-color: white;
        padding: 30px; /* para dar espacio alrededor del texto */
        border-radius:  15px;
        }

    </style>
</head>

<body>
<?php include 'menu.php';?>
<br>
<br>
    <div class="container-cola">
        <h1>Sobre Nosotros</h1>
        <hr class="featurette-divider">

        <div class="row featurette">
        <div class="col-md-7">
            <h1 class="featurette-heading fw-normal lh-1">Comienzos</h1>
            <p class="lead">
            </p>
        </div>
        <div class="col-md-5">
            
        </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette"> 
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading fw-normal lg-1">El antes <span class="text-body-secondary"></span></h2>
            <p class="lead">Jose Pacheco, el dueño de la pyme de barrio, por los años de 1995, cambio su vida al venirse a vivir a san bernardo, el venia de la region de los lagos, en donde era cuidador de animales
                , cambio su rumbo al venir a san bernardo, ya que conocio al primer distribuidor el cual le facilito un camion para hacer reparto.</p>
        </div>
        <div class="col-md-5 order-md-1">
        <img src="img/user.png" alt="" width="200" height="250" >
        </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading fw-normal lh-1">El ahora <span class="text-body-secondary"></span></h2>
            <p class="lead">Se disponen de 2 camiones para hacer repartos de cilindros de gas a la comuna de san bernardo, uno el cual lo maneja jose pacheco y el otro que lo maneja su hijo, hector pacheco.</p>
        </div>
        <div class="col-md-5">
            <img src="img/Menu.jpg" alt="" width="300" height="200" >
        </div>
        </div>

        <hr class="featurette-divider">
        </div>
    
    
        <br>
        <br>
        <?php include 'footer.php';?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

