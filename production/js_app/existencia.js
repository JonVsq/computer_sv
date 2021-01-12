//CONSTANTES
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_productoFiltro = document.getElementById('txt_productoFiltro')
const txt_descripcionFiltro = document.getElementById('txt_descripcionFiltro')
//DIRECCION CONTROLADORES
let urlProducto = '../../controlador/ProductoController.php'
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarExistencias(1, cantidad.value, '', '')
    txt_productoFiltro.addEventListener("keyup", filtroProducto)
    txt_descripcionFiltro.addEventListener("keyup", filtroDescripcion)
}
function listarExistencias(pagina, cantidad, campo, buscar) {
    const datos = new FormData()
    datos.append('opcion', 'listarExistencia')
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
//BUSQUEDA FILTRADA
function filtroProducto() {
    if (txt_productoFiltro.value.length > 0) {
        txt_descripcionFiltro.value = ""
        listarExistencias(1, cantidad.value, 'producto', txt_productoFiltro.value)
    } else {
        listarExistencias(1, cantidad.value, '', '')
    }
}
function filtroDescripcion() {
    if (txt_descripcionFiltro.value.length > 0) {
        txt_productoFiltro.value = ""
        listarExistencias(1, cantidad.value, 'descripcion', txt_descripcionFiltro.value)
    } else {
        listarExistencias(1, cantidad.value, '', '')
    }
}