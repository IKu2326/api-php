<?php
require_once './models/modeloBase.php';
class CalificacionCliente extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('calificacion');
    }

    public static function Crear($idCliente, $idProducto, $numero, $Comentario)
    {
        $conn = Database::conectar();
        $CalificacionCliente = new CalificacionCliente();
        $resultado = $CalificacionCliente->obtenerPorId(id1: $idCliente, id2: $idProducto, nombre1: "idCliente", nombre2: "idProducto");

        if ($resultado) {
            return 'CalificacionCliente_duplicada';
        } else {
            $sql = "INSERT INTO calificacion (idCliente, idProducto, numeroCalificacion, comentarioCalificacion) 
        VALUES (:id, :id2, :numero, :comentario)";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                ':id' => $idCliente,
                ':id2' => $idProducto,
                ':numero' => $numero,
                ':comentario' => $Comentario,
            ]);
        }
    }

    public static function Editar($idCliente, $idProducto, $numero, $Comentario)
    {

        $conn = Database::conectar();

        $sql = "UPDATE calificacion SET numeroCalificacion = :numero, comentarioCalificacion = :comentario 
            WHERE idCliente = :id1 AND idProducto = :id2";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'id1' => $idCliente,
            'id2' => $idProducto,
            'numero' => $numero,
            'comentario' => $Comentario
        ]);
    }

    public function filtrarCalificaciones($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM calificacion WHERE 1=1";
        $params = [];

        if (!empty($filtros['idCliente'])) {
            $sql .= " AND idCliente = :idCliente";
            $params[':idCliente'] = $filtros['idCliente'];
        }

        if (!empty($filtros['idProducto'])) {
            $sql .= " AND idProducto = :idProducto";
            $params[':idProducto'] = $filtros['idProducto'];
        }

        // Precio mínimo
        if (!empty($filtros['calificacion_Minima'])) {
            $sql .= " AND numeroCalificacion >= :precioMin";
            $params[':precioMin'] = $filtros['calificacion_Minima'];
        }

        // Precio máximo
        if (!empty($filtros['calificacion_Maxima'])) {
            $sql .= " AND numeroCalificacion <= :precioMax";
            $params[':precioMax'] = $filtros['calificacion_Maxima'];
        }

        if (!empty($filtros['comentarioCalificacion'])) {
            $sql .= " AND comentarioCalificacion LIKE :comentarioCalificacion";
            $params[':comentarioCalificacion'] = '%' . $filtros['comentarioCalificacion'] . '%';
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}