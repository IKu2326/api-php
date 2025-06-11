<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class EnviarEmail
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function enviarCorreo($cuerpoHtml, $archivoAdjunto = null)
    {
        try {
            // Configuración del servidor SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'sebastianrjs03@gmail.com'; // Tu correo
            $this->mail->Password = 'rmnrvdwogozvsqdl'; // Tu contraseña de aplicación
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = 587;

            // Configuración del mensaje
            $this->mail->setFrom('sebastianrjs03@gmail.com', 'PRUEBA REX');
            $this->mail->addAddress('garmilena79@gmail.com', 'Destinatario');
            $this->mail->isHTML(true);
            $this->mail->Subject = 'PRUEBA DE ENVÍO DE CORREO';
            $this->mail->Body = $cuerpoHtml;

              
            if ($archivoAdjunto && file_exists($archivoAdjunto)) {
                $this->mail->addAttachment($archivoAdjunto);
            }

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$this->mail->ErrorInfo}";
        }
    }
}
