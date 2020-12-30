<?php
require_once('core/Nucleo.php');
class Categoria
{
    private $nucleo;
    private $tabla = "categorias";
    function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->tabla);
    }

    //INSERCION
    public function insertarCategoria($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }


    //MODIFICACION
    public function modificarCategoria($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }


    //ELIMINACION
    public function eliminarCategoria($campos)
    {
        $this->nucleo->setQueryPersonalizado('estado = ? WHERE id = ?');
        return $this->nucleo->modificarRegistro($campos);
    }


    //LISTAR DATOS COMO TABLA HTML
    public function tablaCategoria($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total  FROM categorias WHERE ($campo LIKE '%$buscar%') AND estado = 0 order by nombre");
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM categorias WHERE ($campo LIKE '%$buscar%') AND estado = 0 order by nombre ASC");
        return $this->nucleo->getDatosHtml(array("nombre", "max_atraso", "prestamos", "descripcion"), array("editar" => "edit", "eliminar" => "trash"), "id");
    }


    //VERIFICA SI NO HAY UNA CATEGORIA YA REGISTRADA CON LOS MISMOS CAMPOS
    public function consultarCampos($datos, $identificador, $id)
    {
        $this->nucleo->setAnd("AND estado = 0");
        return $this->nucleo->coincidencias($datos, $identificador, $id);
    }

    //VERIFICA SI NO HAY UNA CATEGORIA YA REGISTRADA CON LOS MISMOS CAMPOS EXCEPTUANDO AL REGISTRO QUE SE VA MODIFICAR
    public function consultarCamposModificar($datos, $identificador, $id)
    {
        $this->nucleo->setConsultarModificar(true);
        $this->nucleo->setAnd("AND estado = 0");
        return $this->nucleo->coincidencias($datos, $identificador, $id);
    }


    //OBTIENE EL REGISTRO SEGUN SU ID
    public function obtenerCategoria($id)
    {
        $this->nucleo->setQueryPersonalizado('SELECT * FROM ' . $this->tabla . ' WHERE id =' . $id . ' and estado=0');
        return $this->nucleo->getDatos();
    }
}
