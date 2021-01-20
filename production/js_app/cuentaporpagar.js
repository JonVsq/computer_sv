//CONSTANTES
//DIRECCION CONTROLADORES
const btn_guardarpago = document.getElementById('btn_guardarpago')
const btn_modalPagar = document.getElementById('btn_modalPagar')
const opBuscar = document.getElementById('opBuscar')
const btn_buscar = document.getElementById('btn_buscar')
let urlCuentaporcobrar = '../../controlador/CuentaporcobrarController.php'
let modificar = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    btn_buscar.addEventListener("click", buscarcuenta)
    opBuscar.addEventListener("click", cargar)
    btn_modalPagar.addEventListener("click", ModalPagar)
    btn_guardarpago.addEventListener("click", pagar)
}

function ModalPagar() {
    CargarModal(document.getElementById('txt_codigo_cliente').textContent)
}
//FUNCIONA PARA PAGAR
function pagar() {
    const datos = new FormData()
    datos.append('id', document.getElementById('txt_id_pago').textContent)
    datos.append('id_credito', document.getElementById('txt_id_credito').textContent)
    datos.append('codigo', document.getElementById('txt_codigo_cliente').textContent)
    datos.append('opcion', 'pagar')
    fetch(urlCuentaporcobrar, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0].estado == 1) {
            swal("VACIO.", "VACIO. es unoooooo", "info")
        } else if (respuesta[0].estado == 2) {
            $('#ModalPagar').modal('hide')
            //ACTUALIZAR TABLA
            cargarFormulario(document.getElementById('txt_codigo_cliente').textContent)
            mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            //OCULTA TABLA Y MUESTRA EL FORMULARIO
        } else if (respuesta[0].estado == 3) {
            //AQUI ES CUANDO YA SE CANCELA TODO EL CREDITO
            $('#ModalPagar').modal('hide')
            //ACTUALIZAR TABLA
            cargarFormulario(document.getElementById('txt_codigo_cliente').textContent)
            mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
        }
    })
    //$('#ModalPagar').modal('show')
}
//FIN DE LA FUNCION PARA PAGAR
function CargarModal(codigo) {
    const datos = new FormData()
    datos.append('codigo', codigo)
    datos.append('opcion', 'obtenerCuota')
    fetch(urlCuentaporcobrar, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta == null) {
            swal("VACIO.", "VACIO. es unoooooo", "info")
        } else {
            //swal("VACIO.", "NO ESTA VACIO. " + respuesta[0]['fecha_pago'], "info")
            document.getElementById("txt_id_credito").innerHTML = respuesta[0]['id_credito']
            document.getElementById("txt_id_pago").innerHTML = respuesta[0]['id']
            document.getElementById("txt_numero_recuperado").innerHTML = respuesta[0]['numero_cuota']
            document.getElementById("txt_montocuota_recuperado").innerHTML = respuesta[0]['cuota']
            document.getElementById("txt_intereses_recuperado").innerHTML = respuesta[0]['interes']
            document.getElementById("txt_mora_recuperado").innerHTML = respuesta[0]['mora']
            document.getElementById("txt_cuotatotal_recuperado").innerHTML = respuesta[0]['cuota_cobrar']
            //OCULTA TABLA Y MUESTRA EL FORMULARIO
            $('#ModalPagar').modal('show')
        }
    })
    //$('#ModalPagar').modal('show')
}

function cargar() {
    opBuscar.className = "active"
    $("#cuadroTabla").slideUp("slow")
    $("#cuadroFormulario").slideDown("slow")
}

function buscarcuenta() {
    opBuscar.className = ""
    cargarFormulario(document.getElementById('txt_codigo').value)
}

function cargarFormulario(codigo) {
    const datos = new FormData()
    datos.append('codigo', codigo)
    datos.append('opcion', 'obtener')
    fetch(urlCuentaporcobrar, {
        method: 'POST',
        body: datos
    }).then(function(respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta == null) {
            swal("VACIO.", "CUENTA NO ENCONTRADA", "info")
        } else {
            document.getElementById('cuerpoTablaCuenta').innerHTML = respuesta['tabla']
            document.getElementById('txt_fecha_venta_recuperado').innerHTML = respuesta['fechaventa']
            document.getElementById('txt_monto_recuperado').innerHTML = respuesta['monto']
            document.getElementById('txt_numfacturarecuperado').innerHTML = respuesta['factura']
            document.getElementById('txt_cliente_recuperado').innerHTML = respuesta['cliente']
            document.getElementById('txt_plazo_recuperado').innerHTML = respuesta['plazo']
            document.getElementById('txt_codigo_cliente').innerHTML = respuesta['codigo']
            //swal("VACIO.", "VACIO. " + respuesta[0]['saldo'], "info")
            //OCULTA TABLA Y MUESTRA EL FORMULARIO
            $("#cuadroFormulario").slideUp("slow")
            $("#cuadroTabla").slideDown("slow")
        }
    })
}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}