<?php 

   require_once './models/DetallesProducto.php';

   class ControladorMostrarDetallesProducto {

    public static function mostrarDetallesProducto(){

        $detalle= new DetallesProducto();

        $id = $_GET['id'] ?? null;
        $detalle=$detalle->traerDetallesProducto($id);

        echo json_encode($detalle);


    }
     public static function mostrarDetalleConsola(){

        $detalle= new DetallesProducto();

        $id = $_GET['id'] ?? null;
        $detalle=$detalle->traerDetallesConsola($id);

        echo json_encode($detalle);


    }


   }







?>