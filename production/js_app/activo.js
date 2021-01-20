//CONSTANTES
//BOTONES PRINCIPALES
const opLista = document.getElementById('opLista')
const opNuevo = document.getElementById('opNueva')
//BOTONES INFERIORES DEL FORMULARIO
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
const btn_guardarbaja = document.getElementById('btn_guardarbaja')
const btn_anterior = document.getElementById('btn_anterior')
const btn_limpiar = document.getElementById('btn_limpiar')
//BORONES SUPERIORES DEL FORMULARIO
const btn_datosgenerales = document.getElementById('btn_datosgenerales')
const btn_datosotros = document.getElementById('btn_datosotros')
//BOTON DEL MODAL DEL DEPARTAMENTO
const btn_modalDepartamento = document.getElementById('btn_modalDepartamento')
const btn_modalDeprediaria = document.getElementById('btn_modalDeprediaria')
const btn_modalDepreciacionMes = document.getElementById('btn_modalDepreciacionMes')
const btn_modalTipoactivo = document.getElementById('btn_modalTipoactivo')
const iconG = document.getElementById('iconG')
//ENTRADAS DEL FORMULARIO datos generales
//
const txt_id = document.getElementById('txt_id')
const idtxt_departamento = document.getElementById('txt_departamento')
const idtxt_tipoactivo = document.getElementById('txt_tipoactivo')
const txt_codigoactivo = document.getElementById('txt_codigoactivo')
const txt_descripcion = document.getElementById('txt_descripcion')
const txt_serie = document.getElementById('txt_serie')
const txt_marca = document.getElementById('txt_marca')
const txt_modelo = document.getElementById('txt_modelo')
const txt_color = document.getElementById('txt_color')
//ENTRADAS DEL FORMULARIO otros datos
const rb_estado = document.getElementById('rb_estado')
const rb_dos = document.getElementById('r2')
const rb_uno = document.getElementById('r1')
const rb_venta = document.getElementById('r1baja')
const rb_donado = document.getElementById('r2baja')
const rb_botado = document.getElementById('r3baja')
const rb_transaccion = document.getElementById('rb_transaccion')
const txt_tiempousado = document.getElementById('txt_tiempousado')
const txt_monto = document.getElementById('txt_monto')
const txt_ubicacion = document.getElementById('txt_ubicacion')
const rb_tangible = document.getElementById('rb_tangible')
const txt_maximo = document.getElementById('txt_maximo')
//ENTRADAS PARA FILTROS
const txt_codigofiltro = document.getElementById('txt_codigofiltro')
const txt_departamentofiltro = document.getElementById('txt_departamentofiltro')
const txt_codigotipofiltro = document.getElementById('txt_codigotipofiltro')
const txt_tipofiltro = document.getElementById('txt_tipofiltro')
const txt_filtrouno = document.getElementById('txt_filtrouno')
const txt_filtrodos = document.getElementById('txt_filtrodos')
const cantidad = document.getElementById('cantidad')
//const txt_idemple = document.getElementById('txt_idemple')
//CONSTANTES NECESARIAS
let urlActivo = '../../controlador/ActivoController.php'
let paso = 1
let modificar = false
let codigoDepartamento = ""
let codigoTipoactivo = ""
let codigoEmpresa = ""
let cantidadactivos = ""
let organizadorTabla = 0
//HASTA QUE LA PAGINA SE CARGA SE INICIAN LOS EVENTOS
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS DEL DOM
function inicio() {
    // listarEmpleado(1, cantidad.value, '', '')
    listarActivos(1, cantidad.value, '', '')
    $("#cuadroFormulario").slideUp("slow")
    opNuevo.addEventListener("click", opcionNuevo)
    btn_anterior.addEventListener("click", anterior)
    btn_guardar.addEventListener("click", siguiente)
    btn_guardarbaja.addEventListener("click", baja)
    opLista.addEventListener("click", opcionLista)
    btn_listar.addEventListener("click", opcionLista)
    btn_modalDepartamento.addEventListener("click", tablaModalDepartamento)
    btn_modalTipoactivo.addEventListener("click", tablaModalTipoactivo)
    btn_modalDeprediaria.addEventListener("click", cargarDepreDiaria)
    btn_modalDepreciacionMes.addEventListener("click", cargarDepreMensual)
    txt_codigofiltro.addEventListener('keyup', filtroCodigo)
    txt_departamentofiltro.addEventListener('keyup', filtroDepartamento)
    txt_codigotipofiltro.addEventListener('keyup', filtroCodigoTipo)
    txt_tipofiltro.addEventListener('keyup', filtroTipo)
    txt_filtrouno.addEventListener('keyup', filtroUno)
    txt_filtrodos.addEventListener('keyup', filtroDos)
    cantidad.addEventListener("change", comboListado)
    rb_dos.addEventListener("change", habilitartiempo);
    rb_uno.addEventListener("change", dehabilitartiempo);
    rb_venta.addEventListener("change", habilitarventa)
    rb_donado.addEventListener("change", habilitardonado)
    rb_botado.addEventListener("change", habilitarbotado)
    txt_tiempousado.addEventListener('keyup', calcularPorcentaje)
    //btn_limpiar.addEventListener("click", limpiarFormularios)
}

