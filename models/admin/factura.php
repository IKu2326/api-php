<?php
require_once './models/modeloBase.php';
class Factura extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('factura');
    }

    public static function Crear($idFactura, $fechaFactura, $iva, $Base, $total, $idCliente, $idFormaPago)
    {
        $conn = Database::conectar();
        $Factura = new Factura();
        $resultado = $Factura->obtenerPorId(id1: $idFactura, nombre1: "idFactura");

        if ($resultado) {
            return 'Factura_duplicada';
        } else {
            $sql = "INSERT INTO factura (idFactura, fechaFactura, iva, base, totalCompra, idCliente, idFormaPago) 
        VALUES (:id, :fecha, :iva, :base, :total, :cliente, :forma)";
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
    }

    public static function Editar($idFactura, $fechaFactura, $iva, $Base, $total, $idCliente, $idFormaPago)
    {

        $conn = Database::conectar();

        $sql = "UPDATE factura SET fechaFactura = :fecha, iva = :iva, base = :base,
            totalCompra = :total, idCliente = :cliente, idFormaPago = :forma, 
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

}