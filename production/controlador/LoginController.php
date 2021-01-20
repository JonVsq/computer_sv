<?php
session_start();
include_once('../modelo/core/Conexion.php');
//CAPTURA LOS PARAMETROS
$correo = (isset($_POST['txt_correo'])) ? $_POST['txt_correo'] : '';
$pass = (isset($_POST['txt_pass'])) ? $_POST['txt_pass'] : '';
//OPCION A EJECUTAR
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 'entrar': {
            $respuesta = array();
            if (!empty($correo) && !empty($pass)) {
                $objeto = new Conexion();
                $conn = $objeto->conectar();
                $records = $conn->prepare('SELECT * FROM usuarios WHERE correo = :correo');
                $records->bindParam(':correo', $correo);
                $records->execute();
                $results = $records->fetch(PDO::FETCH_ASSOC);
                if ($results && $pass == $results['pass']) {
                    $_SESSION['usuario'] = $results;
                    $respuesta[] = array(
                        "estado" => 1,
                        "mensaje" => "Acceso correcto",
                        "primera" => $results['acceso']

                    );
                    $records = $conn->prepare('SELECT e.id, e.nombres from
                    empleado as e where e.id =  :id');
                    $records->bindValue(':id', $_SESSION['usuario']['id_empleado']);
                    $records->execute();
                    $results = $records->fetch(PDO::FETCH_ASSOC);
                    if ($results) {
                        $_SESSION['id'] = $results['id'];
                        $_SESSION['nombre'] = $results['nombres'];
                    }
                } else {
                    $respuesta[] = array(
                        "estado" => 0,
                        "mensaje" => "Credenciales incorrectas",
                        "primera" => 0
                    );
                }
            }
            $conn = null;
            echo  json_encode($respuesta);
            break;
        }
}
