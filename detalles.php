<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'Error 1';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {
        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);

        if ($sql->fetchColumn() > 0) {
            $sql = $con->prepare("SELECT nombre, descripcion, precio FROM productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $dir_images = 'img/productos/' . $id . '/';
            $rutaImg = $dir_images . 'abastible.png';

            $imagenes = array();

            if (file_exists($dir_images)) {
                $dir = dir($dir_images);

                while(($archivo = $dir->read()) !== false) {
                    if ($archivo != 'abastible.png' && (strpos($archivo, 'png') || strpos($archivo, 'jpeg'))) {
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();
            }    
        } else {
            echo 'Error 3';
            exit;
        }
    } else {
        echo 'Error 2';
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css">
    <title>JoseGasam-inicio</title>

    <style>
        body{
            background:linear-gradient(to right, #fbff02, #ff8001);
        
        }

    </style>
</head>
<body>
<?php include 'menu.php';?>
<br>
    <main> 
        <div class="containter">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $rutaImg; ?>" class="d-block w-100" width="100" height="800">
                            </div>  


                            <?php foreach($imagenes as $img) { ?>
                
                                <div class="carousel-item active">
                                    <img src="<?php echo $img; ?>" class="d-block w-100" width="100" height="800">
                                </div>

                            <?php } ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                        

                </div>
                <br>
                <div class="col-md-6 order-md-2">
                    <br>
                    <h2><?php echo $nombre; ?></h2>
                    <br>
                    <h2><?php echo MONEDA . $precio; ?></h2>
                    <br>

                    <p class="lead">
                        <?php echo $descripcion;?>
                    </p>

                    <div class="col-3 my-3">
                        Cantidad:<input type="number" class="form-control" id="cantidad" name="cantidad" min="1" max="10" value="1" >

                    </div>
                    <br>
                    <div class="d-grip gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar ahora</button>
                        <button class="btn btn-outline-primary" id="btnAgregar" type="button">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>

    </main>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <script>

        let btnAgregar = document.getElementById("btnAgregar");

        btnAgregar.onclick = function() {
            let inputCantidad = document.getElementById("cantidad").value;
            addProducto(<?php echo $id; ?>, inputCantidad, '<?php echo $token_tmp; ?>');
        };






        function addProducto(id,cantidad,token){
            let url = 'clases/carrito.php';
            let formData = new FormData;
            formData.append('id',id);
            formData.append('cantidad',cantidad);
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


</body>
    
</html>