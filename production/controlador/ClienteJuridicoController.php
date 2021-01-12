<?php
include('../modelo/ClienteJuridico.php');

//CAPTURA CAMPOS CLIENTE
$txt_codigo = (isset($_POST['txt_codigo'])) ?  strtoupper($_POST['txt_codigo']) : '';
$txt_nombre =  (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_telefono =  (isset($_POST['txt_telefono'])) ? strtoupper($_POST['txt_telefono']) : '';
$txt_direccion =  (isset($_POST['txt_direccion'])) ? strtoupper($_POST['txt_direccion']) : '';
$txt_fechaIngreso =  (isset($_POST['txt_fechaIngreso'])) ? $_POST['txt_fechaIngreso'] : '';
//CAPTURA CAMPOS DATOS JURIDICOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_activoCorriente = (isset($_POST['txt_activoCorriente'])) ?  $_POST['txt_activoCorriente'] : '';
$txt_pasivoCorriente = (isset($_POST['txt_pasivoCorriente'])) ?  $_POST['txt_pasivoCorriente'] : '';
$txt_inventario = (isset($_POST['txt_inventario'])) ?  $_POST['txt_inventario'] : '';
$balanceGeneral = isset($_FILES['balanceGeneral']) ? $_FILES['balanceGeneral'] : '';
$estadoResultado = isset($_FILES['estadoResultado']) ? $_FILES['estadoResultado'] : '';
//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "nombre";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
//DIRECTORIOS
$rutaRaiz = "../archivos";
$existeRaiz = false;

$rutaCliente = "$rutaRaiz/$txt_codigo";
$existeRC = false;
switch ($opcion) {
    case 'insertar': {
            $catClienteJ = new ClienteJuridico();
            $respuesta = array();
            $existe = $catClienteJ->camposUnicosC(array(
                "nombre" => $txt_nombre, "telefono" => $txt_telefono,
            ), "codigo", "");
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                $idCategoria = $catClienteJ->obtenerIdCategoria();
                if (is_numeric($idCategoria)) {
                    if (!file_exists($rutaRaiz)) {
                        $existeRaiz = mkdir($rutaRaiz, 0777, true);
                    } else {
                        $existeRaiz = true;
                    }
                    if ($existeRaiz) {
                        if (!file_exists($rutaCliente)) {
                            $existeRC = mkdir($rutaCliente, 0777, true);
                        } else {
                            $existeRC = true;
                        }
                        $nombreBalance = $balanceGeneral["name"];
                        $nombreEstado = $estadoResultado["name"];
                        $subirBalance = move_uploaded_file($balanceGeneral["tmp_name"], $rutaCliente . "/" . $nombreBalance);
                        $subirEstado = move_uploaded_file($estadoResultado["tmp_name"], $rutaCliente . "/" . $nombreEstado);
                        if ($subirBalance && $subirEstado) {
                            if ($catClienteJ->insertaCliente(array(
                                $txt_codigo, $idCategoria, $txt_nombre,
                                $txt_telefono, $txt_direccion, date("Y-m-d")
                            ))) {
                                if ($catClienteJ->insertaDatosC(array(
                                    $txt_codigo, $txt_activoCorriente, $txt_pasivoCorriente,
                                    $txt_inventario, $nombreBalance, $nombreEstado
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
                                "msj" => "NO SE PUDO SUBIR LOS ARCHIVOS.",
                                "icono" => "error"
                            );
                        }
                    } else {
                        $respuesta[] = array(
                            "estado" => 2,
                            "encabezado" => "ERROR.",
                            "msj" => "NO ES POSIBRE SUBIR LOS PDF.",
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
            $catClienteJ = null;
            echo json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $catClienteJ = new ClienteJuridico();
            echo json_encode($catClienteJ->obtenerClienteJ($txt_codigo));
            $catClienteJ = null;
            break;
        }
    case 'modal': {
            $catClienteJ = new ClienteJuridico();
            echo json_encode($catClienteJ->obtenerDatosModal($txt_codigo));
            $catClienteJ = null;
            break;
        }
    case 'listar': {
            $catClienteJ = new ClienteJuridico();
            echo json_encode($catClienteJ->tablaClienteJ($pagina, $cantidad, $campo, $buscar));
            $catClienteJ = null;
            break;
        }
}
