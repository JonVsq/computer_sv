//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_nombrefiltro = document.getElementById('txt_nombrefiltro')
const txt_id = document.getElementById('txt_id')
//FORMULARIO
const txt_codigo = document.getElementById('txt_codigo')
const txt_nombre = document.getElementById('txt_nombre')
const rb_porcentaje = document.getElementById('rb_porcentaje')
const codigoError = document.getElementById('codigoError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlTipoactivo = '../../controlador/TipoactivoController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    //$("#cuadroFormulario").slideUp("slow")
    listarTipoactivo(1, cantidad.value, '', '')
    txt_nombrefiltro.addEventListener("keyup", filtroNombre)
    cantidad.addEventListener("change", comboListado)
    btn_guardar.addEventListener("click", guardarModificarTipoactivo)
    btn_limpiar.addEventListener("click", Limpiar)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
}

function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_Tipoactivo').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
        codigoError.innerHTML = ""
    }
    const datos = new FormData()
    datos.append('opcion', 'obtenercodigo')
    fetch(urlTipoactivo, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0].estado == 2) {
            document.getElementById('txt_codigo').value = 8871
        } else {
            // document.getElementById('txt_codigo').value = 8871
            document.getElementById('txt_codigo').value = respuesta[0]['codigo'] + 1
        }
    })
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")
}

function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_Tipoactivo').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
        codigoError.innerHTML = ""
    }
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarTipoactivo(1, cantidad.value, '', '')
}

function guardarModificarTipoactivo() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    let errorporcentaje = validaPorcentaje()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else if (!errorporcentaje) {
        swal("DATOS INCOMPLETOS.", "SELECCIONE LA VIDA ÚTIL", "info")
        btn_guardar.removeAttribute('disabled')
    } else {
        const datos = new FormData(document.getElementById('frm_Tipoactivo'))
        if (modificar) {
            datos.append('id', txt_id.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlTipoactivo, {
            method: 'POST',
            body: datos
        }).then(function(respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                listarTipoactivo(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                codigoError.innerHTML = ""
                document.getElementById('frm_Tipoactivo').reset()
                if (modificar) {
                    modificar = false;
                    opLista.className = "active"
                    opNueva.className = ""
                    $("#cuadroFormulario").slideUp("slow")
                    $("#cuadroTabla").slideDown("slow")
                    listarTipoactivo(1, cantidad.value, '', '')
                    opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
                    btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
                } else {
                    const datos = new FormData()
                    datos.append('opcion', 'obtenercodigo')
                    fetch(urlTipoactivo, {
                        method: 'POST',
                        body: datos
                    }).then(function(respuesta) {
                        if (respuesta.ok) {
                            return respuesta.json()
                        }
                    }).then(respuesta => {
                        if (respuesta[0] == null) {
                            swal("ERROR.", "AL OBTENER EL NUEVO CÓDIGO.", "info")
                        } else {
                            if (respuesta[0]['codigo'] == 0) {
                                document.getElementById('txt_codigo').value = 8871
                            } else {
                                document.getElementById('txt_codigo').value = respuesta[0]['codigo'] + 1
                            }
                        }
                    })
                }
            } else {
                if (respuesta[0].errores[0].nombre > 0) {
                    codigoError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    codigoError.innerHTML = ""
                }
            }
            btn_guardar.removeAttribute('disabled')
        }).catch(error => {
            console.log(error)
            btn_guardar.removeAttribute('disabled')
            alert('Ocurrio un error conectando al servidor, intente de nuevo')
        })
    }
}
//OBTIENE LOS DATOS PARA MODIFICAR
$(document).on('click', '.editar', function() {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeditar')
    cargarFormulario(id)
})

function cargarFormulario(id) {
    const datos = new FormData()
    datos.append('id', id)
    datos.append('opcion', 'obtener')
    fetch(urlTipoactivo, {
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
            //swal("ES POSIBLE MODIFICAR.", "LA MARCA YA HA SIDO ELIMINADA.", "info")
            txt_id.value = respuesta[0]['id']
            document.getElementById('txt_codigo').value = respuesta[0]['codigo']
            document.getElementById('txt_nombre').value = respuesta[0]['nombre']
            if (respuesta[0]['porcentaje'] == 5.0) {
                document.getElementById('r1').checked = true
            } else if (respuesta[0]['porcentaje'] == 20.0) {
                document.getElementById('r2').checked = true
            } else if (respuesta[0]['porcentaje'] == 25.0) {
                document.getElementById('r3').checked = true
            } else if (respuesta[0]['porcentaje'] == 50.0) {
                document.getElementById('r4').checked = true
            }
            // document.getElementById('txt_porcentaje').value = respuesta[0]['porcentaje']
            document.getElementById('txt_codigo').setAttribute('readonly', 'true')
            modificar = true
            //OCULTA TABLA Y MUESTRA EL FORMULARIO
            opNueva.className = "active";
            opLista.className = "";
            modificar = true
            opNueva.innerHTML = "<i class='fas fa-edit fa-fw'></i> &nbsp; MODIFICAR"
            btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; MODIFICAR"
            $("#cuadroFormulario").slideDown("slow")
            $("#cuadroTabla").slideUp("slow")
        }
    })
}

function validaPorcentaje() {
    let i
    let valido = false
    for (i = 0; i < document.getElementsByName('rb_porcentaje').length; i++) {
        if (document.getElementsByName('rb_porcentaje')[i].checked) {
            valido = true
            break;
        }
    }
    if (valido) {
        document.getElementById('porcentajeerror').innerHTML = ""
    } else {
        document.getElementById('porcentajeerror').innerHTML = "<span class='error'>Este campo es obligatorio.</span>"
    }
    return valido
}

function listarTipoactivo(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlTipoactivo, {
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
//EVENTO DEL COMBO PARA SELECCIONAR LA CANTIDAD DE REGISTROS A MOSTRAR
function comboListado() {
    listarTipoactivo(1, cantidad.value, '', '')
}
//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarTipoactivo(pagina, cantidad.value, '', '')
})
$(document).on('click', '.siguiente', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarTipoactivo(pagina, cantidad.value, '', '')
})
//ELIMINAR TIPO DE ACTIVO
$(document).on('click', '.eliminar', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeliminar')
    confirmarEliminacion("ELIMINAR TIPO DE ACTIVO", "ESTA SEGURO?", "warning", id)
})

function confirmarEliminacion(titulo, msj, tipo, idEliminar) {
    swal({
        title: titulo,
        text: msj,
        type: tipo,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "SI",
        cancelButtonText: "NO",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function(isConfirm) {
        if (isConfirm) {
            const datos = new FormData()
            datos.append('id', idEliminar)
            datos.append('opcion', 'eliminar')
            fetch(urlTipoactivo, {
                method: 'POST',
                body: datos
            }).then(function(respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarTipoactivo(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            })
        } else {
            swal("CANCELADO", "EL REGISTRO SE CONSERVA INTACTO", "info");
        }
    });
}
//BUSQUEDA FILTRADA
function filtroNombre() {
    if (txt_nombrefiltro.value.length > 0) {
        listarTipoactivo(1, cantidad.value, 'nombre', txt_nombrefiltro.value)
    } else {
        listarTipoactivo(1, cantidad.value, '', '')
    }
}
//FUNCION LIMPIAR
function Limpiar() {
    document.getElementById('txt_nombre').value = "";
}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}