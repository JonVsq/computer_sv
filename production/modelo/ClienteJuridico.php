<?php
require_once('core/Nucleo.php');
class ClienteJuridico
{
    private $nucleo;
    private $tablaClienteJ = "cliente";
    private $tablaDatosJ = "datos_juridica";
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
        $this->nucleo->setQueryPersonalizado("activo_corriente=?, pasivo_corriente=?, inventario=?, balance_general=?, 
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
            array(
                "activo_corriente", "pasivo_corriente", "inventario", "balance_general",
                "estado_resultado"
            ),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function tablaClienteJ($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT 
        COUNT(c.codigo) as total
        FROM
        cliente as c
        INNER JOIN datos_juridica as cj ON cj.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE (c.$campo LIKE '%$buscar%')
        ORDER BY c.nombre DESC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT c.codigo,
        c.nombre,
        ct.nombre as categoria
        FROM
        cliente as c
        INNER JOIN datos_juridica as cj ON cj.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE (c.$campo LIKE '%$buscar%')
        ORDER BY c.nombre DESC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("nombre", "categoria"),
            array("ver" => "tasks", "editar" => "edit", "eliminar" => "trash"),
            "codigo"
        );
    }
    public function obtenerClienteJ($codigo)
    {
        $this->nucleo->setQueryPersonalizado("SELECT 
        c.codigo,
        c.nombre,
        c.telefono,
        c.direccion,
        c.fecha_ingreso,
        c.id_categoria,
        cj.activo_corriente,
        cj.balance_general,
        cj.estado_resultado,
        cj.inventario,
        cj.pasivo_corriente
        FROM
        cliente as c
        INNER JOIN datos_juridica as cj ON cj.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE c.codigo = '$codigo'
        ORDER BY c.nombre DESC");
        return $this->nucleo->getDatos();
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
        c.id_categoria,
        cj.activo_corriente,
        cj.balance_general,
        cj.estado_resultado,
        cj.inventario,
        cj.pasivo_corriente,
        ct.nombre as categoria
        FROM
        cliente as c
        INNER JOIN datos_juridica as cj ON cj.codigo_cliente = c.codigo
        INNER JOIN categoria_cliente as ct ON ct.id = c.id_categoria
        WHERE c.codigo = '$codigo'
        ORDER BY c.nombre DESC");
        $resultado = $this->nucleo->getDatos();

        $respuesta["modalCuerpo"] = $this->htmlModalDatosCliente($resultado);

        return $respuesta;
    }
    public function obtenerIdCategoria()
    {
        $this->nucleo->setQueryPersonalizado("SELECT c.id, min(c.max_atraso) FROM categoria_cliente as c");
        $categoriaMenor = $this->nucleo->getDatos();
        return $categoriaMenor != null ? $categoriaMenor[0]['id'] : null;
    }
    private function htmlModalDatosCliente($datos)
    {
        $datosCliente = "";
        foreach ($datos as $cliente) {
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>CODIGO: {$cliente['codigo']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>NOMBRE: {$cliente['nombre']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>TELEFONO: {$cliente['telefono']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>DIRECCION: {$cliente['direccion']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>CATEGORIA: {$cliente['categoria']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>ACTIVO CORRIENTE: {$cliente['activo_corriente']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>PASIVO CORRIENTE: {$cliente['pasivo_corriente']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'>INVENTARIO: {$cliente['inventario']}</label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'><a href='../../archivos/{$cliente['codigo']}/{$cliente['estado_resultado']}' target='__blank'>ESTADO DE RESULTADOS</a></label>";
            $datosCliente = $datosCliente . "<br>";
            $datosCliente = $datosCliente . "<label class='bmd-label-floating roboto-medium'><a href='../../archivos/{$cliente['codigo']}/{$cliente['balance_general']}' target='__blank'>BALANCE GENERAL</a></label>";
            $datosCliente = $datosCliente . "<br>";
        }
        return $datosCliente;
    }
    public function ClienteJuridicoModal($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT
        COUNT(DISTINCT(c.codigo)) as total
        FROM
        cliente as c
        INNER JOIN categoria_cliente as ct on ct.id = c.id_categoria
        INNER JOIN datos_juridica as dn ON dn.codigo_cliente = c.codigo
        WHERE (c.$campo LIKE '%$buscar%') and NOT EXISTS(SELECT cr.id_venta FROM credito as cr
        INNER JOIN venta as v ON v.id = cr.id_venta
        WHERE c.codigo = v.codigo_cliente)
        OR ct.max_ventas != 0 OR ct.max_ventas < (SELECT COUNT(cc.id) FROM credito as cc
        WHERE cc.cancelado = 0)
        ORDER BY c.nombre DESC");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        c.codigo,
        c.nombre,
        ct.nombre as categoria
        FROM
        cliente as c
        INNER JOIN categoria_cliente as ct on ct.id = c.id_categoria
        INNER JOIN datos_juridica as dn ON dn.codigo_cliente = c.codigo
        WHERE (c.$campo LIKE '%$buscar%') and NOT EXISTS(SELECT cr.id_venta FROM credito as cr
        INNER JOIN venta as v ON v.id = cr.id_venta
        WHERE c.codigo = v.codigo_cliente)
        OR ct.max_ventas != 0 OR ct.max_ventas < (SELECT COUNT(cc.id) FROM credito as cc
        WHERE cc.cancelado = 0)
        ORDER BY c.nombre DESC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("codigo", "nombre", "categoria"),
            array("seleccion" => "user-plus"),
            "codigo"
        );
    }
}
