<?php
require_once './models/modeloBase.php';
class Producto extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('producto');
    }

    public static function Crear(
        $idProducto,
        $nombreProducto,
        $precioProducto,
        $garantiaProducto,
        $idTipoProducto
        ,
        $idAdministrador,
        $stock,
        $cantidad
    ) {

        $conn = Database::conectar();
        $FormaPago = new FormaPago();
        $resultado = $FormaPago->obtenerPorId(id1: $idProducto, nombre1: "idProducto");

        if ($resultado) {
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

    public static function Editar(
        $idProducto,
        $nombreProducto,
        $precioProducto,
        $garantiaProducto,
        $idTipoProducto
        ,
        $idAdministrador,
        $stock,
        $cantidad
    ) {

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

    public function filtrarProductos($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM producto WHERE 1=1";
        $params = [];

        // Por nombre (LIKE)
        if (!empty($filtros['nombreProducto'])) {
            $sql .= " AND nombreProducto LIKE :nombreProducto";
            $params[':nombreProducto'] = '%' . $filtros['nombreProducto'] . '%';
        }

        // Precio mínimo
        if (!empty($filtros['precioMin'])) {
            $sql .= " AND precioProducto >= :precioMin";
            $params[':precioMin'] = $filtros['precioMin'];
        }

        // Precio máximo
        if (!empty($filtros['precioMax'])) {
            $sql .= " AND precioProducto <= :precioMax";
            $params[':precioMax'] = $filtros['precioMax'];
        }

        // Tipo de producto
        if (!empty($filtros['tipoProducto'])) {
            $sql .= " AND idTipoProducto = :tipoProducto";
            $params[':tipoProducto'] = $filtros['tipoProducto'];
        }

        // ID administrador creador
        if (!empty($filtros['adminId'])) {
            $sql .= " AND idAdministrador_crear = :adminId";
            $params[':adminId'] = $filtros['adminId'];
        }

        // Stock mínimo
        if (!empty($filtros['stock'])) {
            $sql .= " AND stock = :stock";
            $params[':stock'] = $filtros['stock'];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}