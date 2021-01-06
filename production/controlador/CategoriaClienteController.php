<?php
include('../modelo/CategoriaCliente.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_nombre =  (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_descripcion =  (isset($_POST['txt_descripcion'])) ? strtoupper($_POST['txt_descripcion']) : '';
$txt_maxAtraso =  (isset($_POST['txt_maxAtraso'])) ? $_POST['txt_maxAtraso'] : '';
$txt_maxVentas =  (isset($_POST['txt_maxVentas'])) ? $_POST['txt_maxVentas'] : '';
$txt_montoLimite =  (isset($_POST['txt_montoLimite'])) ? $_POST['txt_montoLimite'] : '';
//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "nombre";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opcion) {
    case 'insertar': {
            $catCliente = new CategoriaCliente();
            $respuesta = array();
            $existe = $catCliente->camposUnicos(array(
                "nombre" => $txt_nombre, "descripcion" => $txt_descripcion,
                "max_atraso" => $txt_maxAtraso, "max_ventas" => $txt_maxVentas
            ), "id", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($catCliente->insertaCategoriaCliente(array($txt_nombre, $txt_descripcion, $txt_maxAtraso, $txt_maxVentas, $txt_montoLimite))) {
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
            $catCliente = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $catCliente = new CategoriaCliente();
            $respuesta = array();
            $existe = $catCliente->camposUnicosModificar(array(
                "nombre" => $txt_nombre, "descripcion" => $txt_descripcion,
                "max_atraso" => $txt_maxAtraso, "max_ventas" => $txt_maxVentas
            ), "id", $id);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($catCliente->modificarCategoriaCliente(array($id, $txt_nombre, $txt_descripcion, $txt_maxAtraso, $txt_maxVentas, $txt_montoLimite))) {
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
            $catCliente = null;
            echo json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $catCliente = new CategoriaCliente();
            echo json_encode($catCliente->obtenerCategoriaCliente($id));
            $catCliente = null;
            break;
        }
    case 'listar': {
            $catCliente = new CategoriaCliente();
            echo json_encode($catCliente->tablaCategoriaCliente($pagina, $cantidad, $campo, $buscar));
            $catCliente = null;
            break;
        }
}
