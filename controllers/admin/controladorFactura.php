<?php

require_once './models/admin/factura.php';

class controladorFactura {
    
    public static function consultar() {
        $Factura = new Factura();
        $Facturas = $Factura->obtenerTodos();
        
        echo json_encode($Facturas);
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

        $Factura = new Factura();
        $Facturas = $Factura->obtenerPorId($id1, $id2,$nombre1, $nombre2);
        
        echo json_encode($Facturas);
    }

    public static function crear() {
        $datos = json_decode(file_get_contents("php://input"), true);
        
        if($datos){
            if(!isset($datos['fecha'], $datos['iva'], $datos['base'], $datos['total']
            , $datos['cliente'], $datos['formaPago'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }}else{
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }
        

        $registro = Factura::Crear(
            $datos['fecha'],
            $datos['iva'],
             $datos['base'],
             $datos['total'],
             $datos['cliente'],
             $datos['formaPago'],
        );


        if ($registro === true) {
            echo json_encode(["mensaje" => "Factura creada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al registrar la Factura."]);
        }
    }

    public static function editar() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if($datos){
            if(!isset($datos['idFactura'], $datos['fecha'], $datos['iva'], $datos['base'], $datos['total']
            , $datos['cliente'], $datos['formaPago'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }}else{
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }

        $registro = Factura::Editar(
            $datos['idFactura'],
            $datos['fecha'],
            $datos['iva'],
             $datos['base'],
             $datos['total'],
             $datos['cliente'],
             $datos['formaPago'],
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => "Factura Editada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar la Factura."]);
        }
    }
    public static function eliminar() {

        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['id1'], $datos['nombre1'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $id2 = $datos['id2'] ?? null;
        $nombre2 = $datos['nombre2'] ?? null;

        $Factura = new Factura();
        $resultado = $Factura->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "Factura eliminada"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar la Factura."]);
        }
    }
}
