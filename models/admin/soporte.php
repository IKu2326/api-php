<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './models/modeloBase.php';
require 'vendor/autoload.php';
class SoporteAdmin extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('soporte');
    }

    public static function Crear($id, $fecha, $pqrs)
    {

        $conn = Database::conectar();
        $Soporte = new SoporteAdmin();
        $resultado = $Soporte->obtenerPorId(id1: $id, nombre1: "idCliente");

        if ($resultado) {
            return "PQRS_duplicada";
        }

        $sql = "INSERT INTO Soporte (idCliente, fecha, pqrs) 
        VALUES (:id, :fecha, :pqrs)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':fecha' => $fecha,
            ':pqrs' => $pqrs
        ]);
    }

    public static function Editar($id, $fecha, $pqrs)
    {

        $conn = Database::conectar();

        $sql = "UPDATE soporte SET fecha = :fecha, pqrs = :pqrs 
            WHERE idCliente = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':fecha' => $fecha,
            ':pqrs' => $pqrs
        ]);
    }

    public static function responderM($id, $fecha, $pqrs, $respuesta)
    {

        $conn = Database::conectar();

        $sqlCorreoUsuario = "SELECT nombreUsuario, apellidoUsuario, correoUsuario FROM usuario WHERE idUsuario = :id";
        $stmt = $conn->prepare($sqlCorreoUsuario);
        $stmt->execute([':id' => $id]);
        $Usuario = $stmt->fetch(PDO::FETCH_ASSOC) ?: false;

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ksmc825@gmail.com';
            $mail->Password = 'fzqadvntrmjucdmz';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Remitente y destinatario
            $mail->setFrom('ksmc825@gmail.com', 'NVS');
            $mail->addAddress($Usuario['correoUsuario'], $Usuario['nombreUsuario'] . ' ' . $Usuario['apellidoUsuario']);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Equipo Tecnico NVS (New Vision Store)';
            $mail->Body = $respuesta;
            $mail->AltBody = 'Este es el contenido del correo en texto plano';

            $mail->send();

            (new SoporteAdmin())->Eliminar($id, "idCliente", $fecha, "fecha");

            return true;
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function filtrarSoportes($filtros = [])
    {
        $conn = Database::conectar();

        $sql = "SELECT * FROM Soporte WHERE 1=1";
        $params = [];

        if (!empty($filtros['idCliente'])) {
            $sql .= " AND idCliente = :idCliente";
            $params[':idCliente'] = $filtros['idCliente'];
        }

        if (!empty($filtros['fecha'])) {
            $sql .= " AND fecha = :fecha";
            $params[':fecha'] = $filtros['fecha'];
        }

        if (!empty($filtros['Pregunta_Queja_Reclamo'])) {
            $sql .= " AND pqrs LIKE :pqrs";
            $params[':pqrs'] = '%' . $filtros['Pregunta_Queja_Reclamo'] . '%';
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}