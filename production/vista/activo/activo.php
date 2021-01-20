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
                <i class="fas fa-store  fa-fw"></i> &nbsp; ACTIVO
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
                            <th class="text-center">CÓDIGO<br> <input type="text" id="txt_filtrouno"></th>
                            <th class="text-center">ACTIVO<br><input type="text" id="txt_filtrodos"></th>
                            <th class="text-center">MONTO $<br> </th>
                            <th class="text-center">FECHA DE ADQUICICIÓN<br> </th>
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


        <!--CUADRO DEPRECIACION-->
        <div id="cuadroTablaDepreciacion" class="container-fluid" style="display: none">

           <!--AQUI A DENTRO VA TODO -->
           <table class="table table-hover table-bordered table-sm roboto-medium">
            <thead bgcolor = "#DCD5D4">
                <tr class="text-left">
                    <td>  <div class="row">

                        <div class="col-12 col-md-12">
                            <div class="form-group" align="center">
                                <!--<label id="txt_descripcionlabel" class="roboto-medium">DESCRIPCIÓN:  </label>-->
                                <h4><strong><label  id="txt_descripcionrecuperado" class="roboto-medium"></strong></h4>

                                </div>
                            </div>

                        </div> </td>
                    </tr>
                </thead>
                <tbody id="datos">
                    <tr class="text-center">
                        <td>
                           <div class="row">

                            <div class="col-12 col-md-4">
                                <div class="form-group" align="left">
                                    <label id="txt_activocodigorecuperado" class="roboto-medium">CÓDIGO:  </label>
                                    <strong><label  id="txt_codigorecuperado" style="color:black" class="roboto-medium"></label></strong>


                                </div>
                            </div>



                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label id="txt_montolabel" class="roboto-medium">MONTO $:  </label>
                                    <strong><label  id="txt_montorecuperado" style="color:black" class="roboto-medium"></strong>

                                    </div>
                                </div>



                                <div class="col-12 col-md-2">
                                    <div class="form-group">
                                        <label id="" class="roboto-medium">ESTADO:  </label>
                                        <strong><label  id="txt_estadorecuperado" style="color:black" class="roboto-medium"></strong>

                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label id="" class="roboto-medium">TIEMPO USADO(años):  </label>
                                           <strong> <label  id="txt_tiemporecuperado" style="color:black" class="roboto-medium"></strong>

                                            </div>
                                        </div>


                                    </div>


                                </td>

                            </tr>
                            <tr>
                                <td>
                                 <div class="row">


                                     <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label id="" class="roboto-medium">VIDA ÚTIL (años):  </label>
                                            <strong><label  id="txt_vida" style="color:black" class="roboto-medium"></label></strong>

                                        </div>
                                    </div>




                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label id="" class="roboto-medium">DEPRECIAR $:  </label>
                                            <strong><label  id="txt_montodepreciar" style="color:black" class="roboto-medium"></strong>

                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label id="" class="roboto-medium">FECHA DE ADQUICICIÓN:  </label>
                                                <strong><label  id="txt_fechaadquicicion" style="color:black" class="roboto-medium"></strong>

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
                                                <label id="txt_depredia" class="roboto-medium"> </label>
                                                <button id="btn_modalDeprediaria" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                                <input type="hidden" id="txt_iddiaria" name="txt_departamento">

                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label id="txt_depremes" class="roboto-medium"></label>
                                                <button id="btn_modalDepreciacionMes" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                            </div>
                                        </div>



                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>


                    <!--HASTA AQUI-->


                    <!---->


                    <!--SEGUNDOS DATOS-->
                    <!--PARA DEPRECIACION DIARIA Y MENSUAL-->



                    <!--TABLA DE DEPRECIACION ANUAL-->

                    <div class="table-responsive">
                        <table class="table table-dark table-sm">
                            <thead>
                                <tr class="text-center roboto-medium">
                                    <th class="text-center">AÑOS<br> </th>
                                    <th id="txt_celdauno" class="text-center"><br></th>
                                    <th id= "txt_celdados" class="text-center"><br> </th>
                                    <th class="text-center">VALOR EN LIBROS<br> </th>
                                    <th class="text-center">FECHA<br> </th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaDepreciacion" >

                            </tbody>
                        </table>
                    </div>

                </div>




                <div id="cuadroFormulario" class="container-fluid" style="display: none">
                    <input type="hidden" id="txt_id">

                    <div class="container-fluid form-neon">
                        <ul style="list-style: none;">
                            <div class="row text-center col-12">
                                <div class="col-md-4 col-sm-2">
                                    <li><a id="btn_datosgenerales" href="#" class="btn btn-lg btn-warning">DATOS GENERALES</a></li>
                                </div>
                                <div class="col-md-4 col-sm-2">
                                    <li><a id="btn_datosotros" href="#" class="btn btn-lg btn-warning disabled">OTROS DATOS</a></li>
                                </div>
                            </div>

                        </ul>

                        <div id="cuadroGeneral">
                            <form id="frm_datosgenerales" action="" autocomplete="off">
                                <fieldset>
                                    <legend><i class="far fa-plus-square"></i> &nbsp; INFORMACION GENERAL</legend>
                                    <div class="container-fluid">
                                        <div class="row">

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                 <label for="txt_departamento" class="roboto-medium">DEPARTAMENTO</label>
                                                 <input type="hidden" id="txt_departamento" name="txt_departamento">
                                                 <input type="hidden" id="txt_fechaoculta" name="txt_fechaoculta">
                                                 <div class="row col-12">
                                                     <div class="col-10">
                                                        <input type="text" class="form-control" name="txt_departamentonombre" id="txt_departamentonombre" mask  readonly="true">
                                                        <div id="departamentonombreerror">

                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <button id="btn_modalDepartamento" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                                    </div>
                                                </div>       
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                             <label for="txt_tipoactivo" class="roboto-medium">TIPO DE ACTIVO</label>
                                             <input type="hidden" id="txt_tipoactivo" name="txt_tipoactivo">

                                             <div class="row col-12">
                                                 <div class="col-10">
                                                    <input type="text" class="form-control" name="txt_tipoactivonombre" id="txt_tipoactivonombre" mask  readonly="true">
                                                    <div id="tipoactivonombreerror">

                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <button id="btn_modalTipoactivo" type="button" class="btn btn-info btn-sm"><i class="fas fa-list"></i></button>
                                                </div>
                                            </div>     
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_codigolabel" class="roboto-medium">CÓDIGO</label>
                                            <input type="text" class="form-control" name="txt_codigoactivo" id="txt_codigoactivo" mask required readonly="true">
                                            <div id="codigoerror">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_descripcion" class="roboto-medium">DESCRIPCIÓN</label>
                                            <input type="text" class="form-control" name="txt_descripcion" id="txt_descripcion" required>
                                            <div id="descripcionerror">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_serie" class="roboto-medium">SERIE</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_serie" id="txt_serie" >

                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_marca" class="roboto-medium">MARCA</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_marca" id="txt_marca" >

                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_modelo" class="roboto-medium">MODELO</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_modelo" id="txt_modelo" >

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="txt_color" class="roboto-medium">COLOR</label>
                                            <input type="text" class="form-control text-uppercase" name="txt_color" id="txt_color" >

                                        </div>
                                    </div>


                                </fieldset>
                            </form>

                        </div>


                        <div id="cuadroOtros">
                            <form id="frm_otros" action="" autocomplete="off">
                                <fieldset>
                                    <legend><i class="far fa-plus-square"></i> &nbsp; OTROS DATOS</legend>
                                    <div class="container-fluid">
                                        <div class="row">
                                          <div class="col-12 col-md-6">
                                              <div class="form-group">
                                                <label for="rb_estado" class="label-control roboto-medium">ESTADO</label>
                                                <br>
                                                <div class="row col-12">
                                                    <div class="col-2">
                                                        <input type="radio" id="r1" name="rb_estado" value="NUEVO" > NUEVO
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="radio" id="r2" name="rb_estado" value="USADO"> USADO
                                                    </div>                 
                                                </div>
                                                <div id="estadoerror">

                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-12 col-md-6">
                                          <div class="form-group">
                                            <label for="rb_transaccion" class="label-control roboto-medium">TRANSACCIÓN</label>
                                            <br>
                                            <div class="row col-12">
                                                <div class="col-2">
                                                    <input type="radio" id="r1t" name="rb_transaccion" value="COMPRA" > COMPRA
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" id="r2t" name="rb_transaccion" value="DONACION"> DONACIÓN
                                                </div>                 
                                            </div>

                                            <div id="transaccionerror">

                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-12 col-md-6">
                                        <div class="form-group">


                                            <div class="row col-12">
                                             <div class="col-6">
                                                <label for="txt_tiempousado" class="roboto-medium">AÑOS DE USO</label>
                                                <input type="number" class="form-control text-uppercase" name="txt_tiempousado" id="txt_tiempousado" readonly="true" >


                                            </div>
                                            <div class="col-6">
                                                <label for="txt_maximo" class="roboto-medium"> % DEL MONTO </label>
                                                <input type="text" class="form-control text-uppercase" name="txt_maximo" id="txt_maximo" required readonly="true" >


                                            </div>
                                        </div>       
                                    </div>
                                </div>


                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="txt_monto" class="roboto-medium">MONTO $</label>
                                        <input type="text" class="form-control text-uppercase" name="txt_monto" id="txt_monto"  required>
                                        <div id="montoerror">

                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="txt_ubicacion" class="roboto-medium">UBICACIÓN </label>
                                        <input type="text" class="form-control text-uppercase" name="txt_ubicacion" id="txt_ubicacion" required >

                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                  <div class="form-group">
                                    <label for="rb_tangible" class="label-control roboto-medium"></label>
                                    <br>
                                    <div class="row col-12">
                                        <div class="col-2">
                                            <input type="radio" id="r1tangible" name="rb_tangible" value="TANGIBLE" > TANGIBLE
                                        </div>
                                        <div class="col-2">
                                            <input type="radio" id="r2tangible" name="rb_tangible" value="INTANGIBLE"> INTANGIBLE
                                        </div>                 
                                    </div>
                                    <div id="tangibleerror">

                                    </div>


                                </div>
                            </div>



                        </div>
                    </fieldset>
                </form>
            </div>

        </div>

        <br>
        <p class="text-center" style="margin-top: 5px;">
            <button id="btn_anterior" type="button" class="btn btn-raised btn-warning btn-sm disabled"><i class="fas fa-arrow-circle-left"></i> &nbsp; ANTERIOR</button>
            &nbsp; &nbsp;

            <button id="btn_listar" type="button" class="btn btn-raised btn-success btn-sm"><i class="fas fa-list"></i> &nbsp; LISTAR</button>
            &nbsp; &nbsp;
            <button id="btn_guardar" type="button" class="btn btn-raised btn-info btn-sm"><i id="iconG" class="fas fa-arrow-circle-right"></i> &nbsp; SIGUIENTE</button>
        </p>
    </div>

    <div class="modal fade" id="ModalDepartamento" tabindex="-1" role="dialog"  aria-labelledby="ModalCliente" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title roboto-medium" id="ModalDepartamento">DEPARTAMENTOS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label class="bmd-label-floating roboto-medium">TABLA PARA SELECCIONAR EL DEPARTAMENTO AL QUE PERTENECE</label>
                            <br>

                        </div>
                    </div>
                    <br>
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-dark table-sm">
                                <thead>
                                    <tr class="text-center roboto-medium">
                                        <td>CÓDIGO<br><input type="text" id="txt_codigofiltro" autocomplete="off"></td>
                                        <td>DEPARTAMENTO<br><input type="text" id="txt_departamentofiltro"></td>
                                        <td>SELECCIONAR</td>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoDepartamento">

                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <p id="registrosDepartamento" class="text-left roboto-medium"></p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <p id="totalPaginasDepartamento" class="text-right roboto-medium"></p>
                                        </div>
                                    </div>


                                </div>
                                <ul id="paginadorDepartamento" class="pagination justify-content-center">

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

    <!--MODAL PARA DAR DE BAJA UN ACTIVO-->
    <div class="modal fade" id="ModalBajaActivo" tabindex="-1" role="dialog"  aria-labelledby="ModalCliente" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title roboto-medium" id="ModalBajaActivo">ACTIVO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label class="bmd-label-floating roboto-medium">DAR DE BAJA EL ACTIVO</label>
                            <form>  
                                <input type="hidden" class="form-control text-uppercase" name="txt_id_activo" id="txt_id_activo"   >
                                <br>
                                <!--AQUI IRA LOS DATOS-->
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="rb_baja" class="label-control roboto-medium"></label>
                                            <div class="row col-12">
                                                <div class="col-4">
                                                    <input type="radio" id="r1baja" name="rb_baja" value="VENDIDO" > VENTA
                                                </div>
                                                <div class="col-4">
                                                    <input type="radio" id="r2baja" name="rb_baja" value="DONADO"> DONADO
                                                </div> 
                                                <div class="col-4">
                                                    <input type="radio" id="r3baja" name="rb_baja" value="BOTADO"> BOTADO
                                                </div>                 
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <!--DATOS DE REGISTRO DE VENTA DEL ACTIVO-->
                                <div class="row">
                                  <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="txt_monto" class="roboto-medium">ADQUISITOR DEL ACTIVO</label>
                                        <input type="text" class="form-control text-uppercase" name="txt_adquisitor" id="txt_adquisitor"  readonly="true" >
                                        <div id="adquisitorrerror">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="txt_dui_codigo" class="roboto-medium">DUI O CÓDIGO</label>
                                        <input type="text" class="form-control text-uppercase" name="txt_duicodigo" id="txt_duicodigo" readonly="true" >
                                        <div id="codigo_dui_error" >

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="txt_monto" class="roboto-medium">MONTO $</label>
                                        <input type="text" class="form-control text-uppercase" name="txt_montoventaactivo" id="txt_montoventaactivo"  readonly="true">
                                        <div id="ventaactivoerror">

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!---->
                        </form>
                        <button id="btn_guardarbaja" type="button" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
                        <!--FIN DE REGISTROS DE VENTA-->

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

