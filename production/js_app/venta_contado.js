//CONSTANTES
const txt_id = document.getElementById('txt_id')
const txt_factura = document.getElementById('txt_factura')
const spn_Factura = document.getElementById('spn_Factura')
const txt_idCliente = document.getElementById('txt_idCliente')
const spn_Cliente = document.getElementById('spn_Cliente')
const btn_modalCliente = document.getElementById('btn_modalCliente')
const txt_idProducto = document.getElementById('txt_idProducto')
const spn_Producto = document.getElementById('spn_Producto')
const btn_modalProducto = document.getElementById('btn_modalProducto')
const spn_Unidades = document.getElementById('spn_Unidades')
const txt_cantidad = document.getElementById('txt_cantidad')
const cantidadError = document.getElementById('cantidadError')
const btn_agregar = document.getElementById('btn_agregar')
const cuerpoDetalle = document.getElementById('cuerpoDetalle')
const btn_guardar = document.getElementById('btn_guardar')
const tipo = document.getElementById('tipo')
const btn_cancelar = document.getElementById('btn_cancelar')
//DIRECCION CONTROLADORES
let urlCompra = '../../controlador/CompraController.php'
let urlClienteJ = '../../controlador/ClienteJuridicoController.php'
let urlClienteN = '../../controlador/ClienteNaturalController.php'
let urlCatCliente = '../../controlador/CategoriaClienteController.php'
let urlKardex = '../../controlador/KardexController.php'
let urlVentaContado = '../../controlador/VentaContadoController.php'
let paginaCliente = 1
let campoCliente = ""
let buscarCliente = ""
let paginaProducto = 1
let campoProducto = ""
let buscarProducto = ""
let cantida = 5
let stock = 0
let items = []
let cobrarImpuestos = true
let okCantidad = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    listarItems()
    cargarNumeroFactura()
    btn_modalProducto.addEventListener("click", abrirModalProducto)
    btn_modalCliente.addEventListener("click", abrirModalCliente)
    tipo.addEventListener("change", cambioCliente)
    btn_agregar.addEventListener("click", agregarItems)
    txt_cantidad.addEventListener("keyup", validarCantidad)
    btn_cancelar.addEventListener("click", eliminarItems)
    btn_guardar.addEventListener("click", guardarVenta)
}
function guardarVenta() {
    let okCliente = false
    let okFactura = false
    btn_guardar.setAttribute('disabled', 'true')
    if (txt_idCliente.value != "") {
        okCliente = true
    } else {
        okCliente = false
    }
    if (txt_factura.value != "") {
        okFactura = true
    } else {
        okFactura = false
    }
    if (okFactura && okCliente) {
        const datos = new FormData()
        console.log(txt_idCliente.value)
        datos.append('opcion', 'ingresarVenta')
        datos.append('txt_factura', txt_factura.value)
        datos.append('txt_idCliente', txt_idCliente.value)
        fetch(urlVentaContado, {
            method: 'POST',
            body: datos
        }).then(function (respuesta) {
            if (respuesta.ok) {
                return respuesta.json()
            }
        }).then(respuesta => {
            console.log(respuesta)
        }).catch(error => {
            console.log(error)
            alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
        })
    } else {
        btn_guardar.removeAttribute('disabled')
    }
}
function validarCantidad() {
    cantidadError.innerHTML = ""
    if (txt_idProducto.value == "") {
        cantidadError.innerHTML = "<span class='error'>Seleccione un producto</span>"
        okCantidad = false
    } else {
        cantidadError.innerHTML = ""
        if (txt_cantidad.value.length > 0) {
            cantidadError.innerHTML = ""
            let cant = parseFloat(txt_cantidad.value)
            if (cant > 0) {
                if (cant > stock) {
                    okCantidad = true

                    cantidadError.innerHTML = "<span class='error'>No puede ser mayor a: " + stock + " unidades.</span>"
                } else {
                    okCantidad = true
                    cantidadError.innerHTML = ""
                }
            } else {
                cantidadError.innerHTML = "<span class='error'>No puede ser 0</span>"

            }
        } else {
            okCantidad = false
            cantidadError.innerHTML = "<span class='error'>Ingrese una cantidad</span>"
        }
    }
}
function agregarItems() {
    let okProducto = false
    okCliente = txt_idCliente.value != "" ? true : false
    okProducto = txt_idProducto.value != "" ? true : false
    validarCantidad()
    if (okProducto && okCantidad) {
        procesarItem()
    }

}
function listarItems() {
    const datos = new FormData()
    datos.append('tipo', cobrarImpuestos ? "natural" : "juridico")
    datos.append('opcion', 'obtenerItemsFactura')
    datos.append('tipo', cobrarImpuestos ? "natural" : "juridico")
    fetch(urlKardex, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        cuerpoDetalle.innerHTML = respuesta['tabla']
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })
}
function eliminarItems() {
    const datos = new FormData()
    datos.append('opcion', 'cancelar')
    fetch(urlKardex, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (parseInt(respuesta['tabla']) == 0) {
            cuerpoDetalle.innerHTML = ""
        }
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })
}
function procesarItem() {
    const datos = new FormData()
    datos.append('opcion', 'agregarItem')
    datos.append('id', txt_idProducto.value)
    datos.append('cantidad', txt_cantidad.value)
    datos.append('producto', spn_Producto.textContent)
    datos.append('tipo', cobrarImpuestos ? "natural" : "juridico")
    fetch(urlKardex, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        spn_Producto.className = "text-danger"
        spn_Producto.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE PRODUCTO"
        txt_idProducto.value = ""
        spn_Unidades.innerText = "#"
        txt_cantidad.value = ""
        cuerpoDetalle.innerHTML = respuesta['tabla']
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })
}
function cargarNumeroFactura() {
    const datos = new FormData()
    datos.append('opcion', 'numeroFactura')
    fetch(urlVentaContado, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        spn_Factura.innerText = respuesta
        txt_factura.value = respuesta
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })
}
function cambioCliente() {
    cobrarImpuestos = tipo.value == "natural" ? true : false
    modalCliente()
}
function abrirModalCliente() {
    modalCliente()
}
function abrirModalProducto() {
    modalProducto()
}
function modalProducto() {
    const datos = new FormData()
    datos.append('opcion', 'modalProductosVenta')
    datos.append('pagina', paginaProducto)
    datos.append('campoP', campoProducto)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarProducto)
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
function modalCliente() {
    const datos = new FormData()
    datos.append('opcion', 'modalClienteVenta')
    datos.append('pagina', paginaCliente)
    datos.append('campo', campoCliente)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarCliente)
    let urlDestino = tipo.value == "natural" ? urlClienteN : urlClienteJ
    fetch(urlDestino, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaCliente').innerHTML = respuesta['tabla']
        document.getElementById('registrosCliente').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasCliente').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorCliente').innerHTML = respuesta['paginador']
        $('#ModalCliente').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}

