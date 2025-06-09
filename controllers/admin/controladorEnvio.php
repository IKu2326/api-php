<?php

require_once './models/admin/envioAdmin.php';

class controladorEnvioAdmin
{

    public static function consultar()
    {
        $EnvioAdmin = new EnvioAdmin();
        $EnvioAdmins = $EnvioAdmin->obtenerTodos();

        echo json_encode($EnvioAdmins);
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

        $EnvioAdmin = new EnvioAdmin();
        $EnvioAdmins = $EnvioAdmin->obtenerPorId($id1, $nombre1, $id2, $nombre2);

        echo json_encode($EnvioAdmins);
    }

    public static function crear()
    {
        $datos = $_POST;

        if ($datos) {
            if (
                !isset(
                $datos['idFactura'],
                $datos['tiempo'],
                $datos['observaciones'],
                $datos['idEstadoEnvio']
            )
            ) {
                http_response_code(400);
                echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                return;
            }
        } else {
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }


        $registro = EnvioAdmin::Crear(
            $datos['idFactura'],
            $datos['tiempo'],
            $datos['observaciones'],
            $datos['idEstadoEnvio'],
        );


        if ($registro === true) {
            echo json_encode(["mensaje" => "EnvioAdmin creado exitosamente."]);
        } else if($registro === "duplicado"){
            http_response_code(409);
            echo json_encode(["mensaje" => "Envio Duplicado elija otra Factura."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al registrar el EnvioAdmin."]);
        }
    }

    public static function editar()
    {
        $datos = $_POST;

        if ($datos) {
            if (
                !isset(
                $datos['idFactura'],
                $datos['tiempo'],
                $datos['observaciones'],
                $datos['idEstadoEnvio'],
            )
            ) {
                http_response_code(400);
                echo json_encode(["mensaje" => "Faltan datos requeridos."]);
                return;
            }
        } else {
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta, Array Vacio."]);
            return;
        }

        $registro = EnvioAdmin::Editar(
            $datos['idFactura'],
            $datos['tiempo'],
            $datos['observaciones'],
            $datos['idEstadoEnvio'],
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => "Envio Editado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al Editar el Envio."]);
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

        $EnvioAdmin = new EnvioAdmin();
        $resultado = $EnvioAdmin->eliminar($datos['id1'], $datos['nombre1'], $id2, $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "EnvioAdmin eliminada"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar la EnvioAdmin."]);
        }
    }

    public static function filtroEnvioAdmin()
    {

        $datos = $_GET;

        $EnvioAdmin = new EnvioAdmin();

        $resultados = $EnvioAdmin->filtrarEnvioAdmins([
            'id' => $datos['idFactura'] ?? null,
            'tiempo' => $datos['tiempoEstimado'] ?? null,
            'observaciones' => $datos['Observaciones'] ?? null,
            'Estado' => $datos['Estado_Envio'] ?? null,
        ]);

        echo json_encode($resultados);
    }
}
