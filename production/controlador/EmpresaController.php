<?php
include('../modelo/Empresa.php');
$id = (isset($_POST['txt_id'])) ? $_POST['txt_id'] : '';
$txt_nombre = (isset($_POST['txt_nombre'])) ? strtoupper($_POST['txt_nombre']) : '';
$txt_correo = (isset($_POST['txt_correo'])) ? $_POST['txt_correo'] : '';
$txt_telefono = (isset($_POST['txt_telefono'])) ? $_POST['txt_telefono'] : '';
$txt_direccion = (isset($_POST['txt_direccion'])) ? strtoupper($_POST['txt_direccion']) : '';
$txt_cod = (isset($_POST['txt_cod'])) ? strtoupper($_POST['txt_cod']) : '';
$txt_ciu = (isset($_POST['txt_ciu'])) ? strtoupper($_POST['txt_ciu']) : '';
$txt_pais = (isset($_POST['txt_pais'])) ? strtoupper($_POST['txt_pais']) : '';
$txt_fax = (isset($_POST['txt_fax'])) ? strtoupper($_POST['txt_fax']) : '';
$txt_web = (isset($_POST['txt_web'])) ? strtoupper($_POST['txt_web']) : '';
$txt_nit = (isset($_POST['txt_nit'])) ? strtoupper($_POST['txt_nit']) : '';
//OPCION A EJECUTAR
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    
    case 'modificar': {
            $empresa = new Empresa();
            $respuesta = array();

            if ($empresa->modificar((array($id,$txt_cod,
            $txt_nombre,$txt_nit, $txt_pais,
            $txt_ciu, $txt_telefono,$txt_correo,$txt_fax,
            $txt_web, $txt_direccion)))) {
                $respuesta[] = array(
                    "estado" => 1,
                    "encabezado" => "EXITO.",
                    "msj" => "DATOS MODIFICADOS.",
                    "icono" => "success"
                );
            } else {
                $respuesta[] = array(
                    "estado" => 0,
                    "encabezado" => "ERROR.",
                    "msj" => "DATOS NO MODIFICADOS.",
                    "icono" => "error"
                );
            }
            $empresa = null;
            echo json_encode($respuesta);
            break;
        }
    case 'obtener': {
            $empresa = new Empresa();
            echo json_encode($empresa->obtener());
            break;
        }
}
