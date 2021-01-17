<?php
require_once('core/Nucleo.php');
class VentaCredito
{

    private $nucleo;
    private $tblVenta = "venta";
    private $tblCredito = "credito";
    private $tblPagos = "pagos";
    private $tblDetalleVenta = "detalle_venta";
    private $tblCliente = "cliente";
    private $tblEmpleado = "empleado";
    private $tblMovimientos = "movimientos";

    public function __construct()
    {
        $this->nucleo = new Nucleo();
        $this->nucleo->setTablaBase($this->tblVenta);
    }
    public function insertaVentas($campos)
    {
        $this->nucleo->setRegresarId(true);
        return $this->nucleo->insertarRegistro($campos);
    }

    public function modificarVentas($campos)
    {
        return $this->nucleo->modificarRegistro($campos);
    }
    public function camposUnicos($campos, $identificador, $valor)
    {
        return $this->nucleo->coincidencias($campos, $identificador, $valor);
    }
    public function desactivarMovimientos($array)
    {
        $this->nucleo->setTablaBase($this->tblMovimientos);
        $tamanio = count($array);
        for ($i = 0; $i < $tamanio; $i++) {
            $this->nucleo->setQueryPersonalizado("activo = ? where id = ?");
            if (!$this->nucleo->modificarRegistro(array(0, $array[$i]['id_movimiento']))) {
                $this->nucleo->setTablaBase($this->tblVenta);
                return false;
            }
        }
        return true;
    }
    public function crearMovimientos($array, $fecha)
    {
        $this->nucleo->setTablaBase($this->tblMovimientos);
        $tamanio = count($array);
        for ($i = 0; $i < $tamanio; $i++) {
            if (!$this->nucleo->insertarRegistro(array(
                $array[$i]['id_producto'],
                "VENTA",
                $fecha,
                $array[$i]['cantidad_movimiento'],
                $array[$i]['costo_unitario'],
                $array[$i]['saldo'],
                $array[$i]['saldo'] == 0 ? 0 : $array[$i]['costo_unitario'],
                $array[$i]['precio_venta'],
                $array[$i]['activo']
            ))) {
                $this->nucleo->setTablaBase($this->tblVenta);
                return false;
            }
        }
        return true;
    }
    public function crearDetalleVenta($id_venta, $array)
    {
        $this->nucleo->setTablaBase($this->tblDetalleVenta);
        $tamanio = count($array);
        for ($i = 0; $i < $tamanio; $i++) {
            if (!$this->nucleo->insertarRegistro(array(
                $id_venta,
                $array[$i]['id_producto'],
                $array[$i]['cantidad_movimiento'],
                $array[$i]['costo_unitario'],
                $array[$i]['precio_venta'],
                0
            ))) {
                $this->nucleo->setTablaBase($this->tblVenta);
                return false;
            }
        }
        return true;
    }
    public function plazosModal($numPagina, $cantidad, $campo, $buscar)
    {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT
        COUNT(id) as total
        FROM
        interes
        WHERE ($campo LIKE '%$buscar%')");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT
        *
        FROM
        interes 
        WHERE ($campo LIKE '%$buscar%')");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
            array("plazo", "porcentaje"),
            array("seleccion" => "user-plus"),
            "id"
        );
    }

    function insertarCredito($campos)
    {
        $this->nucleo->setTablaBase($this->tblCredito);
        $this->nucleo->setRegresarId(true);
        $id = $this->nucleo->insertarRegistro($campos);
        $this->nucleo->setTablaBase($this->tblVenta);
        return $id;
    }
    public function insertarPrimerPago($idCredito, $idPlazo, $monto)
    {
        $interes = $this->obtenerDatosPlazo($idPlazo);
        $datosPago = $this->simulador($interes[0]['porcentaje'], $interes[0]['plazo'], $monto);
        if (!empty($interes)) {
            $this->nucleo->setTablaBase($this->tblPagos);
            for ($i = 0; $i < 2; $i++) {
                if (!$this->nucleo->insertarRegistro(array(
                    $idCredito,
                    $datosPago[$i]['numcuota'],
                    $datosPago[$i]['fecha'],
                    $datosPago[$i]['dias'],
                    $datosPago[$i]['principal'],
                    $datosPago[$i]['interes'],
                    $datosPago[$i]['dias_atraso'],
                    $datosPago[$i]['mora'],
                    $datosPago[$i]['couta'],
                    $datosPago[$i]['abonocap'],
                    $datosPago[$i]['coutaCobrar'],
                    $datosPago[$i]['saldo'],
                    0
                ))) {
                    $this->nucleo->setTablaBase($this->tblVenta);
                    return false;
                }
            }
            $this->nucleo->setTablaBase($this->tblVenta);
            return true;
        } else {
            return false;
        }
    }
    private function obtenerDatosPlazo($id)
    {
        $this->nucleo->setQueryPersonalizado("SELECT * FROM interes WHERE id = $id");
        return $this->nucleo->getDatos();
    }
    private function simulador($interes, $plazo, $monto)
    {

        $fecha = date("Y-m-d");
        $couta = $this->coutaMensual($monto, $plazo);
        $amortizacion = array();
        $dias = $this->diasMes($fecha);
        $amortizacion[] = array(
            "numcuota" => 0,
            "fecha" => $fecha,
            "dias" => $dias,
            "principal" => 0,
            "interes" => 0,
            "dias_atraso" => 0,
            "mora" => 0,
            "couta" => 0,
            "abonocap" => 0,
            "coutaCobrar" => 0,
            "saldo" => $monto
        );
        $montoAux = $monto;
        $interesMes = round((($interes / 100) * $monto) / $plazo, 2);
        for ($i = 1; $i <= $plazo; $i++) {
            $fecha = $this->proximaCuota($fecha, $dias);
            $dias = $this->diasMes($fecha);
            if ($i == $plazo) {
                if ($montoAux < $couta) {
                    $couta = $couta - round(($montoAux - $couta) * -1, 2);
                } else {
                    $couta = round($couta + (round($montoAux - ($couta), 2)), 2);
                }
            }
            $montoAux = round($montoAux - ($couta), 2);
            $amortizacion[] = array(
                "numcuota" => $i,
                "fecha" => $fecha,
                "dias" => $dias,
                "principal" => round(($couta + $interesMes) - $interesMes, 2),
                "interes" => $interesMes,
                "dias_atraso" => 0,
                "mora" => 0,
                "couta" => $couta,
                "abonocap" => 0,
                "coutaCobrar" => round($couta + $interesMes, 2),
                "saldo" => $montoAux == "-0" ? 0 : $montoAux
            );
        }
        return $amortizacion;
    }
    private function coutaMensual($monto, $plazo)
    {
        return round($monto / $plazo, 2);
    }


    private function proximaCuota($fecha, $dias)
    {
        return date("Y-m-d", strtotime("$dias days", strtotime($fecha)));
    }
    private function diasMes($fecha)
    {
        return date('t', strtotime($fecha));
    }
}
