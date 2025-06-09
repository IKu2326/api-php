<?php

require_once './models/admin/estadoEnvio.php';

class controladorEstadoEnvio {
    
    public static function consultar() {
        $EstadoEnvio = new EstadoEnvio();
        $EstadoEnvios = $EstadoEnvio->obtenerTodos();
        
        echo json_encode($EstadoEnvios);
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

        $EstadoEnvio = new EstadoEnvio();
        $EstadoEnvios = $EstadoEnvio->obtenerPorId($id1, $nombre1);
        
        echo json_encode($EstadoEnvios);
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

        $EstadoEnvio = new EstadoEnvio();
        $resultado = $EstadoEnvio->eliminar($datos['id1'], $datos['nombre1'],$id2, $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "EstadoEnvio eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el EstadoEnvio."]);
        }
    }
}