<?php
require_once './models/modeloBase.php';
class Roles extends ModeloBase {
    public function __construct() {
        parent::__construct('roles'); 
    }
}