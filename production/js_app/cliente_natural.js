//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_nombrefiltro = document.getElementById('txt_nombrefiltro')
const txt_codigo = document.getElementById('txt_codigo')
const txt_fechaIngreso = document.getElementById('txt_fechaIngreso')
const spn_codigo = document.getElementById('spn_codigo')
//FORMULARIO
const txt_nombre = document.getElementById('txt_nombre')
const txt_telefono = document.getElementById('txt_telefono')
const txt_direccion = document.getElementById('txt_direccion')
const txt_dui = document.getElementById('txt_dui')
const txt_nit = document.getElementById('txt_nit')
const txt_lugarTrabajo = document.getElementById('txt_lugarTrabajo')
const txt_ingresos = document.getElementById('txt_ingresos')
const txt_egresos = document.getElementById('txt_egresos')
//const marcaError = document.getElementById('marcaError')
const btn_limpiar = document.getElementById('btn_limpiar')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
//DIRECCION CONTROLADORES
let urlClienteN = '../../controlador/ClienteNaturalController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {

    btn_guardar.addEventListener("click", guardarModificarClienteN)
    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_clienteN').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    } else {
        generarCodigo()
    }
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_clienteN').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    opLista.className = "active"
    opNueva.className = ""
    $("#cuadroFormulario").slideUp("slow")
    $("#cuadroTabla").slideDown("slow")
    //listarMarca(1, cantidad.value, '', '')

}
function guardarModificarClienteN() {
    btn_guardar.setAttribute('disabled', 'true')
    let validar = $('#cuadroFormulario form').valid()
    if (!validar) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        const datos = new FormData(document.getElementById('frm_clienteN'))
        datos.append('txt_codigo', txt_codigo.value)
        if (modificar) {
            datos.append('txt_fechaIngreso', txt_fechaIngreso.value)
            datos.append('opcion', 'modificar')
        } else {
            datos.append('opcion', 'insertar')
        }
        fetch(urlClienteN, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            if (respuesta[0].estado == 1) {
                tabla()
                //listarMarca(1, cantidad.value, '', '')
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                document.getElementById('frm_clienteN').reset()
            } else {
                if (respuesta[0].errores[0].nombre_marca > 0) {
                    marcaError.innerHTML = "<span class='error'>Ingrese otro nombre.</span>"
                } else {
                    marcaError.innerHTML = ""
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
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}