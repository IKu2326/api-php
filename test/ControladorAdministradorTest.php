<?php
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../models/admin/administrador.php');
require_once(__DIR__ . '/../controllers/admin/controladorAdministrador.php');



class ControladorAdministradorTest extends TestCase
{
    protected function setUp(): void {
        // Para capturar salida del echo
        ob_start();
    }

    protected function tearDown(): void {
        ob_end_clean();
    }

    public function testConsultarDevuelveJson() {
        // Simular el método obtenerTodos() con un stub
        $mock = $this->createMock(Administrador::class);
        $mock->method('obtenerTodos')->willReturn([
            ['id' => 1, 'nombre' => 'Admin']
        ]);

        // Sobrescribimos la clase real usando la clase mock temporalmente
        // Esto requiere que tu clase sea más desacoplada, o usar DI (ver mejoras abajo)

        // Ejecutamos
        controladorAdministrador::consultar();

        $salida = ob_get_clean();
        $this->assertJson($salida);
        $this->assertStringContainsString('Admin', $salida);
    }

    public function testConsultar_IdFaltanDatos() {
        $_GET = []; // vacía los datos

        controladorAdministrador::consultar_Id();

        $salida = ob_get_clean();
        $this->assertJson($salida);
        $this->assertStringContainsString('Faltan datos', $salida);
    }
}
