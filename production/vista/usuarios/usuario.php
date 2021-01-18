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
                    <i class="fas fa-store  fa-fw"></i> &nbsp; PRODUCTOS
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
                                <th class="text-center">CORREO<br> 
                                <th class="text-center">NOMBRE<br> <input type="text" name="txt_nombrefiltro" id="txt_nombrefiltro"></th>
    
                                <th class="text-center">ACCIONES<br></th>
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
                    <form id="frm_Usuario" action="" autocomplete="off">
                        <fieldset>
                            <legend><i class="far fa-plus-square"></i> &nbsp; INFORMACION</legend>
                            <div class="container-fluid">
                                
                                <div class="row">
                                <div class="col-12 col-md-10">
                                        <div class="form-group">
                                            <span class="roboto-medium">Empleado: </span>
                                            <input type="hidden" id="txt_idEmpleado" name="txt_idEmpleado">
                                            <span id="spn_empleado" class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> SELECCIONE EMPLEADO</span>
                                            <button id="btn_modalEmpleado" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                     </div>
                                </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-12 col-md-10">
                                    
                                        <div class="form-group">
                                            <label for="txt_correo" class="roboto-medium">CORREO</label>
                                            <input type="email" class="form-control" name="txt_correo" id="txt_correo" required>
                                            <div id="correoError">

                                            </div>
                                        
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-12 col-md-10">
                                        <div class="form-group">
                                            <label for="txt_contra" class="roboto-medium">CONTRASEÑA</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_contra" id="txt_contra" minlength="2" maxlength="350" required>
                                            <div id="contraError">

                                            </div>
                                        </div>
                                        </div>
                                    </div>
                               <div class="row">
                               <div class="col-12 col-md-10">
                                        <div class="form-group">
                                            <label for="txt_ac" class="roboto-medium">ACCESO</label>
                                            <input type="number" class="form-control text-uppercase" name="txt_ac" id="txt_ac" minlength="2" maxlength="250" required>
                                            <div id="acError">

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
            <!-- MODAL Empleado -->
            <div class="modal fade" id="ModalEmpleado" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title roboto-medium" id="ModalEmpleado">LISTA DE EMPLEADOS</h5>
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
                                                <td>NOMBRE<br> <input type="text" id="txt_buscarEmpleado" name="txt_buscarEmpleado"></td>
                                                <td>SELECCIONAR</td>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpoTablaEmpleado">


                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation example">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="registrosEmpleado" class="text-left roboto-medium"></p>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <p id="totalPaginasEmpleado" class="text-right roboto-medium"></p>
                                                </div>
                                            </div>


                                        </div>
                                        <ul id="paginadorEmpleado" class="pagination justify-content-center">

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

           
            <!-- MODAL USUARIO -->
            <div class="modal fade" id="ModalUsuario" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title roboto-medium" id="ModalUsuario">DATOS DEL USUARIO</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div id="md_datosUsuario" class="form-group">

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
            opLista.className = "active";
            $("#cuadroFormulario").slideUp("slow")
            let $validar = $('#cuadroFormulario form').validate({
                rules: {
                    txt_correo: {
                        required: true,
                        minlength: 2,
                        maxlength: 125
                    }
                }
            })
        });
    </script>

    <script src="../../js_app/usuario.js"></script>

</body>

</html>