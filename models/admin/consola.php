<?php
require_once './models/modeloBase.php';
class Consola extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('consola');
    }

    public static function Crear($sobre, $id) {

        $conn = Database::conectar();
        $Genero = new Genero();
        $resultado = $Genero->obtenerPorId(id1: $id,nombre1: "idConsola");

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