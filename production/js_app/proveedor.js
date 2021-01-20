//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_nombrefiltro = document.getElementById('txt_nombrefiltro')
const txt_direccionfiltro = document.getElementById('txt_direccionfiltro')
const txt_telefonofiltro = document.getElementById('txt_telefonofiltro')
const txt_correofiltro = document.getElementById('txt_correofiltro')
const txt_id = document.getElementById('txt_id')
//FORMULARIO
const txt_nombre = document.getElementById('txt_nombre')
const txt_direccion = document.getElementById('txt_direccion')
const txt_telefono = document.getElementById('txt_telefono')
const txt_correo = document.getElementById('txt_correo')
const nombreError = document.getElementById('nombreError')
const direccionError = document.getElementById('direccionError')
const telefonoError = document.getElementById('telefonoError')
const correoError = document.getElementById('correoError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlProveedor = '../../controlador/ProveedoresController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarProveedor(1, cantidad.value, '', '')
    cantidad.addEventListener("change", comboListado)
    txt_nombrefiltro.addEventListener("keyup", filtroNombre)
    txt_telefonofiltro.addEventListener("keyup", filtroTelefono)
    txt_direccionfiltro.addEventListener("keyup", filtroDireccion)
    txt_correofiltro.addEventListener("keyup", filtroCorreo)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
    btn_guardar.addEventListener("click", guardarModificarProveedor)
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_proveedor').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    direccionError.innerHTML = ""
    telefonoError.innerHTML = ""
    correoError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_proveedor').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    direccionError.innerHTML = ""
    telefonoError.innerHTML = ""
    correoError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    // listarMarca(1, cantidad.value, '', '')
}
function guardarModificarProveedor() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_proveedor'))
        if (modificar) {
            datos.append('id', txt_id.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlProveedor, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                tabla()
                listarProveedor(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                document.getElementById('frm_proveedor').reset()
            } else {
                if (respuesta[0].errores[0].nombre > 0) {
                    nombreError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    nombreError.innerHTML = ""
                }
                if (respuesta[0].errores[1].telefono > 0) {
                    telefonoError.innerHTML = "<span class='error'>Ingrese otro télefono.</span>"
                } else {
                    telefonoError.innerHTML = ""
                }
                if (respuesta[0].errores[2].correo > 0) {
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
    fetch(urlProveedor, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "EL PROVEEDOR YA HA SIDO ELIMINADO.", "info")
        } else {
            txt_id.value = respuesta[0]['id']
            txt_nombre.value = respuesta[0]['nombre']
            txt_direccion.value = respuesta[0]['direccion']
            txt_telefono.value = respuesta[0]['telefono']
            txt_correo.value = respuesta[0]['correo']
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
function listarProveedor(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlProveedor, {
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
    listarProveedor(1, cantidad.value, '', '')
}

//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarProveedor(pagina, cantidad.value, '', '')
})

$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarProveedor(pagina, cantidad.value, '', '')
})

//BUSQUEDA FILTRADA
function filtroNombre() {
    if (txt_nombrefiltro.value.length > 0) {
        txt_telefonofiltro.value = ""
        txt_direccionfiltro.value = ""
        txt_correofiltro.value = ""
        listarProveedor(1, cantidad.value, 'nombre', txt_nombrefiltro.value)
    } else {
        listarProveedor(1, cantidad.value, '', '')
    }
}
function filtroTelefono() {
    if (txt_telefonofiltro.value.length > 0) {
        txt_nombrefiltro.value = ""
        txt_direccionfiltro.value = ""
        txt_correofiltro.value = ""
        listarProveedor(1, cantidad.value, 'telefono', txt_telefonofiltro.value)
    } else {
        listarProveedor(1, cantidad.value, '', '')
    }
}
function filtroDireccion() {
    if (txt_direccionfiltro.value.length > 0) {
        txt_nombrefiltro.value = ""
        txt_telefonofiltro.value = ""
        txt_correofiltro.value = ""
        listarProveedor(1, cantidad.value, 'direccion', txt_direccionfiltro.value)
    } else {
        listarProveedor(1, cantidad.value, '', '')
    }
}
function filtroCorreo() {
    if (txt_correofiltro.value.length > 0) {
        txt_nombrefiltro.value = ""
        txt_telefonofiltro.value = ""
        txt_direccionfiltro.value = ""
        listarProveedor(1, cantidad.value, 'correo', txt_correofiltro.value)
    } else {
        listarProveedor(1, cantidad.value, '', '')
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
    confirmarEliminacion("ELIMINAR PROVEEDOR: " + nombre, "ESTA SEGURO?", "warning", id)
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
            fetch(urlProveedor, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarProveedor(1, cantidad.value, '', '')
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