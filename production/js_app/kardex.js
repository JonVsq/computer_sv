//CONSTANTES
const btn_seleccionar = document.getElementById('btn_seleccionar')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const spn_producto = document.getElementById('spn_producto')
const paginador = document.getElementById('paginador')
const txt_buscarProducto = document.getElementById('txt_buscarProducto')
const txt_buscarDescripcion = document.getElementById('txt_buscarDescripcion')
//DIRECCION CONTROLADORES
let urlCompra = '../../controlador/CompraController.php'
let urlKardex = '../../controlador/KardexController.php'
let id = 0
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    btn_seleccionar.addEventListener("click", abrirModal)
    cantidad.addEventListener("keyup", comboListado)
}
function abrirModal() {
    txt_buscarProducto.addEventListener("keyup", filtroProducto)
    txt_buscarDescripcion.addEventListener("keyup", filtroDescripcion)
    modalProducto(1, cantidad.value, '', '')
}
function modalProducto(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'modalProductos')
    datos.append('pagina', pagina)
    datos.append('campoP', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    fetch(urlCompra, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaProducto').innerHTML = respuesta['tabla']
        document.getElementById('registrosProducto').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasProducto').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorProducto').innerHTML = respuesta['paginador']
        $('#ModalProducto').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}
function filtroProducto() {
    if (txt_buscarProducto.value.length > 0) {
        txt_buscarDescripcion.value = ""
        modalProducto(1, cantidad.value, 'producto', txt_buscarProducto.value)

    } else {
        modalProducto(1, cantidad.value, '', '')
    }
}
function filtroDescripcion() {
    if (txt_buscarDescripcion.value.length > 0) {
        txt_buscarProducto.value = ""
        modalProducto(1, cantidad.value, 'descripcion', txt_buscarDescripcion.value)
    } else {
        modalProducto(1, cantidad.value, '', '')
    }
}
$(document).on('click', '.seleccion', function (e) {
    let fila = $(this).parents("tr").find("td")[0]
    let nombre = $(fila).html()
    let elemento = $(this)[0]
    id = $(elemento).attr('objseleccion')
    spn_producto.innerText = nombre
    listarKardex(1, cantidad.value, '', '')
})
function listarKardex(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'kardex')
    datos.append('pagina', pagina)
    datos.append('campo', campo)
    datos.append('cantidad', cantidad)
    datos.append('buscar', buscar)
    datos.append('id', id)
    fetch(urlKardex, {
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
        $('#ModalProducto').modal('hide')
    }).catch(error => {
        alert('Ocurrio un error conectado al servidor, intente de nuevo')
    })
}
//EVENTO DEL COMBO PARA SELECCIONAR LA CANTIDAD DE REGISTROS A MOSTRAR
function comboListado() {
    listarKardex(1, cantidad.value, '', '')
}

//BOTONES DE LA PAGINACION
$(document).on('click', '.pagina', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarKardex(pagina, cantidad.value, '', '')
})

$(document).on('click', '.siguiente', function (e) {
    e.preventDefault()
    let elemento = $(this)[0]
    let pagina = $(elemento).attr('pag')
    listarKardex(pagina, cantidad.value, '', '')
})