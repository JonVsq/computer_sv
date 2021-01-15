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
                    <i class="fas fa-hand-holding-usd  fa-fw"></i> &nbsp; VENTA AL CONTADO
                </h3>

            </div>
            <div class="container-fluid">

            </div>

            <!--CONTENT-->
            <div id="cuadroFormulario" class="container-fluid">

                <div class="container-fluid form-neon">
                    <input type="hidden" id="txt_id" name="txt_id">
                    <form id="frm_factura" action="" autocomplete="off">
                        <fieldset>
                            <legend><i class="far fa-plus-square"></i> &nbsp; INFORMACION FACTURA</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <span class="roboto-medium">N° FACTURA: </span>
                                            <input type="hidden" id="txt_factura" name="txt_factura">
                                            <span id="spn_Factura" class="text-danger roboto-medium">&nbsp; #</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <span class="roboto-medium">CLIENTE: </span>
                                            <input type="hidden" id="txt_idCliente" name="txt_idCliente">
                                            <span id="spn_Cliente" class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> SELECCIONE CLIENTE</span>
                                            <button id="btn_modalCliente" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <form id="frm_detalle" action="" autocomplete="off">
                        <fieldset>
                            <legend><i class="far fa-plus-square"></i> &nbsp; DETALLE COMPRA</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <span class="roboto-medium">PRODUCTO: </span>
                                            <input type="hidden" id="txt_idProducto" name="txt_idProducto">
                                            <span id="spn_Producto" class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> SELECCIONE PRODUCTO</span>
                                            <button id="btn_modalProducto" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <span class="roboto-medium">UNIDADES DISPONIBLES: </span>
                                            <span id="spn_Unidades" class="text-success roboto-medium">&nbsp; #</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_cantidad" class="roboto-medium">CANTIDAD</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_cantidad" id="txt_cantidad" min="1" required>
                                            <div id="cantidadError">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                        <p class="text-center" style="margin-top: 5px;">
                            <button id="btn_agregar" type="button" class="btn btn-raised btn-success btn-sm btn-block"><i class="fa fa-plus"></i> &nbsp; AGREGAR DETALLE</button>
                        </p>
                    </form>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-dark table-sm">
                            <thead>
                                <tr class="text-center roboto-medium">
                                    <th class="text-center">PRODUCTO<br></th>
                                    <th class="text-center">CANTIDAD<br> </th>
                                    <th class="text-center">COSTO (UNITARIO)<br> </th>
                                    <th class="text-center">IVA 13%<br> </th>
                                    <th class="text-center">CESC 5%<br> </th>
                                    <th class="text-center">SUB-TOTAL<br> </th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoDetalle">
                            </tbody>
                        </table>
                    </div>
                    <p class="text-center" style="margin-top: 5px;">
                        <button id="btn_cancelar" type="button" class="btn btn-raised btn-danger btn-sm"><i class="fas fa-exclamation-triangle"></i> &nbsp; CANCELAR</button>

                        <button id="btn_guardar" type="button" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
                    </p>
                </div>
            </div>
            <!-- MODAL Productos -->
            <div class="modal fade" id="ModalProducto" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title roboto-medium" id="Modal1">LISTA DE PROVEEDORES</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm roboto-medium">
                                        <thead>
                                            <tr class="text-center">
                                                <td>PRODUCTO<br> <input type="text" id="txt_buscarProducto" name="txt_buscarProducto"></td>
                                                <td>DESCRIPCION<br> <input type="text" id="txt_buscarDescripcion" name="txt_buscarDescripcion"></td>
                                                <td>SELECCIONAR</td>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpoTablaProducto">


                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation example">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="registrosProducto" class="text-left roboto-medium"></p>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="totalPaginasProducto" class="text-right roboto-medium"></p>
                                                </div>
                                            </div>


                                        </div>
                                        <ul id="paginadorProducto" class="pagination justify-content-center">

                                        </ul>

                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL Proveedor -->
            <div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title roboto-medium" id="Modal1">LISTA DE CLIENTES</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="tipo" class="roboto-medium">SELECCIONE TIPO DE CLIENTE</label>
                                                <select id="tipo" name="tipo">
                                                    <option value="natural">NATURAL</option>
                                                    <option value="juridico">JURIDICO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-hover table-bordered table-sm roboto-medium">
                                        <thead>
                                            <tr class="text-center">
                                                <td>CODIGO<br> <input type="text" id="txt_buscarCodigo" name="txt_buscarCodigo"></td>
                                                <td>NOMBRE<br> <input type="text" id="txt_buscarNombre" name="txt_buscarNombre"></td>
                                                <td>CATEGORIA</td>
                                                <td>SELECCIONAR</td>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpoTablaCliente">


                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation example">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="registrosCliente" class="text-left roboto-medium"></p>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="totalPaginasCliente" class="text-right roboto-medium"></p>
                                                </div>
                                            </div>


                                        </div>
                                        <ul id="paginadorCliente" class="pagination justify-content-center">

                                        </ul>

                                    </nav>
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

    <script src="../../js_app/venta_contado.js"></script>

</body>

</html>