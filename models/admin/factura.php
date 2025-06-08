<?php
require_once './models/modeloBase.php';
class Factura extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('factura');
    }

    public static function Crear($fechaFactura, $iva, $Base, $total, $idCliente, $idFormaPago)
    {
        $conn = Database::conectar();

        $sql = "INSERT INTO factura (fechaFactura, iva, base, totalCompra, idCliente, idFormaPago) 
        VALUES (:fecha, :iva, :base, :total, :cliente, :forma)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':fecha' => $fechaFactura,
            ':iva' => $iva,
            ':base' => $Base,
            ':total' => $total,
            ':cliente' => $idCliente,
            ':forma' => $idFormaPago,
        ]);

    }

    public static function Editar($idFactura, $fechaFactura, $iva, $Base, $total, $idCliente, $idFormaPago)
    {

        $conn = Database::conectar();

        $sql = "UPDATE factura SET fechaFactura = :fecha, iva = :iva, base = :base,
            totalCompra = :total, idCliente = :cliente, idFormaPago = :forma
            WHERE idFactura = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $idFactura,
            ':fecha' => $fechaFactura,
            ':iva' => $iva,
            ':base' => $Base,
            ':total' => $total,
            ':cliente' => $idCliente,
            ':forma' => $idFormaPago,
        ]);
    }

    public function filtrarFacturas($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM factura WHERE 1=1";
        $params = [];

        // Factura
        if (!empty($filtros['idFactura'])) {
            $sql .= " AND idFactura = :fac";
            $params[':fac'] = $filtros['idFactura'];
        }

        // Fecha exacta
        if (!empty($filtros['fechaExacta'])) {
            $sql .= " AND fechaFactura = :fecha";
            $params[':fecha'] = $filtros['fechaExacta'];
        }

        // Precio mínimo
        if (!empty($filtros['totalMinimo'])) {
            $sql .= " AND totalCompra >= :precioMin";
            $params[':precioMin'] = $filtros['totalMinimo'];
        }

        // Precio máximo
        if (!empty($filtros['totalMaximo'])) {
            $sql .= " AND totalCompra <= :precioMax";
            $params[':precioMax'] = $filtros['totalMaximo'];
        }

        // Cliente
        if (!empty($filtros['idCliente'])) {
            $sql .= " AND idCliente = :cliente";
            $params[':cliente'] = $filtros['idCliente'];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}