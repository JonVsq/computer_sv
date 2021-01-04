<?php
require_once('core/Nucleo.php');
class CategoriaProducto
{
    private $nucleo;
    private $nombreTabla = "categoria_producto";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertarCategoriaP($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarCategoriaP($campos)
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
    public function obtenerCategoriaP($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT * FROM categoria_producto as c
        WHERE c.id = $id ORDER BY c.descripcion DESC");
        return $this->nucleo->getDatos();
    }
    public function tablaCategoriaP($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM categoria_producto WHERE ($campo LIKE '%$buscar%')  order by descripcion");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM categoria_producto 
        WHERE ($campo LIKE '%$buscar%') order by descripcion ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("descripcion"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
}
