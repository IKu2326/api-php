<?php

require_once './config/database.php';

class DetallesProducto{
    private $conn; 

    public function __construct()
    {
        $this->conn=Database::conectar();
    }

    public function traerDetallesProducto($id)
    {

        if(!empty($id))
        {
            $sql= "

             SELECT 
             p.idProducto,
             p.precioProducto,
             p.nombreProducto,
             p.descuentoProducto,
             p.totalProducto,
             j.anoLanzamiento,
             j.descripcionJuego,
             GROUP_CONCAT(DISTINCT aug.fk_pk_genero SEPARATOR ', ') AS aux_genero,
             GROUP_CONCAT(DISTINCT apl.idPlataforma SEPARATOR ', ') AS aux_plataforma
             FROM producto p
             JOIN juego j ON p.idProducto = j.idJuego
             JOIN aux_genero aug ON p.idProducto = aug.fk_pk_juego
             JOIN aux_plataforma apl ON p.idProducto = apl.idJuego
             WHERE p.idProducto = :id
             GROUP BY 
             p.idProducto,
             p.precioProducto,
             p.nombreProducto,
             p.descuentoProducto,
             p.totalProducto,
             j.anoLanzamiento,
             j.descripcionJuego;
 
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id",$id,PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

    }

    public function traerDetallesConsola($id)
    {

        if(!empty($id))
        {
            $sql= "

            SELECT 
             p.idProducto,
             p.precioProducto,
             p.nombreProducto,
             p.descuentoProducto,
             p.totalProducto,
             c.sobreConsola,
             crc.*
             FROM producto p
             JOIN consola c ON p.idProducto = c.idConsola
             JOIN caracteristicasconsola crc ON c.idConsola = crc.idConsola 
             WHERE p.idProducto = :id
 
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id",$id,PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

    }

}











?>