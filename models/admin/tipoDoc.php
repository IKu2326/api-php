<?php
require_once './models/modeloBase.php';
class TipoDoc extends ModeloBase {
    public function __construct() {
        parent::__construct('tipo_documento'); 
    }
}