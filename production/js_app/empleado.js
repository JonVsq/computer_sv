//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_id = document.getElementById('txt_id')
const txt_buscarCargo = document.getElementById('txt_buscarCargo')
const txt_buscarDepto = document.getElementById('txt_buscarDepto')
//FORMULARIO
const spn_Cargo = document.getElementById('spn_Cargo')
const spn_Depto = document.getElementById('spn_Depto')
const btn_modalCargo = document.getElementById('btn_modalCargo')
const btn_modalDepto = document.getElementById('btn_modalDepto')
const txt_idCargo = document.getElementById('txt_idCargo')
const txt_idDepto = document.getElementById('txt_idDepto')
const txt_dui = document.getElementById('txt_dui')
const txt_nit = document.getElementById('txt_nit')
const txt_nombre = document.getElementById('txt_nombre')
const txt_apellido = document.getElementById('txt_apellido')
const txt_dir = document.getElementById('txt_dir')
const txt_tell = document.getElementById('txt_tell')
const txt_fecha = document.getElementById('txt_fecha')
const rb_sexo = document.getElementById('rb_sexo')




const nombreError = document.getElementById('nombreError')
const duiError = document.getElementById('duiError')
const nitError = document.getElementById('nitError')
const dirError = document.getElementById('dirError')
const tellError = document.getElementById('tellError')
const sexoError = document.getElementById('sexoError')
const nacimientoError = document.getElementById('nacimiento')

const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
const md_datosEmpleado = document.getElementById('md_datosEmpleado')
//DIRECCION CONTROLADORES
let urlEmpleado = '../../controlador/EmpleadoController.php'
let modificar = false
let paginaCargo = 1
let paginaDepto = 1
let campoCargo = ''
let buscarCargo = ''
let campoDepto = ''
let buscarDepto = ''
let cantida = 10
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarEmpleado(1, cantidad.value, '', '')
    cantidad.addEventListener("change", comboListado)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
    btn_modalCargo.addEventListener("click", modalCargo)
    btn_modalDepto.addEventListener("click", modalDepto)
    txt_buscarCargo.addEventListener("keyup", filtroCargo)
    txt_buscarDepto.addEventListener("keyup", filtroDepto)
    btn_guardar.addEventListener("click", guardarModificarEmpleado)
}
function comboListado() {
    listarEmpleado(1, cantidad.value, '', '')
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        txt_idCargo.value = ""
        txt_idMarca.value = ""
        spn_Cargo.className = "text-danger"
        spn_Depto.className = "text-danger"
        spn_Depto.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE Departamento"
        spn_Cargo.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE Cargo"
        document.getElementById('frm_Producto').reset();
        txt_id.value = ""
       
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    duiError.innerHTML = ""
    nitError.innerHTML = ""
    tellError.innerHTML = ""
    dirError.innerHTML = ""
    sexoError.innerHTML = ""
    nacimientoError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function validaSexo() {
    let i
    let valido = false
    for (i = 0; i < document.getElementsByName('rb_sexo').length; i++) {
        if (document.getElementsByName('rb_sexo')[i].checked) {
            valido = true
            break;
        }
    }
    if (valido) {
        document.getElementById('sexoError').innerHTML = ""
    } else {
        document.getElementById('sexoError').innerHTML = "<span class='error'>Este campo es obligatorio.</span>"
    }
    return valido
}
function tabla() {
    if (modificar) {
        modificar = false;
        txt_idCargo.value = ""
        txt_idDepto.value = ""
        spn_Cargo.className = "text-danger"
        spn_Depto.className = "text-danger"
        spn_Depto.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE DEPARTAMENTO"
        spn_Cargo.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE CARGO"
        document.getElementById('frm_Empleado').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    nombreError.innerHTML = ""
    duiError.innerHTML = ""
    nitError.innerHTML = ""
    tellError.innerHTML = ""
    dirError.innerHTML = ""
    sexoError.innerHTML = ""
    nacimientoError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarEmpleado(1, cantidad.value, '', '')

}

function guardarModificarEmpleado() {
    btn_guardar.setAttribute('disabled', 'true')
    validaSexo()
    calcularEdad()
   
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        if (txt_idCargo.value != "" && txt_idDepto.value != "" && calcularEdad() &&  validaSexo()) {
            
           
            const datos = new FormData(document.getElementById('frm_Empleado'))
            if (modificar) {
                datos.append('id', txt_id.value)
                datos.append('opcion', 'modificar')
            } else {
                datos.append('opcion', 'insertar')
            }
            fetch(urlEmpleado, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                }
            }).then(respuesta => {
                if (respuesta[0].estado == 1) {
                    tabla()
                    listarEmpleado(1, cantidad.value, '', '')
                    txt_idCargo.value = ""
                    txt_idDepto.value = ""
                    spn_Cargo.className = "text-danger"
                    spn_Depto.className = "text-danger"
                    spn_Depto.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE DEPARTAMENTO"
                    spn_Cargo.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE CARGO"
                    mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                    document.getElementById('frm_Empleado').reset()
                } else {
                    if (respuesta[0].errores[0].dui> 0) {
                        duiError.innerHTML = "<span class='error'>EL DUI YA SE ENCUENTRA REGISTRADO FAVOR INGRESAR OTRO.</span>"
                    } else {
                        duiError.innerHTML = ""
                    }
                    if (respuesta[0].errores[1].nit> 0) {
                        nitError.innerHTML = "<span class='error'>EL NIT YA SE ENCURNTRA REGISTRADO POR FAVOR INGRESE OTRO.</span>"
                    } else {
                       nitError.innerHTML = ""
                    }

                    
                }
                btn_guardar.removeAttribute('disabled')
            }).catch(error => {
                console.log(error)
                btn_guardar.removeAttribute('disabled')
                alert('Ocurrio un error conectando al servidor, intente de nuevo'+
                error)
            })
        } else {
            btn_guardar.removeAttribute('disabled')
        }
    }
}



