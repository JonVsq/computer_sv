<?php
require_once('core/Nucleo.php');
class Proveedores{
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
    public function obtenerProveedor($id){
        $this->nucleo->setQueryPersonalizado("SELECT * FROM proveedor as p 
                                             where p.id = $id order by p.nombre DESC");
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
            array("nombre", "direccion", "telefono", "correo", "dias_entrega"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
}