<?php
include('../modelo/ClienteNatural.php');
//CAPTURA CAMPOS CLIENTE
$txt_codigo = (isset($_POST['txt_codigo'])) ?  strtoupper($_POST['txt_codigo']) : '';
$txt_nombre =  (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_telefono =  (isset($_POST['txt_telefono'])) ? strtoupper($_POST['txt_telefono']) : '';
$txt_direccion =  (isset($_POST['txt_direccion'])) ? strtoupper($_POST['txt_direccion']) : '';
$txt_fechaIngreso =  (isset($_POST['txt_fechaIngreso'])) ? $_POST['txt_fechaIngreso'] : '';
//CAPTURA CAMPOS DATOS NATURAL
$txt_dui =  (isset($_POST['txt_dui'])) ? strtoupper($_POST['txt_dui']) : '';
$txt_nit =  (isset($_POST['txt_nit'])) ? strtoupper($_POST['txt_nit']) : '';
$txt_estadoCivil =  (isset($_POST['txt_estadoCivil'])) ? strtoupper($_POST['txt_estadoCivil']) : '';
$txt_lugarTrabajo =  (isset($_POST['txt_lugarTrabajo'])) ? strtoupper($_POST['txt_lugarTrabajo']) : '';
$txt_ingresos =  (isset($_POST['txt_ingresos'])) ? $_POST['txt_ingresos'] : '';
$txt_egresos =  (isset($_POST['txt_egresos'])) ? $_POST['txt_egresos'] : '';
//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "dui";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opcion) {
    case 'insertar': {
            $catClienteN = new ClienteNatural();
            $respuesta = array();
            $existeCliente = $catClienteN->camposUnicosC(array(
                "nombre" => $txt_nombre, "telefono" => $txt_telefono,
            ), "codigo", "");
            $existeDatos = $catClienteN->camposUnicosD(array(
                "dui" => $txt_dui, "nit" => $txt_nit,
            ), "codigo_cliente", "");
            if ($existeCliente['existe'] == 1 || $existeDatos['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errorC" => $existeCliente,
                    "errorD" => $existeDatos

                );
            } else {
                $idCategoria = $catClienteN->obtenerIdCategoria();
                if (is_numeric($idCategoria)) {
                    if ($catClienteN->insertaCliente(array(
                        $txt_codigo, $idCategoria, $txt_nombre,
                        $txt_telefono, $txt_direccion, date("Y-m-d")
                    ))) {
                        if ($catClienteN->insertaDatosC(array(
                            $txt_codigo, $txt_dui, $txt_nit,
                            $txt_estadoCivil, $txt_lugarTrabajo, $txt_ingresos, $txt_egresos
                        ))) {
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
                    } else {
                        $respuesta[] = array(
                            "estado" => 2,
                            "encabezado" => "ERROR.",
                            "msj" => "DATOS NO ALMACENADOS.",
                            "icono" => "error"
                        );
                    }
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "NO SE ENCONTRO CATEGORIA.",
                        "icono" => "error"
                    );
                }
            }
            $catClienteN = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $catClienteN = new ClienteNatural();
            $respuesta = array();
            $existeCliente = $catClienteN->camposUnicosModificarC(array(
                "nombre" => $txt_nombre, "telefono" => $txt_telefono,
            ), "codigo", "$txt_codigo");
            $existeDatos = $catClienteN->camposUnicosModificarD(array(
                "dui" => $txt_dui, "nit" => $txt_nit,
            ), "codigo_cliente", "$txt_codigo");
            if ($existeCliente['existe'] == 1 || $existeDatos['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errorC" => $existeCliente,
                    "errorD" => $existeDatos

                );
            } else {
                $idCategoria = $catClienteN->obtenerIdCategoria();
                if (is_numeric($idCategoria)) {
                    if ($catClienteN->modificarCliente(array(
                        $txt_codigo, $idCategoria, $txt_nombre,
                        $txt_telefono, $txt_direccion, $txt_fechaIngreso
                    ))) {
                        if ($catClienteN->modificarDatosC(array(
                            $txt_dui, $txt_nit, $txt_estadoCivil, 
                            $txt_lugarTrabajo, $txt_ingresos, $txt_egresos, $txt_codigo
                        ))) {
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
                                "msj" => "DATOS NO NO MODIFICADOS.",
                                "icono" => "error"
                            );
                        }
                    } else {
                        $respuesta[] = array(
                            "estado" => 2,
                            "encabezado" => "ERROR.",
                            "msj" => "DATOS NO MODIFICADOS.",
                            "icono" => "error"
                        );
                    }
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "NO SE ENCONTRO CATEGORIA.",
                        "icono" => "error"
                    );
                }
            }
            $catClienteN = null;
            echo json_encode($respuesta);
            break;
        }
        case 'obtener': {
            $catClienteN = new ClienteNatural();
            echo json_encode($catClienteN->obtenerClienteN($txt_codigo));
            $catClienteN = null;
            break;
        }
        case 'modal': {
            $catClienteN = new ClienteNatural();
            echo json_encode($catClienteN->obtenerDatosModal($txt_codigo));
            $catClienteN = null;
            break;
        }
    case 'listar': {
            $catClienteN = new ClienteNatural();
            echo json_encode($catClienteN->tablaClienteN($pagina, $cantidad, $campo, $buscar));
            $catClienteN = null;
            break;
        }
}