function calcularEdad() {
    let mayoredad = false
    if (txt_fecha.value != "") {
        let fecha = new Date()
        let anioActual = fecha.getFullYear()
        let nacimiento = new Date(txt_fecha.value).getFullYear()
        mayoredad = (anioActual - nacimiento) >= 18 ? true : false
        if (mayoredad) {
            document.getElementById('nacimiento').innerHTML = ""
        } else {
            document.getElementById('nacimiento').innerHTML = "<span class='error'>Debe ser mayor o igual a 18 años.</span>"
        }
    }
    return mayoredad
}
function listarEmpleado(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlEmpleado, {
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
function modalCargo() {
    const datos = new FormData()
    datos.append('opcion', 'modalCargo')
    datos.append('pagina', paginaCargo)
    datos.append('campoCargo', campoCargo)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarCargo)
    fetch(urlEmpleado, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaCargo').innerHTML = respuesta['tabla']
        document.getElementById('registrosCargo').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasCargo').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorCargo').innerHTML = respuesta['paginador']
        $('#ModalCargo').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}

function modalDepto() {
    const datos = new FormData()
    datos.append('opcion', 'modalDepto')
    datos.append('pagina', paginaDepto)
    datos.append('campoDepto', campoDepto)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarDepto)
    fetch(urlEmpleado, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaDepto').innerHTML = respuesta['tabla']
        document.getElementById('registrosDepto').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasDepto').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorDepto').innerHTML = respuesta['paginador']
        $('#ModalDepto').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}
