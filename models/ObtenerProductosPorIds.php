<?php

require_once './config/database.php';

class ObtenerProductosPorIds {
    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function obtenerPorIds($ids)
    {
        if (!empty($ids) && is_array($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $sql = "
                SELECT 
                    p.idProducto,   
                    p.nombreProducto,
                    p.precioProducto,
                    p.totalProducto,
                    p.stock,
                    IF(j.idJuego IS NOT NULL, 'videojuego', 'consola') AS tipoProducto,
                    GROUP_CONCAT(DISTINCT apl.idPlataforma SEPARATOR ', ') AS plataformas
                FROM producto p
                LEFT JOIN juego j ON p.idProducto = j.idJuego
                LEFT JOIN aux_plataforma apl ON p.idProducto = apl.idJuego
                WHERE p.idProducto IN ($placeholders)
                GROUP BY p.idProducto, j.idJuego
            ";

            $stmt = $this->conn->prepare($sql);
            
            foreach ($ids as $index => $id) {
                $stmt->bindValue($index + 1, $id, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }
}
?>
