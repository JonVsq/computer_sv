//CONSTANTES
const ir_pedidos = document.getElementById('ir_pedidos')
//DIRECCION CONTROLADORES
let urlPedidos = '../controlador/ProductoController.php'
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    verificarPedidos()
}
function verificarPedidos() {
    const datos = new FormData()
    datos.append('opcion', 'verificarInformacion')
    fetch(urlPedidos, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (parseFloat(respuesta['pedido_necesario']) > 0) {
            mensaje("IMPORTANTE", "HAY PRODUCTOS QUE NECESITAN PEDIDOS NUEVOS", "warning")
        }
    }).catch(arror => {
        alert('Ocurrio un error conectando con el servidor, intente de nuevo.')
    })

}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}