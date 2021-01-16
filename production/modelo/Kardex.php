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
        IF( m.saldo=0,'',m.saldo)as saldo,
        IF(m.saldo_costo_unitario=0,'',m.saldo_costo_unitario) as saldo_costo,
        IF(m.saldo=0,'',ROUND((m.saldo * m.costo_unitario),2)) as total_saldo
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
    public function obtenerStockProductos($id_producto)
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        m.id,
        m.id_producto,
        m.tipo,
        m.fecha,
        m.cantidad_movimiento,
        m.costo_unitario,
        m.saldo,
        m.saldo_costo_unitario,
        m.precio_venta_unitario,
        m.activo,
        IF(m.tipo='VENTA',1,IF(m.tipo='SALDO INICIAL',2,IF(m.tipo='COMPRA',3,0))) as orden
        FROM
        movimientos as m
        where m.id_producto = $id_producto and m.activo = 1 and saldo != 0
        ORDER BY orden asc, id asc");
        return $this->nucleo->getDatos();
    }
}
