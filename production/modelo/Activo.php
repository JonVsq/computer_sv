<?php
require_once('core/Nucleo.php');

class Activo
{
	private $nucleo;
	private $nombreTabla = "activo";

	public function __construct()
	{
		$this->nucleo = new Nucleo();
		$this->nucleo->setTablaBase($this->nombreTabla);
	}
	public function insertarActivo($campos)
	{
		return $this->nucleo->insertarRegistro($campos);
	}
	public function modificarActivo($campos)
	{
		return $this->nucleo->modificarRegistro($campos);
	}
	public function camposUnicos($campos, $identificador, $valor)
	{
		return $this->nucleo->coincidencias($campos, $identificador, $valor);
	}
	public function camposUnicosModificar($campos, $identificador, $valor)
	{
		$this->nucleo->setConsultarModificar(true);
		return $this->nucleo->coincidencias($campos, $identificador, $valor);
	}

  public function insertarVentaActivo($campos)
  {
    $this->nucleo->setTablaBase("venta_activo");
    $insertado = $this->nucleo->insertarRegistro($campos);
    $this->nucleo->setTablaBase($this->nombreTabla);
    return $insertado;
  }



  public function generarDepreciacionHTML($id){

    $repuesta =  array();
    $datos = $this->depreciacion($id);


    $tabla = "";
    $fila1 = 0;
    $fechaactual = date("Y-m-d");
    $year = date("Y", strtotime($fechaactual));


    foreach ($datos['depreciacion'] as $calculo) {

     if($fila1 == 0){

      $tabla = $tabla . "<tr bgcolor='#28DE8C'>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['tiempo']}</td>";

      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'> <strong>{$calculo['depreanual']} </strong> </td>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['depreacumulada']}</td>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['valorenlibros']}</td>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['fecha']}</td>";
      $tabla = $tabla . "</tr>\n";
    }
            //$fila1++:

    if(date("Y", strtotime($calculo['fecha'])) < $year && $fila1 > 0 ){

      $tabla = $tabla . "<tr bgcolor='#28DE8C'>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['tiempo']}</td>";

      $tabla = $tabla . "<td bgcolor='#28DE8C'  style='text-align: center;'> <strong>{$calculo['depreanual']} </strong> </td>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['depreacumulada']}</td>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['valorenlibros']}</td>";
      $tabla = $tabla . "<td  bgcolor='#28DE8C' style='text-align: center;'>{$calculo['fecha']}</td>";
      $tabla = $tabla . "</tr>\n";
    }else if(date("Y", strtotime($calculo['fecha'])) >= $year && $fila1 > 0){

      $tabla = $tabla . "<tr bgcolor='#F0A87C'>";
      $tabla = $tabla . "<td  bgcolor='#F0A87C' style='text-align: center;'>{$calculo['tiempo']}</td>";

      $tabla = $tabla . "<td  bgcolor='#F0A87C' style='text-align: center;'> <strong>{$calculo['depreanual']} </strong> </td>";
      $tabla = $tabla . "<td  bgcolor='#F0A87C' style='text-align: center;'>{$calculo['depreacumulada']}</td>";
      $tabla = $tabla . "<td   bgcolor='#F0A87C'style='text-align: center;'>{$calculo['valorenlibros']}</td>";
      $tabla = $tabla . "<td  bgcolor='#F0A87C' style='text-align: center;'>{$calculo['fecha']}</td>";
      $tabla = $tabla . "</tr>\n";

    }

    $fila1++;

  }
  $respuesta['id']= $datos['id'];
  $respuesta['tangente']= $datos['tangente'];
  $respuesta['codigo']= $datos['codigo'];
  $respuesta['etiqueta']= $datos['nombre'];
  $respuesta['monto']= $datos['monto'];
  $respuesta['vida']= $datos['vida'];
  $respuesta['estado']= $datos['estado'];
  $respuesta['fechaadquicicion']= $datos['fechaadquicicion'];
  $respuesta['tiempousados']= $datos['tiempousados'];
  $respuesta['montodepreciar']= $datos['montodepreciar'];
  $respuesta['tabla'] = $tabla;

  return $respuesta;
}

public function depreciacion($id){
             //VARIABLES PARA GUARDAR LOS DATOS DE LA DEPRECIACION
 $montoanual = 0;
 $suma = 0;
 $depreacumulada = 0;
 $valorlibros = 0;
 $depreciacion[] = null;
 $monto = 0;
             $activo =  $this->obtenerActivo($id); //RECUPERAR EL ACTIVO

             if($activo != null){
              $porcentaje = $activo[0]['porcentaje'] / 100;
              $valorlibros = $activo[0]['monto'] * $porcentaje;
             $monto = $activo[0]['monto'] * $porcentaje; //MONTO A DEPRECIAR
             $depreciacion[] = array(  
              "tiempo" => 0,
              "depreanual" => 0,
              "depreacumulada" => 0,
              "valorenlibros" => $valorlibros,
              "fecha" => "");

             $tipoactivo = null;
             if($activo != null){
               $tipoactivo = $this->obtenerTipoactivo($activo[0]['id_tipoactivo']);
                if($tipoactivo != null){ //INICIO DE IF
                  $datos['id'] = $activo[0]['id'];
                  $datos['monto'] = $activo[0]['monto'];
                  $datos['montodepreciar'] = $monto;
                  $datos['vida'] = $tipoactivo[0]['tiempo'];
                  $datos['estado'] = $activo[0]['estado'];
                  $datos['codigo'] = $activo[0]['codigo'];
                  $datos['nombre'] = $activo[0]['descripcion'];
                  $datos['tiempousados'] = $activo[0]['tiempo_usado'];
                  $datos['fechaadquicicion'] = $activo[0]['fecha'];
                  $datos['tangente'] = $activo[0]['tanintan'];


                      //$dias = $this->diasTotalesDepreciacion($activo[0]['fecha'], $tipoactivo[0]['tiempo']);
                  $pormeses = $tipoactivo[0]['tiempo'] * 12;                     
                  $montomensual = $monto / $pormeses ;
                  $montoanual = $montomensual * 12;

                  $fechaMes = $activo[0]['fecha'];
                  $num = 0;                     
                  for($i = 0 ; $i < $pormeses ; $i++){
                    $suma = $suma + $montomensual ;

                    if(date("m", strtotime($fechaMes)) == 12  || ($pormeses - $i == 1)){

                      $fechadecierre = $fechaMes;
                      $mesfechacierre = date("m", strtotime($fechadecierre));

                      if($mesfechacierre < 12){
                        $fechadecierre = date('Y-m-d', strtotime((12 - $mesfechacierre)." month", strtotime($fechadecierre)));
                      }
                      $diafechacierre = date("d", strtotime($fechadecierre));
                      if($diafechacierre < 31){
                        $fechadecierre = date('Y-m-d', strtotime((31 - $diafechacierre)." day", strtotime($fechadecierre)));
                      }


                      $num++;
                      $depreacumulada += $suma;
                      $valorlibros = $valorlibros-$suma;
                               // $valorlibros = number_format($valorlibros,2);
                      $depreciacion[] = array(         
                        "tiempo" => $num,
                        "depreanual" => $montoanual,
                        "depreacumulada" => number_format($depreacumulada,2),
                        "valorenlibros" => number_format($valorlibros,2),
                        "fecha" => $fechadecierre);

                      $suma = 0;
                    }                        
                    $fechaMes = $this->Mes($fechaMes, 1);                 
                  }

                }//FIN DE IF
              }
            }

            $datos['depreciacion']  = $depreciacion;

            return $datos;
          }


