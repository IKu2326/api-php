<?php

require_once './models/admin/plataforma.php';

class controladorPlataforma

{

    public static function consultar()
    {
        $Plataforma = new Plataforma();
        $Plataformas = $Plataforma->obtenerTodos();

        echo json_encode($Plataformas);
    }

    public static function consultar_Id()
    {

        $id1 = $_GET['id1'] ?? null;
        $id2 = $_GET['id2'] ?? null;
        $nombre1 = $_GET['nombre1'] ?? null;
        $nombre2 = $_GET['nombre2'] ?? null;


        if (!isset($id1, $nombre1)) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $Plataforma = new Plataforma();
        $Plataformas = $Plataforma->obtenerPorId($id1, $nombre1, $id2, $nombre2);

        echo json_encode($Plataformas);
    }

    public static function crear()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['idPlataforma'], $datos['estado'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Plataforma::Crear(
            $datos['idPlataforma'],
            $datos['estado']
        );


        if ($registro === "Plataforma_Duplicada") {
            http_response_code(409);
            echo json_encode(["mensaje" => "La Plataforma ya está registrada."]);
        } elseif ($registro === true) {
            echo json_encode(["mensaje" => "Plataforma creada exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar la Plataforma."]);
        }
    }

    public static function editar()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['idPlataformaA'], $datos['idPlataforma'], $datos['estado'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Plataforma::Editar(
            $datos['idPlataformaA'],
            $datos['idPlataforma'],
            $datos['estado']
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => "Plataforma Editada exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al Editar la Plataforma."]);
        }
    }
    public static function eliminar()
    {

        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['id1'], $datos['nombre1'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $id2 = $datos['id2'] ?? null;
        $nombre2 = $datos['nombre2'] ?? null;

        $Plataforma = new Plataforma();
        $resultado = $Plataforma->eliminar($datos['id1'], $id2, $datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "Plataforma eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el Plataforma."]);
        }
    }

    public static function filtroPlataforma()
    {
        $datos = $_GET;

        $Plataforma = new Plataforma();

        $resultados = $Plataforma->filtrarPlataforma([
            'nombrePlataforma' => $datos['nombrePlataforma'] ?? null,
            'stock' => $datos['stock'] ?? null
        ]);

        echo json_encode($resultados);
    }
}
