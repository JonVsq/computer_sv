//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_nombrefiltro = document.getElementById('txt_nombrefiltro')
const txt_filtro = document.getElementById('txt_filtros')
const txt_id = document.getElementById('txt_id')
//FORMULARIO
const txt_idempresa = document.getElementById('txt_idempresa')
const txt_codigo = document.getElementById('txt_codigo')
const txt_nombre = document.getElementById('txt_nombre')
const txt_ubicacion = document.getElementById('txt_ubicacion')
const codigoError = document.getElementById('codigoError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlDepartamento = '../../controlador/DepartamentoController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarDepartamento(1, cantidad.value, '', '')
    txt_nombrefiltro.addEventListener("keyup", filtroNombre)
    cantidad.addEventListener("change", comboListado)
    btn_guardar.addEventListener("click", guardarModificarDepartamento)
    btn_limpiar.addEventListener("click", Limpiar)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
    txt_filtro.addEventListener("keyup", Filtro)
}

function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_Departamento').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
        codigoError.innerHTML = ""
    }
    const datos = new FormData()
    datos.append('opcion', 'obtenercodigo')
    fetch(urlDepartamento, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0].estado == 2) {
            document.getElementById('txt_codigo').value = 5676
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
        document.getElementById('frm_Departamento').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
        codigoError.innerHTML = ""
    }
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarDepartamento(1, cantidad.value, '', '')
}

function guardarModificarDepartamento() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_Departamento'))
        if (modificar) {
            datos.append('id', txt_id.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlDepartamento, {
            method: 'POST',
            body: datos
        }).then(function(respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                listarDepartamento(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                codigoError.innerHTML = ""
                document.getElementById('frm_Departamento').reset()
                if (modificar) {
                    modificar = false;
                    opLista.className = "active"
                    opNueva.className = ""
                    $("#cuadroFormulario").slideUp("slow")
                    $("#cuadroTabla").slideDown("slow")
                    listarDepartamento(1, cantidad.value, '', '')
                    opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
                    btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
                } else {
                    const datos = new FormData()
                    datos.append('opcion', 'obtenercodigo')
                    fetch(urlDepartamento, {
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
                                document.getElementById('txt_codigo').value = 5676
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
    fetch(urlDepartamento, {
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
            txt_id.value = respuesta[0]['id']
            document.getElementById('txt_codigo').value = respuesta[0]['codigo']
            document.getElementById('txt_nombre').value = respuesta[0]['nombre']
            document.getElementById('txt_ubicacion').value = respuesta[0]['ubicacion']
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

function listarDepartamento(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlDepartamento, {
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
    listarDepartamento(1, cantidad.value, '', '')
}
//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarDepartamento(pagina, cantidad.value, '', '')
})
$(document).on('click', '.siguiente', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarDepartamento(pagina, cantidad.value, '', '')
})
//ELIMINAR DEPARTAMENTO
$(document).on('click', '.eliminar', function(e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeliminar')
    confirmarEliminacion("ELIMINAR DEPARTAMENTO", "ESTA SEGURO?", "warning", id)
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
            fetch(urlDepartamento, {
                method: 'POST',
                body: datos
            }).then(function(respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarDepartamento(1, cantidad.value, '', '')
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
        listarDepartamento(1, cantidad.value, "nombre", txt_nombrefiltro.value)
    } else {
        listarDepartamento(1, cantidad.value, '', '')
    }
}
//FILTRO CODIGO
function Filtro() {
    //swal("ERROR.", "HABILITADO.", "info")
    if (txt_filtro.value.length > 0) {
        listarDepartamento(1, cantidad.value, "codigo", txt_filtro.value)
    } else {
        listarDepartamento(1, cantidad.value, '', '')
    }
}
//FUNCION LIMPIAR
function Limpiar() {
    //swal("ERROR.", "HABILITADO.", "info")
    document.getElementById('txt_nombre').value = "";
    document.getElementById('txt_ubicacion').value = "";
}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}