<?php
require_once './config/database.php';

class Soporte {
    private $conn;

    public function __construct() {
        $this->conn = Database::conectar();
    }

    public function enviarPQRS($idCliente, $fecha, $pqrs) {
        $sql = "INSERT INTO soporte (idCliente, fecha, pqrs) VALUES (:idCliente, :fecha, :pqrs)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':pqrs', $pqrs);
        return $stmt->execute();
    }
}