function habilitartiempo() {
    //swal("ERROR.", "HABILITADO.", "info")
    document.getElementById("txt_tiempousado").readOnly = false;
}

function habilitarventa() {
    //swal("ERROR.", "HABILITADO.", "info")
    document.getElementById("txt_adquisitor").readOnly = false;
    document.getElementById("txt_duicodigo").readOnly = false;
    document.getElementById("txt_montoventaactivo").readOnly = false;
}

function habilitardonado() {
    //swal("ERROR.", "HABILITADO.", "info")
    document.getElementById("txt_adquisitor").readOnly = false;
    document.getElementById("txt_duicodigo").readOnly = false;
    document.getElementById("txt_montoventaactivo").readOnly = true;
}

function habilitarbotado() {
    //swal("ERROR.", "HABILITADO.", "info")
    document.getElementById("txt_adquisitor").readOnly = true;
    document.getElementById("txt_duicodigo").readOnly = true;
    document.getElementById("txt_montoventaactivo").readOnly = true;
}

function dehabilitartiempo() {
    //swal("ERROR.", "HABILITADO.", "info")
    document.getElementById('txt_maximo').value = "100"
    document.getElementById("txt_tiempousado").readOnly = true;
}
//NAVEGACION ENTRE LOS PANEL DEL FORMULARIO
function anterior() {
    if (paso == 1) {} else if (paso == 2) {
        btn_datosgenerales.className = "btn btn-lg btn-warning"
        btn_datosotros.className = "btn btn-lg btn-warning disabled"
        $("#cuadroFormulario").slideDown("slow")
        $("#cuadroGeneral").slideDown("slow")
        $("#cuadroOtros").slideUp("slow")
        paso--
        btn_guardar.removeAttribute('disabled')
    }
}

function siguiente() {
    // btn_guardar.setAttribute('disabled', 'true')
    if (paso == 1) {
        let valid = $('#cuadroGeneral form').valid()
        if (!valid) {
            btn_guardar.removeAttribute('disabled')
            return false;
        } else {
            btn_anterior.className = "btn btn-raised btn-warning btn-sm"
            btn_datosgenerales.className = "btn btn-lg btn-info disabled"
            btn_datosotros.className = "btn btn-lg btn-warning"
            $("#cuadroFormulario").slideDown("slow")
            $("#cuadroGeneral").slideUp("slow")
            $("#cuadroOtros").slideDown("slow")
            if (document.getElementById('txt_tiempousado').value == "") {
                document.getElementById('txt_maximo').value = "100"
            } else {
                calcularPorcentaje()
            }
            paso++
        }
        //btn_guardar.removeAttribute('disabled')
    } else if (paso == 2) {
        let validos = $('#cuadroOtros form').valid()
        let validaestado = validaEstado()
        let validatransaccion = validaTransaccion()
        let validatangible = validaTangible()
        if (!validos || !validaestado || !validatransaccion || !validatangible) {
            btn_guardar.removeAttribute('disabled')
            return false;
        } else {
            guardarModificarActivo()
            paso = 0
        }
    }
}

