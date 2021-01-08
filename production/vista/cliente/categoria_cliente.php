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
                    <i class="fas fa-user  fa-fw"></i> &nbsp; CATEGORIAS DE CLIENTE
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
                                <th class="text-center">NOMBRE<br> <input type="text" name="txt_nombreFiltro" id="txt_nombreFiltro"></th>
                                <th class="text-center">DESCRIPCION<br> <input type="text" name="txt_descripcionFiltro" id="txt_descripcionFiltro"></th>
                                <th class="text-center">MAXIMO PAGOS ATRASO<br> </th>
                                <th class="text-center">MAXIMA VENTAS A REALIZAR<br> </th>
                                <th class="text-center">MONTO LIMITE<br> </th>
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
                    <form id="frm_catCliente" action="" autocomplete="off">
                        <fieldset>
                            <legend><i class="far fa-plus-square"></i> &nbsp; INFORMACION</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_nombre" class="roboto-medium">NOMBRE</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_nombre" id="txt_nombre" minlength="1" maxlength="100" required>
                                            <div id="nombreError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_descripcion" class="roboto-medium">DESCRIPCION</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_descripcion" id="txt_descripcion" minlength="2" maxlength="300" required>
                                            <div id="descripcionError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_maxAtraso" class="roboto-medium">MAXIMO DE PAGOS ATRASADOS</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_maxAtraso" id="txt_maxAtraso" min="1" max="12" required>
                                            <div id="pagoError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_maxVentas" class="roboto-medium">MAXIMO DE VENTAS AL CREDITO</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_maxVentas" id="txt_maxVentas" min="1" max="12" required>
                                            <div id="ventaError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_montoLimite" class="roboto-medium">MONTO MAXIMO DE VENTAS AL CREDITO</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_montoLimite" id="txt_montoLimite" min="1" max="100000" required>
                                            <div id="montoError">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                </div>
                </fieldset>
                <br>
                <p class="text-center" style="margin-top: 5px;">
                    <button id="btn_limpiar" type="reset" class="btn btn-raised btn-info btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                    &nbsp; &nbsp;
                    <button id="btn_listar" type="button" class="btn btn-raised btn-info btn-sm"><i class="fas fa-list"></i> &nbsp; LISTAR</button>
                    &nbsp; &nbsp;
                    <button id="btn_guardar" type="button" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
                </p>
                </form>
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
            $("#cuadroFormulario").slideUp("slow")
            opLista.className = "active";
            let $validar = $('#cuadroFormulario form').validate({
                rules: {
                    txt_nombre: {
                        required: true,
                        minlength: 1,
                        maxlength: 100
                    },
                    txt_descripcion: {
                        required: true,
                        minlength: 2,
                        maxlength: 300
                    },
                    txt_maxAtraso: {
                        required: true,
                        min: 1,
                        max: 12
                    },
                    txt_maxVentas: {
                        required: true,
                        min: 1,
                        max: 12
                    },
                    txt_montoLimite: {
                        required: true,
                        min: 1,
                        max: 100000
                    }
                }
            })
        });
    </script>

    <script src="../../js_app/categoria_cliente.js"></script>

</body>

</html>