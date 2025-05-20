<?php

require_once './models/admin/formaPago.php';

class controladorFormaPago {
    
    public static function consultar() {
        $FormaPago = new FormaPago();
        $FormaPagos = $FormaPago->obtenerTodos();
        
        echo json_encode($FormaPagos);
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

        $FormaPago = new FormaPago();
        $FormaPagos = $FormaPago->obtenerPorId($id1, $id2,$nombre1, $nombre2);
        
        echo json_encode($FormaPagos);
    }

    public static function crear() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['idFormaPago'], $datos['estadoMetodoPago'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = FormaPago::Crear(
        $datos['idFormaPago'],
    $datos['estadoMetodoPago']
        );


        if ($registro === "Forma_Duplicada") {
            http_response_code(409); 
            echo json_encode(["mensaje" => "La forma ya está registrada."]);
        } elseif ($registro === true) {
            echo json_encode(["mensaje" => "Forma de pago creada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al registrar la forma de pago."]);
        }
    }

    public static function editar() {
        $datos = json_decode(file_get_contents("php://input"), true);

        if(!isset($datos['idFormaPagoA'],$datos['idFormaPago'], $datos['estadoMetodoPago'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Faltan datos requeridos."]);
            return;
        }

        $registro = FormaPago::Editar(
            $datos['idFormaPagoA'],
            $datos['idFormaPago'],
            $datos['estadoMetodoPago']
        );

        if ($registro === true) {
            echo json_encode(["mensaje" => "Forma de pago Editada exitosamente."]);
        } else {
            http_response_code(500); 
            echo json_encode(["mensaje" => "Error al Editar la forma de pago."]);
        }
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

        $FormaPago = new FormaPago();
        $resultado = $FormaPago->eliminar($datos['id1'], $id2,$datos['nombre1'], $nombre2);

        if ($resultado) {
            echo json_encode(["mensaje" => "FormaPago eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar el FormaPago."]);
        }
    }
}