function calcularPorcentaje() {
    if (document.getElementById('txt_tiempousado').value == 1) {
        document.getElementById('txt_maximo').value = "80"
    } else if (document.getElementById('txt_tiempousado').value == 2) {
        document.getElementById('txt_maximo').value = "60"
    } else if (document.getElementById('txt_tiempousado').value == 3) {
        document.getElementById('txt_maximo').value = "40"
    } else if (document.getElementById('txt_tiempousado').value >= 4) {
        document.getElementById('txt_maximo').value = "20"
    }
}
//GUARDAR Y MODIFICAR EL ACTIVO
function guardarModificarActivo() {
    //swal("ERROR.", "A GUARDAR VAMOS.", "info")
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_datosgenerales'))
        /*var elemento = document.getElementById('txt_departamento')
        var departamento = elemento.childNodes[1].innerText
        var elemento2 = document.getElementById('txt_tipoactivo')
        var tipoactivo = elemento2.childNodes[1].innerText
        datos.append('txt_departamento', departamento)
        datos.append('txt_tipoactivo', tipoactivo)*/
        datos.append('txt_departamento', document.getElementById('txt_departamento').textContent)
        datos.append('txt_tipoactivo', document.getElementById('txt_tipoactivo').textContent)
        datos.append('rb_estado', obtenerEstado())
        datos.append('rb_estado', obtenerEstado())
        datos.append('rb_transaccion', obtenerTransaccion())
        datos.append('txt_tiempousado', document.getElementById('txt_tiempousado').value)
        datos.append('txt_maximo', document.getElementById('txt_maximo').value)
        datos.append('txt_monto', document.getElementById('txt_monto').value)
        datos.append('txt_ubicacion', document.getElementById('txt_ubicacion').value)
        datos.append('rb_tangible', obtenerTangible())
        if (modificar) {
            //swal("ERROR.", "A modificar." + txt_id.value, "info")
            datos.append('id', txt_id.value)
            datos.append('opcion', 'modificar')
        } else {
            /*datos.append('rb_estado', rb_estado.value)
            datos.append('rb_transaccion', rb_transaccion.value)
            datos.append('txt_tiempousado', txt_tiempousado.value)
            datos.append('txt_maximo', txt_maximo.value)
            datos.append('txt_monto', txt_monto.value)
            datos.append('txt_ubicacion', txt_ubicacion.value)
            datos.append('rb_tangible', rb_tangible.value)
            datos.append('txt_venta', txt_venta.value)*/
            datos.append('opcion', 'insertar')
        }
        fetch(urlActivo, {
            method: 'POST',
            body: datos
        }).then(function(respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                //listarActivo(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                // marcaError.innerHTML = ""
                document.getElementById('frm_datosgenerales').reset()
                document.getElementById('frm_otros').reset()
            } else {
                /*
                if (respuesta[0].errores[0].nombre_marca > 0) {
                    marcaError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    marcaError.innerHTML = ""
                }*/
            }
            btn_guardar.removeAttribute('disabled')
        }).catch(error => {
            console.log(error)
            btn_guardar.removeAttribute('disabled')
            alert('Ocurrio un error conectando al servidor, intente de nuevo')
        })
    }
}
//ONTENER DATOS DE RADIO BUTTON
function obtenerEstado() {
    let i
    for (i = 0; i < document.getElementsByName('rb_estado').length; i++) {
        if (document.getElementsByName('rb_estado')[i].checked) {
            return document.getElementsByName('rb_estado')[i].value
        }
    }
}

function obtenerTransaccion() {
    let i
    for (i = 0; i < document.getElementsByName('rb_transaccion').length; i++) {
        if (document.getElementsByName('rb_transaccion')[i].checked) {
            return document.getElementsByName('rb_transaccion')[i].value
        }
    }
}

function obtenerTangible() {
    let i
    for (i = 0; i < document.getElementsByName('rb_tangible').length; i++) {
        if (document.getElementsByName('rb_tangible')[i].checked) {
            return document.getElementsByName('rb_tangible')[i].value
        }
    }
}
//MUESTRA EL FORMULARIO Y OCULTA LA TABLA
function opcionNuevo() {
    if (modificar) {
        opNuevo.innerHTML = "<i class='fas fa-edit fa-fw'></i> &nbsp; MODIFICAR"
    } else {
        opNuevo.innerHTML = "<i class='fas fa-edit fa-fw'></i> &nbsp; NUEVO"
    }
    opNuevo.className = "active"
    opLista.className = ""
    //swal("ERROR.", "AL OBTENER EL NUEVO CÓDIGO.", "info")
    btn_datosgenerales.className = "btn btn-lg btn-warning"
    btn_datosotros.className = "btn btn-lg btn-warning disabled"
    btn_anterior.className = "btn btn-raised btn-warning btn-sm disabled"
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroGeneral").slideDown("slow")
    $("#cuadroOtros").slideUp("slow")
    $("#cuadroTabla").slideUp("slow")
    $("#cuadroTablaDepreciacion").slideUp("slow")
    // $("#cuadroTabla").slideUp("slow")
    btn_guardar.innerHTML = "<i id='iconG' class='fas fa-arrow-circle-right'></i> &nbsp; SIGUIENTE";
    paso = 1
}
//MOSTRAR TABLA
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_datosgenerales').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
        codigoError.innerHTML = ""
    }
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTablaDepreciacion").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarActivos(1, cantidad.value, '', '')
}
//LISTAR ACTIVOS
function listarActivos(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        registros.innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        totalPaginas.innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        cuerpoTabla.innerHTML = respuesta['tabla']
        paginador.innerHTML = respuesta['paginador']
    })
}
//MUESTRAN LA TABLA Y OCULTA EL FORMULARIO
function opcionLista() {
    tabla()
    //limpiarFiltros()
}
//CARGA LA LISTA DE PUESTOS Y ABRE EL MODAL
function tablaModalDepartamento() {
    //cargarTipoactivo(1, 2, "", "")
    cargarDepartamento(1, 2, "", "")
}

