<?php
require_once('core/Nucleo.php');
class ClienteJuridico
{
    private $nucleo;
    private $tablaClienteJ = "cliente";
    private $tablaDatosJ = "datos_juridico";
    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->tablaClienteJ);
    }
    public function insertaCliente($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarCliente($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }
    public function camposUnicosC($campos, $identificador, $valor)
    {
        return $this->nucleo->coincidencias($campos, $identificador, $valor);
    }
    public function camposUnicosModificarC($campos, $identificador, $valor)
    {
        $this->nucleo->setConsultarModificar(true);
        return $this->nucleo->coincidencias($campos, $identificador, $valor);
    }
    public function insertaDatosC($campos)
    {
        $this->nucleo->setTablaBase($this->tablaDatosJ);
        $guardado = $this->nucleo->insertarRegistro($campos);
        $this->nucleo->setTablaBase($this->tablaClienteJ);
        return $guardado;
    }
    public function modificarDatosC($campos)
    {
        $this->nucleo->setTablaBase($this->tablaDatosJ);
        $this->nucleo->setQueryPersonalizado
        ("activo_corriente=?, pasivo_corriente=?, inventario=?, balance_general=?, 
        estado_resultado=? WHERE codigo_cliente=?");
        $guardado = $this->nucleo->modificarRegistro($campos);
        $this->nucleo->setTablaBase($this->tablaClienteJ);
        return $guardado;
    }
    public function camposUnicosD($campos, $identificador, $valor)
    {
        $this->nucleo->setTablaBase($this->tablaDatosJ);
        $resultado = $this->nucleo->coincidencias($campos, $identificador, $valor);
        $this->nucleo->setTablaBase($this->tablaClienteJ);
        return $resultado;
    }
    public function camposUnicosModificarD($campos, $identificador, $valor)
    {
        $this->nucleo->setConsultarModificar(true);
        $this->nucleo->setTablaBase($this->tablaDatosJ);
        $resultado = $this->nucleo->coincidencias($campos, $identificador, $valor);
        $this->nucleo->setTablaBase($this->tablaClienteJ);
        return $resultado;
    }
    public function tablaCategoriaCliente($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM datos_juridica WHERE ($campo LIKE '%$buscar%')  order by nombre");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM datos_juridica 
        WHERE ($campo LIKE '%$buscar%') order by nombre ASC");

        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("activo_corriente", "pasivo_corriente", "inventario", "balance_general", 
            "estado_resultado"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
        public function obtenerIdCategoria()
    {
        $this->nucleo->setQueryPersonalizado("SELECT c.id, min(c.max_atraso) FROM categoria_cliente as c");
        $categoriaMenor = $this->nucleo->getDatos();
        return $categoriaMenor != null ? $categoriaMenor[0]['id'] : null;
    }
    
}