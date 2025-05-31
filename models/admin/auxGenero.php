<?php
require_once './models/modeloBase.php';
class AuxiliarGenero extends ModeloBase {
    public function __construct() {
        parent::__construct('aux_genero'); 
    }
}