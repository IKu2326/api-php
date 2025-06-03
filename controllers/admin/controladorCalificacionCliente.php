<?php

require_once './models/admin/calificacionCliente.php';

class controladorCalificacionCliente {
    
    public static function consultar() {
        $CalificacionCliente = new CalificacionCliente();
        $CalificacionClientes = $CalificacionCliente->obtenerTodos();
        
        echo json_encode($CalificacionClientes);
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

        $CalificacionCliente = new CalificacionCliente();
        $CalificacionClientes = $CalificacionCliente->obtenerPorId($id1, $nombre1,$id2, $nombre2);
        
        echo json_encode($CalificacionClientes);
    }

    public static function crear() {
        $datos = json_decode(file_get_contents("php://input"), true);
        
        if($datos){
            if(!isset($datos['idCliente'], $datos['idProducto'], $datos['numeroCalificacion'], $datos['comentarioCalificacion'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }}else{
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }
        

        $registro = CalificacionCliente::Crear(
            $datos['idCliente'],
            $datos['idProducto'],
            $datos['numeroCalificacion'],
             $datos['comentarioCalificacion']
        );


        if ($registro === "CalificacionCliente_duplicada") {
            http_response_code(409); 
            echo json_encode(["mensaje" => "La Calificacion ya está registrada."]);
        } elseif ($registro === true) {
            echo json_encode(["mensaje" => "Calificacion creada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al registrar la Calificacion."]);
        }
    }

    public static function editar() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if($datos){
            if(!isset($datos['idCliente'], $datos['idProducto'], $datos['numeroCalificacion'], $datos['comentarioCalificacion'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }}else{
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }

        $registro = CalificacionCliente::Editar(
            $datos['idCliente'],
            $datos['idProducto'],
            $datos['numeroCalificacion'],
            $datos['comentarioCalificacion']
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => "Calificacion Editada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar la Calificacion."]);
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

        $FormaPago = new CalificacionCliente();
        $resultado = $FormaPago->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "Calificacion eliminad"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar la Calificacion."]);
        }
    }
}