function tablaModalTipoactivo() {
    //$('#ModalTipoactivo').modal('show')
    cargarTipoactivo(1, 2, "", "")
}

function cargarDepartamento(pagina, cantidad, campo, buscar) {
    // $('#ModalDepartamento').modal('show')
    /*
    swal("ERROR.", "LA MARCA YA HA SIDO ELIMINADA.", "info")*/
    const datos = new FormData()
    datos.append('opcion', 'obtenerDepartamento')
    datos.append('pagina', pagina)
    datos.append('cantidad', cantidad)
    datos.append('campo', campo)
    datos.append('buscar', buscar)
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        //swal("ERROR.", "LA MARCA YA HA SIDO ELIMINADA.", "info")
        document.getElementById('registrosDepartamento').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasDepartamento').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE " + respuesta['totalPagina']
        document.getElementById('cuerpoDepartamento').innerHTML = respuesta['tabla']
        document.getElementById('paginadorDepartamento').innerHTML = respuesta['paginador']
        $('#ModalDepartamento').modal('show')
    })
    organizadorTabla = 1
}

function cargarTipoactivo(pagina, cantidad, campo, buscar) {
    //$('#ModalTipoactivo').modal('show')
    /*
    swal("ERROR.", "LA MARCA YA HA SIDO ELIMINADA.", "info")*/
    const datos = new FormData()
    datos.append('opcion', 'obtenerTipoactivo')
    datos.append('pagina', pagina)
    datos.append('cantidad', cantidad)
    datos.append('campo', campo)
    datos.append('buscar', buscar)
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        //swal("ERROR.", "LA MARCA YA HA SIDO ELIMINADA.", "info")
        document.getElementById('registrosTipoactivo').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasTipoactivo').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE " + respuesta['totalPagina']
        document.getElementById('cuerpoTipoactivo').innerHTML = respuesta['tabla']
        document.getElementById('paginadorTipoactivo').innerHTML = respuesta['paginador']
        $('#ModalTipoactivo').modal('show')
    })
    organizadorTabla = 2
}
//GUARDAR Y MODIFICAR
function filtroCodigo() {
    if (txt_codigofiltro.value.length > 0) {
        cargarDepartamento(1, 2, "codigo", txt_codigofiltro.value)
    } else {
        cargarDepartamento(1, 2, "", "")
    }
}

function filtroDepartamento() {
    if (txt_departamentofiltro.value.length > 0) {
        cargarDepartamento(1, 2, "nombre", txt_departamentofiltro.value)
    } else {
        cargarDepartamento(1, 2, "", "")
    }
}
//FILTRO DE LOS ACTIVOS
function filtroUno() {
    if (txt_filtrouno.value.length > 0) {
        listarActivos(1, cantidad.value, "codigo", txt_filtrouno.value)
    } else {
        listarActivos(1, cantidad.value, "", "")
    }
}

function filtroDos() {
    if (txt_filtrodos.value.length > 0) {
        listarActivos(1, cantidad.value, "descripcion", txt_filtrodos.value)
    } else {
        listarActivos(1, cantidad.value, "", "")
    }
}

function filtroCodigoTipo() {
    if (txt_codigotipofiltro.value.length > 0) {
        cargarTipoactivo(1, 2, "codigo", txt_codigotipofiltro.value)
    } else {
        cargarTipoactivo(1, 2, "", "")
    }
}

