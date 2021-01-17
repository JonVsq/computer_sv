<?php
require_once('core/Nucleo.php');
class Interes
{
    private $nucleo;
    private $nombreTabla = "interes";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertarInteres($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarInteres($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }
    public function obtenerInteres($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT * FROM interes WHERE id = $id");
        return $this->nucleo->getDatos();
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
    public function tablaInteres($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM interes WHERE ($campo LIKE '%$buscar%')  order by plazo");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM interes 
        WHERE ($campo LIKE '%$buscar%') order by plazo ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("plazo", "porcentaje"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function plazosModal($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT
        COUNT(id) as total
        FROM
        interes
        WHERE ($campo LIKE '%$buscar%')");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        *
        FROM
        interes 
        WHERE ($campo LIKE '%$buscar%')");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("plazo", "porcentaje"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }
}
