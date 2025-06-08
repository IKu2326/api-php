<?php
require_once './models/modeloBase.php';
class DetalleFactura extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('detallefactura');
    }

    public static function Crear($Factura, $Producto, $cantidad, $valorU, $total)
    {
        $conn = Database::conectar();

        $DetalleFactura = new DetalleFactura();
        $resultado = $DetalleFactura->obtenerPorId(id1: $Factura, id2: $Producto, nombre1: "fk_pk_Factura", nombre2: "fk_pk_Producto");

        if ($resultado) {
            return "Forma_duplicada";
        }

        $sql = "INSERT INTO detallefactura (fk_pk_Factura, 	fk_pk_Producto , cantidadProducto, valorUnitarioProducto,
            totalProducto) VALUES (:factura, :producto, :cantidad, :valor, :total)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':factura' => $Factura,
            ':producto' => $Producto,
            ':cantidad' => $cantidad,
            ':valor' => $valorU,
            ':total' => $total,
        ]);

    }

    public static function Editar($Factura, $Producto, $cantidad, $valorU, $total)
    {

        $conn = Database::conectar();

        $sql = "UPDATE detallefactura SET cantidadProducto = :cantidad, valorUnitarioProducto = :valor,
            totalProducto = :total WHERE fk_pk_Factura  = :id1 AND fk_pk_Producto = :id2";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id1' => $Factura,
            ':id2' => $Producto,
            ':cantidad' => $cantidad,
            ':valor' => $valorU,
            ':total' => $total,
        ]);
    }

    public function filtrarDetalleFactura($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM detallefactura WHERE 1=1";
        $params = [];

        if (!empty($filtros['idFactura'])) {
            $sql .= " AND fk_pk_Factura = :idFactura";
            $params[':idFactura'] = $filtros['idFactura'];
        }

        if (!empty($filtros['idProducto'])) {
            $sql .= " AND fk_pk_Producto = :idProducto";
            $params[':idProducto'] = $filtros['idProducto'];
        }

        if (!empty($filtros['valorUni_Minimo'])) {
            $sql .= " AND valorUnitarioProducto >= :valorMin";
            $params[':valorMin'] = $filtros['valorUni_Minimo'];
        }

        if (!empty($filtros['valorUni_Maximo'])) {
            $sql .= " AND valorUnitarioProducto <= :valorMax";
            $params[':valorMax'] = $filtros['valorUni_Maximo'];
        }

        if (!empty($filtros['totalMinimo'])) {
            $sql .= " AND totalProducto >= :totalMin";
            $params[':totalMin'] = $filtros['totalMinimo'];
        }

        if (!empty($filtros['totalMaximo'])) {
            $sql .= " AND totalProducto <= :totalMax";
            $params[':totalMax'] = $filtros['totalMaximo'];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}