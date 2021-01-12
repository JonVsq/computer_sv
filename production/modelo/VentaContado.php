<?php
require_once('core/Nucleo.php');
class VentaContado
{

    private $nucleo;
    private $tblVenta = "venta";
    private $tblDetalleVenta = "detalle_venta";
    private $tblCliente = "cliente";
    private $tblEmpleado = "empleado";
    private $tblMovimientos = "movimientos";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->tblVenta);
    }
    public function insertaVentas($campos)
    {
        $this->nucleo->setRegresarId(true);
        return $this->nucleo->insertarRegistro($campos);
    }

    public function modificarVentas($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }
    public function camposUnicos($campos, $identificador, $valor)
    {
        return $this->nucleo->coincidencias($campos, $identificador, $valor);
    }
}
