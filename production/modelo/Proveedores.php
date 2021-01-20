<?php
require_once('core/Nucleo.php');
class Proveedores
{
    private $nucleo;
    private $nombreTabla = "proveedor";
    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }

    public function insertaProveedor($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }

    public function modificarProveedor($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }

    public function camposUnicos($campos, $identificador, $valor)
    {
        return $this->nucleo->coincidencias($campos, $identificador, $valor);
    }

    public function camposUnicosModificar($campos, $identificador, $valor)
    {
        $this->nucleo->setConsultarModificar(true);
        return $this->nucleo->coincidencias($campos, $identificador, $valor);
    }
    public function obtenerProveedor($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT * FROM proveedor as p 
                                             where p.id = $id order by p.nombre DESC");
        return $this->nucleo->getDatos();
    }
    public function tablaProveedor($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM proveedor WHERE ($campo LIKE '%$buscar%')  order by nombre");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM proveedor 
        WHERE ($campo LIKE '%$buscar%') order by nombre ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("nombre", "direccion", "telefono", "correo"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function verificarRelacion($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        COUNT(c.id_proveedor) as total
        FROM
        compra as c
        WHERE c.id_proveedor = $id");
        $tablaCompra = $this->nucleo->getDatos();
        $tablaCompra = $tablaCompra[0]['total'];
        settype($tablaCompra, 'int');
        return ($tablaCompra > 0) ? false : true;
    }
    public function eliminarProveedor($id)
    {
        $this->nucleo->setQueryPersonalizado("WHERE id = ?");
        return $this->nucleo->eliminarRegistro(array($id));
    }
}