function filtroTipo() {
    if (txt_tipofiltro.value.length > 0) {
        cargarTipoactivo(1, 2, "nombre", txt_tipofiltro.value)
    } else {
        cargarTipoactivo(1, 2, "", "")
    }
}
//SELECCIONA EL PUESTO
$(document).on('click', '.seleccion', function(e) {
    let fila = $(this).parents("tr").find("td")[1]
    let nombre = $(fila).html()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objseleccion')
    document.getElementById('txt_departamento').innerText = id
    document.getElementById('txt_departamentonombre').value = nombre
    let filacodigo = $(this).parents("tr").find("td")[0]
    codigoDepartamento = $(filacodigo).html()
    codigoActivo()
    $('#ModalDepartamento').modal('hide')
    organizadorTabla = 0
    /*if (!empty(codigoDepartamento) && !empty(codigoTipoactivo)) {
        document.getElementById('txt_codigo').value = codigoDepartamento + "-" + codigoTipoactivo
    }*/
})
//selecciona el tipo de activo
$(document).on('click', '.SELECCION', function(e) {
    let fila2 = $(this).parents("tr").find("td")[1]
    let nombre2 = $(fila2).html()
    let elemento2 = $(this)[0]
    let id2 = $(elemento2).attr('objseleccion')
    document.getElementById('txt_tipoactivo').innerText = id2
    document.getElementById('txt_tipoactivonombre').value = nombre2
    //document.getElementById('txt_codigo').value = id2.value
    let fila2codigo = $(this).parents("tr").find("td")[0]
    codigoTipoactivo = $(fila2codigo).html()
    codigoActivo()
    $('#ModalTipoactivo').modal('hide')
    organizadorTabla = 0
})

function codigoActivo() {
    if (codigoTipoactivo !== '' && codigoDepartamento !== '') {
        const datos = new FormData()
        datos.append('opcion', 'obtenerEmpresa')
        fetch(urlActivo, {
            method: 'POST',
            body: datos
        }).then(function(respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0] == null) {
                swal("NO ES POSIBLE MODIFICAR.", "LA MARCA YA HA SIDO ELIMINADA.", "info")
            } else {
                codigoEmpresa = respuesta[0]['codigo']
                //LUEGO ONTENER LA CANTIDAD DE REGISTROS
                ultimoCodigo()
                // document.getElementById('txt_codigoactivo').value = codigoEmpresa + "-" + codigoDepartamento + "-" + codigoTipoactivo
            }
        })
        // ultimoCodigo()
    }
}

