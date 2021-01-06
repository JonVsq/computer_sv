//CONSTANTES
const opLista = document.getElementById('opLista')
const opNueva = document.getElementById('opNueva')
const cantidad = document.getElementById('cantidad')
const cuerpoTabla = document.getElementById('cuerpoTabla')
const registros = document.getElementById('registros')
const totalPaginas = document.getElementById('totalPaginas')
const paginador = document.getElementById('paginador')
const txt_nombrefiltro = document.getElementById('txt_nombrefiltro')
const txt_id = document.getElementById('txt_id')
//FORMULARIO
//const txt_marca = document.getElementById('txt_marca')
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

    opNueva.addEventListener("click", opcionNuevo)
    opLista.addEventListener("click", tabla)
    btn_listar.addEventListener("click", tabla)
}
function opcionNuevo() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_Marca').reset();
        txt_id.value = ""
        opNueva.innerHTML = "<i class='fas fa-plus fa-fw'></i> &nbsp; NUEVO"
        btn_guardar.innerHTML = "<i class='far fa-save'></i> &nbsp; GUARDAR"
    }
    opNueva.className = "active"
    opLista.className = ""
    $("#cuadroFormulario").slideDown("slow")
    $("#cuadroTabla").slideUp("slow")

}
function tabla() {
    if (modificar) {
        modificar = false;
        document.getElementById('frm_Marca').reset();
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