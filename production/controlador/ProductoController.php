<?php
include('../modelo/Producto.php');
//CAPTURA CAMPOS
$id = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_idCategoria =  (isset($_POST['txt_idCategoria'])) ? $_POST['txt_idCategoria'] : '';
$txt_idMarca =  (isset($_POST['txt_idMarca'])) ? $_POST['txt_idMarca'] : '';
$txt_producto =  (isset($_POST['txt_producto'])) ? strtoupper($_POST['txt_producto']) : '';
$txt_descripcion =  (isset($_POST['txt_descripcion'])) ? strtoupper($_POST['txt_descripcion']) : '';
$txt_ganancia =  (isset($_POST['txt_ganancia'])) ? $_POST['txt_ganancia'] : '';
$txt_modelo =  (isset($_POST['txt_modelo'])) ? strtoupper($_POST['txt_modelo']) : '';
$txt_usoDiario =  (isset($_POST['txt_usoDiario'])) ? $_POST['txt_usoDiario'] : '';
$txt_entrega =  (isset($_POST['txt_entrega'])) ? $_POST['txt_entrega'] : '';

//PARAMETROS PARA LISTAR DATOS
$campo = (isset($_POST['campo'])) ? $_POST['campo'] : '';
$campo = strcmp($campo, '') ? $campo : "producto";
//MODAL MARCA
$campoMarca = (isset($_POST['campoMarca'])) ? $_POST['campoMarca'] : '';
$campoMarca = strcmp($campoMarca, '') ? $campoMarca : "nombre_marca";
//MODAL CATEGORIA
$campoCategoria = (isset($_POST['campoCategoria'])) ? $_POST['campoCategoria'] : '';
$campoCategoria = strcmp($campoCategoria, '') ? $campoCategoria : "descripcion";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$buscar = (isset($_POST['buscar'])) ? $_POST['buscar'] : '';
$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'insertar': {
            $producto = new Producto();
            $respuesta = array();
            $existe = $producto->camposUnicos(
                array("producto" => $txt_producto, "descripcion" => $txt_descripcion),
                "id",
                ""
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                $stock_minimo = $producto->puntoReformulacion($txt_entrega, $txt_usoDiario);
                if ($producto->insertarProducto(
                    array(
                        $txt_idCategoria, $txt_idMarca,
                        $txt_producto, $txt_descripcion, $txt_ganancia, $txt_modelo,
                        $stock_minimo, $txt_usoDiario, $txt_entrega
                    )
                )) {
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
            $producto = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modificar': {
            $producto = new Producto();
            $respuesta = array();
            $existe = $producto->camposUnicosModificar(
                array("producto" => $txt_producto, "descripcion" => $txt_descripcion),
                "id",
                $id
            );
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                $stock_minimo = $producto->puntoReformulacion($txt_entrega, $txt_usoDiario);
                if ($producto->modificarProducto(
                    array(
                        $id,
                        $txt_idCategoria, $txt_idMarca,
                        $txt_producto, $txt_descripcion, $txt_ganancia, $txt_modelo,
                        $stock_minimo, $txt_usoDiario, $txt_entrega
                    )
                )) {
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
            $producto = null;
            echo json_encode($respuesta);
            break;
        }
    case 'modalMarca': {
            $producto = new Producto();
            echo json_encode($producto->modalMarca($pagina, $cantidad, $campoMarca, $buscar));
            $producto = null;
            break;
        }
    case 'modalCategoria': {
            $producto = new Producto();
            echo json_encode($producto->modalCategoria($pagina, $cantidad, $campoCategoria, $buscar));
            $producto = null;
            break;
        }
    case 'modal': {
            $producto = new Producto();
            echo json_encode($producto->obtenerDatosModal($id));
            $producto = null;
            break;
        }
    case 'obtener': {
            $producto = new Producto();
            echo json_encode($producto->obtenerProducto($id));
            $producto = null;
            break;
        }
    case 'listar': {
            $producto = new Producto();
            echo json_encode($producto->tablaProducto($pagina, $cantidad, $campo, $buscar));
            $producto = null;
            break;
        }
    case 'listarExistencia': {
            $producto = new Producto();
            echo json_encode($producto->tablaExistencias($pagina, $cantidad, $campo, $buscar));
            $producto = null;
            break;
        }
    case 'verificarInformacion': {
            $producto = new Producto();
            $respuesta = array();
            $respuesta['pedido_necesario'] = $producto->verificarExistencias();
            $producto = null;
            echo json_encode($respuesta);
            break;
        }
}