          public function depreciacionDiaria($id){
            $activo =  $this->obtenerActivo($id);
            $diasadepreciar = 0;
            $respuesta = array();
            $respuesta['kevin'] = "kelvin";
            $diasactuales = 0;
            if($activo != null){
              $tipoactivo = null;
              $tipoactivo = $this->obtenerTipoactivo($activo[0]['id_tipoactivo']);
              if($tipoactivo != null){
               $datos = $this->diasTotalesDepreciacion($activo[0]['fecha'], $tipoactivo[0]['tiempo']);

               $montodepreciar = $activo[0]['monto'] * ($activo[0]['porcentaje'] /100);
               $montodiario = $montodepreciar / $datos['diasdepreciar'];
               $respuesta['fechainiciodia'] = $activo[0]['fecha'];
               $respuesta['montototal'] = $activo[0]['monto'];
               $respuesta['montodepreciar'] = $montodepreciar ;
               $respuesta['tangente'] = $activo[0]['tanintan'];
               $respuesta['montodiario'] = number_format($montodiario,2);; 


               $fechabase = $activo[0]['fecha'];
               $fechabasedos = $activo[0]['fecha'];
               $fechabasetres = $activo[0]['fecha'];



               $fechabasedos = date('Y-m-d', strtotime($datos['diasdepreciar']." day", strtotime($fechabasedos)));
               $respuesta['fechafinal'] = $fechabasedos;
               $respuesta['montofinal'] = number_format($datos['diasdepreciar'] * $montodiario,2);
               $fechabasedosmes = date("m", strtotime($fechabasedos));
               $fechabasedosdia = date("d", strtotime($fechabasedos));
               $fechabasedosyear = date("Y", strtotime($fechabasedos));
               $montodiario = number_format($montodiario,2);

               if($datos['diasanteriores'] > 0){


                $fechabase = date('Y-m-d', strtotime($datos['diasanteriores']." day", strtotime($fechabase)));
                $respuesta['fechacierre'] = $fechabase;
                
                $respuesta['montofechacierre']  = number_format($datos['diasanteriores'] * $montodiario,2);


              }else {
                $respuesta['fechacierre'] = "";
                $respuesta['montofechacierre'] = 0;


              }

              $fechahoy = date("Y-m-d");
              $meshoy = date("m", strtotime($fechahoy));
              $diahoy = date("d", strtotime($fechahoy));
              $yearhoy = date("Y", strtotime($fechahoy));

            //$fechabasetres = date('Y-m-d', strtotime("1 day", strtotime($fechabasetres)));
              $diabase = date("d", strtotime($fechabasetres));
              $mesbase = date("m", strtotime($fechabasetres));
              $yearbase = date("Y", strtotime($fechabasetres));

              while($diabase != $diahoy || $mesbase != $meshoy ||  $yearhoy!= $yearbase ){
                $diasactuales++;
                $fechabasetres = date('Y-m-d', strtotime("1 day", strtotime($fechabasetres)));
                $diabase = date("d", strtotime($fechabasetres));
                $mesbase = date("m", strtotime($fechabasetres));
                $yearbase = date("Y", strtotime($fechabasetres));

              }
              if($diasactuales > $datos['diasdepreciar']){
               $diasactuales = $datos['diasdepreciar'];
             }
             $diasactuales = $diasactuales - $datos['diasanteriores'];
             $respuesta['diasactual'] = $diasactuales;
             $respuesta['montoactual'] = number_format($diasactuales * $montodiario,2); 
             $respuesta['fechahoy'] = date("Y-m-d");

           }

         }
         
         if($respuesta['fechafinal'] < date("Y-m-d")){
          $respuesta['montoactual'] = 0;
         }
         
         return $respuesta;

       }


