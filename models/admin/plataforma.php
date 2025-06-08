<?php
require_once './models/modeloBase.php';
class Plataforma extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('plataforma');
    }

    public static function Crear($id, $estado)
    {

        $conn = Database::conectar();
        $Plataforma = new Plataforma();
        $resultado = $Plataforma->obtenerPorId(id1: $id, nombre1: "idPlataforma");

        if ($resultado) {
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

    public static function Editar($idA, $id, $estado)
    {

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

    public function filtrarPlataforma($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM plataforma WHERE 1=1";
        $params = [];

        // Filtrar por nombreProducto con LIKE si existe
        if (!empty($filtros['nombrePlataforma'])) {
            $sql .= " AND idPlataforma LIKE :nombre";
            $params[':nombre'] = '%' . $filtros['nombrePlataforma'] . '%';
        }

        // Filtrar por tipoProducto si existe
        if (!empty($filtros['stock'])) {
            $stock = ($filtros['stock'] === "Activo") ? 1 : 0;
            $sql .= " AND estadoPlataforma = :stock";
            $params[':stock'] = $stock;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}