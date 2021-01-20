<?php
require_once('../../../Plugins/vendor/autoload.php');
require_once('../../modelo/core/Nucleo.php');
date_default_timezone_set("America/EL_SALVADOR");
$css = file_get_contents('style.css');
$pdf = new \Mpdf\Mpdf([
  "format" => "A4",
  'pagenumPrefix' => 'Pagína número ',
  'nbpgPrefix' => ' de un total de ',
  'nbpgSuffix' => ' pagínas',
  'default_font' => 'arial'
]);
$nucleo = new Nucleo();
$nucleo->setTablaBase("activo");
$nucleo->setQueryPersonalizado("SELECT
  a.codigo, 
  a.descripcion, 
  a.fecha,
  t.tiempo
  FROM
  activo as a
  INNER JOIN
  tipoactivo as t
  ON 
  a.id_tipoactivo = t.id
  WHERE a.baja = 'A' AND a.tanintan = 'TANGIBLE'");
$activos = $nucleo->getDatos();
$nucleo->setQueryPersonalizado("SELECT *
  FROM empresa 
  LIMIT 1");
$empresas = $nucleo->getDatos();
$nucleo = null;

$plantilla = '
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<header class="clearfix">

<h1>
<table width="100%" height="100%">
<tr height="50%">
<td width="80%" height="50%" style="text-align: left;
color: #5D6975;
font-size: 2.4em;
line-height: 1.4em;
font-weight: normal;
text-align: center;
margin: 0 0 20px 0;" align="center" >' .$empresas[0]['nombre']. '</td>
<td width="20%" height="50%" ><img src="../../../assets/avatar/logo.png" width= "100" height ="100"></td>
</tr>
</table>
</h1> 
<div id="project">
<div style=" text-align: center;"> REPORTE DE ACTIVOS EN DEPRECIACIÓN QUE ESTAN DE ALTA</div>
<br>  
<div><span>CODIGO DE EMPRESA: </span> ' .$empresas[0]['codigo']. '</div>
<div><span>NOMBRE DE LA EMPRESA: </span> ' .$empresas[0]['nombre']. '</div>
<div><span>NIT: </span> ' .$empresas[0]['nit']. '</div>
</div>
</header>
<main>
<table>
<thead>
<tr>
<th class="service"  style="text-align: center;">CÓDIGO</th>
<th class="desc" style="text-align: center;">ACTIVO</th>
<th class="desc" style="text-align: center;">TIEMPO</th>
<th class="desc" style="text-align: center;">FECHA COMPRA</th>
</tr>
</thead>
<tbody>
';
foreach ($activos as $activo) {
  $fecha = $activo['fecha'];
  $fechaactual = date("Y-m-d");
  $fecha = date('Y-m-d', strtotime($activo['tiempo']." year", strtotime($fecha)));
  if($fecha >= $fechaactual){
   $plantilla .= '<tr><td class="service" style="text-align: center;">' . $activo["codigo"] . '</td>';
   $plantilla .= '<td class="service" style="text-align: center;">' . $activo["descripcion"] . '</td>';
   $plantilla .= '<td class="service" style="text-align: center;">' . $activo["tiempo"] . '</td>';
   $plantilla .= '<td class="service" style="text-align: center;">' . $activo["fecha"] . '</td></tr>';
 }


}


$plantilla .= '
</tbody>
</table>
</main>
</body>';
$pdf->allow_charset_conversion = true;
$pdf->charset_in = 'utf-8';
$pdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$pdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
$pdf->SetHTMLFooter('
  <table width="100%">
  <tr>
  <td width="33%" style="text-align: left;">{DATE d-m-Y} ' . date("h:i:s A") . '</td>
  <td width="33%" align="center">{PAGENO}{nbpg}</td>
  </tr>
  </table>');
$pdf->Output("Clientes.pdf", "I");