       public function depreciacionMensual($id){
        $activo =  $this->obtenerActivo($id);
        $diasadepreciar = 0;
        $respuesta = array();
        $respuesta['kevin'] = "kelvin";
        $respuesta['montoactualmes'] = "";
        $respuesta['fechaactualmes'] = "";
        $diasactuales = 0;
        if($activo != null){
          $tipoactivo = null;
          $tipoactivo = $this->obtenerTipoactivo($activo[0]['id_tipoactivo']);
          if($tipoactivo != null){
           $respuesta['tangente'] = $activo[0]['tanintan'];
           $meses = $tipoactivo[0]['tiempo'] * 12;

           $montodepreciar = $activo[0]['monto'] * ($activo[0]['porcentaje'] /100);
           $montomensual = $montodepreciar / $meses;
           $fechabase = $activo[0]['fecha'];
           $diainicio = date("d", strtotime($fechabase));
           $diasmes = $this->diasMes($fechabase);
           $diasrestantes = $diasmes - $diainicio;
           $fechamensual = date('Y-m-d', strtotime($diasrestantes." day", strtotime($fechabase)));

           $fechaultima = date('Y-m-d', strtotime($meses." month", strtotime($fechamensual)));
           $respuesta['primermes'] = $fechamensual;
           $respuesta['montodepreciar'] = $montodepreciar;
           $respuesta['montomensual'] = number_format($montomensual,2);
           $fechahoy = date("Y-m-d");
           $yearhoy = date("Y", strtotime($fechahoy));
           $meshoy = date("m", strtotime($fechahoy));
           $diahoy = date("d", strtotime($fechahoy));
           $respuesta['fechaultima'] = $fechaultima;
           $respuesta['montoultimo'] = number_format( $meses*$montomensual,2);
           

           if(date("Y", strtotime($fechabase)) < $yearhoy && $fechahoy < $fechaultima)
           {

            $fechacierre = date('Y-m-d', strtotime("-".$meshoy." month", strtotime($fechahoy)));
            $nuevodia = 31 - $diahoy;
            $fechacierre = date('Y-m-d', strtotime($nuevodia." day", strtotime($fechacierre)));
            $totalmeses = 1;
            while ($fechamensual < $fechacierre ) {
              $totalmeses++;
              $fechamensual = date('Y-m-d', strtotime("1 month", strtotime($fechamensual)));
            }
            $respuesta['montocierremensual'] = number_format($totalmeses * $montomensual,2);
            $respuesta['fechacierre'] = $fechacierre;
          }else {
            $respuesta['montocierremensual'] = 0;
            $respuesta['fechacierre'] = "";
          }


          if($respuesta['montocierremensual'] > 0 && $fechahoy < $fechaultima){
            $fechacierreaux = $respuesta['fechacierre'];
            $fechacierreaux = date('Y-m-d', strtotime("1 month", strtotime($fechacierreaux)));
            $mesactual = 0;
            while($fechacierreaux < $fechahoy){
              $mesactual++;
              $fechacierreaux = date('Y-m-d', strtotime("1 month", strtotime($fechacierreaux)));
            }
            $respuesta['montoactualmes'] = $mesactual * $montomensual ;
            $respuesta['fechaactualmes'] = date('Y-m-d', strtotime("-1 month", strtotime($fechacierreaux)));

          }else if($fechahoy < $fechaultima){
            $fechamensualaux = $fechamensual;
            $mesactual = 0;
            while($fechamensualaux < $fechahoy){
              $mesactual++;
              $fechamensualaux = date('Y-m-d', strtotime("1 month", strtotime($fechamensualaux)));
            }

            if($mesactual > 0){
              $respuesta['montoactualmes'] = $mesactual * $montomensual ;
              $respuesta['fechaactualmes'] = date('Y-m-d', strtotime("-1 month", strtotime($fechacierreaux)));
            }else{
             $respuesta['fechaactualmes'] = $fechamensual;
             $respuesta['montoactualmes'] = 0;
           }

         }





       }

     }

     return $respuesta;

   }


