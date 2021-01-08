<?php
require_once('core/Nucleo.php');
class Producto
{
    private $nucleo;
    private $nombreTabla = "productos";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertarProducto($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarProducto($campos)
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
    public function obtenerProducto($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT 
        p.id,
        p.producto,
        p.descripcion,
        p.modelo,
        p.porcentaje_ganancia,
        p.unidades_periodo,
        p.costo_unitario_pedido,
        p.costo_mantenimiento,
        p.uso_diario,
        p.dias_entrega,
        m.id as id_marca,
        m.nombre_marca,
        cp.id as id_cat,
        cp.descripcion as desCatP
        FROM 
        productos as p
        INNER JOIN categoria_producto as cp on cp.id = p.id_categoria
        INNER JOIN marca as m on m.id = p.id_marca 
        WHERE p.id = $id");
        return $this->nucleo->getDatos();
    }
    public function cep($u, $p, $m)
    {
        return  ceil(sqrt(((2 * $p * $u) / $m)));
    }
    public function puntoReformulacion($tiempo, $uso)
    {
        return ceil($tiempo * $uso);
    }
    //MODAL MARCA
    public function modalMarca($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setTablaBase("marca");
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
            array("seleccion" => "user-plus"),
            "id"
        );
    }
    //MODAL CATEGORIA PRODUCTOS
    public function modalCategoria($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setTablaBase("categoria_producto");
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
            array("seleccion" => "user-plus"),
            "id"
        );
    }
    public function tablaProducto($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(p.id) as total
        FROM 
        productos as p WHERE (p.$campo LIKE '%$buscar%')");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT 
        p.id,
        p.producto,
        p.descripcion,
        m.nombre_marca,
        cp.descripcion as desm
        FROM 
        productos as p
        INNER JOIN categoria_producto as cp on cp.id = p.id_categoria
        INNER JOIN marca as m on m.id = p.id_marca
        WHERE (p.$campo LIKE '%$buscar%') order by p.producto ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("producto", "descripcion", "nombre_marca", "desm"),
            array("ver" => "tasks", "editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function obtenerDatosModal($id)
    {
        $respuesta = array();
        $this->nucleo->setQueryPersonalizado("SELECT 
        p.id,
        p.producto,
        p.descripcion,
        p.modelo,
        p.porcentaje_ganancia,
        p.unidades_periodo,
        p.costo_unitario_pedido,
        p.costo_mantenimiento,
        p.uso_diario,
        p.dias_entrega,
        p.cep,
        p.stock_minimo,
        m.id as id_marca,
        m.nombre_marca,
        cp.id as id_cat,
        cp.descripcion as descripCatP
        FROM 
        productos as p
        INNER JOIN categoria_producto as cp on cp.id = p.id_categoria
        INNER JOIN marca as m on m.id = p.id_marca 
        WHERE p.id = $id");
        $resultado = $this->nucleo->getDatos();
        $respuesta["modalCuerpo"] = $this->htmlModalDatosProducto($resultado);

        return $respuesta;
    }
    private function htmlModalDatosProducto($datos)
    {
        $datosProducto = "";
        foreach ($datos as $producto) {
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>PRODUCTO: {$producto['producto']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>DESCRIPCION: {$producto['descripcion']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>MARCA: {$producto['nombre_marca']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>CATEGORIA: {$producto['descripCatP']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>USO ANUAL: {$producto['unidades_periodo']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>USO DIARIO (UNIDADES): {$producto['uso_diario']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>COSTO PEDIDO (UNITARIO) $: {$producto['costo_unitario_pedido']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>COSTO DE MANTENIMIENTO (UNIDAD) $: {$producto['costo_mantenimiento']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>CEP (UNIDADES): {$producto['cep']}</label>";
            $datosProducto = $datosProducto . "<br>";
            $datosProducto = $datosProducto . "<label class='bmd-label-floating roboto-medium'>STOCK MINIMO (UNIDADES): {$producto['stock_minimo']}</label>";
            $datosProducto = $datosProducto . "<br>";
        }
        return $datosProducto;
    }
}
