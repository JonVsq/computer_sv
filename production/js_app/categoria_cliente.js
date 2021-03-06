//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_nombreFiltro = document.getElementById('txt_nombreFiltro')
const txt_descripcionFiltro = document.getElementById('txt_descripcionFiltro')
const txt_id = document.getElementById('txt_id')
//FORMULARIO
const txt_nombre = document.getElementById('txt_nombre')
const txt_descripcion = document.getElementById('txt_descripcion')
const txt_maxAtraso = document.getElementById('txt_maxAtraso')
const nombreError = document.getElementById('nombreError')
const descripcionError = document.getElementById('descripcionError')
const pagoError = document.getElementById('pagoError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlCatCliente = '../../controlador/CategoriaClienteController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarCategoriaCliente(1, cantidad.value, '', '')
    cantidad.addEventListener("change", comboListado)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    txt_nombreFiltro.addEventListener("keyup", filtroNombre)
    txt_descripcionFiltro.addEventListener("keyup", filtroDescripcion)
    btn_listar.addEventListener("click", tabla)
    btn_guardar.addEventListener("click", guardarModificarCatCliente)
}

function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_catCliente').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    descripcionError.innerHTML = ""
    pagoError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")
}
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_catCliente').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    descripcionError.innerHTML = ""
    pagoError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarCategoriaCliente(1, cantidad.value, '', '')
}

function guardarModificarCatCliente() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_catCliente'))
        if (modificar) {
            datos.append('id', txt_id.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlCatCliente, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json() 
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                tabla()
                listarCategoriaCliente(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                descripcionError.innerHTML = ""
                document.getElementById('frm_catCliente').reset()
            } else {
                if (respuesta[0].errores[0].nombre > 0) {
                    nombreError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    nombreError.innerHTML = ""
                }
                if (respuesta[0].errores[1].descripcion > 0) {
                    descripcionError.innerHTML = "<span class='error'>Ingrese otra descripción.</span>"
                } else {
                    descripcionError.innerHTML = ""
                }
                if (respuesta[0].errores[2].max_atraso > 0) {
                    pagoError.innerHTML = "<span class='error'>Ingrese otro valor.</span>"
                } else {
                    pagoError.innerHTML = ""
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
    datos.append('id', id)
    datos.append('opcion', 'obtener')
    fetch(urlCatCliente, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "LA CATEGORIA DEL PRODUCTO YA HA SIDO ELIMINADA.", "info")
        } else {
            txt_id.value = respuesta[0]['id']
            txt_nombre.value = respuesta[0]['nombre']
            txt_descripcion.value = respuesta[0]['descripcion']
            txt_maxAtraso.value = respuesta[0]['max_atraso']
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
function listarCategoriaCliente(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlCatCliente, {
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
    listarCategoriaCliente(1, cantidad.value, '', '')
}

//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarCategoriaCliente(pagina, cantidad.value, '', '')
})

$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarCategoriaCliente(pagina, cantidad.value, '', '')
})

//BUSQUEDA FILTRADA
function filtroDescripcion() {

    if (txt_descripcionFiltro.value.length > 0) {
        txt_nombreFiltro.value = ""
        listarCategoriaCliente(1, cantidad.value, 'descripcion', txt_descripcionFiltro.value)
    } else {
        listarCategoriaCliente(1, cantidad.value, '', '')
    }
}
//BUSQUEDA FILTRADA
function filtroNombre() {

    if (txt_nombreFiltro.value.length > 0) {
        txt_descripcionFiltro.value = ""
        listarCategoriaCliente(1, cantidad.value, 'nombre', txt_nombreFiltro.value)
    } else {
        listarCategoriaCliente(1, cantidad.value, '', '')
    }
}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}
//ELIMINAR
$(document).on('click', '.eliminar', function (e) {
    e.preventDefault()
    let filaNombre = $(this).parents("tr").find("td")[0]
    let nombre = $(filaNombre).html()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeliminar')
    confirmarEliminacion("ELIMINAR CATEGORIA CLIENTE: " + nombre, "ESTA SEGURO?", "warning", id)
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
            fetch(urlCatCliente, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarCategoriaCliente(1, cantidad.value, '', '')
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