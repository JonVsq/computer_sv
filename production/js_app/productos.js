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
const txt_buscarMarca = document.getElementById('txt_buscarMarca')
const txt_buscarCategoria = document.getElementById('txt_buscarCategoria')
//FORMULARIO
const spn_marca = document.getElementById('spn_marca')
const spn_Categoria = document.getElementById('spn_Categoria')
const btn_modalCategoria = document.getElementById('btn_modalCategoria')
const btn_modalMarca = document.getElementById('btn_modalMarca')
const txt_idMarca = document.getElementById('txt_idMarca')
const txt_idCategoria = document.getElementById('txt_idCategoria')
const txt_producto = document.getElementById('txt_producto')
const txt_descripcion = document.getElementById('txt_descripcion')
const txt_modelo = document.getElementById('txt_modelo')
const txt_ganancia = document.getElementById('txt_ganancia')
const txt_usoDiario = document.getElementById('txt_usoDiario')
const txt_entrega = document.getElementById('txt_entrega')
const productoError = document.getElementById('productoError')
const descripcionError = document.getElementById('descripcionError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
const md_datosProducto = document.getElementById('md_datosProducto')
//DIRECCION CONTROLADORES
let urlProducto = '../../controlador/ProductoController.php'
let modificar = false
let paginaMarca = 1
let paginaCategoria = 1
let campoMarca = ''
let buscarMarca = ''
let campoCategoria = ''
let buscarCategoria = ''
let cantida = 10
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarProducto(1, cantidad.value, '', '')
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
    btn_modalMarca.addEventListener("click", modalMarca)
    btn_modalCategoria.addEventListener("click", modalCategoria)
    txt_buscarMarca.addEventListener("keyup", filtroMarca)
    txt_buscarCategoria.addEventListener("keyup", filtroCategoria)
    btn_guardar.addEventListener("click", guardarModificarProducto)
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        txt_idCategoria.value = ""
        txt_idMarca.value = ""
        spn_Categoria.className = "text-danger"
        spn_marca.className = "text-danger"
        spn_marca.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE MARCA"
        spn_Categoria.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE CATEGORIA"
        document.getElementById('frm_Producto').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    productoError.innerHTML = ""
    descripcionError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    if (modificar) {
        modificar = false;
        txt_idCategoria.value = ""
        txt_idMarca.value = ""
        spn_Categoria.className = "text-danger"
        spn_marca.className = "text-danger"
        spn_marca.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE MARCA"
        spn_Categoria.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE CATEGORIA"
        document.getElementById('frm_Producto').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    productoError.innerHTML = ""
    descripcionError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarProducto(1, cantidad.value, '', '')

}

function guardarModificarProducto() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        if (txt_idMarca.value != "" && txt_idCategoria.value != "") {
            const datos = new FormData(document.getElementById('frm_Producto'))
            if (modificar) {
                datos.append('id', txt_id.value)
                datos.append('opcion', 'modificar')
            } else {
                datos.append('opcion', 'insertar')
            }
            fetch(urlProducto, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                }
            }).then(respuesta => {
                if (respuesta[0].estado == 1) {
                    tabla()
                    listarProducto(1, cantidad.value, '', '')
                    txt_idCategoria.value = ""
                    txt_idMarca.value = ""
                    spn_Categoria.className = "text-danger"
                    spn_marca.className = "text-danger"
                    spn_marca.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE MARCA"
                    spn_Categoria.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE CATEGORIA"
                    mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                    document.getElementById('frm_Producto').reset()
                } else {
                    if (respuesta[0].errores[0].producto > 0) {
                        productoError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                    } else {
                        productoError.innerHTML = ""
                    }
                    if (respuesta[0].errores[1].descripcion > 0) {
                        descripcionError.innerHTML = "<span class='error'>Ingrese otra descripción.</span>"
                    } else {
                        descripcionError.innerHTML = ""
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
function listarProducto(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlProducto, {
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
function modalMarca() {
    const datos = new FormData()
    datos.append('opcion', 'modalMarca')
    datos.append('pagina', paginaMarca)
    datos.append('campoMarca', campoMarca)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarMarca)
    fetch(urlProducto, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaMarca').innerHTML = respuesta['tabla']
        document.getElementById('registrosMarca').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasMarca').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorMarca').innerHTML = respuesta['paginador']
        $('#ModalMarca').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}

function modalCategoria() {
    const datos = new FormData()
    datos.append('opcion', 'modalCategoria')
    datos.append('pagina', paginaCategoria)
    datos.append('campoCategoria', campoCategoria)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarCategoria)
    fetch(urlProducto, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaCategoria').innerHTML = respuesta['tabla']
        document.getElementById('registrosCategoria').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasCategoria').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorCategoria').innerHTML = respuesta['paginador']
        $('#ModalCategoria').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}
//BUSQUEDA FILTRADA
function filtroMarca() {
    if (txt_buscarMarca.value.length > 0) {
        campoMarca = 'nombre_marca'
        buscarMarca = txt_buscarMarca.value
        modalMarca()
    } else {
        campoMarca = ''
        buscarMarca = ''
        modalMarca()
    }
}
function filtroCategoria() {
    if (txt_buscarCategoria.value.length > 0) {
        campoCategoria = 'descripcion'
        buscarCategoria = txt_buscarCategoria.value
        modalCategoria()
    } else {
        campoCategoria = ''
        buscarCategoria = ''
        modalCategoria()
    }
}
//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pag = $(elemento).attr('pag')
    if ($('#ModalCategoria').is(':visible')) {
        paginaCategoria = pag
        paginaMarca = 1
        modalCategoria()
    } else if ($('#ModalMarca').is(':visible')) {
        paginaMarca = pag
        paginaCategoria = 1
        modalMarca()
    } else {
        //listarSolicitudes(pag, cantidad.value, '', '')
    }

})
$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pag = $(elemento).attr('pag')
    if ($('#ModalCategoria').is(':visible')) {
        paginaCategoria = pag
        paginaMarca = 1
        modalCategoria()
    } else if ($('#ModalMarca').is(':visible')) {
        paginaMarca = pag
        paginaCategoria = 1
        modalMarca()
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
    if ($('#ModalCategoria').is(':visible')) {
        spn_Categoria.className = ""
        spn_Categoria.innerText = nombre
        txt_idCategoria.value = id
        paginaMarca = 1
        paginaCategoria = 1
        campoCategoria = ''
        buscarCategoria = ''
        $('#ModalCategoria').modal('hide')
    } else if ($('#ModalMarca').is(':visible')) {
        spn_marca.className = ""
        spn_marca.innerText = nombre
        txt_idMarca.value = id
        paginaCategoria = 1
        paginaMarca = 1
        campoMarca = ''
        buscarMarca = ''
        $('#ModalMarca').modal('hide')
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
    fetch(urlProducto, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "EL PRODUCTO YA HA SIDO ELIMINADO.", "info")
        } else {
            txt_id.value = respuesta[0]['id']
            txt_idMarca.value = respuesta[0]['id_marca']
            txt_idCategoria.value = respuesta[0]['id_cat']
            spn_marca.innerText = respuesta[0]['nombre_marca']
            spn_marca.className = ""
            spn_Categoria.className = ""
            spn_Categoria.innerText = respuesta[0]['desCatP']
            txt_producto.value = respuesta[0]['producto']
            txt_descripcion.value = respuesta[0]['descripcion']
            txt_modelo.value = respuesta[0]['modelo']
            txt_ganancia.value = respuesta[0]['porcentaje_ganancia']
            txt_usoDiario.value = respuesta[0]['uso_diario']
            txt_entrega.value = respuesta[0]['dias_entrega']
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
    fetch(urlProducto, {
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
        $('#ModalProducto').modal('show')
    }).catch(error => {
        alert('OCURRIO UN ERROR CONECTANDO CON EL SERVIDOR, INTENTE DE NUEVO.')
    })

}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}