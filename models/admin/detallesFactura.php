<?php
require_once './models/modeloBase.php';
class DetalleFactura extends ModeloBase {
    public function __construct(){
        parent::__construct('detallefactura');
    }

    public static function Crear($Factura, $Producto, $cantidad, $valorU, $total)
    {
        $conn = Database::conectar();

        $DetalleFactura = new DetalleFactura();
        $resultado = $DetalleFactura->obtenerPorId(id1: $Factura, id2:$Producto, nombre1: "fk_pk_Factura", nombre2: "fk_pk_Producto");

        if ($resultado){
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

}