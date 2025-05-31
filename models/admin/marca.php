<?php
require_once './models/modeloBase.php';
class Marca extends ModeloBase {
    public function __construct() {
        parent::__construct('marca'); 
    }
}