$(document).on('click', '.seleccion', function (e) {
    let fila = $(this).parents("tr").find("td")[0]
    let nombre = $(fila).html()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objseleccion')
    cobrarImpuestos = tipo.value == "natural" ? true : false
    if ($('#ModalCliente').is(':visible')) {
        let filaC = $(this).parents("tr").find("td")[1]
        let nombreC = $(filaC).html()
        spn_Cliente.className = ""
        spn_Cliente.innerText = nombreC
        txt_idCliente.value = id
        paginaCliente = 1
        paginaProducto = 1
        campoCliente = ''
        buscarCliente = ''
        obtenerCategoria(id)
    } else if ($('#ModalProducto').is(':visible')) {
        spn_Producto.className = "text-success roboto-medium"
        spn_Producto.innerText = nombre
        txt_idProducto.value = id
        paginaCliente = 1
        paginaProducto = 1
        campoProducto = ''
        buscarProducto = ''
        obtenerStock(id)
    } else {
    }
})
function obtenerCategoria(codigo) {
    const datos = new FormData()
    datos.append('opcion', 'categoriaCliente')
    datos.append('codigoCliente', codigo)
    fetch(urlCatCliente, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        console.log(respuesta)
        listarItems()
        $('#ModalCliente').modal('hide')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })
}
function obtenerStock(id_producto) {
    const datos = new FormData()
    datos.append('opcion', 'stock')
    datos.append('id', id_producto)
    fetch(urlKardex, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        stock = parseInt(respuesta)
        if (stock == 0) {
            txt_cantidad.setAttribute('readonly', 'true')
        } else {
            txt_cantidad.removeAttribute('readonly')
        }
        spn_Unidades.innerText = stock
        $('#ModalProducto').modal('hide')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })
}