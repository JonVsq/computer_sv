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
    btn_guardar.addEventListener("click", guardarModificarClienteJ)

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
                //tabla()
                //listarClienteN(1, cantidad.value, '', '')
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
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}