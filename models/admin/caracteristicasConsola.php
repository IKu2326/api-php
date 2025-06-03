<?php
require_once './models/modeloBase.php';
class CaracteristicasConsola extends ModeloBase
{
    public function __construct()
    {
        parent::__construct('caracteristicasconsola');
    }

    public static function Crear(
        $fuentes,
        $conectividad,
        $tiposPuertos,
        $color,
        $tipoControles,
        $controlesIncluidos,
        $controlesSoporta,
        $tipoProcesador,
        $resolucionImagen,
        $id
    ) {
        $conn = Database::conectar();

        $sql = "INSERT INTO caracteristicasconsola (idConsola, color, tipoControles, controlesIncluidos,
            controlesSoporta, tipoProcesador, resolucion, fuenteAlimentacion, opcionConectividad, tipoPuertos) 
        VALUES (:id, :color, :tipo, :controlesInc, :controlesSop, :tipoProcesador, :resolucion, fuenteAlimentacion,
        :opcionConectividad, :tipoPuertos)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':color' => $color,
            ':tipo' => $tipoControles,
            ':controlesInc' => $controlesIncluidos,
            ':controlesSop' => $controlesSoporta,
            ':tipoProcesador' => $tipoProcesador,
            ':resolucion' => $resolucionImagen,
            ':fuenteAlimentacion' => $fuentes,
            ':opcionConectividad' => $conectividad,
            ':tipoPuertos' => $tiposPuertos,
        ]);

    }

    public static function Editar(
        $fuentes,
        $conectividad,
        $tiposPuertos,
        $color,
        $tipoControles,
        $controlesIncluidos,
        $controlesSoporta,
        $tipoProcesador,
        $resolucionImagen,
        $id
    ) {

        $conn = Database::conectar();

        $sql = "UPDATE caracteristicasconsola 
                SET color = :color,
                    tipoControles = :tipo,
                    controlesIncluidos = :controlesInc,
                    controlesSoporta = :controlesSop,
                    tipoProcesador = :tipoProcesador,
                    resolucion = :resolucion,
                    fuenteAlimentacion = :fuenteAlimentacion,
                    opcionConectividad = :opcionConectividad,
                    tipoPuertos = :tipoPuertos
                    WHERE idConsola = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':color' => $color,
            ':tipoControles' => $tipoControles,
            ':controlesInc' => $controlesIncluidos,
            ':controlesSop' => $controlesSoporta,
            ':tipoProcesador' => $tipoProcesador,
            ':resolucion' => $resolucionImagen,
            ':fuenteAlimentacion' => $fuentes,
            ':opcionConectividad' => $conectividad,
            ':tipoPuertos' => $tiposPuertos,
            ':id' => $id,
        ]);
    }

}