<?php
require_once './config/database.php';

class Soporte {
    private $conn;

    public function __construct() {
        $this->conn = Database::conectar();
        // Habilita el modo de errores para capturar excepciones
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function enviarPQRS($idCliente, $fecha, $pqrs) {
        try {
            $sql = "INSERT INTO soporte (idCliente, fecha, pqrs) VALUES (:idCliente, :fecha, :pqrs)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':pqrs', $pqrs);
            $stmt->execute();
            return ['success' => true];
        } catch (PDOException $e) {
            // Devuelve el mensaje de error en el JSON
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
