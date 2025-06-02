<?php
require_once './models/imagenes.php';
class ControladorImagenes
{
    public static function consultar()
    {
        $nombre1 = $_GET['categoria'];
        $nombre2 = $_GET['carpeta'];

        if (!isset($nombre1, $nombre2)) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el parametro']);
            exit;
        }

        $registro = Imagenes::consultar(
            $nombre1,
            $nombre2
        );

        if ($registro) {
            echo json_encode($registro);
        }
    }

    public static function consultarPorId()
    {
        $nombre1 = $_GET['categoria'];
        $nombre2 = $_GET['carpeta'];
        $id = $_GET['id'];


        if (!isset($nombre1, $id,$nombre2)) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan parametros']);
            exit;
        }

        $registro = Imagenes::consultarPorId(
            $nombre1,
            $nombre2,
            $id
        );

        if ($registro) {
            echo json_encode($registro);
        }
    }

}