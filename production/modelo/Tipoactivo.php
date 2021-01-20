<?php
require_once('core/Nucleo.php');

class Tipoactivo
{
	private $nucleo;
	private $nombreTabla = "tipoactivo";

	public function __construct()
	{
		$this->nucleo = new Nucleo();
		$this->nucleo->setTablaBase($this->nombreTabla);
	}
	public function insertarTipoactivo($campos)
	{
		return $this->nucleo->insertarRegistro($campos);
	}
	public function modificarTipoactivo($campos)
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
	public function obtenerTipoactivo($id_tipoactivo)
	{
       $this->nucleo->setQueryPersonalizado("SELECT t.id,
       	t.codigo,
       	t.nombre,
       	t.porcentaje,
       	t.tiempo
        FROM tipoactivo as t WHERE t.id = $id_tipoactivo");
       return $this->nucleo->getDatos();
	}

     //ESTE METODO ES PARA CALCULAR EL PROXIMO CODIGO DE DEPARTAMENTO
	public function codigoTipoactivo()
	{ 
        $this->nucleo->setQueryPersonalizado("SELECT t.id,
        t.codigo
        FROM tipoactivo as t WHERE t.codigo = (SELECT MAX(codigo) FROM tipoactivo)");
        return $this->nucleo->getDatos();
	}
	

	public function tablaTipoactivo($numPagina, $cantidad, $campo, $buscar)
	{
		$this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM tipoactivo WHERE ($campo LIKE '%$buscar%')  order by codigo");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM tipoactivo 
        WHERE ($campo LIKE '%$buscar%') order by codigo ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("codigo","nombre","porcentaje"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
	}

	public function verificarRelacion($id_tipoactivo)
    {
        $this->nucleo->setQueryPersonalizado("SELECT COUNT(DISTINCT a.id) as total
        FROM
        tipoactivo as t
        INNER JOIN activo as a ON a.id_tipoactivo = $id_tipoactivo");
        $tablaActivo = $this->nucleo->getDatos();
        $tablaActivo = $tablaActivo[0]["total"];
        settype($tablaActivo, 'int');
        return ($tablaActivo > 0) ? false : true;
    }

    public function eliminarTipoactivo($campos)
    {
        $this->nucleo->setQueryPersonalizado('WHERE id = ?;');
        return $this->nucleo->eliminarRegistro($campos);
    }
}