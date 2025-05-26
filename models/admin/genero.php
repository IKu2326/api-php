<?php
require_once './models/modeloBase.php';
class Genero extends ModeloBase {
    public function __construct() {
        parent::__construct('generojuego'); 
    }

    public static function Crear($id, $estado) {

        $conn = Database::conectar();
        $Genero = new Genero();
        $resultado = $Genero->obtenerPorId(id1: $id,nombre1: "idGeneroJuego");

        if ($resultado){
            return "Genero_duplicado";
        }

        $sql = "INSERT INTO generojuego (idGeneroJuego, estadoGeneroJuego) 
        VALUES (:id, :estado)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':estado' => $estado
        ]);
    }

    public static function Editar($idA, $id, $estado) {

        $conn = Database::conectar();

        $sql = "UPDATE generojuego SET idGeneroJuego = :id, estadoGeneroJuego = :estado 
            WHERE idGeneroJuego = :idA";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'idA' => $idA,
            'id' => $id,
            'estado' => $estado
        ]);
    }

}