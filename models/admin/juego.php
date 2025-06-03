<?php
require_once './models/modeloBase.php';
class Juego extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('juego');
    }

    public static function Crear($lanzamiento, $sobre, $id) {

        $conn = Database::conectar();
        $Genero = new Genero();
        $resultado = $Genero->obtenerPorId(id1: $id,nombre1: "idJuego");

        if ($resultado){
            return "Juego_duplicado";
        }

        $sql = "INSERT INTO juego (idJuego, anoLanzamiento, descripcionJuego) 
        VALUES (:id, :lanzamiento, :descripcion)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':lanzamiento' => $lanzamiento,
            ':descripcion' => $sobre
        ]);
    }
    public static function Editar($idJuego, $Lanzamiento, $Descripcion)
    {

        $conn = Database::conectar();

        $sql = "UPDATE juego SET anoLanzamiento = :Lanzamiento, descripcionJuego = :descripcionJuego 
            WHERE idJuego = :id1";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'id1' => $idJuego,
            'Lanzamiento' => $Lanzamiento,
            'descripcionJuego' => $Descripcion
        ]);
    }
}