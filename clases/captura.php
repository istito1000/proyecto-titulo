<?php
require '../config/config.php';
require '../config/database.php';

$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);  

print_r($datos);    

if(is_array($datos)) {
    $id_cliente = $_SESSION['user_cliente'];
    $nombre_usuario= $_SESSION['user_name'];
    $sqlProd = $con->prepare("SELECT correo FROM clientes WHERE id=? AND estatus=1");
    $sqlProd->execute([$id_cliente]);
    $row_cliente = $sqlProd->fetch(PDO::FETCH_ASSOC);

    $id_transaccion = $datos['detalles']['id']; 
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status']; 
    $fecha = $datos['detalles']['update_time']; 
    date_default_timezone_set('America/Santiago');
    $fecha_nueva = date('Y-m-d H:i:s');
    //$email = $datos['detalles']['payer']['email_address']; 
    $email = $row_cliente['correo']; 

    //$id_cliente = $datos['detalles']['payer']['payer_id']; 
    
    //$idTransaccion = $datos['detalles']['purchase_units'][0]['payments']['captures'][0]['id']; 

    $sql = $con->prepare("INSERT INTO compra(id_transaccion, fecha, status,correo, id_cliente,total) 
    VALUES(?,?,?,?,?,?)");

    $sql->execute([$id_transaccion,$fecha_nueva,$status,$email,$nombre_usuario,$total]);
    $id =$con->lastInsertId();
    
    if($id>0) { 
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {
                $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE id=? AND activo=1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);
        

                $id_producto = $row_prod['id'];
                $nombre_producto = $row_prod['nombre'];
                $precio = $row_prod['precio'];
                $ganancia = $cantidad*3000;
                $ganancia_total +=$ganancia;
        
                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad,ganancia,ganancia_total) VALUES (?,?,?,?,?,?,?)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio, $cantidad,$ganancia,$ganancia_total]);

                }
            }
            unset($_SESSION['carrito']);
        }
        
    }
  
?>

