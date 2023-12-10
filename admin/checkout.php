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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
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
                            ?>   
                         
                        <tr>
                            <td><?php echo $nombre?></td>
                            <td><?php echo MONEDA. $precio?></td>
                            <td>
                                <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>"
                                size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value,<?php echo $_id ?>)">
                            </td>

                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA .$subtotal; ?></div>
                            </td>
                            <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id?>" 
                            data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">
                            <p class="h3" id="total"><?php echo MONEDA .$total; ?></p>
                        </td>
                    </tr>
                <?php } ?>
                </table>
            </div>


            <?php if ($lista_carrito != null) { ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                <?php if (isset($_SESSION['user_cliente'])) { ?>
                    <a href="pago.php" class="btn btn-primary btn-lg" >Realizar pago</a>
                    <?php }else{ ?>
                        <a href="login.php?pago" class="btn btn-primary btn-lg" >Realizar pago</a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </main>
        <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estas seguro de eliminar el producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="elimina()">Eliminar</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event){

            let button = event.relatedTarget 
            let id = button.getAttribute('data-bs-id')
            let buttonElimina =eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })



        function actualizaCantidad(cantidad,id){
            let url = 'clases/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('action','agregar');
            formData.append('id',id);
            formData.append('cantidad',cantidad);
            
            fetch(url,{
                method: 'POST',
                body:formData,
                mode: 'cors'

            }).then(response=> response.json())
            .then(data=>{
                if(data.ok){
                    let divsubtotal =document.getElementById('subtotal_'+ id)
                    divsubtotal.innerHTML = data.sub

                    let total = 0
                    let list = document.getElementByName('subtotal[]')

                    for(let i = 0; i<list.length; i++){
                        total +=parseFloat(list[i].innerHTML.replace(/[$,]/g,''))
                    }

                    total = new Intl.NumberFormat('en-CLP',{
                        minimumFractionDigits: 2
                    }).format(total)
                    document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' +total
                }
            })
        }


        function elimina(){
            let botonElimina =document.getElementById('btn-elimina');
            let id = botonElimina.value;



            let url = 'clases/actualizar_carrito.php';
            let formData = new FormData;
            formData.append('action','elimina');
            formData.append('id',id);
            
            fetch(url,{
                method: 'POST',
                body:formData,
                mode: 'cors'

            }).then(response=> response.json())
            .then(data=>{
                if(data.ok){
                    location.reload()

                }
            })
        }
    </script>
      

</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>