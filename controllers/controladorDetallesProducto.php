<?php 

   require_once './models/DetallesProducto.php';

   class ControladorMostrarDetallesProducto {

    public static function mostrarDetallesProducto(){

        $detalle= new DetallesProducto();

        $id = $_GET['id'] ?? null;
        $detalle=$detalle->traerDetallesProducto($id);

        echo json_encode($detalle);


    }


   }







?>