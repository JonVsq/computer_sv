<?php
include('../modelo/Compra.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_idProveedor =  (isset($_POST['txt_idProveedor'])) ? $_POST['txt_idProveedor'] : '';
$txt_factura =  (isset($_POST['txt_factura'])) ? $_POST['txt_factura'] : '';
$txt_fecha =  (isset($_POST['txt_fecha'])) ? $_POST['txt_fecha'] : '';
$items =  (isset($_POST['items'])) ? json_decode($_POST['items']) : '';

//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "nombre";
$campoP = (isset($_POST['campoP'])) ? $_POST['campoP'] : '';
$campoP = strcmp($campoP, '') ? $campoP : "producto";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opcion) {
    case 'insertar': {
            $compra = new Compra();
            $respuesta = array();
            //INGRESAMOS LA COMPRA, Y SI EL NUCLEO REGRESA EL ID QUE 
            //MARIA DB LE ASIGNO AL REGISTRO PROCEDEMOS A REGISTRAR LOS DETALLES 
            $idCompra = $compra->insertarCompra(array(
                $txt_idProveedor,
                $txt_factura,
                "No disponible",
                $txt_fecha
            ));
            //VERIFICAMOS QUE EN REALIDAD NOS RETORNO UN ID
            if (is_numeric($idCompra)) {
                //INSERTAMOS LOS DETALLES Y SI REGRESA TRUE 
                //PROCEDEMOS CON EL KARDEX
                if ($compra->insertarDetalle($idCompra, $items)) {
                    //SI LOS MOVIMIENTOS EN EL KARDEX SE INGRESAN
                    //SE FINALIZA EL PROCESO CON UN MENSAJE DE EXITO
                    if ($compra->insertarMovimiento($items, $txt_fecha)) {
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
                            "msj" => "FALLO AL ALMACENAR EN KARDEX.",
                            "icono" => "error"
                        );
                    }
                } else {
                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "ERROR.",
                        "msj" => "FALLO AL ALMACENAR LOS DETALLES.",
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
            $compra = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modalProveedor': {
            $compra = new Compra();
            echo json_encode($compra->modalProveedor($pagina, $cantidad, $campo, $buscar));
            $compra = null;
            break;
        }
    case 'modalProductos': {
            $compra = new Compra();
            echo json_encode($compra->modalProductos($pagina, $cantidad, $campoP, $buscar));
            $compra = null;
            break;
        }
}
