<?php
require_once './models/modeloBase.php';
class Consola extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('consola');
    }

    public static function Crear($sobre, $id) {
        try {
        $conn = Database::conectar();
        $Consola = new Consola();
        $resultado = $Consola->obtenerPorId(id1: $id,nombre1: "idConsola");

        if ($resultado){
            return "Consola_duplicado";
        }

        $sql = "INSERT INTO consola (idConsola, sobreConsola) 
        VALUES (:id, :descripcion)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':descripcion' => $sobre
        ]);
        } catch (Throwable $e) {
            var_dump("Error en Crear(Consola): " . $e->getMessage());
            return false;
        }
    }

    public static function Editar($idConsola, $sobre)
    {

        $conn = Database::conectar();

        $sql = "UPDATE consola SET sobreConsola = :sobreConsola
            WHERE idConsola = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'id1' => $idConsola,
            'sobreConsola' => $sobre,
        ]);
    }
}