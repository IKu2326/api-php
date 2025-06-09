<?php

require_once './models/admin/genero.php';

class controladorGenero
{

    public static function consultar()
    {
        $Genero = new Genero();
        $Generos = $Genero->obtenerTodos();

        echo json_encode($Generos);
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

        $Genero = new Genero();
        $Generos = $Genero->obtenerPorId($id1, $nombre1, $id2, $nombre2);

        echo json_encode($Generos);
    }

    public static function crear()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['idGenero'], $datos['estado'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Genero::Crear(
            $datos['idGenero'],
            $datos['estado']
        );


        if ($registro === "Genero_Duplicado") {
            http_response_code(409);
            echo json_encode(["mensaje" => "El genero ya está registrado."]);
        } elseif ($registro === true) {
            echo json_encode(["mensaje" => "Genero juego creado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar el genero."]);
        }
    }

    public static function editar()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['idGeneroA'], $datos['idGenero'], $datos['estado'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Genero::Editar(
            $datos['idGeneroA'],
            $datos['idGenero'],
            $datos['estado']
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => "Genero Editado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al Editar el genero."]);
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

        $Genero = new Genero();
        $resultado = $Genero->eliminar($datos['id1'], $datos['nombre1'], $id2, $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "Genero eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el Genero."]);
        }
    }

    public static function filtroGenero()
    {
        $datos = $_GET;

        $Genero = new Genero();

        $resultados = $Genero->filtrarGenero([
            'nombreGenero' => $datos['nombreGenero'] ?? null,
            'stock' => $datos['stock'] ?? null
        ]);

        echo json_encode($resultados);
    }
}
