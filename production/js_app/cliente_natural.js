//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_duiFiltro = document.getElementById('txt_duiFiltro')
const txt_nitFiltro = document.getElementById('txt_nitFiltro')
const txt_codigo = document.getElementById('txt_codigo')
const txt_fechaIngreso = document.getElementById('txt_fechaIngreso')
const spn_codigo = document.getElementById('spn_codigo')
const md_datosCliente = document.getElementById('md_datosCliente')
//FORMULARIO
const txt_nombre = document.getElementById('txt_nombre')
const txt_telefono = document.getElementById('txt_telefono')
const txt_direccion = document.getElementById('txt_direccion')
const txt_dui = document.getElementById('txt_dui')
const txt_nit = document.getElementById('txt_nit')
const txt_lugarTrabajo = document.getElementById('txt_lugarTrabajo')
const txt_ingresos = document.getElementById('txt_ingresos')
const txt_egresos = document.getElementById('txt_egresos')
const txt_estadoCivil = document.getElementById('txt_estadoCivil')
const nombreError = document.getElementById('nombreError')
const nitError = document.getElementById('nitError')
const duiError = document.getElementById('duiError')
const telefonoError = document.getElementById('telefonoError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlClienteN = '../../controlador/ClienteNaturalController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarClienteN(1, cantidad.value, '', '')
    cantidad.addEventListener("change", comboListado)
    btn_guardar.addEventListener("click", guardarModificarClienteN)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
    txt_duiFiltro.addEventListener("keyup", filtroDui)
    txt_nitFiltro.addEventListener("keyup", filtroNit)
}
function opcionNuevo() {
    txt_dui.removeAttribute('readonly')
    txt_nit.removeAttribute('readonly')
    if (modificar) {
        modificar = false;
        document.getElementById('frm_clienteN').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    } else {
        generarCodigo()
    }
    nombreError.innerHTML = ""
    nitError.innerHTML = ""
    duiError.innerHTML = ""
    telefonoError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    txt_dui.removeAttribute('readonly')
    txt_nit.removeAttribute('readonly')
    if (modificar) {
        modificar = false;
        document.getElementById('frm_clienteN').reset();
        txt_codigo.value = ""
        txt_fechaIngreso.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    nitError.innerHTML = ""
    duiError.innerHTML = ""
    telefonoError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarClienteN(1, cantidad.value, '', '')

}
function guardarModificarClienteN() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_clienteN'))
        datos.append('txt_codigo', txt_codigo.value)
        if (modificar) {
            datos.append('txt_fechaIngreso', txt_fechaIngreso.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlClienteN, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            console.log(respuesta)
            if (respuesta[0].estado == 1) {
                txt_dui.removeAttribute('readonly')
                txt_nit.removeAttribute('readonly')
                tabla()
                listarClienteN(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                document.getElementById('frm_clienteN').reset()
            } else {
                if (respuesta[0].errorC[0].nombre > 0) {
                    nombreError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    nombreError.innerHTML = ""
                }
                if (respuesta[0].errorC[1].telefono > 0) {
                    telefonoError.innerHTML = "<span class='error'>Ingrese otro télefono.</span>"
                } else {
                    telefonoError.innerHTML = ""
                }
                if (respuesta[0].errorD[0].dui > 0) {
                    duiError.innerHTML = "<span class='error'>Ingrese otro DUI.</span>"
                } else {
                    duiError.innerHTML = ""
                }
                if (respuesta[0].errorD[1].nit > 0) {
                    nitError.innerHTML = "<span class='error'>Ingrese otro NIT.</span>"
                } else {
                    nitError.innerHTML = ""
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
$(document).on('click', '.editar', function () {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeditar')
    cargarFormulario(id)
})
function cargarFormulario(id) {
    const datos = new FormData()
    datos.append('txt_codigo', id)
    datos.append('opcion', 'obtener')
    fetch(urlClienteN, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "EL CLIENTE YA HA SIDO ELIMINADO.", "info")
        } else {
            txt_nit.setAttribute('readonly', 'true')
            txt_dui.setAttribute('readonly', 'true')
            txt_codigo.value = respuesta[0]['codigo']
            txt_fechaIngreso.value = respuesta[0]['fecha_ingreso']
            txt_dui.value = respuesta[0]['dui']
            txt_nit.value = respuesta[0]['nit']
            txt_nombre.value = respuesta[0]['nombre']
            txt_telefono.value = respuesta[0]['telefono']
            txt_direccion.value = respuesta[0]['direccion']
            txt_lugarTrabajo.value = respuesta[0]['lugar_trabajo']
            txt_ingresos.value = respuesta[0]['ingresos']
            txt_egresos.value = respuesta[0]['egresos']
            txt_estadoCivil.value = respuesta[0]['estado_civil']
            spn_codigo.innerHTML = "<span class='text text-info tex-center roboto-medium'>CODIGO: " + respuesta[0]['codigo'] + ".</span>"
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

function generarCodigo() {
    let caracteres = "AMN0QWA1SGF2PLI3KZLJ4VCS5KAQ6TEUY7JAHJSJ8JJSA9"
    let array = caracteres.split("")
    let codigo = ""
    for (let index = 0; index < 6; index++) {
        codigo = codigo + array[random(0, array.length - 1)]
    }
    txt_codigo.value = codigo
    spn_codigo.innerHTML = "<span class='text text-info tex-center roboto-medium'>EL CODIGO DE ESTE CLIENTE SERA: " + codigo + ".</span>"
}
function random(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min
}
//OBTIENE LOS DATOS PARA VISUALIZAR EN EL MODAL
$(document).on('click', '.ver', function () {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objver')
    cargarModal(id)
})

function cargarModal(id) {
    const datos = new FormData()
    datos.append('opcion', 'modal')
    datos.append('txt_codigo', id)
    fetch(urlClienteN, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        md_datosCliente.innerHTML = respuesta['modalCuerpo']
        $('#ModalCliente').modal('show')
    }).catch(error => {
        alert('OCURRIO UN ERROR CONECTANDO CON EL SERVIDOR, INTENTE DE NUEVO.')
    })

}
function listarClienteN(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlClienteN, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        registros.innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        totalPaginas.innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        cuerpoTabla.innerHTML = respuesta['tabla']
        paginador.innerHTML = respuesta['paginador']
    }).catch(error => {
        alert('Ocurrio un error conectado al servidor, intente de nuevo')
    })
}
//EVENTO DEL COMBO PARA SELECCIONAR LA CANTIDAD DE REGISTROS A MOSTRAR
function comboListado() {
    listarClienteN(1, cantidad.value, '', '')
}
//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarClienteN(pagina, cantidad.value, '', '')
})

$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarClienteN(pagina, cantidad.value, '', '')
})
//BUSQUEDA FILTRADA
function filtroDui() {

    if (txt_duiFiltro.value.length > 0) {
        txt_nitFiltro.value = ""
        listarClienteN(1, cantidad.value, 'dui', txt_duiFiltro.value)
    } else {
        listarClienteN(1, cantidad.value, '', '')
    }
}
function filtroNit() {

    if (txt_nitFiltro.value.length > 0) {
        txt_duiFiltro.value = ""
        listarClienteN(1, cantidad.value, 'nit', txt_nitFiltro.value)
    } else {
        listarClienteN(1, cantidad.value, '', '')
    }
}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}
//ELIMINAR
$(document).on('click', '.eliminar', function (e) {
    e.preventDefault()
    let filaNombre = $(this).parents("tr").find("td")[2]
    let nombre = $(filaNombre).html()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeliminar')
    confirmarEliminacion("ELIMINAR CLIENTE: " + nombre, "ESTA SEGURO?", "warning", id)
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
    }, function (isConfirm) {
        if (isConfirm) {
            const datos = new FormData()
            datos.append('txt_codigo', idEliminar)
            datos.append('opcion', 'eliminar')
            fetch(urlClienteN, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarClienteN(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            }).catch(error => {
                console.log(error)
                alert("OCURRIO UN ERROR CONECTANDO CON EL SERVIDOR, VERIFIQUE SU CONEXION A INTERNET E INTENTE DE NUEVO ")
            })
        } else {
            swal("CANCELADO", "EL REGISTRO SE CONSERVA INTACTO", "info");
        }
    });
}