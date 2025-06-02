<?php
require_once './config/database.php';

class ModeloBase {
    protected $db;
    protected $tabla;

    public function __construct($tabla) {
        $this->db = Database::conectar();
        $this->tabla = $tabla;
    }

    public function obtenerTodos() {
            $stmt = $this->db->query("SELECT * FROM {$this->tabla}");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id1,$nombre1, $id2 = null, $nombre2 = null,$tipo = null) {
        if ($id2 === null && $nombre2 === null) {
            $stmt = $this->db->prepare("SELECT * FROM {$this->tabla} WHERE $nombre1 = :id1");
            $stmt->execute(['id1' => $id1]);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM {$this->tabla} WHERE $nombre1 = :id1 AND $nombre2 = :id2");
            $stmt->execute([
             'id1' => $id1, 
             'id2' => $id2]);
        }   
        if($tipo = "Aux"){
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }else {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }
        
    }

    public function eliminar($id1, $id2 = null, $nombre1, $nombre2 = null) {

        if ($id2 === null && $nombre2 === null) {
            $stmt = $this->db->prepare("DELETE FROM {$this->tabla} WHERE $nombre1 = :id1");
            $stmt->execute(['id1' => $id1]);
        } else {
            $stmt = $this->db->prepare("DELETE FROM {$this->tabla} WHERE $nombre1 = :id1 AND $nombre2 = :id2");
            $stmt->execute(['id1' => $id1, 'id2' => $id2]);
        }
    
        return true;
    }
}