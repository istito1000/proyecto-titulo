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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles.css">

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
            margin-top: 20px; /* Ajusta según sea necesario */
        }

        .featurette-divider {
            margin: 40px 0;
        }

        .lead {
            font-size: 1.2rem;
        }

        .lh-1 {
            line-height: 1.2;
        }

        .fw-normal {
            font-weight: normal;
        }

        .lg-1 {
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <div class="container-cola">
            <h1>Sobre Nosotros</h1>
            <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading fw-normal lg-1">El antes <span class="text-body-secondary"></span></h2>
                <p class="lead">En 1995, José Pacheco, propietario de una pyme local, dejó su trabajo como cuidador de animales en la Región de Los Lagos para establecerse en San Bernardo.
                    Su vida dio un giro cuando conoció a un distribuidor que le proporcionó un camión para el reparto. Este encuentro no solo facilitó el transporte,
                    sino que también abrió puertas a nuevas alianzas y oportunidades comerciales, marcando el inicio de un exitoso camino empresarial en San Bernardo.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img src="img/user.png" alt="" width="300" height="300">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading fw-normal lh-1">El ahora <span class="text-body-secondary"></span></h2>
                <p class="lead">Dos camiones están disponibles para realizar la entrega de cilindros de gas en la comuna de San Bernardo. Uno de ellos es conducido por José Pacheco, mientras que el otro está a cargo de su hijo, Héctor Pacheco.</p>
            </div>
            <div class="col-md-5">
                <img src="img/Menu.jpg" alt="" width="350" height="200">
            </div>
        </div>      
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
