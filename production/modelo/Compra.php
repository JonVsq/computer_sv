<?php
require_once('core/Nucleo.php');
class Compra
{
    private $nucleo;
    private $tablaCompra = "compra";
    private $tablaDetalle = "detalle_compra";
    private $tablaProveedor = "proveedor";
    private $tablaProductos = "productos";
    private $tablaKardex = "movimientos";
    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->tablaCompra);
    }
    //SECCION DE TABLA COMPRA
    public function insertarCompra($campos)
    {
        $this->nucleo->setRegresarId(true);
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarCompra($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }
    //SECCION DE DETALLE_COMPRA
    public function insertarDetalle($id_compra, $items)
    {
        //MOVEMOS EL NUCLEO A LA TABLA DETALLE COMPRA
        $this->nucleo->setTablaBase($this->tablaDetalle);
        //RECORREMOS LOS PRODUCTOS QUE ENVIO JS
        foreach ($items as $item) {
            //SI EL REGISTRO NO SE INGRESA VOLVEMOS A LA TABLA COMPRA
            //Y RETORNAMOS FALSO
            if (!$this->nucleo->insertarRegistro(array(
                $id_compra,
                $item[0],
                $item[2],
                $item[3],
                $item[4]
            ))) {
                $this->nucleo->setTablaBase($this->tablaCompra);
                return false;
            }
        }
        //SI TODOS LOS REGISTROS SE INGRESARON REGRESAMOS A LA TABLA COMPRA
        //Y RETORNAMOS VERDADERO
        $this->nucleo->setTablaBase($this->tablaCompra);
        return true;
    }
    //SECCION KARDEX
    public function insertarMovimiento($items, $fecha)
    {
        foreach ($items as $item) {
            //OBTENEMOS SI YA HAY UN SALDO INICIAL
            //SI NO DEJAMOS EL TIPO COMO COMPRA
            $this->nucleo->setQueryPersonalizado("SELECT
            COUNT(m.id) as total
            FROM
            movimientos as m
            where m.tipo = 'SALDO INICIAL' AND m.id_producto = $item[0]");
            $existe = $this->nucleo->getDatos();
            $tipo = $existe[0]['total'] > 0 ? "COMPRA" : "SALDO INICIAL";
            //OBTENEMOS EL PORCENTAJE DE GANANCIA
            $this->nucleo->setQueryPersonalizado("SELECT
            p.porcentaje_ganancia
            FROM
            productos p
            where p.id = $item[0]");
            $porcentaje = $this->nucleo->getDatos();
            $porcentaje = round((($porcentaje[0]['porcentaje_ganancia']) / 100), 2);
            //MOVEMOS EL NUCLEO A LA TABLA MOVIMIENTOS QUE TENDRA EL KARDEX
            $this->nucleo->setTablaBase($this->tablaKardex);
            if (!$this->nucleo->insertarRegistro(array(
                $item[0],
                $tipo,
                $fecha,
                $item[2],
                $item[3],
                $item[2],
                $item[3],
                round(($item[3] * $porcentaje) + $item[3], 2),
                1
            ))) {
                $this->nucleo->setTablaBase($this->tablaCompra);
                return false;
            }
        }
        //SI TODO SE INGRESO REGRESAMOS A LA TABLA COMPRA Y RETORNAMOS VERDADERO
        $this->nucleo->setTablaBase($this->tablaCompra);
        return true;
    }
    //MODAL PROVEEDORES
    public function modalProveedor($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM
        proveedor as p
        WHERE (p.$campo LIKE '%$buscar%')
        ORDER BY p.nombre ASC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        p.id,
        p.nombre
        FROM
        proveedor as p
        WHERE (p.$campo LIKE '%$buscar%')
        ORDER BY p.nombre ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("nombre"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }
    //MODAL PRODUCTOS
    public function modalProductos($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
         FROM
         productos as p
         WHERE (p.$campo LIKE '%$buscar%')
         ORDER BY p.producto ASC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        p.id,
        p.producto,
        p.descripcion
        FROM
        productos as p
        WHERE (p.$campo LIKE '%$buscar%')
        ORDER BY p.producto ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("producto", "descripcion"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }

    //MODAL PRODUCTOS
    public function modalProductosVenta($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
           FROM
           productos as p
           WHERE (p.$campo LIKE '%$buscar%')
           ORDER BY p.producto ASC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
          p.id,
          p.producto,
          p.descripcion,
          SUM(m.saldo) as stock
          FROM
          movimientos as m
          INNER JOIN productos as p ON p.id = m.id_producto
          WHERE (p.$campo LIKE '%$buscar%') and m.activo = 1 and m.tipo = 'SALDO INICIAL' or m.tipo = 'COMPRA'
          GROUP BY m.id_producto
          ORDER BY p.producto");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("producto", "descripcion"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }
}
