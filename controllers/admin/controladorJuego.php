<?php

require_once './models/admin/Juego.php';

class controladorJuego {
    
    public static function consultar() {
        $Juego = new Juego();
        $Juegos = $Juego->obtenerTodos();
        
        echo json_encode($Juegos);
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

        $Juego = new Juego();
        $Juegos = $Juego->obtenerPorId($id1, $nombre1,$id2, $nombre2);
        
        echo json_encode($Juegos);
    }


    public static function editar() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['idJuego'], $datos['Lanzamiento'], $datos['descripcion'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Juego::Editar(
            $datos['idJuego'],
            $datos['Lanzamiento'],
            $datos['descripcion']
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => " Editado exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar el Juego."]);
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

        $Juego = new Juego();
        $resultado = $Juego->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => " eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el Juego ."]);
        }
    }
}
