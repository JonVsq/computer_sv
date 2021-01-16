//CONSTANTES
const txt_id = document.getElementById('txt_id')
const txt_idProveedor = document.getElementById('txt_idProveedor')
const txt_garantia = document.getElementById('txt_garantia')
const garantiaError = document.getElementById('garantiaError')
const spn_Proveedor = document.getElementById('spn_Proveedor')
const txt_factura = document.getElementById('txt_factura')
const facturaError = document.getElementById('facturaError')
const txt_fecha = document.getElementById('txt_fecha')
const fechaError = document.getElementById('fechaError')
const txt_idProducto = document.getElementById('txt_idProducto')
const spn_Producto = document.getElementById('spn_Producto')
const btn_modalProducto = document.getElementById('btn_modalProducto')
const btn_modalProveedor = document.getElementById('btn_modalProveedor')
const txt_cantidad = document.getElementById('txt_cantidad')
const cantidadError = document.getElementById('cantidadError')
const txt_precio = document.getElementById('txt_precio')
const precioError = document.getElementById('precioError')
const btn_agregar = document.getElementById('btn_agregar')
const cuerpoDetalle = document.getElementById('cuerpoDetalle')
const btn_listar = document.getElementById('btn_listar')
const btn_guardar = document.getElementById('btn_guardar')
const txt_buscarProducto = document.getElementById('txt_buscarProducto')
const txt_buscarDescripcion = document.getElementById('txt_buscarDescripcion')
const txt_buscarProveedor = document.getElementById('txt_buscarProveedor')
const spn_total = document.getElementById('spn_total')
//DIRECCION CONTROLADORES
let urlCompra = '../../controlador/CompraController.php'
let modificar = false
let paginaProveedor = 1
let campoProveedor = ""
let buscarProveedor = ""
let paginaProducto = 1
let campoProducto = ""
let buscarProducto = ""
let granTotal = 0
let cantida = 5
let items = []
let modificarItem = false
let indice = -1
let modificarCompra = false
//DETECTA SI LA VENTA YA SE CARGAR
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS
function inicio() {
    btn_modalProveedor.addEventListener("click", modalProveedor)
    btn_modalProducto.addEventListener("click", modalProducto)
    txt_buscarProveedor.addEventListener("keyup", filtroProveedor)
    txt_buscarProducto.addEventListener("keyup", filtroProducto)
    txt_buscarDescripcion.addEventListener("keyup", filtroDescripcion)
    btn_agregar.addEventListener("click", agregatItem)
    btn_guardar.addEventListener("click", guardarModificarCompra)
}
function guardarModificarCompra() {
    console.log('hola')
    btn_guardar.setAttribute('disabled', true)
    let fechaV = validarFecha()
    let factV = false
    let validaIdP = false
    if (txt_factura.value != "") {
        factV = true
        facturaError.innerHTML = ""
    } else {
        factV = false
        facturaError.innerHTML = "<span class='error'>Este campo es obligatorio</span>"
    }
    if (txt_idProveedor.value != "") {
        validaIdP = true
    } else {
        validaIdP = false
    }
    if (fechaV && factV && validaIdP) {
        if (items.length == 0) {
            btn_guardar.removeAttribute('disabled')
            mensaje("ERROR", "NO ES POSIBLE REGISTRAR COMPRAS SIN PRODUCTOS.", "error")
        } else {
            const datos = new FormData()
            datos.append('txt_idProveedor', txt_idProveedor.value)
            datos.append('txt_factura', txt_factura.value)
            datos.append('txt_fecha', txt_fecha.value)
            datos.append('items', JSON.stringify(items))
            if (modificarCompra) {
                datos.append('id', txt_id.value)
                datos.append('opcion', 'modificar')
            } else {
                datos.append('opcion', 'insertar')

            }
            fetch(urlCompra, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                }
            }).then(respuesta => {
                if (respuesta[0].estado == 1) {
                    spn_Proveedor.className = "text-danger"
                    spn_Proveedor.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE PROVEEDOR"
                    spn_Proveedor.className = "text-danger"
                    spn_Proveedor.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE PRODUCTO"
                    txt_cantidad.value = ""
                    txt_factura.value = ""
                    txt_garantia.value = ""
                    txt_precio.value = ""
                    txt_fecha.value = ""
                    spn_total.textContent = "TOTAL $:"
                    cuerpoDetalle.innerHTML = ""

                }
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
                btn_guardar.removeAttribute('disabled')

            }).catch(error => {
                btn_guardar.removeAttribute('disabled')
                alert("Ocurrio un error conectando al servidor");
            })

        }
    } else {
        btn_guardar.removeAttribute('disabled')
    }

}
function agregatItem() {
    btn_agregar.setAttribute('disabled', 'true')
    let id = false
    let canti = false
    let precio = false
    let garantia = false
    if (txt_idProducto.value != "") {
        id = true;
    } else {
        id = false;
    }
    if (txt_garantia.value != "") {
        garantia = true
        garantiaError.innerHTML = ""
    } else {
        garantia = false
        garantiaError.innerHTML = "<span class='error'>Este campo es obligatorio.</span>"
    }
    if (txt_cantidad.value != "") {
        if (parseFloat(txt_cantidad.value) < 1) {
            canti = false
            cantidadError.innerHTML = "<span class='error'>Debe ser mayor a 0.</span>"
        } else {
            canti = true
            cantidadError.innerHTML = ""
        }
    } else {
        cantidadError.innerHTML = "<span class='error'>Ingrese una cantidad.</span>"
        canti = false
    }
    if (txt_precio.value != "") {
        if (parseFloat(txt_precio.value) <= 0) {
            precioError.innerHTML = "<span class='error'>Deber ser mayor a 0.</span>"
            precio = false
        } else {
            precio = true
            precioError.innerHTML = ""
        }
    } else {
        precioError.innerHTML = "<span class='error'>Ingrese precio.</span>"
        precio = false
    }
    if (id && canti && precio && garantia) {
        if (modificarItem) {
            items[indice][0] = parseFloat(txt_idProducto.value)
            items[indice][1] = spn_Producto.textContent
            items[indice][2] = parseFloat(txt_cantidad.value)
            items[indice][3] = parseFloat(txt_precio.value)
            items[indice][4] = parseFloat(txt_garantia.value)

        } else {
            items.push([parseFloat(txt_idProducto.value), spn_Producto.textContent, parseFloat(txt_cantidad.value), parseFloat(txt_precio.value), parseFloat(txt_garantia.value)])
        }
        spn_Producto.className = "text-danger"
        spn_Producto.innerHTML = "&nbsp; <i class='fas fa-exclamation-triangle'></i> SELECCIONE PRODUCTO"
        txt_idProducto.value = ""
        txt_cantidad.value = ""
        txt_precio.value = ""
        txt_garantia.value = ""
        indice = -1
        modificarItem = false
        llenarTabla()
        btn_agregar.removeAttribute('disabled')
    } else {
        btn_agregar.removeAttribute('disabled')
    }
}
function llenarTabla() {
    let tabla = ''
    granTotal = 0
    items.forEach(function (elemento, indice, array) {
        var cal = parseFloat(elemento[2] * elemento[3]).toFixed(2)
        granTotal = parseFloat(granTotal) + parseFloat(cal)
        tabla = tabla + `
        <tr>
        <td class ='text-center'>${elemento[1]}</td>
        <td class ='text-center'>${elemento[2]}</td>
        <td class ='text-center'>${elemento[3]}</td>
        <td class ='text-center'>${cal}</td>
        <td class ='text-center'>${elemento[4]}</td>
        <td><button objeditarItem='${indice}' type='button' class='editarItem btn btn-primary btn-sm'>
            <i class='fas fa-edit'></i></button>
            <button objeliminarItem='${indice}' type='button' class='eliminarItem btn btn-danger btn-sm'>
            <i class='fas fa-trash'></i></button>
         </td>
        </tr>
        `;
        console.log(elemento)
    })
    spn_total.innerText = "TOTAL $: " + granTotal
    cuerpoDetalle.innerHTML = tabla
}
//ELIMINA EL ITEM
$(document).on('click', '.eliminarItem', function () {
    let elemento = $(this)[0]
    let i = $(elemento).attr('objeliminarItem')
    eliminarItem(i)
})
function eliminarItem(i) {
    items.splice(i, 1)
    llenarTabla()
}
//OBTIENE LOS DATOS PARA MODIFICAR
$(document).on('click', '.editarItem', function () {
    let elemento = $(this)[0]
    indice = $(elemento).attr('objeditarItem')
    cargaItem()
})
function cargaItem() {
    txt_idProducto.value = items[indice][0]
    spn_Producto.className = ""
    spn_Producto.innerText = items[indice][1]
    txt_cantidad.value = items[indice][2]
    txt_precio.value = items[indice][3]
    modificarItem = true

}
function modalProveedor() {
    const datos = new FormData()
    datos.append('opcion', 'modalProveedor')
    datos.append('pagina', paginaProveedor)
    datos.append('campo', campoProveedor)
    datos.append('cantidad', cantida)
    datos.append('buscar', buscarProveedor)
    fetch(urlCompra, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        document.getElementById('cuerpoTablaProveedor').innerHTML = respuesta['tabla']
        document.getElementById('registrosProveedor').innerText = "MOSTRANDO DEL " + respuesta['desde'] + " AL " + respuesta['hasta'] + " DE UN TOTAL DE " + respuesta['totalRegistros'] + " REGISTROS."
        document.getElementById('totalPaginasProveedor').innerText = "VISUALIZANDO PAGINA " + respuesta['paginaActual'] + " DE UN TOTAL DE  " + respuesta['totalPagina']
        document.getElementById('paginadorProveedor').innerHTML = respuesta['paginador']
        $('#ModalProveedor').modal('show')
    }).catch(error => {
        console.log(error)
        alert('OCURRIO UN ERROR CONECTANDO CON ELSERVIDOR, INTENTE DE NUEVO.')
    })

}
function modalProducto() {
    const datos = new FormData()
    datos.append('opcion', 'modalProductos')
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
function filtroProveedor() {
    if (txt_buscarProveedor.value.length > 0) {
        campoProveedor = 'nombre'
        buscarProveedor = txt_buscarProveedor.value
        modalProveedor()
    } else {
        campoProveedor = ''
        buscarProveedor = ''
        modalProveedor()
    }
}
function filtroProducto() {
    if (txt_buscarProducto.value.length > 0) {
        txt_buscarDescripcion.value = ""
        campoProducto = 'producto'
        buscarProducto = txt_buscarProducto.value
        modalProducto()
    } else {
        campoProducto = ''
        buscarProducto = ''
        modalProducto()
    }
}
function filtroDescripcion() {
    if (txt_buscarDescripcion.value.length > 0) {
        txt_buscarProducto.value = ""
        campoProducto = 'descripcion'
        buscarProducto = txt_buscarDescripcion.value
        modalProducto()
    } else {
        campoProducto = ''
        buscarProducto = ''
        modalProducto()
    }
}
$(document).on('click', '.seleccion', function (e) {
    let fila = $(this).parents("tr").find("td")[0]
    let nombre = $(fila).html()
    let elemento = $(this)[0]
    let id = $(elemento).attr('objseleccion')
    if ($('#ModalProveedor').is(':visible')) {
        spn_Proveedor.className = ""
        spn_Proveedor.innerText = nombre
        txt_idProveedor.value = id
        paginaProveedor = 1
        paginaProducto = 1
        campoProveedor = ''
        buscarProveedor = ''
        $('#ModalProveedor').modal('hide')
    } else if ($('#ModalProducto').is(':visible')) {
        spn_Producto.className = ""
        spn_Producto.innerText = nombre
        txt_idProducto.value = id
        paginaProveedor = 1
        paginaProducto = 1
        campoProducto = ''
        buscarProducto = ''
        $('#ModalProducto').modal('hide')
    } else {
    }
})
function validarFecha() {
    let fechaValida = false
    if (txt_fecha.value != "") {
        let fecha = new Date()

        let compra = new Date(txt_fecha.value)
        fechaValida = (fecha > compra) ? true : false
        if (fechaValida) {
            fechaError.innerHTML = ""
        } else {
            fechaError.innerHTML = "<span  class='error'>La fecha no puede ser mayor a la actual.</span>"
        }
    } else {
        fechaValida = false
        fechaError.innerHTML = "<span  class='error'>Este campo es obligatorio.</span>"

    }
    return fechaValida
}
//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}