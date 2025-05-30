<?php

require_once './config/database.php';

class CalificacionesProducto {
    private $conn;

    public function __construct() {
        $this->conn = Database::conectar();
    }
    
    public function obtenerPorProducto($idProducto) {
        $sql = "
            SELECT 
                c.idCliente,
                c.idProducto,
                c.numeroCalificacion,
                c.comentarioCalificacion,
                cl.nombreCliente
            FROM calificacion c
            JOIN cliente cl ON c.idCliente = cl.idCliente
            WHERE c.idProducto = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $idProducto, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva calificación
    public function crearCalificacion($idCliente, $idProducto, $numeroCalificacion, $comentarioCalificacion) {
        $sql = "
            INSERT INTO calificacion (idCliente, idProducto, numeroCalificacion, comentarioCalificacion)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $idCliente, PDO::PARAM_INT);
        $stmt->bindValue(2, $idProducto, PDO::PARAM_INT);
        $stmt->bindValue(3, $numeroCalificacion, PDO::PARAM_INT);
        $stmt->bindValue(4, $comentarioCalificacion, PDO::PARAM_STR);

        return $stmt->execute();
    }               
}
?>
