<?php
include('../modelo/Activo.php');
//CAPTURA CAMPOS DEL PRIMER FORMULARIO
$idActivo = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_adquisitor = (isset($_POST['txt_adquisitor'])) ?  $_POST['txt_adquisitor'] : '';
$txt_duicodigo = (isset($_POST['txt_duicodigo'])) ?  $_POST['txt_duicodigo'] : '';
$txt_montoventa = (isset($_POST['txt_montoventaactivo'])) ?  $_POST['txt_montoventaactivo'] : '';
$idDepartamento = (isset($_POST['txt_departamento'])) ?  $_POST['txt_departamento'] : '';
$idTipoactivo = (isset($_POST['txt_tipoactivo'])) ?  $_POST['txt_tipoactivo'] : '';
$txt_codigoactivo =  (isset($_POST['txt_codigoactivo'])) ? strtoupper($_POST['txt_codigoactivo']) : '';
$txt_descripcion =  (isset($_POST['txt_descripcion'])) ? strtoupper($_POST['txt_descripcion']) : '';
$txt_serie =  (isset($_POST['txt_serie'])) ? strtoupper($_POST['txt_serie']) : '';
$txt_marca =  (isset($_POST['txt_marca'])) ? strtoupper($_POST['txt_marca']) : '';
$txt_modelo =  (isset($_POST['txt_modelo'])) ? strtoupper($_POST['txt_modelo']) : '';
$txt_color =  (isset($_POST['txt_color'])) ? strtoupper($_POST['txt_color']) : '';
$txt_fechaoculta =  (isset($_POST['txt_fechaoculta'])) ? strtoupper($_POST['txt_fechaoculta']) : '';
//CAPTURA CAMPOS DEL SEGUNDO FORMULARIO
$rb_estado =  (isset($_POST['rb_estado'])) ? strtoupper($_POST['rb_estado']) : '';
$rb_baja =  (isset($_POST['rb_baja'])) ? strtoupper($_POST['rb_baja']) : '';
$rb_transaccion =  (isset($_POST['rb_transaccion'])) ? strtoupper($_POST['rb_transaccion']) : '';
$txt_tiempousado =  (isset($_POST['txt_tiempousado'])) ? strtoupper($_POST['txt_tiempousado']) : '';
$txt_maximo =  (isset($_POST['txt_maximo'])) ? strtoupper($_POST['txt_maximo']) : '';
$txt_monto =  (isset($_POST['txt_monto'])) ? strtoupper($_POST['txt_monto']) : '';
$txt_ubicacion =  (isset($_POST['txt_ubicacion'])) ? strtoupper($_POST['txt_ubicacion']) : '';
$rb_tangible =  (isset($_POST['rb_tangible'])) ? strtoupper($_POST['rb_tangible']) : '';





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

        $activo = new Activo();
        $respuesta = array();
            /*$existe = $departamento->camposUnicos(array("codigo" => $txt_codigo, "nombre" => $txt_nombre, "ubicacion"=> $ubicacion), "", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else { */

                if(empty($txt_tiempousado)){
                    $txt_tiempousado = 0;
                }
                $txt_venta = 0;  
                $fecha = date("Y-m-d");
                    // $idDepartamento = 5;
                    // $idTipoactivo = 1;

                if ($activo->insertarActivo(array($txt_codigoactivo, $txt_descripcion, $txt_serie, $txt_marca, $txt_modelo, $txt_color, $rb_estado, $txt_tiempousado, $rb_transaccion, $txt_ubicacion, $txt_monto, $rb_tangible, $txt_maximo, $idDepartamento, $idTipoactivo, "A", $txt_venta, $fecha))) {
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
                $activo = null;
                echo  json_encode($respuesta);
                break;  

        //}*/
            }
    case 'modificar': {
            $activo = new Activo();
            $respuesta = array();
            /*$existe = $departamento->camposUnicosModificar(array("nombre" => $txt_nombre), "id", $idDepartamento);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } */
                if(empty($txt_tiempousado)){
                    $txt_tiempousado = 10;
                }
                
                $txt_venta = 0;
                $fecha = date($txt_fechaoculta);
                /*$respuesta[] = array(
                        "estado" => 1,
                        "encabezado" => $idTipoactivo,
                        "msj" => $idDepartamento,
                        "icono" => "success"
                    );*/
                if ($activo->modificarActivo(array($idActivo, $txt_codigoactivo, $txt_descripcion, $txt_serie, $txt_marca, $txt_modelo, $txt_color, $rb_estado, $txt_tiempousado, $rb_transaccion, $txt_ubicacion, $txt_monto, $rb_tangible, $txt_maximo, $idDepartamento, $idTipoactivo, "A", $txt_venta, $fecha))) {
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
            
            $activo = null;
            echo  json_encode($respuesta);
            break;  
        }
    case 'obtener': { 
            $activo = new Activo();
            echo json_encode($activo->obtenerActivo($idActivo));
            $activo = null;
            break;
        }

        case 'obtenerDepartamento': {
            $activo = new Activo();
            echo json_encode($activo->tablaDepartamento($pagina, 5, $campo, $buscar));
            $activo = null;
            break;
        }
        case 'obtenerTipoactivo': {
            $activo = new Activo();
            echo json_encode($activo->tablaTipoactivo($pagina, 5, $campo, $buscar));
            $activo = null;
            break;
        } 
        case 'obtenerEmpresa': {
            $activo = new Activo();
            echo json_encode($activo->codigoEmpresa());
            $activo = null;
            break;
        }

        case 'depreciacion': {
            $activo = new Activo();
            if(empty($activo->generarDepreciacionHTML($idActivo))){
                $respuesta[] = array(
                    "tabla" => 2);
                echo json_encode($respuesta);
            }else{
               echo json_encode($activo->generarDepreciacionHTML($idActivo));
           }

           $activo = null;
           break;
       }

       case 'depreciacionDiaria': {
        $activo = new Activo();
        if(empty($activo->depreciacionDiaria($idActivo))){
            $respuesta[] = array(
                "tabla" => 2);
            echo json_encode($respuesta);
        }else{
           echo json_encode($activo->depreciacionDiaria($idActivo));
       }

       $activo = null;
       break;
   } 

   case 'depreciacionMensual': {
    $activo = new Activo();
    if(empty($activo->depreciacionMensual($idActivo))){
        $respuesta[] = array(
            "tabla" => 2);
        echo json_encode($respuesta);
    }else{
       echo json_encode($activo->depreciacionMensual($idActivo));
   }

   $activo = null;
   break;
} 

case 'obtenerCantidad': {
    $activo = new Activo();

    if(empty($activo->cantidadActivos(1,5, $campo, $buscar))){
     $respuesta[] = array(
        "totalRegistros" => 0  
    );
     echo json_encode($respuesta);
 }else {
    echo json_encode($activo->cantidadActivos(1,5, $campo, $buscar));
}

$activo = null;
break;
}       
case 'listar': {
    $activo = new Activo();
    echo json_encode($activo->tablaActivos($pagina, $cantidad, $campo, $buscar));
    $activo = null;
    break;
}

case 'VENDIDO': {
    $activo = new Activo();
    $respuesta = array();
    if(empty($txt_montoventa)){
        $txt_montoventa = 0;
    }
    
    $fecha = date("Y-m-d");
        if($activo->insertarVentaActivo(array($idActivo, $txt_adquisitor, $txt_duicodigo, $fecha)) && $activo->darbajaVendido(array("V", $txt_montoventa, $idActivo)) ){
         $respuesta[] = array(
            "estado" => 1,
            "encabezado" => "EXITO.",
            "msj" => "ACTIVO VENDIDO",
            "icono" => "success"
        );
     } else {
        $respuesta[] = array(
            "estado" => 2,
            "encabezado" => "ERROR.",
            "msj" => "ERROR EN LA TRANSACCION",
            "icono" => "error"
        );
    }
echo  json_encode($respuesta);
    //echo json_encode($activo->tablaActivos($pagina, $cantidad, $campo, $buscar));
$activo = null;
break;
}

case 'DONADO': {
    $activo = new Activo();
    $respuesta = array();
    if(empty($txt_montoventa)){
        $txt_montoventa = 0;
    }

    $fecha = date("Y-m-d");
        if($activo->insertarVentaActivo(array($idActivo, $txt_adquisitor, $txt_duicodigo, $fecha)) && $activo->darbajaVendido(array("D", $txt_montoventa, $idActivo))){
         $respuesta[] = array(
            "estado" => 1,
            "encabezado" => "EXITO.",
            "msj" => "ACTIVO DONADO",
            "icono" => "success"
        );
     } else {
        $respuesta[] = array(
            "estado" => 2,
            "encabezado" => "ERROR.",
            "msj" => "ERROR EN LA TRANSACCION",
            "icono" => "error"
        );
    }
    
echo  json_encode($respuesta);
    //echo json_encode($activo->tablaActivos($pagina, $cantidad, $campo, $buscar));
$activo = null;
break;
}

case 'BOTADO': {
    $activo = new Activo();
    $respuesta = array();
    
        if($activo->darbajaBotado(array("B", $idActivo))){
         $respuesta[] = array(
            "estado" => 1,
            "encabezado" => "EXITO.",
            "msj" => "ACTIVO BOTADO",
            "icono" => "success"
        );
     } else {
        $respuesta[] = array(
            "estado" => 2,
            "encabezado" => "ERROR.",
            "msj" => "ERROR EN LA TRANSACCION",
            "icono" => "error"
        );
    }
echo  json_encode($respuesta);
    //echo json_encode($activo->tablaActivos($pagina, $cantidad, $campo, $buscar));
$activo = null;
break;
}

    case 'obtenercodigo' : {/*
        $departamento = new Departamento();
        echo json_encode($departamento->codigoDepartamento(), JSON_NUMERIC_CHECK);
        $departamento = null;
        break;*/
    }
}
