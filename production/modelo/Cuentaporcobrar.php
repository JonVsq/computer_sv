<?php
require_once('core/Nucleo.php');

class Cuentaporcobrar
{
	private $nucleo;
	private $nombreTabla = "venta";

	public function __construct()
	{
		$this->nucleo = new Nucleo();
		$this->nucleo->setTablaBase($this->nombreTabla);
	}

	public function modificarCuenta($campos)
	{
		return $this->nucleo->modificarRegistro($campos);
	}


	public function mostrarCuentaHTML($codigoCliente)
	{

		$repuesta =  array();
		$datos = array();
		$datos[] = $this->obtenerCuenta($codigoCliente);


		$tabla = "";

		$fechaactual = date('Y-m-d');
		$fechaactual = date('Y-m-d', strtotime("-1 day", strtotime($fechaactual)));
		$fila = 0;
		foreach ($datos[0] as $calculo) {
			if ($fila == 0) {
				$respuesta['monto'] = number_format($calculo['saldo'], 2);
			}

			$respuesta['fechaventa'] = date("Y-m-d", strtotime($calculo['fecha_venta']));
			$respuesta['factura'] = $calculo['numero_factura'];
			$respuesta['cliente'] = $calculo['nombre'];
			$respuesta['plazo'] = $calculo['plazo'];
			$respuesta['codigo'] = $calculo['codigo'];
			//number_format($valorlibros,2)
			if ($calculo['cancelado'] == 1 || $calculo['cuota'] == 0) {

				$aux = number_format($calculo['cuota'], 2);
				$tabla = $tabla . "<tr bgcolor='#B9624F'>";
				$tabla = $tabla . "<td bgcolor='#B9624F' style='text-align: center;'>{$calculo['numero_cuota']}</td>";

				$tabla = $tabla . "<td  bgcolor='#B9624F' style='text-align: center;'> <strong>{$aux} </strong> </td>";
				$aux = number_format($calculo['mora'], 2);
				$tabla = $tabla . "<td  bgcolor='#B9624F' style='text-align: center;'> <strong>{$aux} </strong> </td>";
				$aux = number_format($calculo['cuota_cobrar'], 2);
				$tabla = $tabla . "<td  bgcolor='#B9624F' style='text-align: center;'>{$aux}</td>";
				$aux = number_format($calculo['saldo'], 2);
				$tabla = $tabla . "<td  bgcolor='#B9624F' style='text-align: center;'>{$aux}</td>";
				$tabla = $tabla . "<td  bgcolor='#B9624F' style='text-align: center;'>{$calculo['fecha_pago']}</td>";
				$tabla = $tabla . "</tr>\n";
			}

			if ($calculo['cancelado'] == 0  && $calculo['fecha_pago'] < $fechaactual && $calculo['cuota'] > 0) {
				$tabla = $tabla . "<tr bgcolor='#C48D45'>";
				$tabla = $tabla . "<td  bgcolor='#C48D45' style='text-align: center;'>{$calculo['numero_cuota']}</td>";
				$aux = number_format($calculo['cuota'], 2);
				$tabla = $tabla . "<td  bgcolor='#C48D45' style='text-align: center;'> <strong>{$aux} </strong> </td>";
				$aux = number_format($calculo['mora'], 2);
				$tabla = $tabla . "<td  bgcolor='#C48D45' style='text-align: center;'> <strong>{$aux} </strong> </td>";
				$aux = number_format($calculo['cuota_cobrar'], 2);
				$tabla = $tabla . "<td  bgcolor='#C48D45' style='text-align: center;'>{$aux}</td>";
				$aux = number_format($calculo['saldo'], 2);
				$tabla = $tabla . "<td  bgcolor='#C48D45' style='text-align: center;'>{$aux}</td>";
				$tabla = $tabla . "<td  bgcolor='#C48D45' style='text-align: center;'>{$calculo['fecha_pago']}</td>";
				$tabla = $tabla . "</tr>\n";
			} else if ($calculo['cancelado'] == 0  && $calculo['fecha_pago'] >= $fechaactual && $calculo['cuota'] > 0) {
				$tabla = $tabla . "<tr bgcolor='#7FF563'>";
				$tabla = $tabla . "<td  bgcolor='#7FF563' style='text-align: center;'> <strong>{$calculo['numero_cuota']} </strong> </td>";
				$aux = number_format($calculo['cuota'], 2);
				$tabla = $tabla . "<td  bgcolor='#7FF563' style='text-align: center;'>{$aux}</td>";
				$aux = number_format($calculo['mora'], 2);
				$tabla = $tabla . "<td  bgcolor='#7FF563' style='text-align: center;'> <strong>{$aux} </strong> </td>";
				$aux = number_format($calculo['cuota_cobrar'], 2);
				$tabla = $tabla . "<td  bgcolor='#7FF563' style='text-align: center;'>{$aux}</td>";
				$aux = number_format($calculo['saldo'], 2);
				$tabla = $tabla . "<td  bgcolor='#7FF563' style='text-align: center;'>{$aux}</td>";
				$tabla = $tabla . "<td  bgcolor='#7FF563' style='text-align: center;'>{$calculo['fecha_pago']}</td>";
				$tabla = $tabla . "</tr>\n";
			}
			$fila++;
		}
		/*$respuesta['id']= $datos['id'];
		$respuesta['tangente']= $datos['tangente'];
		$respuesta['codigo']= $datos['codigo'];
		$respuesta['etiqueta']= $datos['nombre'];
		$respuesta['monto']= $datos['monto'];
		$respuesta['vida']= $datos['vida'];
		$respuesta['estado']= $datos['estado'];
		$respuesta['fechaadquicicion']= $datos['fechaadquicicion'];
		$respuesta['tiempousados']= $datos['tiempousados'];
		$respuesta['montodepreciar']= $datos['montodepreciar'];*/
		$respuesta['tabla'] = $tabla;

		return $respuesta;
	}

