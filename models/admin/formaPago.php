<?php
require_once './models/modeloBase.php';
class FormaPago extends ModeloBase {
    public function __construct() {
        parent::__construct('formapago'); 
    }

    public static function Crear($id, $estado) {

        $conn = Database::conectar();
        $FormaPago = new FormaPago();
        $resultado = $FormaPago->obtenerPorId(id1: $id,nombre1: "idFormaPago");

        if ($resultado){
            return "Forma_duplicada";
        }

        $sql = "INSERT INTO formapago (idFormaPago, estadoMetodoPago) 
        VALUES (:id, :estado)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':estado' => $estado
        ]);
    }

    public static function Editar($idA, $id, $estado) {

        $conn = Database::conectar();

        $sql = "UPDATE formapago SET idFormaPago = :id, estadoMetodoPago = :estado 
            WHERE idFormaPago = :idA";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'idA' => $idA,
            'id' => $id,
            'estado' => $estado
        ]);
    }

}