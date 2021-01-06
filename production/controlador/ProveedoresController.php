<?php
include('../modelo/Proveedores.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_nombre =  (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_direccion =  (isset($_POST['txt_direccion'])) ? strtoupper($_POST['txt_direccion']) : '';
$txt_telefono =  (isset($_POST['txt_telefono'])) ? strtoupper($_POST['txt_telefono']) : '';
$txt_correo =  (isset($_POST['txt_correo'])) ? $_POST['txt_correo'] : '';
$txt_diasEntrega =  (isset($_POST['txt_diasEntrega'])) ? $_POST['txt_diasEntrega'] : '';
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
            $catProveedor = new Proveedores();
            $respuesta = array();
            $existe = $catProveedor->camposUnicos(array(
                "nombre" => $txt_nombre, "telefono" => $txt_telefono,
                "correo" => $txt_correo,
            ), "id", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($catProveedor->insertaProveedor(array($txt_nombre, $txt_direccion, $txt_telefono, $txt_correo, $txt_diasEntrega))) {
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
            $catProveedor = null;
            echo json_encode($respuesta);
            break;
        }
        case 'modificar': {
            $catProveedor = new Proveedores();
            $respuesta = array();
            $existe = $catProveedor->camposUnicosModificar(array(
                "nombre" => $txt_nombre, "telefono" => $txt_telefono,
                "correo" => $txt_correo,
            ), "id", $id);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                if ($catProveedor->modificarProveedor(array($id, $txt_nombre, $txt_direccion, $txt_telefono, $txt_correo, $txt_diasEntrega))) {
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
            $catProveedor = null;
            echo json_encode($respuesta);
            break;
        }
        case 'obtener': {
            $catProveedor = new Proveedores();
            echo json_encode($catProveedor->obtenerProveedor($id));
            $catProveedor = null;
            break;
        }
        case 'listar': {
            $catProveedor = new Proveedores();
            echo json_encode($catProveedor->tablaProveedor($pagina, $cantidad, $campo, $buscar));
            $catProveedor = null;
            break;
        }
}