	public function verificarMora($datos)
	{
		$fecha = date('Y-m-d');
		$fecha = date('Y-m-d', strtotime("-1 day", strtotime($fecha)));
		$cuotasretrasadas = 0;
		$CODIGO_CLIENTE = "";
		foreach ($datos[0] as $calculo) {
			$CODIGO_CLIENTE = $calculo['codigo'];
			if ($calculo['fecha_pago'] < $fecha && $calculo['cancelado'] == 0 && $calculo['mora'] == 0) {
				$cuotasretrasadas++;
				$this->calcularMora(
					$calculo['id'],
					$calculo['fecha_pago'],
					$fecha,
					$calculo['saldo'],
					$calculo['porcentaje'],
					$calculo['cuota_cobrar'],
					$calculo['plazo']
				);
			}
		}

		//RECLASIFICAR LA CATEGORIA DEL CLIENTE
		$categorias = array();
		$categorias[] = $this->categorias();
		$cliente =  array();
		$cliente[] = $this->clientes($CODIGO_CLIENTE);
		$result = false;
		$interval = 0;

		foreach ($categorias[0] as $categoria) {
			if ($cuotasretrasadas > $interval &&  $cuotasretrasadas <= $categoria['max_atraso'] && $cliente['id_categoria'] < $categoria['id']) {
				$id = $categoria['id'];
				$result = $this->modificarCategoria(array($id, $CODIGO_CLIENTE));
			}
			$interval = $categoria['max_atraso'];
		}

		return true;
	}

