<?php
require_once './models/modeloBase.php';
require_once './models/admin/auxMarca.php';
require_once './models/admin/auxPlataforma.php';
require_once './models/admin/auxGenero.php';
require_once './models/admin/juego.php';
require_once './models/admin/consola.php';
require_once './models/admin/caracteristicasConsola.php';
require_once './models/imagenes.php';
require_once './models/admin/caracteristicasConsola.php';
class Producto extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('producto');
    }

    public static function Crear(
        array $datos,
        array $imagenes
    ): bool {
        try {
            $conn = Database::conectar();

           $sql = "INSERT INTO Producto (
    nombreProducto, precioProducto, descuentoProducto, totalProducto, garantiaProducto, idTipoProducto,
    idAdministrador_crear, stock
) VALUES (
    :nombre, :precio, :descuento, :total, :garantia, :tipo, :administrador, :stock
)";
            $stmt = $conn->prepare($sql);
            $exito = $stmt->execute([
                ':nombre' => $datos['nombreProducto'],
                ':precio' => $datos['precioProducto'],
                ':descuento' => $datos['descuentoProducto'],
                ':total' => $datos['totalProducto'],
                ':garantia' => $datos['garantiaProducto'],
                ':tipo' => $datos['idTipoProducto'],
                ':administrador' => $datos['idAdmin'],
                ':stock' => $datos['stock'],
            ]);

            $ultimo_id = $conn->lastInsertId();

            $imagen = new Imagenes();
            $imagen->subir($imagenes, $ultimo_id, $datos['idTipoProducto'], "Agregar");

            if ($datos['idTipoProducto'] === "Videojuego") {
                (new Juego())->crear($datos['lanzamiento'], $datos['sobreJuego'], $ultimo_id);
                (new AuxiliarGenero())->crear($datos['genero'], $ultimo_id);
                (new AuxiliarPlataforma())->crear($datos['plataforma'], $ultimo_id);
                (new AuxiliarMarca())->crear($datos['marca'], $ultimo_id);
            } else {
                (new Consola())->crear($datos['sobre'], $ultimo_id);
                (new AuxiliarMarca())->crear($datos['marca'], $ultimo_id);
                (new CaracteristicasConsola())->crear(
                    $datos['fuentesAlimentacion'],
                    $datos['opcionesConectividad'],
                    $datos['tiposPuertos'],
                    $datos['color'],
                    $datos['tipoControles'],
                    $datos['controlesIncluidos'],
                    $datos['controlesSoporta'],
                    $datos['tipoProcesador'],
                    $datos['resolucionImagen'],
                    $ultimo_id
                );
            }

            return true;
        } catch (Throwable $e) {
            var_dump("Error en Crear(): " . $e->getMessage());
            return false;
        }
    }

    public static function Editar(
        array $datos,
        array $imagenes
    ): bool {

        $conn = Database::conectar();

        $sql = "UPDATE Producto SET nombreProducto = :nombre, precioProducto = :precio, descuentoProducto = :descuento,
         totalProducto = :total garantiaProducto = :garantia, idTipoProducto = :tipo,
         idAdministrador_crear = :administrador, stock = :stock, ventaProducto = :venta, 

            WHERE idProducto = :id1";
        $stmt = $conn->prepare($sql);

        $exito = $stmt->execute([
            ':id1' => $datos['idProducto'],
            ':nombre' => $datos['nombreProducto'],
            ':precio' => $datos['precioProducto'],
            ':descuento' => $datos['descuentoProducto'],
            ':total' => $datos['totalProducto'],
            ':garantia' => $datos['garantiaProducto'],
            ':tipo' => $datos['idTipoProducto'],
            ':administrador' => $datos['idAdmin'],
            ':stock' => $datos['stock'],
            ':venta' => $datos['ventaproducto'],
        ]);

        if ($exito) {

            $imagen = new Imagenes();
            $resultadoImagen = $imagen->subir(
                $imagenes,
                $datos['idProducto'],
                $datos['idTipoProducto'],
                $metodo = "Editar"

            );

            (new AuxiliarMarca())->editar($datos['marca'], $datos['idProducto']);

            if ($datos['idTipoProducto'] === "Videojuego") {
                (new Juego())->Editar($datos['idProducto'], $datos['lanzamiento'], $datos['sobreJuego']);
                (new AuxiliarGenero())->editar($datos['genero'], $datos['idProducto']);
                (new AuxiliarPlataforma())->editar($datos['plataforma'], $datos['idProducto']);
                (new AuxiliarMarca())->editar($datos['marca'], $datos['idProducto']);
            } else {
                (new Consola())->Editar($datos['idProducto'], $datos['sobre']);
                (new AuxiliarMarca())->editar($datos['marca'], $datos['idProducto']);
                (new CaracteristicasConsola())->editar(
                    $datos['fuentesAlimentacion'],
                    $datos['opcionesConectividad'],
                    $datos['tiposPuertos'],
                    $datos['color'],
                    $datos['tipoControles'],
                    $datos['controlesIncluidos'],
                    $datos['controlesSoporta'],
                    $datos['tipoProcesador'],
                    $datos['resolucionImagen'],
                    $datos['idProducto']
                );
            }

            return true;
        }

        return false;
    }

    public function filtrarProductos($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM producto WHERE 1=1";
        $params = [];

        // Por nombre (LIKE)
        if (!empty($filtros['idProducto'])) {
            $sql .= " AND idProducto = :id";
            $params[':id'] = $filtros['idProducto'];
        }

        // Por nombre (LIKE)
        if (!empty($filtros['nombreProducto'])) {
            $sql .= " AND nombreProducto LIKE :nombreProducto";
            $params[':nombreProducto'] = '%' . $filtros['nombreProducto'] . '%';
        }

        // Precio mínimo
        if (!empty($filtros['precioMin'])) {
            $sql .= " AND totalProducto >= :precioMin";
            $params[':precioMin'] = $filtros['precioMin'];
        }

        // Precio máximo
        if (!empty($filtros['precioMax'])) {
            $sql .= " AND totalProducto <= :precioMax";
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

        // Disponibles
        if (!empty($filtros['disponibles'])) {
            $rango = $filtros['disponibles'];

            $rangoLimpio = trim(str_replace('unidades', '', $rango));

            if (strpos($rangoLimpio, '+') !== false) {
                $min = (int) filter_var($rangoLimpio, FILTER_SANITIZE_NUMBER_INT);
                $sql .= " AND stock >= :stockMin";
                $params[':stockMin'] = $min;
            }
            elseif (preg_match('/^(\d+)\s*a\s*(\d+)$/', $rangoLimpio, $matches)) {
                $min = (int) $matches[1];
                $max = (int) $matches[2];
                $sql .= " AND stock BETWEEN :stockMin AND :stockMax";
                $params[':stockMin'] = $min;
                $params[':stockMax'] = $max;
            }
        }
        
        // Disponibles
        if (!empty($filtros['vendidas'])) {
            $rango = $filtros['vendidas'];

            $rangoLimpio = trim(str_replace('unidades', '', $rango));

            if (strpos($rangoLimpio, '+') !== false) {
                $min = (int) filter_var($rangoLimpio, FILTER_SANITIZE_NUMBER_INT);
                $sql .= " AND ventaProducto >= :stockMin";
                $params[':stockMin'] = $min;
            }
            elseif (preg_match('/^(\d+)\s*a\s*(\d+)$/', $rangoLimpio, $matches)) {
                $min = (int) $matches[1];
                $max = (int) $matches[2];
                $sql .= " AND ventaProducto BETWEEN :stockMin AND :stockMax";
                $params[':stockMin'] = $min;
                $params[':stockMax'] = $max;
            }
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}