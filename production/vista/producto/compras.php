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
                    <i class="fas fa-shopping-cart  fa-fw"></i> &nbsp; COMPRAS DE PRODUCTO
                </h3>

            </div>
            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a id="opLista" href="#"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA</a>
                    </li>
                    <li>
                        <a id="opNueva" href="#"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA</a>
                    </li>
                </ul>
            </div>

            <!--CONTENT-->
            <div id="cuadroTabla" class="container-fluid" style="margin-top: 0px;">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cantidad" class="roboto-medium">MOSTRAR</label>
                            <select id="cantidad" name="cantidad">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th class="text-center">NOMBRE<br> <input type="text" name="txt_nombrefiltro" id="txt_nombrefiltro"></th>
                                <th class="text-center">ACCIONES<br> </th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTabla">
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <p id="registros" class="text-left roboto-medium"></p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <p id="totalPaginas" class="text-right roboto-medium"></p>
                            </div>
                        </div>
                    </div>
                    <ul id="paginador" class="pagination justify-content-center">

                    </ul>

                </nav>
            </div>

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
                                            <span class="roboto-medium">PROVEEDOR: </span>
                                            <input type="hidden" id="txt_idProveedor" name="txt_idProveedor">
                                            <span id="spn_Proveedor" class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> SELECCIONE PROVEEDOR</span>
                                            <button id="btn_modalProveedor" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group text-center">
                                            <span id="spn_total" style="font-size: 24px;" class="roboto-medium text-danger">TOTAL $: </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_factura" class="roboto-medium">Nº FACTURA</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_factura" id="txt_factura" min="1" required>
                                            <div id="facturaError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_fecha" class="roboto-medium">FECHA COMPRA</label>
                                            <input type="date" class="form-control text-uppercase" name="txt_fecha" id="txt_fecha" required>
                                            <div id="fechaError">

                                            </div>
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
                                            <label for="txt_garantia" class="roboto-medium">AÑOS DE GARANTIA</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_garantia" id="txt_garantia" min="0" required>
                                            <div id="garantiaError">

                                            </div>
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
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_precio" class="roboto-medium">COSTO (UNITARIO)</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_precio" id="txt_precio" required>
                                            <div id="precioError">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <p class="text-center" style="margin-top: 5px;">
                            <button id="btn_agregar" type="button" class="btn btn-raised btn-info btn-sm btn-block"><i class="fa fa-plus"></i> &nbsp; AGREGAR DETALLE</button>
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
                                    <th class="text-center">SUB-TOTAL<br> </th>
                                    <th class="text-center">AÑOS GARANTIA<br> </th>
                                    <th class="text-center">ACCIONES<br> </th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoDetalle">
                            </tbody>
                        </table>
                    </div>
                    <p class="text-center" style="margin-top: 5px;">
                        <button id="btn_listar" type="button" class="btn btn-raised btn-info btn-sm"><i class="fas fa-list"></i> &nbsp; LISTAR</button>
                        &nbsp; &nbsp;
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
            <div class="modal fade" id="ModalProveedor" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
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
                                                <td>NOMBRE<br> <input type="text" id="txt_buscarProveedor" name="txt_buscarProveedor"></td>
                                                <td>SELECCIONAR</td>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpoTablaProveedor">


                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation example">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="registrosProveedor" class="text-left roboto-medium"></p>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="totalPaginasProveedor" class="text-right roboto-medium"></p>
                                                </div>
                                            </div>


                                        </div>
                                        <ul id="paginadorProveedor" class="pagination justify-content-center">

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

    <script>
        $(document).ready(function() {
            // $("#cuadroFormulario").slideUp("slow")
            opLista.className = "active";
            let $validar = $('#cuadroFormulario form').validate({
                rules: {
                    txt_marca: {
                        required: true,
                        minlength: 2,
                        maxlength: 125
                    }
                }
            })
        });
    </script>

    <script src="../../js_app/compras.js"></script>

</body>

</html>