   private function diasMes($fecha)
   {
    return date('t', strtotime($fecha));
  }

  private function Mes($fecha, $mes)
  {
    return date('Y-m-d', strtotime("$mes month", strtotime($fecha)));
  }

  private function diasTotalesDepreciacion($fechabase, $tiempo){

           // $fechaentero = strtotime($fechabase);
    $mesbase = date("m", strtotime($fechabase));
    $diabase = date("d", strtotime($fechabase));
    $yearbase = date("Y", strtotime($fechabase));
    $meses = $tiempo * 12;
    $diasdepreciar = 0;
    $diasdepreciar = $this->diasMes($fechabase);
    $diasdepreciar = $diasdepreciar - $diabase;
    $diasyearanteriores = 0;

    $fechaactual = date("Y-m-d");
    $yearactual = date("Y", strtotime($fechaactual));
    $mesactual = date('n', strtotime($fechaactual));

    $diasactuales = 0;


    $nuevafecha = null;
    $nuevomes = 0;
    $nuevoY = 0;
    if($yearbase < $yearactual){
                    //$mesactual = $mesactual;
      $nuevafecha = date('Y-m-d', strtotime("-".$mesactual." month", strtotime($fechaactual)));
                    //$nuevafecha2 = date('Y-m-d', strtotime("$-2 day", strtotime($nuevafecha)));
      $nuevomes = date("m", strtotime($nuevafecha));
      $nuevoY = date("Y", strtotime($nuevafecha));

                   //$diasyearanteriores = $nuevomes;
    }

    $mismoyear = false;
    if($yearactual == date("Y", strtotime($fechabase)) ){
      $mismoyear = true;
    }

    for( $i = 0 ; $i < $meses ; $i++){


     if($nuevafecha != null){
       $mesaux = date("m", strtotime($fechabase));
       $Yearaux = date("Y", strtotime($fechabase));
       if($nuevoY == $Yearaux && $nuevomes == $mesaux ){
        $diasyearanteriores = $diasyearanteriores + $diasdepreciar;
                        //$diasactuales = 2;
        $mismoyear = true;   
      }    

    }


    $fechabase = $this->Mes($fechabase, 1);
    $diasdepreciar = $diasdepreciar + $this->diasMes($fechabase);



                if($i == ($meses - 1)){ //ESTO ES PARA EVALUAR CUADNO SEA UN FEBRERO CON 29 DIAS
                  $resto = $this->diasMes($fechabase) - $diabase; 

                  if($resto > 0){
                    $diasdepreciar = $diasdepreciar - $resto;
                  }
                }//CIERRE DE LA EVALUACION 


              }

              $respuesta['diasdepreciar'] = $diasdepreciar;
              $respuesta['diasanteriores'] = $diasyearanteriores;
            //$respuesta['diasactuales'] = $diasactuales; 

              return $respuesta;  

            }