//BUSQUEDA FILTRADA
function filtroCargo() {
    if (txt_buscarCargo.value.length > 0) {
        campoCargo = 'cargo'
        buscarCargo = txt_buscarCargo.value
        modalCargo()
    } else {
        campoCargo = ''
        buscarCargo = ''
        modalCargo()
    }
}
function filtroDepto() {
    if (txt_buscarDepto.value.length > 0) {
        campoDepto = 'nombre'
        buscarDepto = txt_buscarDepto.value
        modalDepto()
    } else {
        campoDepto = ''
        buscarDepto = ''
        modalDepto()
    }
}
//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pag = $(elemento).attr('pag')
    if ($('#ModalCargo').is(':visible')) {
        paginaCargo = pag
        paginaDepto = 1
        modalCargo()
    } else if ($('#ModalDepto').is(':visible')) {
        paginaDepto = pag
        paginaCargo = 1
        modalDepto()
    } else {
        //listarSolicitudes(pag, cantidad.value, '', '')
    }

})
$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pag = $(elemento).attr('pag')
    if ($('#ModalCargo').is(':visible')) {
        paginaCargo = pag
        paginaDepto = 1
        modalCargo()
    } else if ($('#ModalDepto').is(':visible')) {
        paginaDepto = pag
        paginaCargo = 1
        modalDepto()
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
    if ($('#ModalCargo').is(':visible')) {
        spn_Cargo.className = ""
        spn_Cargo.innerText = nombre
        txt_idCargo.value = id
        paginaDepto = 1
        paginaCargo = 1
        campoCargo = ''
        buscarCargo = ''
        $('#ModalCargo').modal('hide')
    } else if ($('#ModalDepto').is(':visible')) {
        spn_Depto.className = ""
        spn_Depto.innerText = nombre
        txt_idDepto.value = id
        paginaCargo = 1
        paginaDepto = 1
        campoDepto = ''
        buscarDepto = ''
        $('#ModalDepto').modal('hide')
    } else {
    }
})
//OBTIENE LOS DATOS PARA MODIFICAR
$(document).on('click', '.editar', function () {
    let elemento = $(this)[0]
    let id = $(elemento).attr('objeditar')
    cargarFormulario(id)
})

$(document).on('click', '.eliminar', function (e) {
    e.preventDefault()
    let fila = $(this).parents("tr").find("td")[1]
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
            fetch('../../controlador/EmpleadoController.php', {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                } else {
                    console('error')
                }
            }).then(respuesta => {
                listarEmpleado(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            }).catch(error => {
                alert('OCURRIO UN ERROR CONECTANDO CON EL SERVIDOR, INTENTE DE NUEVO.  ' + error)
                
            
            })
        } else {
            swal("CANCELADO", "EL REGISTRO SE CONSERVA INTACTO", "info");
        }
    });
}

    function cargarFormulario(id) {
        const datos = new FormData()
        datos.append('id', id)
        datos.append('opcion', 'obtener')
        fetch(urlEmpleado, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0] == null) {
                swal("NO ES POSIBLE MODIFICAR.", "EL EMPLEADO YA HA SIDO ELIMINADO.", "info")
            } else {
                txt_id.value = respuesta[0]['id']
                txt_idDepto.value = respuesta[0]['id_departamento']
                txt_idCargo.value = respuesta[0]['id_cargo']
                spn_Depto.innerText = respuesta[0]['nombre']
                spn_Cargo.innerText = respuesta[0]['cargo']
                spn_Depto.className = ""
                spn_Cargo.className = ""
                
                txt_nombre.value = respuesta[0]['nombres']
                txt_apellido.value = respuesta[0]['apellidos']
                txt_nit.value = respuesta[0]['nit']
                txt_dui.value = respuesta[0]['dui']
                txt_fecha.value = respuesta[0]['fecha_nacimiento']
                txt_tell.value = respuesta[0]['telefono']
                txt_dir.value = respuesta[0]['direccion']
                if (respuesta[0]['sexo'] == "F") {
                    document.getElementById('r1').checked = true
                } else {
                    document.getElementById('r2').checked = true
                }
            
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
    fetch(urlEmpleado, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        } else {
            console('error')
        }
    }).then(respuesta => {
        md_datosEmpleado.innerHTML = respuesta['modalCuerpo']
        $('#ModalEmpleado').modal('show')
    }).catch(error => {
        alert('OCURRIO UN ERROR CONECTANDO CON EL SERVIDOR, INTENTE DE NUEVO.ñ')
    })

}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}


