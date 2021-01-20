<?php
include('../modelo/Departamento.php');
//CAPTURA CAMPOS
$idDepartamento = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_codigo =  (isset($_POST['txt_codigo'])) ? strtoupper($_POST['txt_codigo']) : '';
$txt_nombre =  (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_ubicacion =  (isset($_POST['txt_ubicacion'])) ? strtoupper($_POST['txt_ubicacion']) : '';

//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "codigo";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'insertar': {
        $departamento = new Departamento();
        $respuesta = array();
            /*$existe = $departamento->camposUnicos(array("codigo" => $txt_codigo, "nombre" => $txt_nombre, "ubicacion"=> $ubicacion), "", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {*/
                $alta=true;
                
                if($departamento->obtenerEmpresa()){
                    $id_empresa = $departamento->obtenerEmpresa()[0]['id'];
                    if ($departamento->insertarDepartamento(array($id_empresa, $txt_codigo, $txt_nombre, $txt_ubicacion, $alta))) {
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
            //}
                $departamento = null;
                echo  json_encode($respuesta);
                break;
            }
            case 'modificar': {
                $departamento = new Departamento();
                $respuesta = array();
            /*$existe = $departamento->camposUnicosModificar(array("nombre" => $txt_nombre), "id", $idDepartamento);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {*/
                $alta=true;
                if($departamento->obtenerEmpresa()){
                    $id_empresa = $departamento->obtenerEmpresa()[0]['id'];
                    if ($departamento->modificarDepartamento(array($idDepartamento,$id_empresa, $txt_codigo, $txt_nombre, $txt_ubicacion,$alta))) {
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
            //}
                $departamento = null;
                echo  json_encode($respuesta);
                break;
            }
            case 'obtener': {
                $departamento = new Departamento();
                echo json_encode($departamento->obtenerDepartamento($idDepartamento));
                $departamento = null;
                break;
            }
            case 'listar': {
                $departamento = new Departamento();
                echo json_encode($departamento->tablaDepartamento($pagina, $cantidad, $campo, $buscar));
                $departamento = null;
                break;
            }

            case 'eliminar': {
                $departamento = new Departamento();
                $respuesta = array();
                if ($departamento->verificarRelacion($idDepartamento)) {
                    if ($departamento->eliminarDepartamento(array($idDepartamento))) {
                        $respuesta[] = array(
                            "estado" => 1,
                            "encabezado" => "EXITO.",
                            "msj" => "DEPARTAMENTO ELIMINADO.",
                            "icono" => "success"
                        );
                    } else {
                        $respuesta[] = array(
                            "estado" => 2,
                            "encabezado" => "ERROR.",
                            "msj" => "NO SE PUDO ELIMINAR EL DEPARTAMENTO.",
                            "icono" => "error"
                        );
                    }
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "HAY REGISTROS ACTIVOS RELACIONADOS AL DEPARTAMENTO.",
                        "icono" => "error"
                    );
                }
                $departamento = null;
                echo  json_encode($respuesta);
                break;
            }    

            
            case 'obtenercodigo': {
                $departamento = new Departamento();
                if(empty($departamento->codigoDepartamento())){
                    $respuesta[] = array(
                        "estado" => 2  
                    );
                    echo json_encode($respuesta);
                }else {
                    echo json_encode($departamento->codigoDepartamento(), JSON_NUMERIC_CHECK);
                }

                $departamento = null;
                break;
        /*
        $departamento = new Departamento();
        echo json_encode($departamento->codigoDepartamento(), JSON_NUMERIC_CHECK);
        $departamento = null;*/
        
    }
}
