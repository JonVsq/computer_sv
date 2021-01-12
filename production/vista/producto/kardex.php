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
                    <i class="fas fa-store  fa-fw"></i> &nbsp; KARDEX PRODUCTO
                </h3>

            </div>

            <!--CONTENT-->
            <div id="cuadroTabla" class="container-fluid" style="margin-top: 0px;">
                <div class="col-12 text-center">
                    <button id="btn_seleccionar" class="btn btn-info btn-sm">SELECCIONE PRODUCTO</button>
                </div>
                <br>
                <div class="col-12 text-center">
                    <span id="spn_producto" class="text text-success roboto-medium" style="font-size: 36px;">PRODUCTO</span>
                </div>
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
                                <th style="border-color: black;  background-color: #fff; color:black !important; border: 1px solid black;" colspan="2" class="text-center">DATOS<br> </th>
                                <th style="border-color: black;  background-color: #fff; color:black !important; border: 1px solid black;" colspan="3" class="text-center">ENTRADAS<br> </th>
                                <th style="border-color: black;  background-color: #fff; color:black !important; border: 1px solid black;" colspan="3" class="text-center">SALIDAS<br> </th>
                                <th style="border-color: black;  background-color: #fff; color:black !important; border: 1px solid black;" colspan="3" class="text-center">SALDO<br> </th>
                            </tr>
                            <tr class="text-center">
                                <th class="text-center">FECHA<br> </th>
                                <th class="text-center">TIPO<br> </th>
                                <th class="text-center">CANTIDAD<br> </th>
                                <th class="text-center">COSTO UNITARIO $<br> </th>
                                <th class="text-center">TOTAL<br> </th>
                                <th class="text-center">CANTIDAD<br> </th>
                                <th class="text-center">COSTO UNITARIO $<br> </th>
                                <th class="text-center">TOTAL<br> </th>
                                <th class="text-center">CANTIDAD<br> </th>
                                <th class="text-center">COSTO UNITARIO $<br> </th>
                                <th class="text-center">TOTAL<br> </th>
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

    <script src="../../js_app/kardex.js"></script>

</body>

</html>