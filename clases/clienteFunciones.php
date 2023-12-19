<?php

function esNulo(array $parametros) {

    foreach( $parametros as $parametros) {
        if(strlen(trim($parametros)) < 0) {
            return true;
        }
    }
    return false;
}

function esEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }

    return false;
}


function validaPassword($password,$repassword){
        if(strcmp($password,$repassword) === 0) {
        return true;
    }
    return false;
}


function generarToken(){
    return md5(uniqid(mt_rand(), false));
}

function registraCliente(array $datos, $con){
    $sql = $con->prepare("INSERT INTO clientes (nombre, rut, telefono, direccion, estatus, correo, fecha_alta) 
    VALUES(?, ?, ?, ?, 1, ?, now())");
    if($sql->execute($datos)){
        return $con->lastInsertId();
    }
    return 0;
}

function registraUsuario(array $datos, $con){
    $sql = $con->prepare("INSERT INTO usuarios(usuario, contraseña, token, id_cliente) 
    VALUES(?, ?, ?, ?)");

    if($sql->execute($datos)){
        return $con->lastInsertId();
    }
    return 0;
}


function usuarioExiste($usuario, $con){
    $sql = $con->prepare("SELECT id from usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);

    if($sql->fetchColumn() > 0){
        return true;

    }    
    return false;
}


function correoExiste($correo, $con){
    $sql = $con->prepare("SELECT id from clientes WHERE correo LIKE ? LIMIT 1");
    $sql->execute([$correo]);

    if($sql->fetchColumn() > 0){
        return true;

    }    
    return false;
}

function mostrarMensajes(array $errors){
    if(count($errors) > 0){
        echo'<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul>';
        foreach($errors as $error){
            echo '<li>' . $error .'</li>';
        }
        echo '<ul>';
        echo'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

        
    }
    
}


function validaToken($id,$token, $con){

    $msg = "";
    $sql = $con->prepare("SELECT id from usuarios WHERE id=? AND token LIKE ? LIMIT 1");
    $sql->execute([$id, $token]);

    if($sql->fetchColumn() >= 0){
        if(activarUsuario($id,$con)){
            $msg = "cuenta activada.";
        }else{
            $msg = "ERROR al activar cuenta.";
        }
    }   else{ 
        $msg = "NO existe el registro del cliente"; 
    }

    return $msg;
}


function activarUsuario($id,$con){
    $sql = $con->prepare("UPDATE usuarios SET activacion=1 WHERE id=?");
    return $sql->execute([$id]);   
}

function login($usuario,$password,$con, $proceso){

    $sql = $con->prepare("SELECT id,usuario, contraseña,id_cliente FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    
    if($row = $sql-> fetch(PDO::FETCH_ASSOC)){
        if(esActivo($usuario,$con)){
            if(password_verify($password,$row["contraseña"])){
                $_SESSION['user_id'] = $row ['id'];
                $_SESSION['user_name'] = $row ['usuario'];
                $_SESSION['user_cliente'] = $row ['id_cliente'];
                if($proceso == 'pago'){
                    header("Location:index.php");     
                }else{
                    header("Location:checkout.php");
                }
                exit;
            }
        }else{
            return "no activo";
        }    
    }

    $sql = $con->prepare("SELECT id,usuario, contraseña,nombre FROM admin WHERE usuario LIKE ? AND activo=1 LIMIT 1");
    $sql->execute([$usuario]);
    if($row = $sql-> fetch(PDO::FETCH_ASSOC)){

        if(password_verify($password,$row["contraseña"])){
            $_SESSION['user_id'] = $row ['id'];
            $_SESSION['user_name'] = $row ['nombre'];
            $_SESSION['user_type'] = 'admin';
            header('Location: admin/index.php');
            exit;
        }  
}
    return 'incorrectos';   
}
function esActivo($usuario,$con){
    $sql = $con->prepare("SELECT activacion FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);  
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if($row['activacion'] == 0){
        return true;
    }
    return false;
}

?>




