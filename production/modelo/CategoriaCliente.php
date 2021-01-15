<?php
require_once('core/Nucleo.php');
class CategoriaCliente
{
    private $nucleo;
    private $nombreTabla = "categoria_cliente";
    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertaCategoriaCliente($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarCategoriaCliente($campos)
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
    public function obtenerCategoriaCliente($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT * FROM categoria_cliente as c 
                                             where c.id = $id order by c.nombre DESC");
        return $this->nucleo->getDatos();
    }
    public function tablaCategoriaCliente($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM categoria_cliente WHERE ($campo LIKE '%$buscar%')  order by nombre");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM categoria_cliente 
        WHERE ($campo LIKE '%$buscar%') order by nombre ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("nombre", "descripcion", "max_atraso", "max_ventas", "monto_limite"),
            array("editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function categoriaCliente($codigo)
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        ct.id,
        ct.nombre,
        ct.max_atraso,
        ct.max_ventas,
        ct.monto_limite
        FROM
        categoria_cliente as ct
        INNER JOIN cliente as c on c.id_categoria = ct.id
        WHERE c.codigo = '$codigo'");
        return $this->nucleo->getDatos();
    }
}
