<?php
include('../modelo/Interes.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_porcentaje =  (isset($_POST['txt_porcentaje'])) ? $_POST['txt_porcentaje'] : '';
$txt_plazo =  (isset($_POST['txt_plazo'])) ? $_POST['txt_plazo'] : '';
//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "plazo";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opcion) {
    case 'insertar': {
            $interes = new Interes();
            $respuesta = array();
            $existe = $interes->CamposUnicos(
                array("plazo" => $txt_plazo, "porcentaje" => $txt_porcentaje),
                "id",
                ""
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($interes->insertarInteres(array($txt_porcentaje, $txt_plazo))) {
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
            $interes = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $interes = new Interes();
            $respuesta = array();
            $existe = $interes->camposUnicosModificar(
                array("plazo" => $txt_plazo, "porcentaje" => $txt_porcentaje),
                "id",
                $id
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($interes->modificarInteres(array($id, $txt_porcentaje, $txt_plazo))) {
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
            $interes = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $interes = new Interes();
            echo json_encode($interes->obtenerInteres($id));
            $interes = null;
            break;
        }
    case 'listar': {
            $interes = new Interes();
            echo json_encode($interes->tablaInteres($pagina, $cantidad, $campo, $buscar));
            $interes = null;
            break;
        }
}