<!--FIN PARA DAR DE BAJA UN ACTIVO-->

<!--MODAL DEPRECIACION DIARIA-->
<div class="modal fade" id="ModalDeprediaria" tabindex="-1" role="dialog"  aria-labelledby="ModalCliente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" align="center">
                <h5 class="modal-title roboto-medium" id="ModalDeprediaria" align="center"><label id="depreDia" class="roboto-medium"> </label></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">

                        <!--AQUI IRAN LOS DATOS-->

                        <!--INICIO TABLA-->
                        <table class="table table-hover table-bordered table-sm roboto-medium">
                            <thead bgcolor = "#28DE8C">
                                <tr class="text-left">
                                    <td>INICIO</td>
                                </tr>
                            </thead>
                            <tbody >
                              <tr class="text-center">
                                <td>
                                    <div class="row">

                                        <div class="col-12 col-md-6">
                                            <div class="form-group" align="left">
                                             <label id="" class="roboto-medium"> FECHA:  </label>
                                            <strong> <label  id="txt_fechainicio"  class="roboto-medium"></label></strong>

                                         </div>
                                     </div>

                                     <div class="col-12 col-md-6">
                                        <div class="form-group" align="left">
                                         <label id="" class="roboto-medium">MONTO DIARIO:  </label>
                                         <strong><label  id="txt_montodiario"  class="roboto-medium"></label></strong>

                                     </div>
                                 </div>            
                             </div>
                         </td>
                     </tr>
                 </tbody>
             </table>

             <!--FIN TABLA-->
             <!--INICIO TABLA DOS-->
             <table class="table table-hover table-bordered table-sm roboto-medium">
                <thead bgcolor = "#28DE8C">
                    <tr class="text-left">
                        <td>ULTIMO CIERRE</td>
                    </tr>
                </thead>
                <tbody >
                  <tr class="text-center">
                    <td>

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group" align="left">
                                    <label id="" class="roboto-medium"> FECHA :  </label>
                                    <strong><label  id="txt_fechacierre"  class="roboto-medium"></label></strong>

                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" align="left">
                                   <label id="" class="roboto-medium">MONTO $:  </label>
                                   <strong><label  id="txt_montocierre"  class="roboto-medium"></label></strong>
                               </div>
                           </div>
                       </div>
                   </td>
               </tr>
           </tbody>
       </table>


       <!--FIN TABLA DOS-->
       <!--INICIO TABLA TRES-->
       <table class="table table-hover table-bordered table-sm roboto-medium">
        <thead bgcolor = "#28DE8C">
            <tr class="text-left">
                <td>ACTUAL</td>
            </tr>
        </thead>
        <tbody >
          <tr class="text-center">
            <td>
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="form-group" align="left">
                         <label id="" class="roboto-medium"> FECHA:  </label>
                         <strong><label  id="txt_fechaactual"  class="roboto-medium"></label></strong>

                     </div>
                 </div>

                 <div class="col-12 col-md-6">
                    <div class="form-group" align="left">
                       <label id="" class="roboto-medium">MONTO $:  </label>
                       <strong><label  id="txt_montoactual"  class="roboto-medium"></label></strong>
                   </div>
               </div>
           </div>
       </td>

   </tr>
