<?php

require_once './models/admin/auxMarca.php';
require_once './models/admin/auxPlataforma.php';
require_once './models/admin/auxGenero.php';
require_once './models/admin/juego.php';
require_once './models/admin/consola.php';
require_once './models/admin/caracteristicasConsola.php';
require_once './models/imagenes.php';
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
            $camposRequeridos = [
                'portada' => $imagenes['portada'] ?? null,
                'banner' => $imagenes['banner'] ?? null,
                'visual1' => $imagenes['visual1'] ?? null,
                'visual2' => $imagenes['visual2'] ?? null,
                'visual3' => $imagenes['visual3'] ?? null,
                'trailer' => $imagenes['trailer'] ?? null,
                'nombreProducto' => $datos['nombreProducto'] ?? null,
                'precioProducto' => $datos['precioProducto'] ?? null,
                'garantiaProducto' => $datos['garantiaProducto'] ?? null,
                'idAdmin' => $datos['idAdmin'] ?? null,
                'stock' => $datos['stock'] ?? null,
                'cantidad' => $datos['cantidad'] ?? null,
                'marca' => $datos['marca'] ?? null,
                'plataforma' => $datos['plataforma'] ?? null,
                'genero' => $datos['genero'] ?? null,
                'lanzamiento' => $datos['lanzamiento'] ?? null,
                'sobreJuego' => $datos['sobreJuego'] ?? null,
            ];

            $faltantes = [];

            foreach ($camposRequeridos as $campo => $valor) {
                if (!isset($valor) && $valor !== 0) {
                    $faltantes[] = $campo;
                } elseif ($campo !== 'stock' && empty($valor)) {
                    $faltantes[] = $campo;
                }
            }

            if (!empty($faltantes)) {
                http_response_code(400);
                echo json_encode([
                    "mensaje" => "Faltan datos requeridos.",
                    "faltantes" => $faltantes
                ]);
                return;
            }

            $resultado = $producto->Crear($datos, $imagenes);
        } else {
            $camposRequeridos = [
                'portada' => $imagenes['portada'] ?? null,
                'visual1' => $imagenes['visual1'] ?? null,
                'visual2' => $imagenes['visual2'] ?? null,
                'visual3' => $imagenes['visual3'] ?? null,
                'nombreProducto' => $datos['nombreProducto'] ?? null,
                'precioProducto' => $datos['precioProducto'] ?? null,
                'garantiaProducto' => $datos['garantiaProducto'] ?? null,
                'idAdmin' => $datos['idAdmin'] ?? null,
                'stock' => $datos['stock'] ?? null,
                'cantidad' => $datos['cantidad'] ?? null,
                'marca' => $datos['marca'] ?? null,
                'sobre' => $datos['sobre'] ?? null,
                'fuentesAlimentacion' => $datos['fuentesAlimentacion'] ?? null,
                'opcionesConectividad' => $datos['opcionesConectividad'] ?? null,
                'tiposPuertos' => $datos['tiposPuertos'] ?? null,
                'color' => $datos['color'] ?? null,
                'tipoControles' => $datos['tipoControles'] ?? null,
                'controlesIncluidos' => $datos['controlesIncluidos'] ?? null,
                'controlesSoporta' => $datos['controlesSoporta'] ?? null,
                'tipoProcesador' => $datos['tipoProcesador'] ?? null,
                'resolucionImagen' => $datos['resolucionImagen'] ?? null,
            ];

            $faltantes = [];

            foreach ($camposRequeridos as $campo => $valor) {
                if (!isset($valor) && $valor !== 0) {
                    $faltantes[] = $campo;
                } elseif ($campo !== 'stock' && empty($valor)) {
                    $faltantes[] = $campo;
                }
            }

            if (!empty($faltantes)) {
                http_response_code(400);
                echo json_encode([
                    "mensaje" => "Faltan datos requeridos.",
                    "faltantes" => $faltantes
                ]);
                return;
            }
            $resultado = $producto->Crear($datos, $imagenes);
        }

        if ($resultado == true) {
            echo json_encode(["mensaje" => "Creado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar producto"]);
        }
    }


    public static function editar()
    {
        header('Content-Type: application/json');

        echo json_encode([
            'POST' => $_POST,
            'FILES' => $_FILES
        ]);
        $datos = $_POST;
        $imagenes = $_FILES;
        $producto = new Producto();

        if (empty($datos['idTipoProducto'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta Tipo."]);
            return;
        }


        if ($datos['idTipoProducto'] === "Videojuego") {
            $camposRequeridos = [
                'idProducto' => $datos['idProducto'] ?? null,
                'nombreProducto' => $datos['nombreProducto'] ?? null,
                'precioProducto' => $datos['precioProducto'] ?? null,
                'garantiaProducto' => $datos['garantiaProducto'] ?? null,
                'idAdmin' => $datos['idAdmin'] ?? null,
                'stock' => $datos['stock'] ?? null,
                'cantidad' => $datos['cantidad'] ?? null,
                'marca' => $datos['marca'] ?? null,
                'plataforma' => $datos['plataforma'] ?? null,
                'genero' => $datos['genero'] ?? null,
                'lanzamiento' => $datos['lanzamiento'] ?? null,
                'sobreJuego' => $datos['sobreJuego'] ?? null,
            ];

            $faltantes = [];

            foreach ($camposRequeridos as $campo => $valor) {
                if (!isset($valor) && $valor !== 0) {
                    $faltantes[] = $campo;
                } elseif ($campo !== 'stock' && empty($valor)) {
                    $faltantes[] = $campo;
                }
            }

            if (!empty($faltantes)) {
                http_response_code(400);
                echo json_encode([
                    "mensaje" => "Faltan datos requeridos.",
                    "faltantes" => $faltantes
                ]);
                return;
            }
            $resultado = $producto->Editar($datos, $imagenes);
        } else {
            if (
                !isset(
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
            $resultado = $producto->Editar($datos, $imagenes);
        }

        if ($resultado === true) {
            echo json_encode(["mensaje" => "Editado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al Editar producto"]);
        }
    }
    public static function eliminar()
    {

        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['id1'], $datos['nombre1'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $id2 = $datos['id2'] ?? null;
        $nombre2 = $datos['nombre2'] ?? null;



        (new Imagenes())->eliminar($datos['id1']);
        (new AuxiliarMarca())->eliminar($datos['id1'], nombre1: "fk_pk_producto");
        (new AuxiliarGenero())->eliminar($datos['id1'], nombre1: "fk_pk_juego");
        (new AuxiliarPlataforma())->eliminar($datos['id1'], nombre1: "idJuego");

        (new Juego())->eliminar($datos['id1'], nombre1: "idJuego");
        (new Consola())->eliminar($datos['id1'], nombre1: "idConsola");

        $Producto = new Producto();
        $resultado = $Producto->eliminar($datos['id1'], $datos['nombre1']);

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
