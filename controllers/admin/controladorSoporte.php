<?php

require_once './models/admin/soporte.php';

class controladorSoporteAdmin {
    
    public static function consultar() {
        $Soporte = new SoporteAdmin();
        $Soportes = $Soporte->obtenerTodos();
        
        echo json_encode($Soportes);
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

        $Soporte = new SoporteAdmin();
        $Soportes = $Soporte->obtenerPorId($id1, $nombre1,$id2, $nombre2);
        
        echo json_encode($Soportes);
    }


    public static function editar() {
        $datos = $_POST;

        if(!isset($datos['idCliente'], $datos['fecha'], $datos['pqrs'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = SoporteAdmin::Editar(
            $datos['idCliente'],
            $datos['fecha'],
            $datos['pqrs']
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => " Editado exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar el Soporte."]);
        }
    }

    public static function responder() {
        $datos = $_POST;
        
        if(!isset($datos['idCliente'], $datos['fecha'], $datos['pqrs'], $datos['respuesta'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = SoporteAdmin::responderM(
            $datos['idCliente'],
            $datos['fecha'],
            $datos['pqrs'],
            $datos['respuesta'],
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => " Respondido exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al responder el Soporte."]);
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

        $Soporte = new SoporteAdmin();
        $resultado = $Soporte->eliminar($datos['id1'], $datos['nombre1'],$id2, $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => " eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el Soporte ."]);
        }
    }

    public static function filtroSoporte()
    {
        $datos = $_GET;

        $Soporte = new SoporteAdmin();

        $resultados = $Soporte->filtrarSoportes([
            'idCliente' => $datos['idCliente'] ?? null,
            'fecha' => $datos['fecha'] ?? null,
            'Pregunta_Queja_Reclamo' => $datos['Pregunta_Queja_Reclamo'] ?? null,
        ]);

        echo json_encode($resultados);
    }
}
