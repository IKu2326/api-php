<?php
require_once './models/modeloBase.php';
class EnvioAdmin extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('envios');
    }

    public static function Crear($id, $tiempo, $observaciones, $estado)
    {
        $conn = Database::conectar();
        $Envio = new EnvioAdmin();
        $resultado = $Envio->obtenerPorId(id1: $id, nombre1: "fk_pk_Factura");
        
        if ($resultado) {
            return 'duplicado';
        } 

        $sql = "INSERT INTO envios (fk_pk_Factura, tiempoEstimado, observaciones, idEstadoEnvio) 
        VALUES (:id, :tiempo, :obser, :idE)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':tiempo' => $tiempo,
            ':obser' => $observaciones,
            ':idE' => $estado,
        ]);

    }

    public static function Editar($id, $tiempo, $observaciones, $estado)
    {

        $conn = Database::conectar();

        $sql = "UPDATE envios 
        SET tiempoEstimado = :tiempo, 
            observaciones = :obser, 
            idEstadoEnvio = :idE 
        WHERE fk_pk_Factura = :id";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':tiempo' => $tiempo,
            ':obser' => $observaciones,
            ':idE' => $estado,
        ]);
    }

    public function filtrarEnvioAdmins($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM envios WHERE 1=1";
        $params = [];

        // Factura
        if (!empty($filtros['id'])) {
            $sql .= " AND fk_pk_Factura = :fac";
            $params[':fac'] = $filtros['id'];
        }

        // Por TiempoEstimado (LIKE)
        if (!empty($filtros['tiempo'])) {
            $sql .= " AND tiempoEstimado LIKE :nombreProducto";
            $params[':nombreProducto'] = '%' . $filtros['tiempo'] . '%';
        }

        // Por Observaciones (LIKE)
        if (!empty($filtros['observaciones'])) {
            $sql .= " AND observaciones LIKE :nombreProducto";
            $params[':nombreProducto'] = '%' . $filtros['observaciones'] . '%';
        }

        // Estado Envio
        if (!empty($filtros['Estado'])) {
            $sql .= " AND idEstadoEnvio <= :precioMax";
            $params[':precioMax'] = $filtros['Estado'];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}