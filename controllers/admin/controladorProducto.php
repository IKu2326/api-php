<?php

require_once './models/admin/Producto.php';

class controladorProducto
{

    public static function consultar()
    {
        $Producto = new Producto();
        $Productos = $Producto->obtenerTodos();

        echo json_encode($Productos);
    }

    public static function consultar_Id()
    {

        $id1 = $_GET['id1'];
        $id2 = $_GET['id2'] ?? null;
        $nombre1 = $_GET['nombre1'];
        $nombre2 = $_GET['nombre2'] ?? null;


        if (!isset($id1, $nombre1)) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $Producto = new Producto();
        $Productos = $Producto->obtenerPorId($id1, $nombre1, $id2, $nombre2);

        echo json_encode($Productos);
    }

    public static function crear()
    {
        $datos = $_POST;
        $imagenes = $_FILES;
        $producto = new Producto();

        if (!isset($datos['idTipoProducto'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta Tipo."]);
            return;
        }

        if ($datos['idTipoProducto'] === "Videojuego") {
            if (
                !isset(
                $imagenes['portada'],
                $imagenes['banner'],
                $imagenes['visuales'],
                $imagenes['trailer'],
                $datos['nombreProducto'],
                $datos['precioProducto'],
                $datos['garantiaProducto'],
                $datos['idAdmin'],
                $datos['stock'],
                $datos['cantidad'],
                $datos['marca'],
                $datos['plataforma'],
                $datos['genero'],
                $datos['lanzamiento'],
                $datos['sobreJuego']
            )
            ) {
                http_response_code(400);
                echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                return;
            }
            $resultado = $producto->Crear($datos, $imagenes);
        } else {
            if (
                !isset(
                $imagenes['portada'],
                $imagenes['visuales'],
                $datos['nombreProducto'],
                $datos['precioProducto'],
                $datos['garantiaProducto'],
                $datos['idAdmin'],
                $datos['stock'],
                $datos['cantidad'],
                $datos['marca'],
                $datos['sobre'],
                $datos['fuentesAlimentacion'],
                $datos['opcionesConectividad'],
                $datos['tiposPuertos'],
                $datos['color'],
                $datos['tipoControles'],
                $datos['controlesIncluidos'],
                $datos['controlesSoporta'],
                $datos['tipoProcesador'],
                $datos['resolucionImagen']
            )
            ) {
                http_response_code(400);
                echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                return;
            }
            $resultado = $producto->Crear($datos, $imagenes);
        }

        if ($resultado === true) {
            echo json_encode(["mensaje" => "Creado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar producto"]);
        }
    }


    public static function editar()
    {
        $datos = $_POST;
        $imagenes = $_FILES;
        $producto = new Producto();

        if (!isset($datos['idTipoProducto'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta Tipo."]);
            return;
        }

        if ($datos['idTipoProducto'] === "Videojuego") {
            if (
                !isset(
                $imagenes['portada'],
                $imagenes['banner'],
                $imagenes['visuales'],
                $imagenes['trailer'],
                $datos['idProducto'],
                $datos['nombreProducto'],
                $datos['precioProducto'],
                $datos['garantiaProducto'],
                $datos['idAdmin'],
                $datos['stock'],
                $datos['cantidad'],
                $datos['marca'],
                $datos['plataforma'],
                $datos['genero'],
                $datos['lanzamiento'],
                $datos['sobreJuego']
            )
            ) {
                http_response_code(400);
                echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                return;
            }
            $resultado = $producto->Crear($datos, $imagenes);
        } else {
            if (
                !isset(
                $imagenes['portada'],
                $imagenes['visuales'],
                $datos['idProducto'],
                $datos['nombreProducto'],
                $datos['precioProducto'],
                $datos['garantiaProducto'],
                $datos['idAdmin'],
                $datos['stock'],
                $datos['cantidad'],
                $datos['marca'],
                $datos['sobre'],
                $datos['fuentesAlimentacion'],
                $datos['opcionesConectividad'],
                $datos['tiposPuertos'],
                $datos['color'],
                $datos['tipoControles'],
                $datos['controlesIncluidos'],
                $datos['controlesSoporta'],
                $datos['tipoProcesador'],
                $datos['resolucionImagen']
            )
            ) {
                http_response_code(400);
                echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                return;
            }
            $resultado = $producto->Crear($datos, $imagenes);
        }

        if ($resultado === true) {
            echo json_encode(["mensaje" => "Creado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar producto"]);
        }
    }
    public static function eliminar()
    {

        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['id1'], $datos['id2'], $datos['nombre1'], $datos['nombre2'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $id2 = $datos['id2'] ?? null;
        $nombre2 = $datos['nombre2'] ?? null;

        $Producto = new Producto();
        $resultado = $Producto->eliminar($datos['id1'], $id2, $datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => " eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el Producto ."]);
        }
    }
    public static function filtroProductos()
    {
        $datos = $_GET; // o $_POST o JSON

        $producto = new Producto();

        $resultados = $producto->filtrarProductos([
            'idProducto' => $datos['idProducto'] ?? null,
            'nombreProducto' => $datos['nombreProducto'] ?? null,
            'precioMin' => $datos['precioMin'] ?? null,
            'precioMax' => $datos['precioMax'] ?? null,
            'tipoProducto' => $datos['Tipo_Producto'] ?? null,
            'adminId' => $datos['ID_Administrador'] ?? null,
            'stock' => $datos['stock'] ?? null,
        ]);

        echo json_encode($resultados);
    }
}
