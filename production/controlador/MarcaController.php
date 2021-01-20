<?php
include('../modelo/Marca.php');
//CAPTURA CAMPOS
$idMarca = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_marca =  (isset($_POST['txt_marca'])) ? strtoupper($_POST['txt_marca']) : '';
//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "nombre_marca";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'insertar': {
            $marca = new Marca();
            $respuesta = array();
            $existe = $marca->CamposUnicos(array("nombre_marca" => $txt_marca), "id", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($marca->insertarMarca(array($txt_marca))) {
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
            $marca = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $marca = new Marca();
            $respuesta = array();
            $existe = $marca->camposUnicosModificar(array("nombre_marca" => $txt_marca), "id", $idMarca);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($marca->modificarMarca(array($idMarca, $txt_marca))) {
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
            $marca = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $marca = new Marca();
            echo json_encode($marca->obtenerMarca($idMarca));
            $marca = null;
            break;
        }
    case 'listar': {
            $marca = new Marca();
            echo json_encode($marca->tablaMarca($pagina, $cantidad, $campo, $buscar));
            $marca = null;
            break;
        }
    case 'eliminar': {
            $marca = new Marca();
            $respuesta = array();
            if ($marca->verificarRelacion($idMarca)) {
                if ($marca->eliminarMarca($idMarca)) {
                    $respuesta[] = array(
                        "estado" => 1,
                        "encabezado" => "EXITO.",
                        "msj" => "MARCA ELIMINADA.",
                        "icono" => "success"
                    );
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "NO SE PUDO ELIMINAR LA MARCA.",
                        "icono" => "error"
                    );
                }
            } else {
                $respuesta[] = array(
                    "estado" => 2,
                    "encabezado" => "ERROR.",
                    "msj" => "HAY REGISTROS ACTIVOS RELACIONADOS A LA MARCA.",
                    "icono" => "error"
                );
            }
            $marca = null;
            echo  json_encode($respuesta);
            break;
        }
}
