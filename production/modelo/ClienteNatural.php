<?php
require_once('core/Nucleo.php');
class ClienteNatural
{
    private $nucleo;
    private $tablaClienteN = "cliente";
    private $tablaDatosN = "datos_natural";
    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->tablaClienteN);
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
        $this->nucleo->setTablaBase($this->tablaDatosN);
        $guardado = $this->nucleo->insertarRegistro($campos);
        $this->nucleo->setTablaBase($this->tablaClienteN);
        return $guardado;
    }
    public function modificarDatosC($campos)
    {
        $this->nucleo->setTablaBase($this->tablaDatosN);
        $this->nucleo->setQueryPersonalizado
        ("dui=?, nit=?, estado_civil=?, lugar_trabajo=?, ingresos=?, egresos=? WHERE codigo_cliente=?");
        $guardado = $this->nucleo->modificarRegistro($campos);
        $this->nucleo->setTablaBase($this->tablaClienteN);
        return $guardado;
    }
    public function camposUnicosD($campos, $identificador, $valor)
    {
        $this->nucleo->setTablaBase($this->tablaDatosN);
        $resultado = $this->nucleo->coincidencias($campos, $identificador, $valor);
        $this->nucleo->setTablaBase($this->tablaClienteN);
        return $resultado;
    }
    public function camposUnicosModificarD($campos, $identificador, $valor)
    {
        $this->nucleo->setConsultarModificar(true);
        $this->nucleo->setTablaBase($this->tablaDatosN);
        $resultado = $this->nucleo->coincidencias($campos, $identificador, $valor);
        $this->nucleo->setTablaBase($this->tablaClienteN);
        return $resultado;
    }
    public function obtenerIdCategoria()
    {
        $this->nucleo->setQueryPersonalizado
        ("SELECT c.id, min(c.max_atraso) FROM categoria_cliente as c");
        $categoriaMenor = $this->nucleo->getDatos();
        return $categoriaMenor != null ? $categoriaMenor[0]['id'] : null;
    }
}
