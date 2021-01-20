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
        $this->nucleo->setQueryPersonalizado("dui=?, nit=?, estado_civil=?, lugar_trabajo=?, ingresos=?, egresos=? WHERE codigo_cliente=?");
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
        $this->nucleo->setQueryPersonalizado("SELECT c.id FROM categoria_cliente as c
        where c.nombre = 'A'");
        $categoriaMenor = $this->nucleo->getDatos();
        return $categoriaMenor != null ? $categoriaMenor[0]['id'] : null;
    }
    public function obtenerClienteN($codigo)
    {
        $this->nucleo->setQueryPersonalizado("SELECT 
        c.codigo,
        c.nombre,
        c.telefono,
        c.direccion,
        c.fecha_ingreso,
        dn.dui,
        dn.nit,
        dn.estado_civil,
        dn.lugar_trabajo,
        dn.ingresos,
        dn.egresos
        FROM
        cliente as c
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE c.codigo = '$codigo'
        ORDER BY c.nombre DESC");
        return $this->nucleo->getDatos();
    }
    public function tablaClienteN($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT 
        COUNT(c.codigo) as total
        FROM
        cliente as c
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE (dn.$campo LIKE '%$buscar%')
        ORDER BY c.nombre DESC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT 
        dn.dui,
        dn.nit,
        c.codigo,
        c.nombre,
        ct.nombre as categoria
        FROM
        cliente as c
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE (dn.$campo LIKE '%$buscar%')
        ORDER BY c.nombre DESC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("dui", "nit", "nombre", "categoria"),
            array("ver" => "tasks", "editar" => "edit", "eliminar" => "trash"),
            "codigo"
        );
    }
    public function obtenerDatosModal($codigo)
    {
        $respuesta = array();
        $this->nucleo->setQueryPersonalizado("SELECT 
        c.codigo,
        c.nombre,
        c.telefono,
        c.direccion,
        c.fecha_ingreso,
        dn.dui,
        dn.nit,
        dn.estado_civil,
        dn.lugar_trabajo,
        dn.ingresos,
        dn.egresos,
        ct.nombre as categoria
        FROM
        cliente as c
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE c.codigo = '$codigo'
        ORDER BY c.nombre DESC");
        $resultado = $this->nucleo->getDatos();

        $respuesta["modalCuerpo"] = $this->htmlModalDatosCliente($resultado);

        return $respuesta;
    }
    private function htmlModalDatosCliente($datos)
    {
        $datosCliente = "";
        foreach ($datos as $cliente) {
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>CODIGO: {$cliente['codigo']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>DUI: {$cliente['dui']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>NIT: {$cliente['nit']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>NOMBRE: {$cliente['nombre']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>ESTADO CIVIL: {$cliente['estado_civil']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>TELEFONO: {$cliente['telefono']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>DIRECCION: {$cliente['direccion']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>LUGAR DE TRABAJO: {$cliente['lugar_trabajo']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>INGRESOS: {$cliente['ingresos']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>EGRESOS: {$cliente['egresos']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>CATEGORIA: {$cliente['categoria']}</label>";
            $datosCliente = $datosCliente . "<br>";
        }
        return $datosCliente;
    }
    public function ClienteNaturalModal($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT
        count(c.codigo) as total
        FROM
        cliente as c
        INNER JOIN categoria_cliente as ct on ct.id = c.id_categoria
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        WHERE ct.nombre != 'C'
             ORDER BY c.nombre DESC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        c.codigo,
        c.nombre,
        ct.nombre as categoria
        FROM
        cliente as c
        INNER JOIN categoria_cliente as ct on ct.id = c.id_categoria
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        WHERE ct.nombre != 'C'
             ORDER BY c.nombre DESC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("codigo", "nombre", "categoria"),
            array("seleccion" => "user-plus"),
            "codigo"
        );
    }
    public function verificarRelacion($codigo)
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        COUNT(v.codigo_cliente) as total
        FROM
        venta as v
        WHERE v.codigo_cliente = '$codigo'");
        $tablaVenta = $this->nucleo->getDatos();
        $tablaVenta = $tablaVenta[0]['total'];
        settype($tablaVenta, 'int');
        return ($tablaVenta > 0) ? false : true;
    }
    public function eliminarCliente($codigo)
    {
        $this->nucleo->setTablaBase("datos_natural");
        $this->nucleo->setQueryPersonalizado("WHERE codigo_cliente = ?");
        $eliminaDatos = $this->nucleo->eliminarRegistro(array($codigo));
        $this->nucleo->setTablaBase($this->tablaClienteN);
        if ($eliminaDatos) {
            $this->nucleo->setQueryPersonalizado("WHERE codigo = ?");
            return $this->nucleo->eliminarRegistro(array($codigo));
        } else {
            return false;
        }
    }
    public function ClienteNaturalCredito($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT
        COUNT(c.codigo) as total
        FROM
        cliente as c
        INNER JOIN categoria_cliente as ct on ct.id = c.id_categoria
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        WHERE  NOT EXISTS(SELECT cr.id_venta FROM credito as cr
        INNER JOIN venta as v ON v.id = cr.id_venta
        WHERE c.codigo = v.codigo_cliente and cr.cancelado=0) 
             ORDER BY c.nombre DESC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        c.codigo,
        c.nombre,
        ct.nombre as categoria
        FROM
        cliente as c
        INNER JOIN categoria_cliente as ct on ct.id = c.id_categoria
        INNER JOIN datos_natural as dn ON dn.codigo_cliente = c.codigo
        WHERE  NOT EXISTS(SELECT cr.id_venta FROM credito as cr
        INNER JOIN venta as v ON v.id = cr.id_venta
        WHERE c.codigo = v.codigo_cliente and cr.cancelado=0) 
             ORDER BY c.nombre DESC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("codigo", "nombre", "categoria"),
            array("seleccion" => "user-plus"),
            "codigo"
        );
    }
}
