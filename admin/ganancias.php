<?php

// Incluye los archivos necesarios
require_once 'config/config.php';
require_once 'config/database.php';


// Crea una instancia de la Database class
$db = new Database();

// Incluye el archivo que contiene la SumaColumna class
require_once 'config/gananciaVenta.php'; // Asegúrate de poner la ruta correcta

// Crea una instancia de la SumaColumna class y pasa la instancia de Database como un argumento
$sumaColumna = new SumaColumna($db);

// Llama a la función para sumar la columna

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $db->conectar()->prepare("SELECT id, nombre, precio, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1 ");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

$resultado = $sumaColumna->sumarColumna();

// Imprime el resultado
//echo "La suma de la columna es: " . $resultado;


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
        <br>
    <?php
    
class MostrarDatosTabla

{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function mostrarDatosEnPagina($tabla)
    {
        try {
            
            $sql = "SELECT * FROM $tabla";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<main>
                    <div class="container">
                            <div class="col-12">
                                <div class="table-responsive">';
            
            if (!empty($resultados)) {
                echo '<table class="table" border="1">';
                echo '<tr>';
                foreach ($resultados[0] as $columna => $valor) {
                    echo '<th>' . $columna . '</th>';
                }
                echo '</tr>';

                foreach ($resultados as $fila) {
                    echo '<tr>';
                    foreach ($fila as $valor) {
                        echo '<td>' . $valor . '</td>';
                    }
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo 'No hay datos en la tabla.';
            }

            echo '</div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                </div>
            </div>
        </div>
    </main>';
        } catch (PDOException $e) {
            echo 'Error en la consulta: ' . $e->getMessage();
        }
    }
}

// Uso de la clase
try {
    $conexion = new PDO("mysql:host=localhost;dbname=josegasam", "root", "");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $mostrarDatosTabla = new MostrarDatosTabla($conexion);

    // Reemplaza 'nombre_de_tu_tabla' con el nombre real de tu tabla
    $mostrarDatosTabla->mostrarDatosEnPagina('detalle_compra');
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>

    </main>
    
    <div class="row mt-4">
        <div class="col-12 text-center">
            <h3>Total de Ganancias: <?php echo MONEDA . $resultado; ?></h3>
        </div>
    </div>
</div>
</main>
      
</body>
      
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    
</html>