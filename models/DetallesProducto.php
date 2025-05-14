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
             j.anoLanzamineto,
             j.descripcionJuego
             FROM producto p
             JOIN juego j ON p.idProducto = j.idJuego
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