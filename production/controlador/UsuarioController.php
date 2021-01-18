<?php
include('../modelo/Usuario.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_idEmpleado =  (isset($_POST['txt_idEmpleado'])) ? $_POST['txt_idEmpleado'] : '';

$txt_correo =  (isset($_POST['txt_correo'])) ? strtoupper($_POST['txt_correo']) : '';
$txt_ac =  (isset($_POST['txt_ac'])) ? strtoupper($_POST['txt_ac']) : '';
$txt_contra =  (isset($_POST['txt_contra'])) ? $_POST['txt_contra'] : '';

//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "correo";
//MODAL MARCA
$campoEmpleado = (isset($_POST['campoEmpleado'])) ? $_POST['campoEmpleado'] : '';
$campoEmpleado= strcmp($campoEmpleado, '') ? $campoEmpleado : "nombres";
//MODAL CATEGORIA



$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'insertar': {
            $usuario = new Usuario();
            $respuesta = array();
            $existe = $usuario->camposUnicos(
                array("correo" => $txt_correo),
                "id",
                ""
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
            
                if ($usuario->insertarUsuario(
                    array(
                        $txt_idEmpleado, $txt_correo,
                        $txt_contra, $txt_ac
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
            $usuario = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $usuario = new Usuario();
            $respuesta = array();
            $existe = $usuario->camposUnicosModificar(
                array("correo" => $txt_correo),
                "id",
                $id
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                
                if ($usuario->modificarUsuario(
                    array(
                        $id,
                        $txt_idEmpleado, $txt_correo,
                        $txt_contra, $txt_ac
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
            $usuario = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modalEmpleado': {
            $usuario = new Usuario();
            echo json_encode($usuario->modalEmpleado($pagina, $cantidad, $campoEmpleado, $buscar));
            $usuario = null;
            break;
        }
    
    case 'modal': {
            $usuario = new Usuario();
            echo json_encode($usuario->obtenerDatosModal($id));
            $usuario= null;
            break;
        }
    case 'obtener': {
            $usuario = new Usuario();
            echo json_encode($usuario->obtenerUsuario($id));
            $usuario = null;
            break;
        }
    case 'listar': {
            $usuario = new Usuario();
            echo json_encode($usuario->tablaUsuarios($pagina, $cantidad, $campo, $buscar));
            $usuario = null;
            break;
        }
}
