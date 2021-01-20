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
const txt_activoCorriente = document.getElementById('txt_activoCorriente')
const txt_pasivoCorriente = document.getElementById('txt_pasivoCorriente')
const txt_inventario = document.getElementById('txt_inventario')
const balanceGeneral = document.getElementById('balanceGeneral')
const estadoResultado = document.getElementById('estadoResultado')
const nombreError = document.getElementById('nombreError')
const telefonoError = document.getElementById('telefonoError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlClienteJ = '../../controlador/ClienteJuridicoController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarClienteJ(1, cantidad.value, '', '')
    generarCodigo()
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_guardar.addEventListener("click", guardarModificarClienteJ)

}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_clienteJ').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    } else {
        generarCodigo()
    }
    nombreError.innerHTML = ""
    telefonoError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")
}
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_clienteJ').reset();
        txt_codigo.value = ""
        txt_fechaIngreso.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    telefonoError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarClienteJ(1, cantidad.value, '', '')

}

function guardarModificarClienteJ() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_clienteJ'))
        datos.append('txt_codigo', txt_codigo.value)
        if (modificar) {
            datos.append('txt_fechaIngreso', txt_fechaIngreso.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlClienteJ, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            console.log(respuesta)
            if (respuesta[0].estado == 1) {
                tabla()
                listarClienteJ(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                document.getElementById('frm_clienteJ').reset()
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


            }
            btn_guardar.removeAttribute('disabled')
        }).catch(error => {
            console.log(error)
            btn_guardar.removeAttribute('disabled')
            alert('Ocurrio un error conectando al servidor, intente de nuevo')
        })
    }
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
function listarClienteJ(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlClienteJ, {
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
            datos.append('txt_codigo', idEliminar)
            datos.append('opcion', 'eliminar')
            fetch(urlClienteJ, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarClienteJ(1, cantidad.value, '', '')
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
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
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
    fetch(urlClienteJ, {
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
    fetch(urlClienteJ, {
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

            txt_codigo.value = respuesta[0]['codigo']
            txt_fechaIngreso.value = respuesta[0]['fecha_ingreso']
            txt_nombre.value = respuesta[0]['nombre']
            txt_telefono.value = respuesta[0]['telefono']
            txt_direccion.value = respuesta[0]['direccion']
            spn_codigo.innerHTML = "<span class='text text-info tex-center roboto-medium'>CODIGO: " + respuesta[0]['codigo'] + ".</span>"
            txt_activoCorriente.value = respuesta[0]['activo_corriente']
            txt_pasivoCorriente.value = respuesta[0]['pasivo_corriente']
            txt_inventario.value = respuesta[0]['inventario']
            modificar = true
            //OCULTA TABLA Y MUESTRA EL FORMULARIO
            opNueva.className = "active";
            opLista.className = "";
            opNueva.innerHTML = "<i class='fas fa-edit fa-fw'></i> &nbsp; MODIFICAR"
            btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; MODIFICAR"
            $("#cuadroFormulario").slideDown("slow")
            $("#cuadroTabla").slideUp("slow")
        }

    })
}
