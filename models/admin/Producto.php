<?php
require_once './models/modeloBase.php';
class Producto extends ModeloBase {
    public function __construct() {
        parent::__construct('producto'); 
    }

    public static function Crear($idCliente, $direccion, $complemento) {

        $conn = Database::conectar();
        $FormaPago = new FormaPago();
        $resultado = $FormaPago->obtenerPorId(id1: $idCliente, nombre1: "idCliente");

        if ($resultado){
            return "cliente_duplicado";
        }

        $sql = "INSERT INTO cliente (idCliente, direccion, complemento) 
        VALUES (:id, :direccion, :complemento)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $idCliente,
            ':direccion' => $direccion,
            ':complemento' => $complemento,
        ]);
    }

    public static function Editar($idCliente, $direccion, $complemento) {

        $conn = Database::conectar();

        $sql = "UPDATE cliente SET direccion = :direccion, complemento = :complemento 
            WHERE idCliente = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'id1' => $idCliente,
            'direccion' => $direccion,
            'complemento' => $complemento
        ]);
    }

}