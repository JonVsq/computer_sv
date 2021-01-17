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
                    <i class="fas fa-store  fa-fw"></i> &nbsp; EMPRESA
                </h3>

            </div>
           

            <!--CONTENT-->
          

            <div id="cuadroFormulario" class="container-fluid">
                <div class="container-fluid form-neon">
                    <form id="frm_datos" action="" autocomplete="off">
                        <fieldset>
                            <input type="hidden" id="txt_id" name="txt_id">
                            <div class="container-fluid">
                                <div class="row">

                                <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_cod" class="roboto-medium">CODIGO</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_cod" id="txt_cod" minlength="6" maxlength="6" readonly required>
                                            <div id="codError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_nombre" class="roboto-medium">NOMBRE</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_nombre" id="txt_nombre" minlength="4" maxlength="50" readonly required>
                                            <div id="nombreError">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_nit" class="roboto-medium">NIT</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_nit" id="txt_nit"  mask minlength="17" maxlength="17" readonly required>
                                            <div id="nitError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_pais" class="roboto-medium">PAIS</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_pais" id="txt_pais" minlength="4" maxlength="125" readonly required>
                                            <div id="paisError">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_ciu" class="roboto-medium">CIUDAD</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_ciu" id="txt_ciu" minlength="3" maxlength="125" readonly required>
                                            <div id="ciuError">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_direccion" class="roboto-medium">DIRECCION</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_direccion" id="txt_direccion" readonly minlength="6" maxlength="300" required>
                                            <div id="direccionError">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_correo" class="roboto-medium">CORREO</label>
                                            <input type="email" class="form-control" name="txt_correo" id="txt_correo" readonly required>
                                            <div id="correoError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_telefono" class="bmd-label-floating roboto-medium">TELEFONO</label>
                                            <input id="txt_telefono" name="txt_telefono" class="form-control" mask type="text" readonly required>
                                            <div id="telefonoError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_fax" class="bmd-label-floating roboto-medium">FAX</label>
                                            <input id="txt_fax" name="txt_fax" class="form-control" mask type="text" readonly required>
                                            <div id="faxError">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_web" class="bmd-label-floating roboto-medium">WEB</label>
                                            <input id="txt_web" name="txt_web" class="form-control" type="text" readonly required>
                                            <div id="webError">

                                            </div>
                                        </div>
                                    </div>       

                                         
                        </fieldset>
                   
                    <br>
                    <p class="text-center" style="margin-top: 5px;">
                        <button id="btn_modificar" type="button" class="btn btn-raised btn-info btn-sm" disabled><i class="fas fa-edit"></i> &nbsp; MODIFICAR</button>
                        <button id="btn_guardar" type="button" class="btn btn-raised btn-info btn-sm" disabled><i id="iconG" class="fas fa-save"></i> &nbsp; GUARDAR</button>
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
    <script src="../../../Plugins/mascara.js"></script>
    <script src="../../../js/main.js"></script>
    <script>
     

        $(document).ready(function() {
            $("#txt_nit").mask("9999-999999-999-9")
            $('#txt_telefono').mask("(999)9999-9999")
            $('#txt_fax').mask("(999)9999-9999")
            let $validar = $('#cuadroFormulario form').validate({
                rules: {
                    txt_nombre: {
                        required: true,
                        minlength: 3,
                        maxlength: 125
                    },
                    txt_correo: {
                        required: true
                    },
                    txt_direccion: {
                        required: true,
                        minlength: 6,
                        maxlength: 300
                    }

                

                }
            })
        });
    </script>
 <script src="../../js_app/empresa.js"></script>


</body>

</html>