<?php
require_once('core/Nucleo.php');

class Cargo
{
    private $nucleo;
    private $nombreTabla = "cargo";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertarCargo($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }

    public function modificarCargo($campos)
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
    public function obtenerCargo($id_cargo)
    {
        $this->nucleo->setQueryPersonalizado("SELECT * FROM cargo as m
        WHERE m.id = $id_cargo ORDER BY m.cargo DESC");
        return $this->nucleo->getDatos();
    }
    public function tablaCargo($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM cargo as cr WHERE ($campo LIKE '%$buscar%')  order by cr.cargo");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM cargo as c
        WHERE ($campo LIKE '%$buscar%') order by c.cargo ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("cargo","descripcion","sueldo"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function verificarRelacion($id_cargo)
    {
        $this->nucleo->setQueryPersonalizado("SELECT COUNT(DISTINCT p.id) as total
        FROM
        empleado as p
        INNER JOIN cargo as m ON m.id = $id_cargo");
        $tablaEmpleado = $this->nucleo->getDatos();
        $tablaEmpleado = $tablaEmpleado[0]["total"];
        settype($tablaEmpleado, 'int');
        return ($tablaEmpleado > 0) ? false : true;
    }
}
