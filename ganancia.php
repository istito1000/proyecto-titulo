<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


$lista_carrito = array();


if ($productos != null) {
    foreach ($productos as $clave=> $cantidad) {
        $sql = $con->prepare("SELECT id,nombre,precio, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1 ");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);


    }
}else{
    header("Location: index.php");
    exit;
}   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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

    <main> 
        <div class="container">   
           
            

                <div class="row">
                    <div class="col-6">
                        <h1>Ganancias</h1>
                        <br>
                    </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Ganancia</th>
                                </tr>                    
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class = "text-center"><b>Lista vacia </b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $subtotal = $cantidad * $precio;
                                        $total +=$subtotal ;
                                        $ganancia = $cantidad*3000;
                                    ?>                           
                                <tr>
                                    <td>
                                        <?php echo $nombre?>
                                    </td>

                                    <td>    
                                                         
                                        <div id="cantidad_<?php echo $_id; ?>" name="cantidad[]"><?php echo $cantidad; ?></div>
                                    </td>

                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA .$subtotal; ?></div>
                                    </td>
                                    <td>
                                        <div id="ganancia_<?php echo $_id; ?>" name="ganancia[]"><?php echo MONEDA .$ganancia; ?></div>
                                    </td>

                                </tr>
                                
                            
                                <?php } ?>
                                    </tr>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>              
                    </div>
                </div>    
            </div>
        </div>    
    </main>
        <!-- Modal -->
      
</body>
      
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    
</html>