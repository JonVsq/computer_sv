<?php
session_start();
require_once('../../../Plugins/vendor/autoload.php');
require_once('../../modelo/core/Nucleo.php');
date_default_timezone_set("America/EL_SALVADOR");
$css = file_get_contents('style.css');
$factura = isset($_SESSION['factura']) ?  $_SESSION['factura'] : null;
//CREACION DE PDF
$pdf = new \Mpdf\Mpdf([
    "format" => "A4",
    'pagenumPrefix' => 'Pagína número ',
    'nbpgPrefix' => ' de un total de ',
    'nbpgSuffix' => ' pagínas',
    'default_font' => 'arial'
]);

//INICIA EL NUCLEO
$nucleo = new Nucleo();
$nucleo->setTablaBase("venta");
//OBTIENE LA VENTA
$nucleo->setQueryPersonalizado("SELECT * FROM venta
 as v where v.numero_factura = $factura");
$venta = $nucleo->getDatos();
//OBTIENE EL CLIENTE
$nucleo->setQueryPersonalizado("SELECT * FROM
cliente as c where c.codigo = '{$venta[0]['codigo_cliente']}'");
$cliente = $nucleo->getDatos();
//OBTIENE EL DETALLE DE LA VENTA
$nucleo->setQueryPersonalizado("SELECT
*
FROM
detalle_venta as dv 
INNER JOIN productos as p on p.id = dv.id_producto
where dv.id_venta = {$venta[0]['id']}");
$items = $nucleo->getDatos();
$nucleo = null;
//PlANTILLA HTML
$plantilla = '
<body>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css" media="all" />
 </head>
<header class="clearfix">

  <div id="company">
    <h2 class="name">FACTURA VENTAS INTERNAS</h2>
    <div>Nº FACTURA  ' . $venta[0]['numero_factura'] . '</div>
    <div>NIT 0400-032033-112-2</div>
    <div>NRC 98043-32-32</a></div>
  </div>
  </div>
</header>
<main>
  <div id="details" class="clearfix">
  <div id="client" width="50%">
  <div class="to">NOMBRE, DENOMINACION O RAZON COMPROBANTE
  </div>
  <div class="to"> DE CREDITO SOCIAL DEL CONTRIBUYENTE EMISOR:</div>
  <h2 class="name">COMPUTER SV</h2>
  <div class="address">GIRO, ACTIVIDAD:</div>
  <h2 class="name">COMERCIAL</h2>
  <div class="to"> DIRECCION: SAN SALVADOR, AVENIDA JUAN PABLO II</div>
  <div class="to"> FECHA: ' . $venta[0]['fecha_venta'] . ' </div>
 <br>
  <div class="to">NOMBRE, DENOMINACION O RAZON SOCIAL CLIENTE
  </div>
  <h2 class="name">' . $cliente[0]['nombre'] . '</h2>
</div >
    
  </div>
  <table border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th class="unit">CANTIDAD</th>
        <th class="desc">DESCRIPCION</th>
        <th class="unit">PRECIO UNITARIO</th>
        <th class="unit">VENTAS NO SUJETAS</th>
        <th class="unit">VENTAS EXENTAS</th>
        <th class="total">VENTAS GRAVADAS</th>
      </tr>
    </thead>
    <tbody>
';
$total = 0;
$iva = 0;
$cesc = 0;
foreach ($items as $item) {
    $total = $total + round($item['cantidad'] * $item['precio_venta'], 2);
    $plantilla .= '<tr> <td class="unit">' . $item['cantidad'] . '</td>';
    $plantilla .= '<td class="desc">
                     ' . $item['producto'] . '
                   </td>';
    $plantilla .= '<td class="unit">$' . $item['precio_venta'] . '</td>';
    $plantilla .= '<td class="unit"></td>';
    $plantilla .= '<td class="unit"></td>';
    $plantilla .= '<td class="total">$' . round($item['cantidad'] * $item['precio_venta'], 2) . '</td> </tr>';
}
$iva = round($total * 0.13, 2);
$cesc = round($total * 0.05);
$plantilla = $plantilla . ' </tbody>
<tfoot>
  <tr>
    <td colspan="3"></td>
    <td colspan="2">SUBTOTAL</td>
    <td>$' . $total . '</td>
  </tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="2">IVA 13%</td>
    <td>$' . $iva . '</td>
  </tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="2">CESC 5%</td>
    <td>$' . $cesc . '</td>
  </tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="2">TOTAL</td>
    <td>$' . round($total + $iva + $cesc, 2) . '</td>
  </tr>
</tfoot>
</table>

</main>
<footer>
</footer>
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
$pdf->Output("ComprobanteCF.pdf", "I");
