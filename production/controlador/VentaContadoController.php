<?php
session_start();
include('../modelo/VentaContado.php');
//VARIABLES DE SESION
$items = isset($_SESSION['items']) ?  $_SESSION['items'] : array();
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_factura = (isset($_POST['txt_factura'])) ?  $_POST['txt_factura'] : '';
$txt_idCliente = (isset($_POST['txt_idCliente'])) ?  $_POST['txt_idCliente'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opcion) {
    case 'numeroFactura': {
            $contado = new VentaContado();
            echo json_encode($contado->numeroFcatura());
            $contado = null;
            break;
        }
    case 'ingresarVenta': {
            $venta = new VentaContado();
            $respuesta = array();
            $fecha = date("Y-m-d");
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
                                $_SESSION['inventario'] = null;
                                $_SESSION['items'] = null;
                                $_SESSION['factura'] = $txt_factura;
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
