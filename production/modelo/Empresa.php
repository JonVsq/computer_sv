<?php
require_once('core/Nucleo.php');
class Empresa
{
    private $nucleo;
    private $tabla = "empresa";

    function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->tabla);
    }

    public function obtener()
    {
        return $this->nucleo->getDatos();
    }
    public function insertar($campos)
    {
        $this->nucleo->setRegresarId(true);
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificar($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }
}
