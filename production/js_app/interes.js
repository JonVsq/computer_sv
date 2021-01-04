//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_plazofiltro = document.getElementById('txt_plazofiltro')
const txt_interesfiltro = document.getElementById('txt_interesfiltro')
const txt_id = document.getElementById('txt_id')
//FORMULARIO
const txt_plazo = document.getElementById('txt_plazo')
const txt_porcentaje = document.getElementById('txt_porcentaje')
const plazoError = document.getElementById('plazoError')
const porcentajeError = document.getElementById('porcentajeError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
// DIRECCION CONTROLADORES
let urlInteres = '../../controlador/InteresController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarInteres(1, cantidad.value, '', '')
    btn_guardar.addEventListener("click", guardarModificarInteres)
    cantidad.addEventListener("change", comboListado)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
    txt_interesfiltro.addEventListener("keyup", filtroPorcentaje)
    txt_plazofiltro.addEventListener("keyup", filtroPlazo)
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_interes').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
        porcentajeError.innerHTML = ""
        plazoError.innerHTML = ""

    }
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_interes').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
        porcentajeError.innerHTML = ""
        plazoError.innerHTML = ""

    }
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarInteres(1, cantidad.value, '', '')

}
function guardarModificarInteres() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_interes'))
        if (modificar) {
            datos.append('id', txt_id.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlInteres, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                tabla()
                listarInteres(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                porcentajeError.innerHTML = ""
                plazoError.innerHTML = ""
                document.getElementById('frm_interes').reset()
            } else {
                if (respuesta[0].errores[0].plazo > 0) {
                    plazoError.innerHTML = "<span class='error'>Ingrese otro plazo.</span>"
                } else {
                    plazoError.innerHTML = ""
                }
                if (respuesta[0].errores[1].porcentaje > 0) {
                    porcentajeError.innerHTML = "<span class='error'>Ingrese otro porcentaje.</span>"
                } else {
                    porcentajeError.innerHTML = ""
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
function listarInteres(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlInteres, {
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
//OBTIENE LOS DATOS PARA MODIFICAR
$(document).on('click', '.editar', function () {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeditar')
    cargarFormulario(id)
})
function cargarFormulario(id) {
    const datos = new FormData()
    datos.append('id', id)
    datos.append('opcion', 'obtener')
    fetch(urlInteres, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "EL INTERES YA HA SIDO ELIMINADO.", "info")
        } else {
            txt_id.value = respuesta[0]['id']
            txt_plazo.value = respuesta[0]['plazo']
            txt_porcentaje.value = respuesta[0]['porcentaje']
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
//EVENTO DEL COMBO PARA SELECCIONAR LA CANTIDAD DE REGISTROS A MOSTRAR
function comboListado() {
    listarInteres(1, cantidad.value, '', '')
}

//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarInteres(pagina, cantidad.value, '', '')
})

$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarInteres(pagina, cantidad.value, '', '')
})
//BUSQUEDA FILTRADA
function filtroPlazo() {
    if (txt_plazofiltro.value.length > 0) {
        txt_porcentaje.value = ""
        listarInteres(1, cantidad.value, 'plazo', txt_plazofiltro.value)
    } else {
        listarInteres(1, cantidad.value, '', '')
    }
}
function filtroPorcentaje() {
    if (txt_interesfiltro.value.length > 0) {
        txt_plazofiltro.value = ""
        listarInteres(1, cantidad.value, 'porcentaje', txt_interesfiltro.value)
    } else {
        listarInteres(1, cantidad.value, '', '')
    }
}

//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}