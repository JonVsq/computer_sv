<?php
session_start();
include('../modelo/Kardex.php');
//VARIABLES DE SESION
$inventario = isset($_SESSION['inventario']) ?  $_SESSION['inventario'] : null;
$items = isset($_SESSION['items']) ?  $_SESSION['items'] : array();
//CAPTURA CAMPOS
$tipo = isset($_POST['tipo']) ?  $_POST['tipo'] : array();
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$cantidad = (isset($_POST['cantidad'])) ?  $_POST['cantidad'] : '';
$producto = (isset($_POST['producto'])) ?  $_POST['producto'] : '';

//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "tipo";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opcion) {
    case 'kardex': {
            $kardex = new Kardex();
            echo json_encode($kardex->kardex($pagina, $cantidad, $campo, $buscar, $id));
            $kardex = null;
            break;
        }
    case 'agregarItem': {
            $items = desactivar($id, $items);
            agregarItem($id, $producto, $inventario[$id], $cantidad, $items);
            echo json_encode(array("tabla" => tablaItems($_SESSION['items'], $tipo)));
            break;
        }
    case 'obtenerItemsFactura': {
            if (isset($_SESSION['items'])) {
                echo json_encode(array("tabla" => tablaItems($_SESSION['items'], $tipo)));
            } else {
                echo json_encode(array("tabla" => ""));
            }
            break;
        }
    case 'cancelar': {
            $_SESSION['inventario'] = null;
            $_SESSION['items'] = null;
            echo json_encode(array("tabla" => 0));
            break;
        }
    case 'stock': {
            if (is_null($inventario)) {
                $kardex = new Kardex();
                $_SESSION['inventario'][$id] = $kardex->obtenerStockProductos($id);
                echo json_encode(sumarStock($_SESSION['inventario'][$id]));
                $kardex = null;
                break;
            } else {
                if (!isset($_SESSION['inventario'][$id])) {
                    $kardex = new Kardex();
                    $_SESSION['inventario'][$id] = $kardex->obtenerStockProductos($id);
                    echo json_encode(sumarStock($_SESSION['inventario'][$id]));
                    $kardex = null;
                    break;
                } else {
                    echo json_encode(sumarStock($_SESSION['inventario'][$id]));
                    break;
                }
            }
        }
}

