<?php
require_once './models/modeloBase.php';
class EstadoEnvio extends ModeloBase {
    public function __construct() {
        parent::__construct('estadoenvio'); 
    }
}