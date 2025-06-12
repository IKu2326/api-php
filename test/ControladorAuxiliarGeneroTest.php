<?php
use PHPUnit\Framework\TestCase;

require_once './controllers/admin/controladorAuxiliarGenero.php';
require_once './models/admin/auxGenero.php';

class AuxiliarGeneroMock extends AuxiliarGenero {
    public function obtenerTodos() {
        return [['id' => 1, 'nombre' => 'Acción']];
    }

    public function obtenerPorId($id1, $nombre1, $id2, $nombre2, $tipo) {
        return ['id' => $id1, 'nombre' => $nombre1, 'tipo' => $tipo];
    }

    public function eliminar($id1, $nombre1, $id2, $nombre2) {
        return true;
    }
}

class ControladorAuxiliarGeneroTest extends TestCase
{
    protected function setUp(): void
    {
        // Redefinir la clase usada internamente si es necesario
        require_once './models/admin/auxGenero.php';
    }

    public function testConsultarDevuelveJson()
    {
        // Simular la salida
        ob_start();
        controladorAuxiliarGenero::consultar();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertIsArray($datos);
    }

    public function testConsultar_IdFaltanDatos()
    {
        $_GET = []; // vacíos

        ob_start();
        controladorAuxiliarGenero::consultar_Id();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertEquals("Faltan datos requeridos.", $datos['mensaje']);
    }

    public function testConsultar_IdCorrecto()
    {
        $_GET = [
            'id1' => 1,
            'nombre1' => 'Acción'
        ];

        ob_start();
        controladorAuxiliarGenero::consultar_Id();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertEquals('Acción', $datos['nombre']);
    }

    public function testEliminarFaltanDatos()
    {
        $json = json_encode([]); // vacío
        file_put_contents('php://input', $json);

        ob_start();
        controladorAuxiliarGenero::eliminar();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertEquals("Faltan datos requeridos.", $datos['mensaje']);
    }

    public function testEliminarExitoso()
    {
        $data = [
            'id1' => 1,
            'nombre1' => 'Acción'
        ];
        $json = json_encode($data);
        stream_wrapper_unregister("php");
        stream_wrapper_register("php", "MockPhpStream");
        file_put_contents('php://input', $json);

        ob_start();
        controladorAuxiliarGenero::eliminar();
        $salida = ob_get_clean();

        $this->assertJson($salida);
        $datos = json_decode($salida, true);
        $this->assertEquals("AuxiliarGenero eliminado", $datos['mensaje']);
    }
}
