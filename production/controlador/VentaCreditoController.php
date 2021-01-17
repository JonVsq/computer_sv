<?php
session_start();
include('../modelo/VentaCredito.php');
//VARIABLES DE SESION
$items = isset($_SESSION['items']) ?  $_SESSION['items'] : array();
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_factura = (isset($_POST['txt_factura'])) ?  $_POST['txt_factura'] : '';
$txt_idCliente = (isset($_POST['txt_idCliente'])) ?  $_POST['txt_idCliente'] : '';
$txt_idplazo =  (isset($_POST['txt_idplazo'])) ?  $_POST['txt_idplazo'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opcion) {
    case 'ingresarVenta': {
            $venta = new VentaCredito();
            $respuesta = array();
            $fecha = date("Y-m-d H:i:s");
            if (!empty($items)) {
                $idVenta = $venta->insertaVentas(array(
                    1,
                    $txt_idCliente,
                    $txt_factura,
                    $fecha
                ));
                if (is_numeric($idVenta)) {
                    if ($venta->crearDetalleVenta($idVenta, $items)) {
                        if ($venta->desactivarMovimientos($items)) {
                            if ($venta->crearMovimientos($items, $fecha)) {
                                $idCredito = $venta->insertarCredito(array($idVenta, $txt_idplazo, $fecha, 0, 0));
                                if (is_numeric($idCredito)) {
                                    if ($venta->insertarPrimerPago($idCredito, $txt_idplazo, $_SESSION['total'])) {
                                        $_SESSION['inventario'] = null;
                                        $_SESSION['items'] = null;
                                        $_SESSION['total'] = null;
                                        $respuesta[] = array(
                                            "estado" => 1,
                                            "encabezado" => "EXITO.",
                                            "msj" => "VENTA PROCESADA.",
                                            "icono" => "success"
                                        );
                                    } else {
                                        $respuesta[] = array(
                                            "estado" => 2,
                                            "encabezado" => "ERROR.",
                                            "msj" => "OCURRIO UN ERROR EN EL CREDITO.",
                                            "icono" => "error"
                                        );
                                    }
                                } else {
                                    $respuesta[] = array(
                                        "estado" => 2,
                                        "encabezado" => "ERROR.",
                                        "msj" => "OCURRIO UN ERROR EN EL CREDITO.",
                                        "icono" => "error"
                                    );
                                }
                            } else {
                                $respuesta[] = array(
                                    "estado" => 2,
                                    "encabezado" => "ERROR.",
                                    "msj" => "OCURRIO UN ERROR EN EL KARDEX.",
                                    "icono" => "error"
                                );
                            }
                        } else {
                            $respuesta[] = array(
                                "estado" => 2,
                                "encabezado" => "ERROR.",
                                "msj" => "OCURRIO UN ERROR EN EL KARDEX.",
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
            $venta = null;
            echo json_encode($respuesta);
            break;
        }
}
