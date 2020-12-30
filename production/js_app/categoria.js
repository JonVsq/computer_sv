//CONSTANTES
const opLista = document.getElementById('opLista')
const opNuevo = document.getElementById('opNueva')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const cantidad = document.getElementById('cantidad')
const txt_nombrefiltro = document.getElementById('txt_nombrefiltro')
const txt_descripfiltro = document.getElementById('txt_descripfiltro')
const btn_limpiar = document.getElementById('btn_limpiar')
//CONTROLA SI EL USUARIO VA REALIZAR UNA MODIFICACION
const txt_idmodificar = document.getElementById('txt_idmodificar')
let modificar = false
//HASTA QUE LA PAGINA SE CARGA SE INICIAN LOS EVENTOS
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS DEL DOM
function inicio() {
    listarCategoria(1, cantidad.value, '', '')
    opNuevo.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_limpiar.addEventListener("click", limpiarFormulario)
    btn_listar.addEventListener("click", tabla)
    btn_guardar.addEventListener("click", guardarModificar)
    cantidad.addEventListener("change", comboListado)
    txt_nombrefiltro.addEventListener('keyup', filtroNombre)
    txt_descripfiltro.addEventListener('keyup', filtroDescripcion)
}
var intervalo = setInterval(() => {
    listarCategoria(1, cantidad.value, '', '')
}, 300000);
//MUESTRA EL FORMULARIO Y OCULTA LA TABLA
function opcionNuevo(e) {
    e.preventDefault()
    if (modificar) {
        limpiar()
    }
    opNuevo.className += "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
//MUESTRA LA TABLA Y OCULTA EL FORMULARIO
function tabla(e) {
    e.preventDefault()
    if (modificar) {
        limpiar()
    }
    limpiarFormulario()
    opLista.className = "active"
    opNuevo.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarCategoria(1, cantidad.value, '', '')

}
//LIMPIA LOS MENSAJES DE VALIDACION
function limpiarFormulario() {
    var formCategoria = $("#cuadroFormulario form").validate();
    formCategoria.resetForm();
    document.getElementById('nombreerror').innerHTML = ""
    document.getElementById('pagoserror').innerHTML = ""
    document.getElementById('prestamoserror').innerHTML = ""
    document.getElementById('descripcionerror').innerHTML = ""
    var formCategoria = $("#cuadroFormulario form").validate();
    formCategoria.resetForm();
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
    fetch('../controlador/CategoriaController.php', {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "LA CATEGORIA YA HA SIDO ELIMINADA.", "info")
        } else {
            txt_idmodificar.value = respuesta[0].id
            txt_nombrec.value = respuesta[0].nombre
            txt_numpagos.value = respuesta[0].max_atraso
            txt_prestamos.value = respuesta[0].prestamos
            txt_descripcion.value = respuesta[0].descripcion
            //OCULTA TABLA Y MUESTRA EL FORMULARIO
            opNuevo.className += "active";
            opLista.className = "";
            modificar = true
            opNuevo.innerHTML = "<i class='fas fa-edit fa-fw'></i> &nbsp; MODIFICAR"
            btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; MODIFICAR"
            $("#cuadroFormulario").slideDown("slow")
            $("#cuadroTabla").slideUp("slow")
        }

    })
}
//INSERTAR O MODIFICAR DATOS
function guardarModificar() {

    btn_guardar.setAttribute('disabled', 'true')
    let $valid = $('#cuadroFormulario form').valid()
    if (!$valid) {
        btn_guardar.removeAttribute('disabled')
        return false
    } else {
        const datos = new FormData(document.getElementById('frm_categoria'))
        if (modificar) {
            datos.append('opcion', 'modificar')
            datos.append('txt_idmodificar', document.getElementById('txt_idmodificar').value)
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch('../controlador/CategoriaController.php', {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            } else {
                console('error')
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 0) {
                if (respuesta[0].errores[0].nombre > 0) {
                    document.getElementById('nombreerror').innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    document.getElementById('nombreerror').innerHTML = ""
                }
                if (respuesta[0].errores[1].max_atraso > 0) {
                    document.getElementById('pagoserror').innerHTML = "<span class='error'>Ingrese otra cantidad.</span>"
                } else {
                    document.getElementById('pagoserror').innerHTML = ""
                }
                if (respuesta[0].errores[2].prestamos > 0) {
                    document.getElementById('prestamoserror').innerHTML = "<span class='error'>Ingrese otra cantidad.</span>"
                } else {
                    document.getElementById('prestamoserror').innerHTML = ""
                }
                if (respuesta[0].errores[3].descripcion > 0) {
                    document.getElementById('descripcionerror').innerHTML = "<span class='error'>Ingrese otra descripción.</span>"
                } else {
                    document.getElementById('descripcionerror').innerHTML = ""
                }
                btn_guardar.removeAttribute('disabled')
            } else {
                if (respuesta[0].estado == 1) {
                    limpiar()
                }
                btn_guardar.removeAttribute('disabled')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            }
        })

    }

}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}

//LISTA LAS CATEGORIAS
function listarCategoria(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch('../controlador/CategoriaController.php', {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
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
function comboListado(e) {
    e.preventDefault()
    listarCategoria(1, cantidad.value, '', '')
}

//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarCategoria(pagina, cantidad.value, '', '')
})

$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarCategoria(pagina, cantidad.value, '', '')
})

//BUSQUEDA FILTRADA
function filtroNombre() {

    if (txt_nombrefiltro.value.length > 0) {
        txt_descripfiltro.value = ""
        listarCategoria(1, cantidad.value, 'nombre', txt_nombrefiltro.value)
    } else {
        listarCategoria(1, cantidad.value, '', '')
    }
}

function filtroDescripcion() {
    if (txt_descripfiltro.value.length > 0) {
        txt_nombrefiltro.value = ""
        listarCategoria(1, cantidad.value, 'descripcion', txt_descripfiltro.value)
    } else {
        listarCategoria(1, cantidad.value, '', '')
    }
}

//ELIMINAR
$(document).on('click', '.eliminar', function (e) {
    e.preventDefault()
    let fila = $(this).parents("tr").find("td")[0]
    let nombre = $(fila).html()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeliminar')
    confirmarEliminacion("ELIMINAR A: " + nombre, "ESTA SEGURO?", "warning", id)
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
            datos.append('id', idEliminar)
            datos.append('opcion', 'eliminar')
            fetch('../controlador/CategoriaController.php', {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarCategoria(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            })
        } else {
            swal("CANCELADO", "EL REGISTRO SE CONSERVA INTACTO", "info");
        }
    });

}
//LIMPIAR
function limpiar() {
    modificar = false;
    document.getElementById('frm_categoria').reset();
    opNuevo.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
    btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    document.getElementById('nombreerror').innerHTML = ""
    document.getElementById('pagoserror').innerHTML = ""
    document.getElementById('prestamoserror').innerHTML = ""
    document.getElementById('descripcionerror').innerHTML = ""
}
