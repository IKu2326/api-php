<?php
require_once './models/modeloBase.php';
class Plataforma extends ModeloBase {
    public function __construct() {
        parent::__construct('plataforma'); 
    }

    public static function Crear($id, $estado) {

        $conn = Database::conectar();
        $Plataforma = new Plataforma();
        $resultado = $Plataforma->obtenerPorId(id1: $id,nombre1: "idPlataforma");

        if ($resultado){
            return "Plataforma_duplicada";
        }

        $sql = "INSERT INTO plataforma (idPlataforma, estadoPlataforma) 
        VALUES (:id, :estado)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':estado' => $estado
        ]);
    }

    public static function Editar($idA, $id, $estado) {

        $conn = Database::conectar();

        $sql = "UPDATE plataforma SET idPlataforma = :id, estadoPlataforma = :estado 
            WHERE idPlataforma = :idA";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'idA' => $idA,
            'id' => $id,
            'estado' => $estado
        ]);
    }

}