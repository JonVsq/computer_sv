<?php
include('../modelo/Tipoactivo.php');
//CAPTURA CAMPOS
$idTipoactivo = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_codigo =  (isset($_POST['txt_codigo'])) ? strtoupper($_POST['txt_codigo']) : '';
$txt_nombre =  (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_porcentaje =  (isset($_POST['rb_porcentaje'])) ? $_POST['rb_porcentaje'] : '';

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
            $tipoactivo = new Tipoactivo();
            $respuesta = array();
            /*$existe = $departamento->camposUnicos(array("codigo" => $txt_codigo, "nombre" => $txt_nombre, "ubicacion"=> $ubicacion), "", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {*/
               
                $tiempo=0.0;
                if($txt_porcentaje=="20.0"){
                    $tiempo=5.0;
                }else if($txt_porcentaje=="5.0"){
                    $tiempo=20.0;
                }else if($txt_porcentaje=="25.0"){
                    $tiempo=4.0;
                }else if($txt_porcentaje=="50.0"){
                    $tiempo=2.0;
                }
                $estados="A";
                if ($tipoactivo->insertarTipoactivo(array($txt_codigo, $txt_nombre, $estados , $txt_porcentaje, $tiempo))) {
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
            //}
            $tipoactivo = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $tipoactivo = new Tipoactivo();
            $respuesta = array();
            /*$existe = $departamento->camposUnicosModificar(array("nombre" => $txt_nombre), "id", $idDepartamento);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {*/
                
                 $tiempo=0.0;
                if($txt_porcentaje=="20.0"){
                    $tiempo=5.0;
                }else if($txt_porcentaje=="5.0"){
                    $tiempo=20.0;
                }else if($txt_porcentaje=="25.0"){
                    $tiempo=4.0;
                }else if($txt_porcentaje=="50.0"){
                    $tiempo=2.0;
                }
                    $estados="A";
                if ($tipoactivo->modificarTipoactivo(array($idTipoactivo, $txt_codigo, $txt_nombre, $estados, $txt_porcentaje, $tiempo))) {
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
            //}
            $tipoactivo = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $tipoactivo = new Tipoactivo();
            echo json_encode($tipoactivo->obtenerTipoactivo($idTipoactivo));
            $tipoactivo = null;
            break;
        }
    case 'listar': {
            $tipoactivo = new Tipoactivo();
            echo json_encode($tipoactivo->tablaTipoactivo($pagina, $cantidad, $campo, $buscar));
            $tipoactivo = null;
            break;
        }

    case 'eliminar': {
            $tipoactivo = new Tipoactivo();
            $respuesta = array();
            if ($tipoactivo->verificarRelacion($idTipoactivo)) {
                if ($tipoactivo->eliminarTipoactivo(array($idTipoactivo))) {
                    $respuesta[] = array(
                        "estado" => 1,
                        "encabezado" => "EXITO.",
                        "msj" => "TIPO DE ACTIVO ELIMINADO.",
                        "icono" => "success"
                    );
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "NO SE PUDO ELIMINAR.",
                        "icono" => "error"
                    );
                }
            } else {
                $respuesta[] = array(
                    "estado" => 2,
                    "encabezado" => "ERROR.",
                    "msj" => "HAY REGISTROS ACTIVOS RELACIONADOS AL TIPO DE ACTIVO.",
                    "icono" => "error"
                );
            }
            $tipoactivo = null;
            echo  json_encode($respuesta);
            break;
        }    
            
    case 'obtenercodigo' : {
        $tipoactivo = new Tipoactivo();
        if(empty($tipoactivo->codigoTipoactivo())){
            $respuesta[] = array(
                        "estado" => 2  
                    );
            echo json_encode($respuesta);
        }else {
        echo json_encode($tipoactivo->codigoTipoactivo(), JSON_NUMERIC_CHECK);
        }
        $tipoactivo = null;
        break;
    }
}
