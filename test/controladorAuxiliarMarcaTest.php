<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../models/admin/auxMarca.php');
require_once(__DIR__ . '/../controllers/admin/controladorAuxMarca.php');

class ControladorAuxiliarMarcaTest extends TestCase
{
    public function testConsultarDevuelveJson()
    {
        ob_start();
        controladorAuxiliarMarca::consultar();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertIsArray($datos);
    }

    public function testConsultar_IdFaltanDatos()
    {
        $_GET = []; // No se envían id1 ni nombre1
        ob_start();
        controladorAuxiliarMarca::consultar_Id();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertArrayHasKey('mensaje', $datos);
        $this->assertEquals('Faltan datos requeridos.', $datos['mensaje']);
    }

    public function testEliminarFaltanDatos()
    {
        $input = json_encode([]); // No se envía id1 ni nombre1
        file_put_contents('php://input', $input);

        ob_start();
        controladorAuxiliarMarca::eliminar();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertArrayHasKey('mensaje', $datos);
        $this->assertEquals('Faltan datos requeridos.', $datos['mensaje']);
    }
}
