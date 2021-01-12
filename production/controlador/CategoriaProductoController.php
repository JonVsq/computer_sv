<?php
include('../modelo/CategoriaProducto.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_descripcion =  (isset($_POST['txt_descripcion'])) ? strtoupper($_POST['txt_descripcion']) : '';
//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "descripcion";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'insertar': {
            $catPro = new CategoriaProducto();
            $respuesta = array();
            $existe = $catPro->CamposUnicos(array("descripcion" => $txt_descripcion), "id", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($catPro->insertarCategoriaP(array($txt_descripcion))) {
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
            $catPro = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $catPro = new CategoriaProducto();
            $respuesta = array();
            $existe = $catPro->camposUnicosModificar(array("descripcion" => $txt_descripcion), "id", $id);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($catPro->modificarCategoriaP(array($id, $txt_descripcion))) {
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
            $catPro = null;
            echo  json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $catPro = new CategoriaProducto();
            echo json_encode($catPro->obtenerCategoriaP($id));
            $catPro = null;
            break;
        }
    case 'listar': {
            $catPro = new CategoriaProducto();
            echo json_encode($catPro->tablaCategoriaP($pagina, $cantidad, $campo, $buscar));
            $catPro = null;
            break;
        }
}
