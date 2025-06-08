<?php

require_once './models/admin/Detallesfactura.php';

class controladorDetallesFactura {
    
    public static function consultar() {
        $DetallesFactura = new DetalleFactura();
        $DetallesFacturas = $DetallesFactura->obtenerTodos();
        
        echo json_encode($DetallesFacturas);
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

        $DetallesFactura = new DetalleFactura();
        $DetallesFacturas = $DetallesFactura->obtenerPorId($id1, $nombre1,$id2, $nombre2);
        
        echo json_encode($DetallesFacturas);
    }

    public static function crear() {
        $datos = json_decode(file_get_contents("php://input"), true);
        
        if($datos){
            if(!isset($datos['factura'], $datos['producto'], $datos['cantidad'], $datos['valor']
            , $datos['total'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }}else{
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }
        

        $registro = DetalleFactura::Crear(
            $datos['factura'],
            $datos['producto'],
             $datos['cantidad'],
             $datos['valor'],
             $datos['total'],
        );


        if ($registro === true) {
            echo json_encode(["mensaje" => "DetallesFactura creada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al registrar la DetallesFactura."]);
        }
    }

    public static function editar() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if($datos){
            if(!isset($datos['factura'], $datos['producto'], $datos['cantidad'], $datos['valor']
            , $datos['total'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }}else{
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }

        $registro = DetalleFactura::Editar(
            $datos['factura'],
            $datos['producto'],
            $datos['cantidad'],
             $datos['valor'],
             $datos['total'],
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => "DetallesFactura Editada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar la DetallesFactura."]);
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

        $DetallesFactura = new DetalleFactura();
        $resultado = $DetallesFactura->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "DetallesFactura eliminada"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar la DetallesFactura."]);
        }
    }

    public static function filtroDetallesFactura()
    {
        $datos = $_GET; 

        $Detalles = new DetalleFactura();

        $resultados = $Detalles->filtrarDetalleFactura([
            'idFactura' => $datos['idFactura'] ?? null,
            'idProducto' => $datos['idProducto'] ?? null,
            'valorUni_Minimo' => $datos['valorUni_Minimo'] ?? null,
            'valorUni_Maximo' => $datos['valorUni_Maximo'] ?? null,
            'totalMinimo' => $datos['totalMinimo'] ?? null,
            'totalMaximo' => $datos['totalMaximo'] ?? null,
        ]);

        echo json_encode($resultados);
    }
}
