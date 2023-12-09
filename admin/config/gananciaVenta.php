<?php   
require_once 'database.php';


class SumaColumna
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function sumarColumna()
    {
        try {
            $conn = $this->db->conectar();

            $sql = "SELECT SUM(ganancia) as total FROM detalle_compra";
            $result = $conn->query($sql);

            if ($result->rowCount() > 0) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $total = $row["total"];
                return $total;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo 'Error en la consulta:' . $e->getMessage();
            return 0;
        } finally {
            // Cerrar la conexión en el bloque finally para asegurarse de que se cierre incluso si ocurre una excepción
            $conn = null;
        }
    }
}

?>