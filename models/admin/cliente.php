<?php
require_once './models/modeloBase.php';
class Cliente extends ModeloBase {
    public function __construct() {
        parent::__construct('cliente'); 
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