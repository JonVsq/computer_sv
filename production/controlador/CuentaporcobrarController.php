<?php
session_start();
include('../modelo/Cuentaporcobrar.php');
//CAPTURA CAMPOS
//$codigoCliente = (isset($_POST['id'])) ?  $_POST['id'] : '';
$txt_codigo =  (isset($_POST['codigo'])) ? strtoupper($_POST['codigo']) : '';
$id_pago = (isset($_POST['id'])) ? strtoupper($_POST['id']) : '';
$id_credito = (isset($_POST['id_credito'])) ? strtoupper($_POST['id_credito']) : '';
//OPCION A EJECUTAR
$opcion  = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {

    case 'modificar': {
            /*$departamento = new Departamento();
                $respuesta = array();
            /*$existe = $departamento->camposUnicosModificar(array("nombre" => $txt_nombre), "id", $idDepartamento);
            if ($existe['existe'] == 1) {
                $respuesta[] = array(
                    "estado" => 0,
                    "errores" => $existe
                );
            } else {
                $alta=true;
                if($departamento->obtenerEmpresa()){
                    $id_empresa = $departamento->obtenerEmpresa()[0]['id'];
                    if ($departamento->modificarDepartamento(array($idDepartamento,$id_empresa, $txt_codigo, $txt_nombre, $txt_ubicacion,$alta))) {
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
            //}
                $departamento = null;
                echo  json_encode($respuesta);
                break;*/
        }
    case 'obtener': {
            $cuenta = new Cuentaporcobrar();
            if (empty($cuenta->obtenerCuenta($txt_codigo))) {
                $respuesta = null;

                echo json_encode($respuesta);
            } else {
                $respuesta[] = array(
                    "estado" => 2,
                    "encabezado" => "ERROR.",
                    "msj" => "DATOS NO MODIFICADOS.",
                    "icono" => "error"
                );
                $datos[] = $cuenta->obtenerCuenta($txt_codigo);
                $cuenta->verificarMora($datos);
                echo json_encode($cuenta->mostrarCuentaHTML($txt_codigo));
                //echo json_encode($cuenta->tablaCuotas(1, 5, "","", $txt_codigo));

            }
            //echo json_encode($cuenta->tablaCuotas($txt_codigo));
            $cuenta = null;
            break;
        }

    case 'obtenerCuota': {
            $cuenta = new Cuentaporcobrar();
            if (empty($cuenta->obtenerCuota($txt_codigo))) {
                $respuesta[] = array(
                    "estado" => 1,
                    "encabezado" => "ERROR.",
                    "msj" => "DATOS ESTA VACIO LA FUNCION.",
                    "icono" => "error"
                );
                echo json_encode($respuesta);
            } else {
                $respuesta[] = array(
                    "estado" => 2,
                    "encabezado" => "ERROR.",
                    "msj" => "DATOS NO MODIFICADOS.",
                    "icono" => "error"
                );
                //$datos[] = $cuenta->obtenerCuenta($txt_codigo);
                //$cuenta->verificarMora($datos);
                //echo json_encode($cuenta->mostrarCuentaHTML($txt_codigo));
                //echo json_encode($cuenta->tablaCuotas(1, 5, "","", $txt_codigo));
                echo json_encode($cuenta->obtenerCuota($txt_codigo));
            }
            //echo json_encode($cuenta->tablaCuotas($txt_codigo));
            $cuenta = null;
            break;
        }


    case 'pagar': {
            $cuenta = new Cuentaporcobrar();
            $respuesta = array();
            if (!$cuenta->pagar(array(true, $id_pago), $id_pago)) {
                $respuesta[] = array(
                    "estado" => 1,
                    "encabezado" => "ERROR.",
                    "msj" => "NO CANCELADA.",
                    "icono" => "error"
                );
                // echo json_encode($respuesta);
            } else {

                if (empty($cuenta->obtenerCuota($txt_codigo)) || $cuenta->obtenerCuota($txt_codigo) == null) {

                    if ($cuenta->cancelarCredito($id_credito, $txt_codigo)) {
                        $esJuridico = $cuenta->isJuridico($txt_codigo);
                        $_SESSION['factura'] = $cuenta->numeroFactura($id_credito);
                        $tipo = $esJuridico ? "JURIDICO" : "NATURAL";
                        $respuesta[] = array(
                            "estado" => 3,
                            "encabezado" => "EXITO.",
                            "msj" => "EL CREDITO A SIDO CANCELADO",
                            "icono" => "success",
                            "tipo" => $tipo
                        );
                    }
                } else {

                    $respuesta[] = array(
                        "estado" => 2,
                        "encabezado" => "EXITO.",
                        "msj" => "CUOTA CANCELADA",
                        "icono" => "success"
                    );
                }
            }
            echo json_encode($respuesta);
            $cuenta = null;
            break;
        }
}
