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

        public function filtrarGenero($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM generojuego WHERE 1=1";
        $params = [];

        if (!empty($filtros['nombreGenero'])) {
            $sql .= " AND idGeneroJuego LIKE :nombre";
            $params[':nombre'] = '%' . $filtros['nombreGenero'] . '%';
        }

        if (!empty($filtros['stock'])) {
            $stock = ($filtros['stock'] === "Activo") ? 1 : 0;
            $sql .= " AND estadoGeneroJuego = :stock";
            $params[':stock'] = $stock;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}