</tbody>
</table>

<!--FIN TABLA TRES-->
<!--INICIO TABLA CUATRO-->
<table class="table table-hover table-bordered table-sm roboto-medium">
    <thead bgcolor = "#28DE8C">
        <tr class="text-left">
            <td>FINAL</td>
        </tr>
    </thead>
    <tbody >
      <tr class="text-center">
        <td>
           <div class="row">

            <div class="col-12 col-md-6">
                <div class="form-group" align="left">
                 <label id="" class="roboto-medium">FECHA :  </label>
                 <strong><label  id="txt_fechafinal"  class="roboto-medium"></label></strong>

             </div>
         </div>

         <div class="col-12 col-md-6">
            <div class="form-group" align="left">
               <label id="" class="roboto-medium">MONTO $:  </label>
               <strong><label  id="txt_montofinal" class="roboto-medium"></label></strong>
           </div>
       </div>



   </div>   
</td>

</tr>
</tbody>
</table>

<!--FIN TABLA CUATRO-->


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

<!--MODAL DEPRECIACION MENSUAL-->

<div class="modal fade" id="ModalDepreMensual" tabindex="-1" role="dialog"  aria-labelledby="ModalCliente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title roboto-medium" id="ModalDepreMensual"><label id="depreMes" class="roboto-medium"> </label></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">


                        <!--AQUI IRAN LOS DATOS-->

                        <!--INICIO TABLA-->
                        <table class="table table-hover table-bordered table-sm roboto-medium">
                            <thead bgcolor = "#28DE8C">
                                <tr class="text-left">
                                    <td>INICIO</td>
                                </tr>
                            </thead>
                            <tbody >
                              <tr class="text-center">
                                <td>
                                    <div class="row">

                                        <div class="col-12 col-md-6">
                                            <div class="form-group" align="left">
                                             <label id="" class="roboto-medium">FECHA:  </label>
                                             <strong><label  id="txt_fechainiciomes" class="roboto-medium"></label></strong>

                                         </div>
                                     </div>

                                     <div class="col-12 col-md-6">
                                        <div class="form-group" align="left">
                                         <label id="" class="roboto-medium">MONTO MES:  </label>
                                         <strong><label  id="txt_montomensual" class="roboto-medium"></label></strong>

                                     </div>
                                 </div>            



                             </div>


                         </td>
                     </tr>
                 </tbody>
             </table>

             <!--FIN DE TABLA-->
             <!--INICIO DE TABLA DOS-->
             <table class="table table-hover table-bordered table-sm roboto-medium">
                <thead bgcolor = "#28DE8C">
                    <tr class="text-left">
                        <td>ULTIMO CIERRE</td>
                    </tr>
                </thead>
                <tbody >
                  <tr class="text-center">
                    <td>

                     <div class="row">

                        <div class="col-12 col-md-6">
                            <div class="form-group" align="left">
                             <label id="" class="roboto-medium">FECHA :  </label>
                            <strong> <label  id="txt_fechados" class="roboto-medium"></label></strong>

                         </div>
                     </div>

                     <div class="col-12 col-md-6">
                        <div class="form-group" align="left">
                           <label id="" class="roboto-medium">MONTO $:  </label>
                           <strong><label  id="txt_montodos" class="roboto-medium"></label></strong>
                       </div>
                   </div>



               </div>

           </td>
       </tr>
   </tbody>
