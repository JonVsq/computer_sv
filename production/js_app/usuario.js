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
const txt_buscarEmpleado = document.getElementById('txt_buscarEmpleado')

//FORMULARIO
const spn_empleado = document.getElementById('spn_empleado')
const btn_modalEmpleado = document.getElementById('btn_modalEmpleado')
const txt_idEmpleado = document.getElementById('txt_idEmpleado')
const txt_correo= document.getElementById('txt_correo')
const txt_ac = document.getElementById('txt_ac')
const txt_contra = document.getElementById('txt_contra')


const correoError = document.getElementById('correoError')
const acError = document.getElementById('acError')
const contraError = document.getElementById('contraError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
const md_datosUsuario = document.getElementById('md_datosUsuario')
//DIRECCION CONTROLADORES
let urlUsuario = '../../controlador/UsuarioController.php'
let modificar = false
let paginaEmpleado = 1
let campoEmpleado = ''
let buscarEmpleado = ''

let cantida = 10
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarUsuario(1, cantidad.value, '', '')
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
    btn_modalEmpleado.addEventListener("click", modalEmpleado)
   
    txt_buscarEmpleado.addEventListener("keyup", filtroEmpleado)
    btn_guardar.addEventListener("click", guardarModificarUsuario)
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
       
        txt_idEmpleado.value = ""
        spn_empleado.className = "text-danger"
        
        spn_empleado.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE EMPLEADO"
        document.getElementById('frm_Usuario').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    acError.innerHTML = ""
    contraError.innerHTML = ""
    correoError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    if (modificar) {
        modificar = false;
        txt_idEmpledo.value = ""
        
        spn_empleado.className = "text-danger"
        spn_empleado.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE EMPLEADO"
        document.getElementById('frm_Usuario').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    acError.innerHTML = ""
    contraError.innerHTML = ""
    correoError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarUsuario(1, cantidad.value, '', '')

}

function guardarModificarUsuario() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        if (txt_idEmpleado.value != "") {
            const datos = new FormData(document.getElementById('frm_Usuario'))
            if (modificar) {
                datos.append('id', txt_id.value)
                datos.append('opcion', 'modificar')
            } else {
                datos.append('opcion', 'insertar')
            }
            fetch(urlUsuario, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                }
            }).then(respuesta => {
                if (respuesta[0].estado == 1) {
                    tabla()
                    listarUsuario(1, cantidad.value, '', '')
                    txt_idEmpleado.value = ""
                    
                    spn_empleado.className = "text-danger"
                   
                    spn_empleado.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE EMPLEADO"
                    mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                    document.getElementById('frm_Usuario').reset()
                } else {
                    if (respuesta[0].errores[0].producto > 0) {
                        correoError.innerHTML = "<span class='error'>Ingrese otro correo.</span>"
                    } else {
                        correoError.innerHTML = ""
                    }
                    
                }
                btn_guardar.removeAttribute('disabled')
            }).catch(error => {
                console.log(error)
                btn_guardar.removeAttribute('disabled')
                alert('Ocurrio un error conectando al servidor, intente de nuevo')
            })
        } else {
            btn_guardar.removeAttribute('disabled')
        }
    }
}
function listarUsuario(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlUsuario, {
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
function modalEmpleado() {
    const datos = new FormData()
    datos.append('opcion', 'modalEmpleado')
    datos.append('pagina', paginaEmpleado)
    datos.append('campoMarca', campoEmpleado)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarEmpleado)
    fetch(urlUsuario, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaEmpleado').innerHTML = respuesta['tabla']
        document.getElementById('registrosEmpleado').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasEmpleado').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorEmpleado').innerHTML = respuesta['paginador']
        $('#ModalEmpleado').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}


//BUSQUEDA FILTRADA
function filtroEmpleado() {
    if (txt_buscarEmpleado.value.length > 0) {
        campoEmpleado = 'nombres'
        buscarEmpleado = txt_buscarEmpleado.value
        modalEmpleado()
    } else {
        campoEmpleado= ''
        buscarEmpleado = ''
        modalEmpleado()
    }
}

//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pag = $(elemento).attr('pag')
     if ($('#ModalEmpleado').is(':visible')) {
        paginaEmpleado = pag
        modalEmpleado()
    } else {
        //listarSolicitudes(pag, cantidad.value, '', '')
    }

})
$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pag = $(elemento).attr('pag')
     if ($('#ModalEmpleado').is(':visible')) {
        paginaEmpleado = pag
       
        modalEmpleado()
    } else {
        //listarSolicitudes(pag, cantidad.value, '', '')
    }
})


$(document).on('click', '.seleccion', function (e) {
    let fila = $(this).parents("tr").find("td")[0]
    let nombre = $(fila).html()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objseleccion')
    console.log(id + " " + nombre)
     if ($('#ModalEmpleado').is(':visible')) {
        spn_empleado.className = ""
        spn_empleado.innerText = nombre
        txt_idEmpleado.value = id
        paginaEmpleado = 1
        campoEmpleado = ''
        buscarEmpleado = ''
        $('#ModalEmpleado').modal('hide')
    } else {
    }
})
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
    fetch(urlUsuario, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "EL USUARIO YA HA SIDO ELIMINADO.", "info")
        } else {
            txt_id.value = respuesta[0]['id']
            txt_idEmpleado.value = respuesta[0]['id_empleado']
           
            spn_empleado.innerText = respuesta[0]['nombres']
            spn_empleado.className = ""
           
            txt_correo.value = respuesta[0]['correo']
            txt_contra.value = respuesta[0]['pass']
            txt_ac.value = respuesta[0]['acceso']
            
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
//OBTIENE LOS DATOS PARA VISUALIZAR EN EL MODAL
$(document).on('click', '.ver', function () {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objver')
    cargarModal(id)
})

function cargarModal(id) {
    const datos = new FormData()
    datos.append('opcion', 'modal')
    datos.append('id', id)
    fetch(urlUsuario, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        md_datosProducto.innerHTML = respuesta['modalCuerpo']
        $('#ModalUsuario').modal('show')
    }).catch(error => {
        alert('OCURRIO UN ERROR CONECTANDO CON EL SERVIDOR, INTENTE DE NUEVO.')
    })

}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}