function ultimoCodigo() {
    //swal("NO ES POSIBLE MODIFICAR.", "LA MARCA YA HA SIDO ELIMINADA.", "info")
    const datos = new FormData()
    datos.append('opcion', 'obtenerCantidad')
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta['totalRegistros'] == null) {
            //swal("NO ES POSIBLE MODIFICAR.", "LA MARCA nulas.", "info")
        } else {
            let total = respuesta['totalRegistros'] + 1
            if (total >= 0 && total < 10) {
                cantidadactivos = "000" + total
            } else if (total >= 10 && total < 100) {
                cantidadactivos = "00" + total
            } else if (total >= 100 && total < 1000) {
                cantidadactivos = "0" + total
            } else if (total >= 1000) {
                cantidadactivos = total
            }
            //LUEGO ONTENER LA CANTIDAD DE REGISTROS
            document.getElementById('txt_codigoactivo').value = codigoEmpresa + "-" + codigoDepartamento + "-" + codigoTipoactivo + "-" + cantidadactivos
        }
    })
}
//CONSULTA SI LOS DATOS PERSONALES DEL EMPLEADO SON UNICOS
function avanzaPaso2() {
    btn_anterior.className = "btn btn-raised btn-warning btn-sm"
    btn_datospersona.className = "btn btn-lg btn-info disabled"
    btn_contacto.className = "btn btn-lg btn-warning"
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroContacto").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")
    $("#cuadroPersonal").slideUp("slow")
    $("#cuadroPermiso").slideUp("slow")
    paso++
    btn_guardar.removeAttribute('disabled')
}
//GUARDA O MODIFICA LOS DATOS DEL EMPLEADO
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}
//CARGAR DEPRECIACION
function cargarDepreciacion(id) {
    //swal("LISTO PARA DE Y AMOR.", "LISTO PARA DEPRECIACION." + id, "info")
    const datos = new FormData()
    datos.append('id', id)
    datos.append('opcion', 'depreciacion')
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        if (respuesta['tabla'] == 2) {
            swal("ERROR.", "RECUPERADO HASTA EL ACTIVO", "info")
            //document.getElementById('cuerpoTablaDepreciacion').innerHTML = respuesta['tabla']
            //$("#cuadroTabla").slideUp("slow")
            //$("#cuadroTablaDepreciacion").slideDown("slow")
        } else {
            //swal("ERROR.", "OTROS DATOS", "info")
            document.getElementById('txt_codigorecuperado').innerHTML = respuesta['codigo']
            document.getElementById('txt_descripcionrecuperado').innerHTML = respuesta['etiqueta']
            document.getElementById('txt_montorecuperado').innerHTML = respuesta['monto']
            document.getElementById('txt_montodepreciar').innerHTML = respuesta['montodepreciar']
            document.getElementById('txt_vida').innerHTML = respuesta['vida']
            document.getElementById('txt_estadorecuperado').innerHTML = respuesta['estado']
            document.getElementById('txt_tiemporecuperado').innerHTML = respuesta['tiempousados']
            document.getElementById('txt_fechaadquicicion').innerHTML = respuesta['fechaadquicicion']
            document.getElementById('txt_iddiaria').innerText = respuesta['id']
            document.getElementById('cuerpoTablaDepreciacion').innerHTML = respuesta['tabla']
            if (respuesta['tangente'] == "TANGIBLE") {
                document.getElementById('txt_celdauno').innerHTML = "DEPRECIACIÓN ANUAL"
                document.getElementById('txt_celdados').innerHTML = "DEPRECIACIÓN ACUMULADA"
                document.getElementById('txt_depredia').innerHTML = "DEPRECIACIÓN DIARIA"
                document.getElementById('txt_depremes').innerHTML = "DEPRECIACIÓN MENSUAL"
            } else {
                document.getElementById('txt_celdauno').innerHTML = "AMORTIZACIÓN ANUAL"
                document.getElementById('txt_celdados').innerHTML = "AMORTIZACIÓN ACUMULADA"
                document.getElementById('txt_depredia').innerHTML = "AMORTIZACIÓN DIARIA"
                document.getElementById('txt_depremes').innerHTML = "AMORTIZACIÓN MENSUAL"
            }
            opLista.className = ""
            opNueva.className = ""
            $("#cuadroTabla").slideUp("slow")
            $("#cuadroFormulario").slideUp("slow")
            $("#cuadroTablaDepreciacion").slideDown("slow")
        }
    })
}
//DEPRECIACION DIARIA
//
function cargarDepreDiaria() {
    //swal("ERROR.", "PRIMER FILTRO", "info")
    const id = document.getElementById('txt_iddiaria').textContent
    cargarDepreciacionDiaria(id)
}

function cargarDepreMensual() {
    //swal("ERROR.", "PRIMER FILTRO", "info")
    const id = document.getElementById('txt_iddiaria').textContent
    cargarDepreciacionMensual(id)
}