</table>

<!--FIN DE TABLA DOS-->
<!--INICIO TABLA TRES-->

<table class="table table-hover table-bordered table-sm roboto-medium">
    <thead bgcolor = "#28DE8C">
        <tr class="text-left">
            <td>ACTUAL</td>
        </tr>
    </thead>
    <tbody >
      <tr class="text-center">
        <td>
          <div class="row">

            <div class="col-12 col-md-6">
                <div class="form-group" align="left">
                 <label id="" class="roboto-medium">FECHA :  </label>
                 <strong><label  id="txt_fechaactualmes" class="roboto-medium"></label></strong>

             </div>
         </div>

         <div class="col-12 col-md-6">
            <div class="form-group" align="left">
               <label id="" class="roboto-medium">MONTO $:  </label>
               <strong><label  id="txt_montoactualmes" class="roboto-medium"></label></strong>
           </div>
       </div>



   </div>


</td>
</tr>
</tbody>
</table>
<!--FIN DE TABLA TRES-->

<!--INICIO TABLA CUATRO-->
<table class="table table-hover table-bordered table-sm roboto-medium">
    <thead bgcolor = "#28DE8C">
        <tr class="text-left">
            <td>ULTIMO</td>
        </tr>
    </thead>
    <tbody >
      <tr class="text-center">
        <td>

          <div class="row">

            <div class="col-12 col-md-6">
                <div class="form-group" align="left">
                 <label id="" class="roboto-medium">FECHA :  </label>
                <strong> <label  id="txt_fechaultima" class="roboto-medium"></label></strong>

             </div>
         </div>

         <div class="col-12 col-md-6">
            <div class="form-group" align="left">
               <label id="" class="roboto-medium">MONTO $:  </label>
               <strong><label  id="txt_montoultimo" class="roboto-medium"></label></strong>
           </div>
       </div>



   </div>

