<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id,nombre,precio FROM productos WHERE activo=1 ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


//session_destroy();


//print_r($_SESSION);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/estilos.css">
    <title>JoseGasam-Productos</title>

    <style>
        body{
            background:linear-gradient(to right, #fbff02, #ff8001);      
        }

        .col {
            width: 300px;
             /* Define el ancho de cada columna */
        }

        .card {
            width: 100%; /* Haz que la tarjeta ocupe todo el ancho del contenedor .col */
            height: 500px; /* Define la altura de cada tarjeta */
        }

        .card:last-child img {
        max-width: 260px; /* Ajusta el ancho máximo según tus necesidades */
        height: 350px; /* Para mantener la proporción de la imagen */
        }
    </style>
 
</head>
<body>
<?php include 'menu.php';?>
    <main> 
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach($resultado as $row) { ?>
                <div class="col">
                    <div class="card shadow-sm " width="50" height="0">
                        <?php 
                        $id = $row["id"];
                        $imagen = "img/productos/" . $id . "/abastible.png";

                        if(!file_exists($imagen)) {
                            $imagen = "";
                        }

                        ?>
                        <img src="<?php echo $imagen; ?>">
                        <div class="card-body">
                            <h5 class="card-titulo"><?php echo $row['nombre']; ?></h5>              
                            <p class="card-text"><?php echo MONEDA.number_format($row['precio'], 0, ',', '.'); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="detalles.php?id=<?php echo $row['id'];?>&token=<?php 
                                    echo hash_hmac('sha1',$row['id'],KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>    
                                </div> 
                                <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id'];?>,'<?php echo hash_hmac('sha1',$row['id'],KEY_TOKEN);?>' )">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <script>
        function addProducto(id,token){
            let url = 'clases/carrito.php';
            let formData = new FormData;
            formData.append('id',id);
            formData.append('token',token);
            
            fetch(url,{
                method: 'POST',
                body:formData,
                mode: 'cors'

            }).then(response=> response.json())
            .then(data=>{
                if(data.ok){
                    let elemento =document.getElementById("num_cart")
                    elemento.innerHTML= data.numero

                }
            })
        }
    </script>
      
     <?php include 'footer.php';?>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>