function cargarDepreciacionDiaria(id) {
    //swal("LISTO PARA DE Y AMOR.", "LISTO PARA DEPRECIACION." + id, "info")
    const datos = new FormData()
    datos.append('id', id)
    datos.append('opcion', 'depreciacionDiaria')
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        if (respuesta['tabla'] == 2) {
            swal("ERROR.", "RECUPERADO HASTA EL ACTIVO", "info")
        } else {
            document.getElementById('txt_fechainicio').innerHTML = respuesta['fechainiciodia']
            document.getElementById('txt_fechacierre').innerHTML = respuesta['fechacierre']
            document.getElementById('txt_montocierre').innerHTML = respuesta['montofechacierre']
            document.getElementById('txt_fechaactual').innerHTML = respuesta['fechahoy']
            document.getElementById('txt_montoactual').innerHTML = respuesta['montoactual']
            document.getElementById('txt_montodiario').innerHTML = respuesta['montodiario']
            document.getElementById('txt_fechafinal').innerHTML = respuesta['fechafinal']
            document.getElementById('txt_montofinal').innerHTML = respuesta['montofinal']
            if (respuesta['tangente'] == "TANGIBLE") {
                document.getElementById('depreDia').innerHTML = "DEPRECIACIÓN DIARIA"
            } else {
                document.getElementById('depreDia').innerHTML = "AMORTIZACIÓN DIARIA"
            }
            $('#ModalDeprediaria').modal('show')
        }
    })
}
//DEPRECIACION MENSUAL
function cargarDepreciacionMensual(id) {
    // swal("LISTO PARA DE Y AMOR.", "LISTO PARA DEPRECIACION." + id, "info")
    const datos = new FormData()
    datos.append('id', id)
    datos.append('opcion', 'depreciacionMensual')
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        if (respuesta['tabla'] == 2) {
            swal("ERROR.", "RECUPERADO HASTA EL ACTIVO", "info")
        } else {
            //swal("ERROR.", "OTROS DATOS", "info")
            //swal("ERROR.", "HEMOS LLEGADO", "info")
            document.getElementById('txt_fechainiciomes').innerHTML = respuesta['primermes']
            document.getElementById('txt_montomensual').innerHTML = respuesta['montomensual']
            document.getElementById('txt_montodos').innerHTML = respuesta['montocierremensual']
            document.getElementById('txt_fechados').innerHTML = respuesta['fechacierre']
            document.getElementById('txt_montoultimo').innerHTML = respuesta['montoultimo']
            document.getElementById('txt_fechaultima').innerHTML = respuesta['fechaultima']
            document.getElementById('txt_fechaactualmes').innerHTML = respuesta['fechaactualmes']
            document.getElementById('txt_montoactualmes').innerHTML = respuesta['montoactualmes']
            if (respuesta['tangente'] == "TANGIBLE") {
                document.getElementById('depreMes').innerHTML = "DEPRECIACIÓN MENSUAL"
            } else {
                document.getElementById('depreMes').innerHTML = "AMORTIZACIÓN MENSUAL"
            }
            $('#ModalDepreMensual').modal('show')
        }
    })
}
//EVENTO DEL COMBO PARA SELECCIONAR LA CANTIDAD DE REGISTROS A MOSTRAR
function comboListado(e) {
    e.preventDefault()
    listarActivos(1, cantidad.value, '', '')
}
//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    if (organizadorTabla == 1) {
        cargarDepartamento(pagina, cantidad.value, "", "")
    } else if (organizadorTabla == 2) {
        cargarTipoactivo(pagina, cantidad.value, "", "")
    } else if (organizadorTabla == 0) {
        listarActivos(pagina, cantidad.value, '', '')
    }
    //listarEmpleado(pagina, cantidad.value, '', '')
})
$(document).on('click', '.siguiente', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    if (organizadorTabla == 1) {
        cargarDepartamento(pagina, cantidad.value, "", "")
    } else if (organizadorTabla == 2) {
        cargarTipoactivo(pagina, cantidad.value, "", "")
    } else if (organizadorTabla == 0) {
        listarActivos(pagina, cantidad.value, '', '')
    }
    // listarEmpleado(pagina, cantidad.value, '', '')
})
//OBTIENE LOS DATOS PARA MODIFICAR
$(document).on('click', '.editar', function() {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeditar')
    cargarActivo(id)
})

