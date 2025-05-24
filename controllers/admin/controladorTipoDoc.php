<?php

require_once './models/admin/tipoDoc.php';

class controladorTipoDoc {
    
    public static function consultar() {
        $TipoDoc = new TipoDoc();
        $TipoDocs = $TipoDoc->obtenerTodos();
        
        echo json_encode($TipoDocs);
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

        $TipoDoc = new TipoDoc();
        $TipoDocs = $TipoDoc->obtenerPorId($id1, $id2,$nombre1, $nombre2);
        
        echo json_encode($TipoDocs);
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

        $TipoDoc = new TipoDoc();
        $resultado = $TipoDoc->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "TipoDoc eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el TipoDoc."]);
        }
    }
}
