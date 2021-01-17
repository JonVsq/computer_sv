<?php
include('../modelo/Cargo.php');
//CAPTURA CAMPOS
$idCargo = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_cargo =  (isset($_POST['txt_cargo'])) ? strtoupper($_POST['txt_cargo']) : '';
$txt_sueldo =  (isset($_POST['txt_sueldo'])) ? strtoupper($_POST['txt_sueldo']) : '';
$txt_descripcion =  (isset($_POST['txt_descripcion'])) ? strtoupper($_POST['txt_descripcion']) : '';
//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "cargo";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'insertar': {
            $cargo = new Cargo();
            $respuesta = array();
            $existe = $cargo->CamposUnicos(array("cargo" => $txt_cargo,"descripcion" => $txt_descripcion), "id", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($cargo->insertarCargo(array($txt_cargo,$txt_descripcion,$txt_sueldo))) {
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
            $cargo = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $cargo = new Cargo();
            $respuesta = array();
            $existe = $cargo->camposUnicosModificar(array("cargo" => $txt_cargo,"descripcion" => $txt_descripcion,"sueldo" => $txt_sueldo), "id", $idCargo);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($cargo->modificarCargo(array($idCargo, $txt_cargo,$txt_descripcion,$txt_sueldo))) {
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
            $cargo = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $cargo = new Cargo();
            echo json_encode($cargo->obtenerCargo($idCargo));
            $cargo = null;
            break;
        }
    case 'listar': {
            $cargo = new Cargo();
            echo json_encode($cargo->tablaCargo($pagina, $cantidad, $campo, $buscar));
            $cargo = null;
            break;
        }
}
