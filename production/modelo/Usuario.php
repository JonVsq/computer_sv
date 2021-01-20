<?php
require_once('core/Nucleo.php');
class Usuario
{
    private $nucleo;
    private $nombreTabla = "usuarios";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertarUsuario($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarUsuario($campos) 
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
    public function obtenerUsuario($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        u.id,
        u.id_empleado,
        u.correo,
        u.pass,
        u.acceso,
        e.nombres,
        e.id
        FROM
        usuarios u
        INNER JOIN empleado e ON u.id_empleado = e.id
        WHERE u.id = $id");
        return $this->nucleo->getDatos();
    }
    
    //MODAL EMPLEADO        
    public function modalEmpleado($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setTablaBase("empleado");
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM empleado WHERE ($campo LIKE '%$buscar%')  order by nombres");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM empleado
        WHERE ($campo LIKE '%$buscar%') order by nombres ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("nombres"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }
    //MODAL CATEGORIA PRODUCTOS
    
    public function tablaUsuarios($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(u.id) as total
        FROM 
        usuarios as u WHERE (u.$campo LIKE '%$buscar%')");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        u.id,
        e.id,
        u.correo,
        e.nombres
        FROM
        usuarios AS u
        INNER JOIN empleado e ON u.id_empleado = e.id
        
        WHERE (u.$campo LIKE '%$buscar%') order by u.correo ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("correo", "nombres"),
            array("ver" => "tasks", "editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }
    public function obtenerDatosModal($id)
    {
        $respuesta = array();
        $this->nucleo->setQueryPersonalizado("SELECT
        u.id,
        u.correo,
        e.nombres,
        e.id as id_empleado,
        u.acceso
        FROM
        usuarios AS u
        INNER JOIN empleado e ON u.id_empleado = e.id
        WHERE u.id = $id");
        $resultado = $this->nucleo->getDatos();
        $respuesta["modalCuerpo"] = $this->htmlModalDatosUsuario($resultado);

        return $respuesta;
    }
    private function htmlModalDatosUsuario($datos)
    {
        $datosUsuario = "";
        foreach ($datos as $usuario) {
            $datosUsuario = $datosUsuario . "<label class='bmd-label-floating roboto-medium'>EMPLEADO: {$usuario['nombres']}</label>";
            $datosUsuario = $datosUsuario . "<br>";
            $datosUsuario = $datosUsuario . "<label class='bmd-label-floating roboto-medium'>CORREO: {$usuario['correo']}</label>";
            $datosUsuario = $datosUsuario . "<br>";
            $datosUsuario = $datosUsuario . "<label class='bmd-label-floating roboto-medium'>ACCESO: {$usuario['acceso']}</label>";
            $datosUsuario = $datosUsuario . "<br>";
        
        }
        return $datosUsuario;
    }
}
