<?php
require_once './models/Envia.php';

class EnviosController
{
  static public function cotizar()
    {
        // Obtener los datos JSON del body
        $body = json_decode(file_get_contents("php://input"), true);

        if (!$body) {
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos"]);
            return;
        }

        $envia = new Envia();
        $resultado = $envia->cotizarEnvio($body);

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
}
