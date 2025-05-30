<?php
require_once './models/imagenes.php';
class ControladorImagenes
{
    public static function subirImagenes()
    {
        if (!isset($_FILES['portada']) || $_FILES['portada']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = Imagenes::subir(
            $_FILES
        );

        if ($registro) {
            echo json_encode(["mensaje" => " creado exitosamente."]);
        }
    }

    public static function consultar()
    {
        $nombre1 = $_GET['categoria'];

        if (!isset($nombre1)) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el parametro']);
            exit;
        }

        $registro = Imagenes::consultar(
            $nombre1
        );

        if ($registro) {
            echo json_encode($registro);
        }
    }

    public static function consultarPorId()
    {
        $nombre1 = $_GET['categoria'];
        $id = $_GET['id'];

        if (!isset($nombre1, $id)) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan parametros']);
            exit;
        }

        $registro = Imagenes::consultarPorId(
            $nombre1,
            $id
        );

        if ($registro) {
            echo json_encode($registro);
        }
    }

}