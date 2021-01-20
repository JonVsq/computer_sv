<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>COMPUTER SV</title>
    <!-- Normalize V8.0.1 -->
    <link rel="stylesheet" href="../../../css/normalize.css">

    <!-- Bootstrap V4.3 -->
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">

    <!-- Bootstrap Material Design V4.0 -->

    <!-- Font Awesome V5.9.0 -->
    <link rel="stylesheet" href="../../../css/all.css">

    <!-- Sweet Alerts V8.13.0 CSS file -->
    <link rel="stylesheet" href="../../../Plugins/sweetalert/sweetalert.css">

    <!-- Sweet Alert V8.13.0 JS file-->
    <script src="../../../Plugins/sweetalert/sweetalert.min.js"></script>

    <!-- jQuery Custom Content Scroller V3.1.5 -->
    <link rel="stylesheet" href="../../../css/jquery.mCustomScrollbar.css">

    <!-- General Styles -->
    <link rel="stylesheet" href="../../../css/style.css">



</head>

<body>

    <!-- Main container -->
    <main class="full-box main-container">
        <!-- Nav lateral -->
        <section class="full-box nav-lateral">
            <div class="full-box nav-lateral-bg show-nav-lateral"></div>
            <div class="full-box nav-lateral-content">
                <figure class="full-box nav-lateral-avatar">
                    <i class="far fa-times-circle show-nav-lateral"></i>
                    <img src="../../../assets/avatar/logo.png" class="img-fluid" alt="Avatar">
                    <figcaption class="roboto-medium text-center">
                        NOMBRE
                        <br><small class="roboto-condensed-light">ADMINISTRADOR</small>
                    </figcaption>
                </figure>
                <div class="full-box nav-lateral-bar"></div>
                <nav class="full-box nav-lateral-menu">
                    <?php
                    include('../../includes/menuAdmin.php');
                    ?>
                </nav>
            </div>
        </section>

        <!-- Page content -->
        <section class="full-box page-content">
            <nav class="full-box navbar-info">
                <a href="#" class="btn-exit-system">AYUDA
                    <i class="fas fa-question"></i>
                </a>
                <a href="#" class="float-left show-nav-lateral">
                    <i class="fas fa-exchange-alt"></i>
                </a>
                <a href="user-update.html">
                    <i class="fas fa-user-cog"></i>
                </a>
                <a href="#" class="btn-exit-system">
                    <i class="fas fa-power-off"></i>
                </a>
            </nav>
            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-store  fa-fw"></i> &nbsp; CUENTA POR COBRAR
                </h3>

            </div>

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a id="opBuscar" href="#"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; BUSCAR CUENTA</a>
                    </li>

                </ul>
            </div>


            <!--CONTENT-->





            <div id="cuadroTabla" class="container-fluid" style="display: none">
                <table class="table table-hover table-bordered table-sm roboto-medium">
                    <thead bgcolor="#DCD5D4" style="border: 5px;">
                        <tr class="text-left">
                            <td>DATOS DE LAS CUENTAS POR COBRAR</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>

                                <div class="row">
                                    <input type="hidden" class="form-control text-uppercase" name="txt_codigo_cliente" id="txt_codigo_cliente">

                                    <div class="col-12 col-md-4" align="left">
                                        <div class="form-group" align="left">
                                            <label id="txt_numfactura" class="roboto-medium"># DE FACTURA: </label>
                                            <strong> <label id="txt_numfacturarecuperado" class="roboto-medium"></strong>

                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label id="txt_fecha_venta" class="roboto-medium">FECHA DE VENTA: </label>
                                            <strong> <label id="txt_fecha_venta_recuperado" class="roboto-medium"></strong>

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label id="txt_monto_etiqueta" class="roboto-medium">MONTO $: </label>
                                            <strong><label id="txt_monto_recuperado" class="roboto-medium"></strong>

                                        </div>
                                    </div>
                                </div>

                            </td>

                        </tr>
                        <tr>
                            <td>
                                <div class="row">


                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label id="txt_clientes" class="roboto-medium">CLIENTE: </label>
                                            <strong><label id="txt_cliente_recuperado" class="roboto-medium"></strong>

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label id="txt_vendedor" class="roboto-medium">PLAZO: </label>
                                            <strong><label id="txt_plazo_recuperado" class="roboto-medium"></strong>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label id="txt_pagar" class="roboto-medium">CANCELAR CUOTA </label>
                                        <button id="btn_modalPagar" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>


                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>



                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th class="text-center"># CUOTA<br> </th>
                                <th class="text-center">CUOTA $<br></th>
                                <th class="text-center">MORA $<br></th>
                                <th class="text-center">CUOTA COBRAR $<br> </th>
                                <th class="text-center">SALDO $<br> </th>
                                <th class="text-center">FECHA PAGO<br> </th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTablaCuenta">
                        </tbody>
                    </table>
                </div>

            </div>



            <div id="cuadroFormulario" class="" align="center" style="margin-top: 0px;">

                <div class="container-fluid form-neon" align="center">
                    <input type="hidden" id="txt_id" name="txt_id">
                    <form id="frm_Cuenta" action="" autocomplete="off">
                        <fieldset>
                            <legend><i class="far fa-plus-square"></i> &nbsp; INFORMACION</legend>
                            <div class="" align="center">
                                <div class="row" align="center">
                                    <div class="col-12 col-md-4" align="center">
                                        <div class="form-group" align="right">


                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4" align="center">
                                        <div class="form-group" align="center">
                                            <label for="txt_codigo" class="roboto-medium">CÓDIGO</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_codigo" id="txt_codigo" minlength="2" maxlength="125" align="center">
                                            <div id="codigoError">

                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <p class="text-center" style="margin-top: 5px;">

                            <button id="btn_buscar" type="button" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; BUSCAR CUENTA</button>
                        </p>
                    </form>
                </div>
            </div>


            <div class="modal fade" id="ModalPagar" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title roboto-medium" id="ModalPagar">CANCELAR CUOTA</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="container-fluid">
                                    <input type="hidden" class="form-control text-uppercase" name="txt_id_pago" id="txt_id_pago">
                                    <!---->
                                    <input type="hidden" class="form-control text-uppercase" name="txt_id_credito" id="txt_id_credito">

                                    <table class="table table-hover table-bordered table-sm roboto-medium">
                                        <thead bgcolor="#DCD5D4" style="border: 5px;">
                                            <tr class="text-left">
                                                <td>CANCELACIÓN DE CUOTA</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td>
                                                    <!---->
                                                    <!--AQUI IRA LOS DATOS-->
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group" align="left">
                                                                <label id="txt_numero" class="roboto-medium"># CUOTA: </label>
                                                                <strong> <label id="txt_numero_recuperado" class="roboto-medium"></strong>

                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group" align="left">
                                                                <label id="txt_montocuota" class="roboto-medium">CUOTA $ : </label>
                                                                <strong> <label id="txt_montocuota_recuperado" class="roboto-medium"></strong>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <!--DATOS DE REGISTRO DE VENTA DEL ACTIVO-->
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label id="txt_intereses" class="roboto-medium">INTERES $: </label>
                                                                <strong><label id="txt_intereses_recuperado" class="roboto-medium"></strong>

                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label id="txt_mora_re" class="roboto-medium">MORA $ : </label>
                                                                <strong><label id="txt_mora_recuperado" class="roboto-medium"></strong>

                                                            </div>
                                                        </div>


                                                    </div>

                                                </td>

                                            </tr>
                                            <tr>
                                                <td>

                                                    <div class="row">
                                                        <div class="col-12 col-md-12">
                                                            <div class="form-group">
                                                                <label id="txt_cuotatotal" class="roboto-medium">CUOTA TOTAL $: </label>
                                                                <strong><label id="txt_cuotatotal_recuperado" class="roboto-medium"></strong>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!---->

                                    <button id="btn_guardarpago" type="button" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; PAGAR</button>
                                    <!--FIN DE REGISTROS DE VENTA-->
                            </form>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="table-responsive">

                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            </div>
            </div>

        </section>
    </main>


    <!--=============================================
	=            Include JavaScript files           =
	==============================================-->
    <!-- jQuery V3.4.1 -->
    <script src="../../../js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap V4.3 -->
    <script src="../../../js/bootstrap.min.js"></script>

    <!-- jQuery Custom Content Scroller V3.1.5 -->
    <script src="../../../js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="../../../css/login/js/jquery.validate.min.js"></script>

    <script src="../../../js/main.js"></script>

    <script>
        $(document).ready(function() {
            $("#cuadroFormulario").slideDown("slow")
            let $validar = $('#cuadroFormulario form').validate({
                rules: {
                    txt_codigo: {
                        required: true,
                        minlength: 2,
                        maxlength: 125
                    }

                }
            })
        });
    </script>

    <script src="../../js_app/cuentaporpagar.js"></script>

</body>

</html>