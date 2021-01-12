<?php
require_once('core/Nucleo.php');
class Kardex
{
    private $nucleo;
    private $nombreTabla = "movimientos";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }

    public function kardex($numPagina, $cantidad, $campo, $buscar, $id_producto)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT 
        COUNT(m.id) as total
        FROM
        movimientos as m
        WHERE m.id_producto = $id_producto
        ORDER BY m.id");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT 
        DATE_FORMAT(m.fecha,'%d-%m-%Y') as fecha,
        m.tipo,
        IF(m.tipo = 'COMPRA',m.cantidad_movimiento,IF(m.tipo='SALDO INICIAL','','')) as cantidad_entrada,
        IF(m.tipo = 'COMPRA',m.costo_unitario,IF(m.tipo='SALDO INICIAL','','')) as costo_unitario_entrada,
        IF(m.tipo = 'COMPRA',ROUND((m.cantidad_movimiento * m.costo_unitario),2),IF(m.tipo='SALDO INICIAL','','')) as total_entrada,
        IF(m.tipo = 'VENTA',m.cantidad_movimiento,'') as cantidad_salida,
        IF(m.tipo = 'VENTA',m.costo_unitario,'') as costo_unitario_salida,
        IF(m.tipo = 'VENTA',ROUND((m.cantidad_movimiento * m.costo_unitario),2),'') as total_salida,
        m.saldo as saldo,
        m.saldo_costo_unitario as saldo_costo,
        ROUND((m.saldo * m.costo_unitario),2) as total_saldo
        FROM
        movimientos as m
        WHERE m.id_producto = $id_producto
        ORDER BY m.id");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array(
                "fecha", "tipo",
                "cantidad_entrada", "costo_unitario_entrada", "total_entrada",
                "cantidad_salida", "costo_unitario_salida", "total_salida",
                "saldo", "saldo_costo", "total_saldo"
            ),
            array(),
            "id"
        );
    }
}