            public function obtenerActivo($id_activo)
            {
             $this->nucleo->setQueryPersonalizado("SELECT *
              
              FROM activo as a WHERE a.id = $id_activo");
             return $this->nucleo->getDatos();
           }


           /*
            public function obtenerActivo($id_activo)
            {
             $this->nucleo->setQueryPersonalizado("SELECT a.id,
              a.codigo,
              a.descripcion,
              a.estado,
              a.tiempo_usado,
              a.monto,
              a.tanintan,
              a.porcentaje,
              a.id_tipoactivo,
              a.fecha
              FROM activo as a WHERE a.id = $id_activo");
             return $this->nucleo->getDatos();
           }*/


           public function obtenerTipoactivo($id_tipoactivo)
           {
             $this->nucleo->setQueryPersonalizado("SELECT t.id,
              t.codigo,
              t.nombre,
              t.porcentaje,
              t.tiempo
              FROM tipoactivo as t WHERE t.id = $id_tipoactivo");

             return $this->nucleo->getDatos();
           }

           public function obtenerDepartamento($id_departamento)
           {
             $this->nucleo->setQueryPersonalizado("SELECT d.id,
              d.codigo,
              d.nombre,
              d.ubicacion
              FROM departamento as d WHERE d.id = $id_departamento");
             return $this->nucleo->getDatos();
           }

	//tabla de departamentos

           public function cantidadActivos($numPagina, $cantidad, $campo, $buscar)
           {
            $this->nucleo->setNumPagina($numPagina);
            $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
            $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
              FROM activo WHERE ($campo LIKE '%$buscar%') order by codigo");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
            $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM activo WHERE ($campo LIKE '%$buscar%') order by codigo ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
            return $this->nucleo->getDatosHtml(
              array("codigo","descripcion"),
              array("seleccion" => "plus-square"),
              "id"
            );
          }

          public function tablaDepartamento($numPagina, $cantidad, $campo, $buscar)
          {


           $this->nucleo->setNumPagina($numPagina);
           $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
           $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
            FROM departamento WHERE ($campo LIKE '%$buscar%') order by nombre");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
           $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM departamento WHERE ($campo LIKE '%$buscar%') order by nombre ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
           return $this->nucleo->getDatosHtml(
            array("codigo","nombre"),
            array("seleccion" => "plus-square"),
            "id"
          );
        /*
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total  FROM departamento WHERE ($campo LIKE '%$buscar%') AND estado = 1 order by codigo");
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM departamento WHERE ($campo LIKE '%$buscar%') AND estado = 1 order by codigo ASC");
        return $this->nucleo->getDatosHtml(array("codigo", "nombre"), array("seleccion" => "plus-square"), "id");*/
      }

      public function tablaTipoactivo($numPagina, $cantidad, $campo, $buscar)
      {


        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
          FROM tipoactivo WHERE ($campo LIKE '%$buscar%') order by nombre");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM tipoactivo WHERE ($campo LIKE '%$buscar%') order by nombre ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
          array("codigo","nombre"),
          array("SELECCION" => "plus-square"),
          "id"
        );
        /*
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total  FROM departamento WHERE ($campo LIKE '%$buscar%') AND estado = 1 order by codigo");
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM departamento WHERE ($campo LIKE '%$buscar%') AND estado = 1 order by codigo ASC");
        return $this->nucleo->getDatosHtml(array("codigo", "nombre"), array("seleccion" => "plus-square"), "id");*/
      }

     //ESTE METODO ES PARA CALCULAR EL PROXIMO CODIGO DE DEPARTAMENTO
      public function codigoDepartamento()
      { 
        $this->nucleo->setQueryPersonalizado("SELECT a.id,
          d.codigo
          FROM activo as a WHERE a.fecha = (SELECT MAX(fecha) FROM activo)");
        return $this->nucleo->getDatos();
      }

      public function codigoEmpresa()
      { 
        $this->nucleo->setQueryPersonalizado("SELECT e.id,
          e.codigo
          FROM empresa as e LIMIT 1");
        return $this->nucleo->getDatos();
      }


      public function tablaActivos($numPagina, $cantidad, $campo, $buscar)
      {
        $this->nucleo->setNumPagina($numPagina);
        $this->nucleo->setPorPagina($cantidad);
        //SQL QUE CUENTA LOS REGISTROS EN LA TABLA
        $this->nucleo->setQueryTotalRegistroPag("SELECT COUNT(id) AS total
          FROM activo WHERE ($campo LIKE '%$buscar%') AND baja = 'A' order by id");
        //SQL QUE OBTIENE LOS REGISTROS DE LA TABLA
        $this->nucleo->setQueryExtractRegistroPag("SELECT * FROM activo 
          WHERE ($campo LIKE '%$buscar%') AND baja = 'A' order by id ASC");
        //RETORNA EL HTML SEGUN REQUERIMIENTOS DADOS
        return $this->nucleo->getDatosHtml(
          array("codigo","descripcion", "monto","fecha"),
          array("ver" => "eye", "editar" => "edit", "eliminar" => "trash"),
          "id"
        );
      }

      public function darbajaBotado($campos){
        $this->nucleo->setQueryPersonalizado('baja = ? WHERE id = ?;');
        return $this->nucleo->modificarRegistro($campos);
      }

      public function darbajaVendido($campos){
        $this->nucleo->setQueryPersonalizado('baja = ?, precioventa = ? WHERE id = ?;');
        return $this->nucleo->modificarRegistro($campos);
      }

      
    }