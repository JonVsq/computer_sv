<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>COMPUTER SV</title>



    <!-- CSS Files -->
    <link href="../../css/login/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../css/login/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../../css/login/css/demo.css" rel="stylesheet" />
</head>

<body>
    <div class="image-container set-full-height" style="background-image: url('../../assets/img/fondologin.jpg')">

        <!--   Big container   -->
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">

                    <!--      Wizard container        -->
                    <div class="wizard-container">

                        <div class="card wizard-card" data-color="orange" id="wizardProfile">
                            <!--        You can switch ' data-color="orange" '  with one of the next bright colors: "blue", "green", "orange", "red"          -->

                            <div class="wizard-header">
                                <h3>
                                    <b>Bienvenido</b> Inicia sesión <br>
                                    <small>Ingresa tus credenciales</small>
                                </h3>
                            </div>
                            <div class="tab-content">
                                <div id="cuadroFormulario">
                                    <form id="frm_login" autocomplete="off">
                                        <div class="row">
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="../../assets/avatar/logo.png" class="picture-src" id="wizardPicturePreview" title="" />
                                                    </div>
                                                    <h6>COMPUTER SV</h6>
                                                </div>
                                                <div id="errorLogin" class="text-center">
                                                </div>
                                            </div>

                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Correo <small>(Obligatorio)</small></label>
                                                    <input id="txt_correo" name="txt_correo" type="email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Contraseña <small>(Obligatorio)</small></label>
                                                    <input id="txt_pass" name="txt_pass" type="password" minlength="8" maxlength="16" class="form-control" required>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div class="wizard-footer height-wizard">
                                <div class="pull-right">
                                    <a id="btn_ingresar" href="administracion.php" type="button" class="btn btn-next btn-fill btn-warning btn-wd btn-sm" name="next" >INGRESAR</a>
                                </div>

                                <div class="pull-left">
                                    <a href="recuperar.php" class="text-info roboto-medium">No recuerda su contraseña?</a> </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>


                    </div>
                </div> <!-- wizard container -->
            </div>
            <div class="footer">
                <div class="container">
                    COMPUTER SV. Todos los derechos reservados 2021.</a>
                </div>
            </div>
        </div><!-- end row -->


        <!--   Core JS Files   -->
        <script src="../../js/jquery-3.4.1.min.js"></script>
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../css/login/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
        <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
        <script src="../../css/login/js/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                var $validacorreo = $('#cuadroFormulario form').validate({
                    rules: {
                        txt_correo: {
                            required: true
                        }

                    }
                })
            });
        </script>
        <script src="../js_app/login.js"></script>

</body>


</html>