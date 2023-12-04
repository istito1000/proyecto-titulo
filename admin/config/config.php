<?php 

define("SITE_URL","http://localhost/definitivo");
define("KEY_TOKEN","APR.wqc-354*");
define("MONEDA","$");



//paypal
define("CLIENTE_ID","AfgcIvbyFA77gpncLxTquAj7HfaWviLr7EFuJfg34EyDEE4ZYfvCXbGttB5LxEsgDL9m8jlhFLa9qfkH");
define("CURRENCY","USD");

session_start();




//CORREO
define("MAIL_HOST","titokacique1.0@gmail.com");
define("MAIL_USER","titokacique1.0@gmail.com");
define("MAIL_PASS","sg3509la");
define("MAIL_PORT","456");



$num_cart = 0;
if (isset($_SESSION['carrito']['productos'])) {

    $num_cart = count($_SESSION['carrito']['productos']);
}




?>