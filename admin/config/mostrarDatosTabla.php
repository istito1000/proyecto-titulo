<?php
require_once 'database.php';
require_once 'gananciaVenta.php';

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
                    <h3>Total de Ganancias: MONEDA . $resultado;</h3>
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
