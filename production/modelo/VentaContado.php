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
    public function numeroFcatura()
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        COUNT(id) as total
        FROM venta");
        $factura = $this->nucleo->getDatos();
        return ($factura[0]['total'] + 1);
    }
    public function desactivarMovimientos($array)
    {
        $this->nucleo->setTablaBase($this->tblMovimientos);
        $tamanio = count($array);
        for ($i = 0; $i < $tamanio; $i++) {
            $this->nucleo->setQueryPersonalizado("activo = ? where id = ?");
            if (!$this->nucleo->modificarRegistro(array(0, $array[$i]['id_movimiento']))) {
                $this->nucleo->setTablaBase($this->tblVenta);
                return false;
            }
        }
        return true;
    }
    public function crearMovimientos($array, $fecha)
    {
        $this->nucleo->setTablaBase($this->tblMovimientos);
        $tamanio = count($array);
        for ($i = 0; $i < $tamanio; $i++) {
            if (!$this->nucleo->insertarRegistro(array(
                $array[$i]['id_producto'],
                "VENTA",
                $fecha,
                $array[$i]['cantidad_movimiento'],
                $array[$i]['costo_unitario'],
                $array[$i]['saldo'],
                $array[$i]['saldo'] == 0 ? 0 : $array[$i]['costo_unitario'],
                $array[$i]['precio_venta'],
                $array[$i]['activo']
            ))) {
                $this->nucleo->setTablaBase($this->tblVenta);
                return false;
            }
        }
        return true;
    }
    public function crearDetalleVenta($id_venta, $array)
    {
        $this->nucleo->setTablaBase($this->tblDetalleVenta);
        $tamanio = count($array);
        for ($i = 0; $i < $tamanio; $i++) {
            if (!$this->nucleo->insertarRegistro(array(
                $id_venta,
                $array[$i]['id_producto'],
                $array[$i]['cantidad_movimiento'],
                $array[$i]['costo_unitario'],
                $array[$i]['precio_venta'],
                0
            ))) {
                $this->nucleo->setTablaBase($this->tblVenta);
                return false;
            }
        }
        return true;
    }
}