//METODOS PARA LA VENTA
//PONE 0 A LOS ITEMS ACTIVOS
function desactivar($id, $array)
{

    $tamanio = count($array);
    for ($i = 0; $i < $tamanio; $i++) {
        if ($array[$i]['id_producto'] == $id) {
            $array[$i]['activo'] = 0;
        }
    }
    return $array;
}
//SUMA EL STOCK Y LO DEVUELVE
function sumarStock($array)
{
    $stock = 0;
    foreach ($array as $valor) {
        $stock = $stock + $valor['saldo'];
    }
    return $stock;
}
//AGREGA UN ITEM A LA FACTURA
function agregarItem($id_producto, $producto, $array, $cantidad, $items)
{
    $i = 0;
    foreach ($array as $valor) {
        $saldo = $valor['saldo'];
        if ($cantidad == 0) {
            break;
        } else {
            if ($saldo > 0) {
                if ($cantidad < $saldo) {
                    $items[] = array(
                        "cantidad_movimiento" => $cantidad,
                        "precio_venta" => $valor['precio_venta_unitario'],
                        "saldo" => $saldo - $cantidad,
                        "id_producto" => $valor['id_producto'],
                        "id_movimiento" => $valor['id'],
                        "costo_unitario" => $valor['costo_unitario'],
                        "activo" => 1,
                        "producto" => $producto
                    );
                    $_SESSION['inventario'][$id_producto][$i]['saldo'] = $saldo - $cantidad;
                    $cantidad = 0;
                } else if ($cantidad > $saldo) {
                    $items[] = array(
                        "cantidad_movimiento" => $saldo,
                        "precio_venta" => $valor['precio_venta_unitario'],
                        "saldo" => 0,
                        "id_producto" => $valor['id_producto'],
                        "id_movimiento" => $valor['id'],
                        "costo_unitario" => $valor['costo_unitario'],
                        "activo" => 0,
                        "producto" => $producto
                    );
                    $cantidad = $cantidad - $saldo;
                    $_SESSION['inventario'][$id_producto][$i]['saldo'] =  0;
                } else if ($cantidad == $saldo) {
                    $items[] = array(
                        "cantidad_movimiento" => $cantidad,
                        "precio_venta" => $valor['precio_venta_unitario'],
                        "saldo" => 0,
                        "id_producto" => $valor['id_producto'],
                        "id_movimiento" => $valor['id'],
                        "costo_unitario" => $valor['costo_unitario'],
                        "activo" => 0,
                        "producto" => $producto
                    );
                    $_SESSION['inventario'][$id_producto][$i]['saldo'] =  0;
                    $cantidad = 0;
                }
            }
            $i++;
        }
    }
    $_SESSION['items'] = $items;
}
function tablaItems($array, $tipo)
{
    $totalIva = 0;
    $totalCesc = 0;
    $subTotal = 0;
    $tabla = '';

    foreach ($array as $valor) {
        $tabla = $tabla . '<tr>';
        $iva = round(($valor['cantidad_movimiento'] * $valor['precio_venta']) * 0.13, 2);
        $cesc = round(($valor['cantidad_movimiento'] * $valor['precio_venta']) * 0.05, 2);
        $subT = round(($valor['cantidad_movimiento'] * $valor['precio_venta']), 2);
        $subTotal = $subTotal + $subT;
        $tabla = $tabla . "<td class ='text-center'>{$valor['producto']}</td>";
        $tabla = $tabla . "<td class ='text-center'>{$valor['cantidad_movimiento']}</td>";
        $tabla = $tabla . "<td class ='text-center'>{$valor['precio_venta']}</td>";
        if ($tipo === "natural") {
            $totalIva = $totalIva + $iva;
            $totalCesc = $totalCesc + $cesc;
            $tabla = $tabla . "<td class ='text-center'>{$iva}</td>";
            $tabla = $tabla . "<td class ='text-center'>{$cesc}</td>";
            $tabla = $tabla . "<td class ='text-center'>" . round($subT, 2) . "</td>";
        } else {
            $tabla = $tabla . "<td class ='text-center'></td>";
            $tabla = $tabla . "<td class ='text-center'></td>";
            $tabla = $tabla . "<td class ='text-center'>{$subT}</td>";
        }
        $tabla = $tabla . '</tr>';
    }
    $tabla = $tabla . '<tr>';
    $tabla = $tabla . "<td class ='text-center'></td>";
    $tabla = $tabla . "<td class ='text-center'></td>";
    $tabla = $tabla . "<td class ='text-center text-success roboto-medium'>Sub-Totales $:</td>";
    $tabla = $tabla . "<td class ='text-center text-success roboto-medium'>{$totalIva}</td>";
    $tabla = $tabla . "<td class ='text-center text-success roboto-medium'>{$totalCesc}</td>";
    $tabla = $tabla . "<td class ='text-center text-success roboto-medium'>" . round($subTotal, 2) . "</td>";
    $tabla = $tabla . '</tr>';
    $tabla = $tabla . '<tr>';
    $tabla = $tabla . "<td class ='text-center'></td>";
    $tabla = $tabla . "<td class ='text-center'></td>";
    $tabla = $tabla . "<td class ='text-center text-success roboto-medium'></td>";
    $tabla = $tabla . "<td class ='text-center text-success roboto-medium'></td>";
    $tabla = $tabla . "<td class ='text-center text-danger roboto-medium'>TOTAL A PAGAR $: </td>";
    $tabla = $tabla . "<td id='totalPagar' class ='text-center text-danger roboto-medium'>" . round($subTotal + $totalIva + $totalCesc, 2) . "</td>";

    $tabla = $tabla . '</tr>';
    $_SESSION['total'] = $subTotal + $totalIva + $totalCesc;
    return $tabla;
}
