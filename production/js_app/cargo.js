//CONSTANTES
const opLista = document.getElementById('opLista')
const opEliminar = document.getElementById('opEliminar')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_nombrefiltro = document.getElementById('txt_nombrefiltro')
const txt_descripcionfiltro = document.getElementById('txt_descripcionfiltro')
const txt_id = document.getElementById('txt_id')
//FORMULARIO
const txt_cargo = document.getElementById('txt_cargo')
const txt_descripcion = document.getElementById('txt_descripcion')
const txt_sueldo = document.getElementById('txt_sueldo')
const cargoError = document.getElementById('cargoError')
const sueldoError = document.getElementById('sueldoError')
const descripcionError = document.getElementById('descripcionError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlCargo = '../../controlador/CargoController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarCargo(1, cantidad.value, '', '')
    txt_nombrefiltro.addEventListener("keyup", filtroNombre)
    txt_descripcionfiltro.addEventListener("keyup", filtroDescripcion)

    cantidad.addEventListener("change", comboListado)
    btn_guardar.addEventListener("click", guardarModificarCargo)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_Cargo').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    cargoError.innerHTML = ""
    descripcionError.innerHTML = ""
    sueldoError.innerHTML = ""
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_Cargo').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVA"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    cargoError.innerHTML = ""
    descripcionError.innerHTML = ""
    sueldoError.innerHTML = ""
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    listarCargo(1, cantidad.value, '', '')

}

function guardarModificarCargo() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar && sueldoValido()) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_Cargo'))
        if (modificar) {
            datos.append('id', txt_id.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlCargo, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                tabla()
                listarCargo(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                cargoError.innerHTML = ""
                document.getElementById('frm_Cargo').reset()
            } else {
                if (respuesta[0].errores[0].cargo > 0) {
                    cargoError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    cargoError.innerHTML = ""
                }

                if (respuesta[0].errores[0].descripcion > 0) {
                    descripcionError.innerHTML = "<span class='error'>Ingrese otra Descripción.</span>"
                } else {
                    descripcionError.innerHTML = ""
                }if (respuesta[0].errores[0].sueldo > 0) {
                    sueldoError.innerHTML = "<span class='error'>Ingrese otra cantidad.</span>"
                } else {
                    sueldoError.innerHTML = ""
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
    fetch(urlCargo, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0] == null) {
            swal("NO ES POSIBLE MODIFICAR.", "EL CARGO HA SIDO ELIMINADA.", "info")
        } else {
            txt_id.value = respuesta[0]['id']
            document.getElementById('txt_cargo').value = respuesta[0]['cargo']
            document.getElementById('txt_descripcion').value = respuesta[0]['descripcion']
            document.getElementById('txt_sueldo').value = respuesta[0]['sueldo']
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
function listarCargo(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listar')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlCargo, {
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

function sueldoValido() {
    let valido = false
    if (txt_sueldo!= "") {
       
        
        if (txt_sueldo.value>=300) {
           
            document.getElementById('sueldoError').innerHTML = ""
            valido=true
        } else {
            document.getElementById('sueldoError').innerHTML = "<span class='error'>Debe ser mayor o igual a $300.00</span>"
        }
    }
    return valido
}

//EVENTO DEL COMBO PARA SELECCIONAR LA CANTIDAD DE REGISTROS A MOSTRAR
function comboListado() {
    listarCargo(1, cantidad.value, '', '')
}

//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarCargo(pagina, cantidad.value, '', '')
})

$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarCargo(pagina, cantidad.value, '', '')
})

//BUSQUEDA FILTRADA
function filtroNombre() {

    if (txt_nombrefiltro.value.length > 0) {
        listarCargo(1, cantidad.value, 'cargo', txt_nombrefiltro.value)
    } else {
        listarCargo(1, cantidad.value, '', '')
    }
}


function filtroDescripcion() {

    if (txt_descripcionfiltro.value.length > 0) {
        listarCargo(1, cantidad.value, 'descripcion', txt_descripcionfiltro.value)
    } else {
        listarCargo(1, cantidad.value, '', '')
    }
}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}