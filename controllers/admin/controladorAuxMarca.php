<?php

require_once './models/admin/auxMarca.php';

class controladorAuxiliarMarca {
    
    public static function consultar() {
        $AuxiliarMarca = new AuxiliarMarca();
        $AuxiliarMarcas = $AuxiliarMarca->obtenerTodos();
        
        echo json_encode($AuxiliarMarcas);
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
        $tipo = "Aux";
        $AuxiliarMarca = new AuxiliarMarca();
        $AuxiliarMarcas = $AuxiliarMarca->obtenerPorId($id1, $nombre1,$id2, $nombre2,$tipo);
        
        echo json_encode($AuxiliarMarcas);
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

        $AuxiliarMarca = new AuxiliarMarca();
        $resultado = $AuxiliarMarca->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "AuxiliarMarca eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el AuxiliarMarca."]);
        }
    }
}
