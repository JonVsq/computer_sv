<?php
include('../modelo/Empleado.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_idCargo =  (isset($_POST['txt_idCargo'])) ? $_POST['txt_idCargo'] : '';
$txt_idDepto =  (isset($_POST['txt_idDepto'])) ? $_POST['txt_idDepto'] : '';
$txt_nombre =  (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_apellido =  (isset($_POST['txt_apellido'])) ? strtoupper($_POST['txt_apellido']) : '';
$txt_dui =  (isset($_POST['txt_dui'])) ? $_POST['txt_dui'] : '';
$txt_nit =  (isset($_POST['txt_nit'])) ? strtoupper($_POST['txt_nit']) : '';
$txt_fecha =  (isset($_POST['txt_fecha'])) ? $_POST['txt_fecha'] : '';
$txt_sexo =  (isset($_POST['rb_sexo'])) ? $_POST['rb_sexo'] : '';
$txt_tell =  (isset($_POST['txt_tell'])) ? $_POST['txt_tell'] : '';
$txt_dir =  (isset($_POST['txt_dir'])) ? $_POST['txt_dir'] : '';

//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "nombres";
//MODAL MARCA
$campoDepto = (isset($_POST['campoDepto'])) ? $_POST['campoDepto'] : '';
$campoDepto= strcmp($campoDepto, '') ? $campoDepto : "nombre";
//MODAL CATEGORIA
$campoCargo = (isset($_POST['campoCargo'])) ? $_POST['campoCargo'] : '';
$campoCargo = strcmp($campoCargo, '') ? $campoCargo : "cargo";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'insertar': {
            $empleado = new Empleado();
            $respuesta = array();
            $existe = $empleado->camposUnicos(
                array("dui" => $txt_dui, "nit" => $txt_nit),
                "id",
                ""
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                
                if ($empleado->insertarEmpleado(
                    array(
                        $txt_idDepto, $txt_dui,
                        $txt_nit, $txt_nombre, $txt_apellido, $txt_sexo,
                        $txt_fecha, $txt_tell, $txt_dir, $txt_idCargo
                    )
                )) {
                    $respuesta[] = array(
                        "estado" => 1,
                        "encabezado" => "EXITO.",
                        "msj" => "DATOS ALMACENADOS.",
                        "icono" => "success"
                    );
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "DATOS NO ALMACENADOS.",
                        "icono" => "error"
                    );
                }
            }
            $empleado = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $empleado= new Empleado();
            $respuesta = array();
            $existe = $empleado->camposUnicosModificar(
                array("dui" => $txt_dui, "nit" => $txt_nit),
                "id",
                $id
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                
                if ($empleado->modificarEmpleado(
                    array(
                        $id,
                        $txt_idDepto, $txt_dui,
                        $txt_nit, $txt_nombre, $txt_apellido, $txt_sexo,
                        $txt_fecha, $txt_tell, $txt_dir, $txt_idCargo
                    )
                )) {
                    $respuesta[] = array(
                        "estado" => 1,
                        "encabezado" => "EXITO.",
                        "msj" => "DATOS MODIFICADOS.",
                        "icono" => "success"
                    );
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "DATOS NO MODIFICADOS.",
                        "icono" => "error"
                    );
                }
            }
            $empleado = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modalDepto': {
            $empleado = new Empleado();
            echo json_encode($empleado->modalDepto($pagina, $cantidad, $campoDepto, $buscar));
            $empleado = null;
            break;
        }
    case 'modalCargo': {
            $empleado= new Empleado();
            echo json_encode($empleado->modalCargo($pagina, $cantidad, $campoCargo, $buscar));
            $empleado = null;
            break;
        }
    case 'modal': {
            $empleado = new Empleado();
            echo json_encode($empleado->obtenerDatosModal($id));
            $empleado = null;
            break;
        }
    case 'obtener': {
            $empleado = new Empleado();
            echo json_encode($empleado->obtenerEmpleado($id));
            $empleado = null;
            break;
        }
    case 'listar': {
            $empleado = new Empleado();
            echo json_encode($empleado->tablaEmpleado($pagina, $cantidad, $campo, $buscar));
            $empleado = null; 
            break;
        }

        case 'eliminar': {
            $empleado = new Empleado();
            $respuesta = array();
            
                if ($empleado->eliminarEmpleado(array($id))) {
                    $respuesta[] = array(
                        "estado" => 1,
                        "encabezado" => "EXITO.",
                        "msj" => "EMPLEADO ELIMINADO.",
                        "icono" => "success"
                    );
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "NO SE PUDO ELIMINAR EL REGISTRO",
                        "icono" => "error"
                    );
                }
            
            $empleado = null;
            echo  json_encode($respuesta);
            break;
        }
}
