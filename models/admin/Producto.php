<?php
require_once './models/modeloBase.php';
class Producto extends ModeloBase {
    public function __construct() {
        parent::__construct('producto'); 
    }

    public static function Crear($idProducto, $nombreProducto, $precioProducto, $garantiaProducto, $idTipoProducto
    , $idAdministrador, $stock, $cantidad) {

        $conn = Database::conectar();
        $FormaPago = new FormaPago();
        $resultado = $FormaPago->obtenerPorId(id1: $idProducto, nombre1: "idProducto");

        if ($resultado){
            return "Producto_duplicado";
        }

        $sql = "INSERT INTO Producto (idProducto, nombreProducto, precioProducto, garantiaProducto, idTipoProducto,
        idAdministrador_crear, stock, cantidad) 
        VALUES (:id, :nombre, :precio, :garantia, :tipo, :administrador, :stock, :cantidad)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $idProducto,
            ':nombre' => $nombreProducto,
            ':precio' => $precioProducto,
            ':garantia' => $garantiaProducto,
            ':tipo' => $idTipoProducto,
            ':administrador' => $idAdministrador,
            ':stock' => $stock,
            ':cantidad' => $cantidad,
        ]);
    }

    public static function Editar($idProducto, $nombreProducto, $precioProducto, $garantiaProducto, $idTipoProducto
    , $idAdministrador, $stock, $cantidad) {

        $conn = Database::conectar();

        $sql = "UPDATE Producto SET nombreProducto = :nombre, precioProducto = :precio, garantiaProducto = :garantia,
         idTipoProducto = :tipo, idAdministrador_crear = :administrador, stock = :stock, cantidad = :cantidad, 
            WHERE idProducto = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id1' => $idProducto,
            ':nombre' => $nombreProducto,
            ':precio' => $precioProducto,
            ':garantia' => $garantiaProducto,
            ':tipo' => $idTipoProducto,
            ':administrador' => $idAdministrador,
            ':stock' => $stock,
            ':cantidad' => $cantidad,
        ]);
    }

}