	public function modificarCategoria($campos)
	{
		$this->nucleo->setTablaBase("cliente");
		$this->nucleo->setQueryPersonalizado('id_categoria = ? WHERE codigo = ?;');

		return $this->nucleo->modificarRegistro($campos);
	}
	//RECUPERAR CATEGORIAS
	public function categorias()
	{
		$this->nucleo->setTablaBase("categoria_cliente");
		$this->nucleo->setQueryPersonalizado("SELECT
			cat.id, 
			cat.nombre, 
			cat.max_atraso
			FROM
			categoria_cliente as cat");
		return $this->nucleo->getDatos();
	}

	//RECUPERAR EL CLIENTE
	public function clientes($codigo)
	{

		$this->nucleo->setTablaBase("cliente");
		$this->nucleo->setQueryPersonalizado("SELECT
			cli.codigo,
			cli.id_categoria	
			FROM
			cliente as cli
			WHERE
			cli.codigo = '$codigo'");
		return $this->nucleo->getDatos();
	}

	public function calcularMora($id, $fechapago, $fechaactual, $saldo, $interesanual, $cuota, $plazo)
	{
		$mora = 0;
		$dias = 0;
		$fechapagoaux = $fechapago;
		while ($fechapagoaux <= $fechaactual) {
			$dias++;
			$fechapagoaux = date('Y-m-d', strtotime("1 day", strtotime($fechapagoaux)));
		}

		$dias_interes = 30 * $plazo;
		$interesanual = $interesanual / 100;

		$mora = ($saldo) * (($interesanual * 0.50) / $dias_interes) * ($dias);
		$cuota = $cuota + $mora;
		$resultado = $this->modificarDatos(array($mora, $cuota, $id));
		return $resultado;
	}

	public function modificarDatos($campos)
	{
		$this->nucleo->setTablaBase("pagos");
		$this->nucleo->setQueryPersonalizado('mora = ?, cuota_cobrar = ? WHERE id = ?;');
		$resultado = $this->nucleo->modificarRegistro($campos);
		$this->nucleo->setTablaBase($this->nombreTabla);
		return $resultado;
	}

	private function diasMes($fecha)
	{
		return date('t', strtotime($fecha));
	}

	public function obtenerCuota($codigo)
	{
		$this->nucleo->setQueryPersonalizado("SELECT 
			p.id, 
			p.id_credito, 
			p.numero_cuota, 
			p.fecha_pago, 
			p.dias, 
			p.abono_principal, 
			p.interes, 
			p.dias_atraso, 
			p.mora, 
			p.cuota, 
			p.abono_capital, 
			p.cuota_cobrar, 
			p.saldo, 
			p.cancelado, 
			cl.codigo,
			cl.nombre,
			v.fecha_venta,
			v.numero_factura,
			i.plazo,
			i.porcentaje
			FROM venta as v INNER JOIN detalle_venta as d
			ON v.id = d.id_venta INNER JOIN pagos as p
			INNER JOIN credito as c
			ON p.id_credito = c.id AND v.id = c.id_venta
			INNER JOIN interes as i
			ON c.id_interes = i.id
			INNER JOIN cliente as cl
			ON v.codigo_cliente = cl.codigo
			WHERE cl.codigo = '$codigo' AND c.cancelado = 0 AND p.cancelado = 0 AND p.cuota > 0
			LIMIT 1");
		return $this->nucleo->getDatos();
	}

	public function obtenerCuenta($codigo)
	{
		$this->nucleo->setQueryPersonalizado("SELECT 
			p.id, 
			p.id_credito, 
			p.numero_cuota, 
			p.fecha_pago, 
			p.dias, 
			p.abono_principal, 
			p.interes, 
			p.dias_atraso, 
			p.mora, 
			p.cuota, 
			p.abono_capital, 
			p.cuota_cobrar, 
			p.saldo, 
			p.cancelado, 
			cl.codigo,
			cl.nombre,
			v.fecha_venta,
			v.numero_factura,
			i.plazo,
			i.porcentaje
			FROM venta as v INNER JOIN detalle_venta as d
			ON v.id = d.id_venta INNER JOIN pagos as p
			INNER JOIN credito as c
			ON p.id_credito = c.id AND v.id = c.id_venta
			INNER JOIN interes as i
			ON c.id_interes = i.id
			INNER JOIN cliente as cl
			ON v.codigo_cliente = cl.codigo
			WHERE cl.codigo = '$codigo' AND c.cancelado = 0
			GROUP BY p.id");
		//$this->nucleo->setQueryPersonalizado("SELECT *
		//FROM departamento");
		return $this->nucleo->getDatos();
	}


	public function tablaCuotas($numPagina, $cantidad, $campo, $buscar, $codigo)
	{
		$this->nucleo->setNumPagina($numPagina);
		$this->nucleo->setPorPagina($cantidad);
		//SQL QUE CUENTA LOS REGISTROS EN LA TABLA
		$this->nucleo->setQueryTotalRegistroPag("SELECT 
			p.id, 
			p.id_credito, 
			p.numero_cuota, 
			p.fecha_pago, 
			p.dias, 
			p.abono_principal, 
			p.interes, 
			p.dias_atraso, 
			p.mora, 
			p.cuota, 
			p.abono_capital, 
			p.cuota_cobrar, 
			p.saldo, 
			p.cancelado, 
			cl.codigo
			FROM venta as v INNER JOIN detalle_venta as d
			ON v.id = d.id_venta INNER JOIN pagos as p
			INNER JOIN credito as c
			ON p.id_credito = c.id AND v.id = c.id_venta
			INNER JOIN cliente as cl
			ON v.codigo_cliente = cl.codigo
			WHERE cl.codigo = '$codigo' AND c.cancelado = 0");
		//SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
		$this->nucleo->setQueryExtractRegistroPag("SELECT 
			p.id, 
			p.id_credito, 
			p.numero_cuota, 
			p.fecha_pago, 
			p.dias, 
			p.abono_principal, 
			p.interes, 
			p.dias_atraso, 
			p.mora, 
			p.cuota, 
			p.abono_capital, 
			p.cuota_cobrar, 
			p.saldo, 
			p.cancelado, 
			cl.codigo
			FROM venta as v INNER JOIN detalle_venta as d
			ON v.id = d.id_venta INNER JOIN pagos as p
			INNER JOIN credito as c
			ON p.id_credito = c.id AND v.id = c.id_venta
			INNER JOIN cliente as cl
			ON v.codigo_cliente = cl.codigo
			WHERE cl.codigo = '$codigo' AND c.cancelado = 0");
		//RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
		return $this->nucleo->getDatosHtmlCuotas(
			array("numero_cuota", "cuota", "mora", "cuota_cobrar", "saldo", "fecha_pago"),
			array(),
			"id"

		);
	}


	public function pagar($campos, $id)
	{
		$this->nucleo->setTablaBase("pagos");
		//MODIFICAR Y QUE APARESCA COMO CANCELADO
		$this->nucleo->setQueryPersonalizado('cancelado = ? WHERE id = ?;');
		$resultado = $this->nucleo->modificarRegistro($campos);
		$this->nucleo->setTablaBase("ticket");
		$fecha = date("Y-m-d");
		//REGISTRAR TICKET
		$resultado2 = $this->nucleo->insertarRegistro(array($id, $fecha));
		$this->nucleo->setTablaBase($this->nombreTabla);
		return $resultado;
	}

	public function cancelarCredito($id_credito, $codigocliente)
	{
		$this->creditoFin(array(true, $id_credito));

		if (!empty($this->verificarActivacion($codigocliente)) || $this->verificarActivacion($codigocliente) == null) {
			$categorias = array();
			$categorias[] = $this->categorias();
			$id_categoria = 0;
			foreach ($categorias[0] as $categoria) {
				if ($categoria['nombre'] == "B") {
					$id_categoria = $categoria['id'];
				}
			}
			$this->modificarClienteActivo(array($id_categoria, $codigocliente));
		}
		return true;
	}


	public function modificarClienteActivo($campos)
	{
		$this->nucleo->setTablaBase("cliente");
		$this->nucleo->setQueryPersonalizado('id_categoria = ? WHERE codigo = ?;');
		$resultado = $this->nucleo->modificarRegistro($campos);
		$this->nucleo->setTablaBase($this->nombreTabla);
		return $resultado;
	}



	public function verificarActivacion($codigo)
	{
		$this->nucleo->setTablaBase("cliente");
		$this->nucleo->setQueryPersonalizado("SELECT * FROM cliente WHERE cliente.codigo='$codigo' AND cliente.id_categoria = (SELECT
			categoria_cliente.id
			FROM
			categoria_cliente
			ORDER BY categoria_cliente.id DESC 
			LIMIT 1)");
		return $this->nucleo->getDatos();
	}


	public function creditoFin($campos)
	{
		$this->nucleo->setTablaBase("credito");
		$this->nucleo->setQueryPersonalizado('cancelado = ? WHERE id = ?;');
		$resultado = $this->nucleo->modificarRegistro($campos);
		$this->nucleo->setTablaBase($this->nombreTabla);
		return $resultado;
	}
	public function isJuridico($codigoCliente)
	{
		//VERIFICA SI ES JURIDICO
		$this->nucleo->setQueryPersonalizado("SELECT
		COUNT(dj.codigo_cliente) as total
		FROM datos_juridica as dj
		WHERE dj.codigo_cliente = '$codigoCliente'");
		$juridico = $this->nucleo->getDatos();
		$juridico = $juridico[0]['total'];
		settype($juridico, 'int');
		return ($juridico > 0) ? true : false;
	}
	public function numeroFactura($id_credito)
	{
		$this->nucleo->setQueryPersonalizado("SELECT
		v.numero_factura
		from 
		venta as v INNER JOIN
		credito as c on c.id_venta = v.id
		WHERE c.id = $id_credito ");
		$factura = $this->nucleo->getDatos();
		return $factura[0]['numero_factura'];
	}
}