function cargarActivo(id) {
    const datos = new FormData()
    datos.append('id', id)
    datos.append('opcion', 'obtener')
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "", "info")
        } else {
            //document.getElementById('txt_departamento').innerText = 
            txt_id.value = respuesta[0]['id']
            document.getElementById('txt_codigoactivo').value = respuesta[0]['codigo']
            document.getElementById('txt_departamento').innerText = respuesta[0]['id_departamento']
            document.getElementById('txt_tipoactivo').innerText = respuesta[0]['id_tipoactivo']
            document.getElementById('txt_descripcion').value = respuesta[0]['descripcion']
            document.getElementById('txt_serie').value = respuesta[0]['serie']
            document.getElementById('txt_marca').value = respuesta[0]['marca']
            document.getElementById('txt_modelo').value = respuesta[0]['modelo']
            document.getElementById('txt_color').value = respuesta[0]['color']
            document.getElementById('txt_fechaoculta').value = respuesta[0]['fecha']
            if (respuesta[0]['estado'] == "NUEVO") {
                document.getElementById('r1').checked = true
            } else if (respuesta[0]['estado'] == "USADO") {
                document.getElementById('r2').checked = true
            }
            if (respuesta[0]['transaccion'] == "COMPRA") {
                document.getElementById('r1t').checked = true
            } else if (respuesta[0]['transaccion'] == "DONACION") {
                document.getElementById('r2t').checked = true
            }
            // document.getElementById('txt_porcentaje').value = respuesta[0]['porcentaje']
            document.getElementById('txt_tiempousado').value = respuesta[0]['tiempo_usado']
            document.getElementById('txt_maximo').value = respuesta[0]['porcentaje']
            document.getElementById('txt_monto').value = respuesta[0]['monto']
            document.getElementById('txt_ubicacion').value = respuesta[0]['ubicacion']
            if (respuesta[0]['tanintan'] == "TANGIBLE") {
                document.getElementById('r1tangible').checked = true
            } else if (respuesta[0]['tanintan'] == "INTANGIBLE") {
                document.getElementById('r2tangible').checked = true
            }
            document.getElementById('txt_codigoactivo').setAttribute('readonly', 'true')
            modificar = true
            //OCULTA TABLA Y MUESTRA EL FORMULARIO
            opNueva.className = "active";
            opLista.className = "";
            modificar = true
            opNueva.innerHTML = "<i class='fas fa-edit fa-fw'></i> &nbsp; MODIFICAR"
            btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; MODIFICAR"
            $("#cuadroFormulario").slideDown("slow")
            $("#cuadroGeneral").slideDown("slow")
            $("#cuadroOtros").slideUp("slow")
            $("#cuadroTabla").slideUp("slow")
        }
    })
}
$(document).on('click', '.ver', function() {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objver')
    cargarDepreciacion(id)
})
//DAR DE BAJA
$(document).on('click', '.eliminar', function() {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeliminar')
    document.getElementById('txt_id_activo').innerText = id
    $('#ModalBajaActivo').modal('show')
    //cargarFormulario(id)
})
//DAR DE BAJA
function baja() {
    const id = document.getElementById('txt_id_activo').textContent
    darbaja(id)
}

function darbaja(id) {
    //swal("LISTO PARA DE Y AMOR.", "LISTO PARA DEPRECIACION." + id, "info")
    let baja = "";
    for (i = 0; i < document.getElementsByName('rb_baja').length; i++) {
        if (document.getElementsByName('rb_baja')[i].checked) {
            baja = document.getElementsByName('rb_baja')[i].value
        }
    }
    //swal("LISTO PARA DE Y AMOR.", "LISTO PARA DEPRECIACION. " + baja, "info")
    const datos = new FormData()
    datos.append('id', id)
    datos.append('opcion', baja)
    datos.append('txt_montoventaactivo', document.getElementById('txt_montoventaactivo').value)
    datos.append('txt_adquisitor', document.getElementById('txt_adquisitor').value)
    datos.append('txt_duicodigo', document.getElementById('txt_duicodigo').value)
    $('#ModalBajaActivo').modal('hide') //SI SE CIERRA ANTES NO RECUPERA LOS DATOS QUE ESTEN DENTRO DEL MODAL
    fetch(urlActivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        if (respuesta[0].estado == 1) {
            mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            listarActivos(1, cantidad.value, '', '')
        } else {
            mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
        }
    })
    //OTRA CONDICION 
}

function validaEstado() {
    let i
    let valido = false
    for (i = 0; i < document.getElementsByName('rb_estado').length; i++) {
        if (document.getElementsByName('rb_estado')[i].checked) {
            valido = true
            break;
        }
    }
    if (valido) {
        document.getElementById('estadoerror').innerHTML = ""
    } else {
        document.getElementById('estadoerror').innerHTML = "<span class='error'>Este campo es obligatorio.</span>"
    }
    return valido
}

function validaTransaccion() {
    let i
    let valido = false
    for (i = 0; i < document.getElementsByName('rb_transaccion').length; i++) {
        if (document.getElementsByName('rb_transaccion')[i].checked) {
            valido = true
            break;
        }
    }
    if (valido) {
        document.getElementById('transaccionerror').innerHTML = ""
    } else {
        document.getElementById('transaccionerror').innerHTML = "<span class='error'>Este campo es obligatorio.</span>"
    }
    return valido
}

function validaTangible() {
    let i
    let valido = false
    for (i = 0; i < document.getElementsByName('rb_tangible').length; i++) {
        if (document.getElementsByName('rb_tangible')[i].checked) {
            valido = true
            break;
        }
    }
    if (valido) {
        document.getElementById('tangibleerror').innerHTML = ""
    } else {
        document.getElementById('tangibleerror').innerHTML = "<span class='error'>Este campo es obligatorio.</span>"
    }
    return valido
}