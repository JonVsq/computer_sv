<?php
require_once('core/Nucleo.php');

class Marca
{
    private $nucleo;
    private $nombreTabla = "marca";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertarMarca($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }

    public function modificarMarca($campos)
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
    public function obtenerMarca($id_marca)
    {
        $this->nucleo->setQueryPersonalizado("SELECT * FROM marca as m
        WHERE m.id = $id_marca ORDER BY m.nombre_marca DESC");
        return $this->nucleo->getDatos();
    }
    public function tablaMarca($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM marca WHERE ($campo LIKE '%$buscar%')  order by nombre_marca");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM marca 
        WHERE ($campo LIKE '%$buscar%') order by nombre_marca ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("nombre_marca"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function verificarRelacion($id_marca)
    {
        $this->nucleo->setQueryPersonalizado("SELECT COUNT(DISTINCT p.id) as total
        FROM
        productos as p
        INNER JOIN marca as m ON m.id = $id_marca");
        $tablaProducto = $this->nucleo->getDatos();
        $tablaProducto = $tablaProducto[0]["total"];
        settype($tablaProducto, 'int');
        return ($tablaProducto > 0) ? false : true;
    }
}
