<?php

class Database {
    public static function conectar() {
    
    $host = 'localhost';
    $db = 'basedatosnvs';
    $usuario = 'root';
    $clave = '';

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$db", $usuario, $clave);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return null;
    }
}
}
?>