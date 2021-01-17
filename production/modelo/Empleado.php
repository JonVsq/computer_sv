<?php
require_once('core/Nucleo.php');
class Empleado
{
    private $nucleo;
    private $nombreTabla = "empleado";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->nombreTabla);
    }
    public function insertarEmpleado($campos)
    {
        return $this->nucleo->insertarRegistro($campos);
    }
    public function modificarEmpleado($campos)
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

    public function eliminarEmpleado($campos)
    {
        return $this->nucleo->eliminarRegistro($campos);
    }

    public function verificarRelacion($campos)
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        count(v.id_empleado) AS TOTAL
        FROM
        venta as v
        INNER JOIN empleado e ON v.id_empleado = e.id");

        $tablaVenta = $this->nucleo->getDatosParametros($campos);
        $tablaVenta = $tablaVenta[0]["total"];
        settype($tablaVenta, 'int');

        return $tablaVenta > 0  ? false : true;
    }


    public function obtenerEmpleado($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT
        e.id,
        e.dui,
        e.nombres,
        e.apellidos,
        d.nombre,
        c.cargo,
        e.id_departamento,
        e.nit,
        e.sexo,
        e.fecha_nacimiento,
        e.telefono,
        e.direccion
        FROM
        empleado as e
        INNER JOIN departamento as d ON e.id_departamento = d.id
        INNER JOIN cargo as c ON e.id_cargo = c.id
        WHERE e.id = $id");
        return $this->nucleo->getDatos();
    }
    
    //MODAL DEPTO
    public function modalDepto($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setTablaBase("departamento");
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM departamento WHERE ($campo LIKE '%$buscar%')  order by nombre");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM departamento 
        WHERE ($campo LIKE '%$buscar%') order by nombre ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("nombre"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }
    //MODAL CARGO
    public function modalCargo($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setTablaBase("cargo");
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
        FROM cargo WHERE ($campo LIKE '%$buscar%')  order by cargo");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM cargo
        WHERE ($campo LIKE '%$buscar%') order by cargo ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("cargo"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }
    public function tablaEmpleado($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(e.id) as total
        FROM 
        empleado as e WHERE (e.$campo LIKE '%$buscar%')");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT 
        e.id,
        e.dui,
        e.nombres,
        e.apellidos,
        d.nombre,
        c.cargo
        FROM
        empleado as e
        INNER JOIN departamento as d ON e.id_departamento = d.id
        INNER JOIN cargo as c ON e.id_cargo = c.id
        WHERE (e.$campo LIKE '%$buscar%') order by e.nombres ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("dui", "nombres", "apellidos", "nombre","cargo"),
            array("ver" => "tasks", "editar" => "edit", "eliminar" => "trash"),
            "id"
        );
    }

    public function obtenerDatosModal($id)
    {
        $respuesta = array();
        $this->nucleo->setQueryPersonalizado("SELECT 
        e.id,
        e.dui,
        e.nit,
        e.nombres,
        e.apellidos,
        e.sexo,
        e.fecha_nacimiento,
        e.telefono,
        e.id_departamento,
        d.nombre,
        c.cargo   
       FROM
       empleado as e
       INNER JOIN departamento as d ON e.id_departamento = d.id
       INNER JOIN cargo as c ON e.id_cargo = c.id
        WHERE e.id = $id");
        $resultado = $this->nucleo->getDatos();
        $respuesta["modalCuerpo"] = $this->htmlModalDatosEmpleado($resultado);

        return $respuesta;
    }
    private function htmlModalDatosEmpleado($datos)
    {
        $datosEmpleado= "";
        foreach ($datos as $empleado) {
            $datosEmpleado = $datosEmpleado. "<label class='bmd-label-floating roboto-medium'>DUI: {$empleado['dui']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>NIT: {$empleado['nit']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>NOMBRE: {$empleado['nombres']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>APELLIDO: {$empleado['apellidos']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>SEXO: {$empleado['sexo']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>FECHA DE NACIMIENTO: {$empleado['fecha_nacimiento']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>TELEFONO: {$empleado['telefono']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>DEPARTAMENTO: {$empleado['nombre']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
            $datosEmpleado = $datosEmpleado . "<label class='bmd-label-floating roboto-medium'>CARGO: {$empleado['cargo']}</label>";
            $datosEmpleado = $datosEmpleado . "<br>";
    
        }
        return $datosEmpleado;
    }
}
