<?php

require_once './models/admin/consola.php';

class controladorConsola {
    
    public static function consultar() {
        $Consola = new Consola();
        $Consolas = $Consola->obtenerTodos();
        
        echo json_encode($Consolas);
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

        $Consola = new Consola();
        $Consolas = $Consola->obtenerPorId($id1, $nombre1,$id2, $nombre2);
        
        echo json_encode($Consolas);
    }


    public static function editar() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['idConsola'], $datos['sobreConsola'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Consola::Editar(
            $datos['idConsola'],
            $datos['sobreConsola'],
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => " Editado exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar el Consola."]);
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

        $Consola = new Consola();
        $resultado = $Consola->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => " eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el Consola ."]);
        }
    }
}