</td>
</tr>
</tbody>
</table>
<!--FIN TABLA CUATRO-->

<!--SEGUNDO-->


<!--CUADRO-->


<!--TERCERO-->


<!--CUARTO-->

               <!-- <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                             <label id="" class="roboto-medium">(FINAL) FECHA :  </label>
                                    <label  id="txt_fechafinal" style="color:blue" class="roboto-medium"></label>
                            
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                               <label id="" class="roboto-medium">MONTO $:  </label>
                                    <label  id="txt_montofinal" style="color:blue" class="roboto-medium"></label>
                        </div>
                    </div>

                    

                </div>-->




                


            </div>
        </div>
        <br>
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


<!--MODAL TIPO DE ACTIVO-->
<div class="modal fade" id="ModalTipoactivo" tabindex="-1" role="dialog"  aria-labelledby="ModalCliente" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title roboto-medium" id="ModalTipoactivo">TIPO DE ACTIVOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label class="bmd-label-floating roboto-medium">TABLA PARA SELECCIONAR EL TIPO DE ACTIVO AL QUE PERTENECE</label>
                        <br>

                    </div>
                </div>
                <br>
                <div class="container-fluid">
                    <div class="table-responsive">

                        <!--<table class="table table-hover table-bordered table-sm roboto-medium">-->
                            <table class="table table-dark table-sm">
                                <thead>
                                    <tr class="text-center roboto-medium">
                                        <td>CÓDIGO<br><input type="text" id="txt_codigotipofiltro" autocomplete="off"></td>
                                        <td>TIPO DE ACTIVO<br><input type="text" id="txt_tipofiltro"></td>
                                        <td>SELECCIONAR</td>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTipoactivo">

                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <p id="registrosTipoactivo" class="text-left roboto-medium"></p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <p id="totalPaginasTipoactivo" class="text-right roboto-medium"></p>
                                        </div>
                                    </div>


                                </div>
                                <ul id="paginadorTipoactivo" class="pagination justify-content-center">

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
            $("#cuadroFormulario").slideUp("slow")
            opLista.className = "active";
            let $validar = $('#cuadroFormulario form').validate({
                rules: {
                    txt_codigo: {
                        required: true,
                        minlength: 2,
                        maxlength: 125
                    },
                    txt_nombre: {
                        required: true,
                        minlength: 2,
                        maxlength: 125
                    }
                }
            })
        });
    </script>

    <script src="../../js_app/activo.js"></script>

</body>

</html>