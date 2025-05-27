<?php

require_once './models/admin/Producto.php';

class controladorProducto {
    
    public static function consultar() {
        $Producto = new Producto();
        $Productos = $Producto->obtenerTodos();
        
        echo json_encode($Productos);
    }

    public static function consultar_Id() {
        
        $id1 = $_GET['id1'] ?? null;
        $id2 = $_GET['id2'] ?? null;
        $nombre1 = $_GET['nombre1'] ?? null;
        $nombre2 = $_GET['nombre2'] ?? null;


        if(!isset($id1, $nombre1)) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $Producto = new Producto();
        $Productos = $Producto->obtenerPorId($id1, $id2,$nombre1, $nombre2);
        
        echo json_encode($Productos);
    }

    public static function crear() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['idProducto'], $datos['nombreProducto'], $datos['precioProducto']
        , $datos['garantiaProducto'], $datos['idTipoProducto'], $datos['id'], $datos['stock'], $datos['cantidad'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Producto::Crear(
            $datos['idProducto'],
            $datos['nombreProducto'],
            $datos['precioProducto'],
            $datos['garantiaProducto'],
            $datos['idTipoProducto'],
            $datos['idAdministrador'],
            $datos['stock'],
            $datos['cantidad'],
        );


        if ($registro === "Producto_Duplicado") {
            http_response_code(409); 
            echo json_encode(["mensaje" => "El Producto ya está registrado."]);
        } elseif ($registro === true) {
            echo json_encode(["mensaje" => " creado exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al registrar el Producto."]);
        }
    }

    public static function editar() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['idProducto'], $datos['nombreProducto'], $datos['precioProducto']
        , $datos['garantiaProducto'], $datos['idTipoProducto'], $datos['idAdministrador'], $datos['stock'],
        $datos['cantidad'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Producto::Editar(
            $datos['idProducto'],
            $datos['nombreProducto'],
            $datos['precioProducto'],
            $datos['garantiaProducto'],
            $datos['idTipoProducto'],
            $datos['idAdministrador'],
            $datos['stock'],
            $datos['cantidad'],
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => " Editado exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar el Producto."]);
        }
    }
    public static function eliminar() {

        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['id1'], $datos['id2'], $datos['nombre1'], $datos['nombre2'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $id2 = $datos['id2'] ?? null;
        $nombre2 = $datos['nombre2'] ?? null;

        $Producto = new Producto();
        $resultado = $Producto->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

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
            'adminId' => $datos['idAdministrador_crear'] ?? null,
            'stock' => $datos['stock'] ?? null,
        ]);

        echo json_encode($resultados);
    }
}
