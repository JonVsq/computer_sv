<?php
require_once('core/Nucleo.php');

class Departamento
{
	private $nucleo;
	private $nombreTabla = "departamento";

	public function __construct()
	{
		$this->nucleo = new Nucleo();
		$this->nucleo->setTablaBase($this->nombreTabla);
	}
	public function insertarDepartamento($campos)
	{
		return $this->nucleo->insertarRegistro($campos);
	}
	public function modificarDepartamento($campos)
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
	public function obtenerDepartamento($id_departamento)
	{
       $this->nucleo->setQueryPersonalizado("SELECT d.id,
       	d.codigo,
       	d.nombre,
       	d.ubicacion
        FROM departamento as d WHERE d.id = $id_departamento");
       return $this->nucleo->getDatos();
	}

    public function obtenerEmpresa()
    {
       $this->nucleo->setQueryPersonalizado("SELECT *
        FROM empresa LIMIT 1");
       return $this->nucleo->getDatos();
    }

     //ESTE METODO ES PARA CALCULAR EL PROXIMO CODIGO DE DEPARTAMENTO
	public function codigoDepartamento()
	{ 
        $this->nucleo->setQueryPersonalizado("SELECT d.id,
        d.codigo
        FROM departamento as d WHERE d.codigo = (SELECT MAX(codigo) FROM departamento)");
        return $this->nucleo->getDatos();
	}
	

	public function tablaDepartamento($numPagina, $cantidad, $campo, $buscar)
	{
		$this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM departamento WHERE ($campo LIKE '%$buscar%')  order by codigo");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM departamento 
        WHERE ($campo LIKE '%$buscar%') order by codigo ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("codigo","nombre"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
	}

	public function verificarRelacion($id_departamento)
    {
        $this->nucleo->setQueryPersonalizado("SELECT COUNT(DISTINCT a.id) as total
        FROM
        departamento as d
        INNER JOIN activo as a ON a.id_departamento = $id_departamento");
        $tablaActivo = $this->nucleo->getDatos();
        $tablaActivo = $tablaActivo[0]["total"];
        settype($tablaActivo, 'int');
        return ($tablaActivo > 0) ? false : true;
    }

    public function eliminarDepartamento($campos)
    {
        $this->nucleo->setQueryPersonalizado('WHERE id = ?;');
        return $this->nucleo->eliminarRegistro($campos);
    }

}