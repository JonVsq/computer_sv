let url = '../../controlador/EmpresaController.php';
const btn_guardar = document.getElementById('btn_guardar')
const btn_modificar = document.getElementById('btn_modificar')
let modificar = false
//HASTA QUE LA PAGINA SE CARGA SE INICIAN LOS EVENTOS
window.addEventListener("load", inicio)
//INICIA LOS EVENTOS DEL DOM
function inicio() {
    consultarDatos()
    btn_guardar.addEventListener("click", guardar)
    btn_modificar.addEventListener("click", modificacion)
}
function modificacion() {
    if (modificar) {
        btn_modificar.innerHTML = "<i class='fas fa-edit'></i> &nbsp; MODIFICAR"
        modificar = false
        document.getElementById('txt_nombre').setAttribute('readonly', 'true')
        document.getElementById('txt_correo').setAttribute('readonly', 'true')
        document.getElementById('txt_telefono').setAttribute('readonly', 'true')
        document.getElementById('txt_direccion').setAttribute('readonly', 'true')
        document.getElementById('txt_cod').setAttribute('readonly', 'true')
        document.getElementById('txt_nit').setAttribute('readonly', 'true')
        document.getElementById('txt_ciu').setAttribute('readonly', 'true')
        document.getElementById('txt_pais').setAttribute('readonly', 'true')
        document.getElementById('txt_correo').setAttribute('readonly', 'true')
        document.getElementById('txt_fax').setAttribute('readonly', 'true')
        document.getElementById('txt_web').setAttribute('readonly', 'true')
        btn_guardar.setAttribute('disabled', 'true')
        consultarDatos()
    } else {
        modificar = true
        btn_modificar.innerHTML = "<i class='fas fa-arrow-circle-left'></i> &nbsp; CANCELAR"
        document.getElementById('txt_nombre').removeAttribute('readonly')
        document.getElementById('txt_correo').removeAttribute('readonly')
        document.getElementById('txt_telefono').removeAttribute('readonly')
        document.getElementById('txt_direccion').removeAttribute('readonly')
        document.getElementById('txt_cod').removeAttribute('readonly')
        document.getElementById('txt_nit').removeAttribute('readonly')
        document.getElementById('txt_ciu').removeAttribute('readonly')
        document.getElementById('txt_pais').removeAttribute('readonly')
        document.getElementById('txt_correo').removeAttribute('readonly')
        document.getElementById('txt_fax').removeAttribute('readonly')
        document.getElementById('txt_web').removeAttribute('readonly')
        btn_guardar.removeAttribute('disabled')
    }
}
function guardar() {
    btn_guardar.setAttribute('disabled', 'true')
    let $valid = $('#cuadroFormulario form').valid()
    let telefono = validarTelefono()
    if (!$valid) {
        btn_guardar.removeAttribute('disabled')
        return false;
    } else {
        if (telefono) {
            const datos = new FormData(document.getElementById('frm_datos'))
            if (!modificar) {
                datos.append('opcion', 'insertar')
            } else {
                datos.append('opcion', 'modificar')
            }
            fetch(url, {
                method: 'POST',
                body: datos
            }).then(function (respuesta) {
                if (respuesta.ok) {
                    return respuesta.json()
                }
            }).then(respuesta => {
                if (respuesta[0].estado == 1) {
                    modificar = false
                    document.getElementById('txt_nombre').setAttribute('readonly', 'true')
                    document.getElementById('txt_correo').setAttribute('readonly', 'true')
                    document.getElementById('txt_telefono').setAttribute('readonly', 'true')
                    document.getElementById('txt_direccion').setAttribute('readonly', 'true')

                    document.getElementById('txt_cod').setAttribute('readonly', 'true')
                    document.getElementById('txt_nit').setAttribute('readonly', 'true')
                    document.getElementById('txt_ciu').setAttribute('readonly', 'true')
                    document.getElementById('txt_pais').setAttribute('readonly', 'true')
                    document.getElementById('txt_correo').setAttribute('readonly', 'true')
                    document.getElementById('txt_fax').setAttribute('readonly', 'true')
                    document.getElementById('txt_web').setAttribute('readonly', 'true')
                    document.getElementById('txt_id').value = respuesta[0].id

                    btn_modificar.removeAttribute('disabled')
                    btn_modificar.innerHTML = "<i class='fas fa-edit'></i> &nbsp; MODIFICAR"
                }
                mensaje(respuesta[0].encabezado, respuesta[0].msj, respuesta[0].icono)
            }).catch(error => {
                btn_guardar.removeAttribute('disabled')
                alert('Ocurrio un error conectando con el servidor, intente de nuevo'+ error)
            })
        } else {
            btn_guardar.removeAttribute('disabled')
        }
    }
}
function validarTelefono() {
    let valido = false
    if (document.getElementById('txt_telefono').value == "") {
        document.getElementById('telefonoError').innerHTML = "<span id='txt_telefonoError' class='error'>Por favor, ingrese número de teléfono.</span>"
    } else {
        valido = true
        document.getElementById('telefonoError').innerHTML = ""
    }
    return valido
}
function consultarDatos() {
    const datos = new FormData()
    datos.append('opcion', 'obtener')
    fetch(url, {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        console.log(respuesta)
        if (respuesta == null) {
        document.getElementById('txt_nombre').removeAttribute('readonly')
        document.getElementById('txt_correo').removeAttribute('readonly')
        document.getElementById('txt_telefono').removeAttribute('readonly')
        document.getElementById('txt_direccion').removeAttribute('readonly')
        document.getElementById('txt_cod').removeAttribute('readonly')
        document.getElementById('txt_nit').removeAttribute('readonly')
        document.getElementById('txt_ciu').removeAttribute('readonly')
        document.getElementById('txt_pais').removeAttribute('readonly')
        document.getElementById('txt_correo').removeAttribute('readonly')
        document.getElementById('txt_fax').removeAttribute('readonly')
        document.getElementById('txt_web').removeAttribute('readonly')
        btn_guardar.removeAttribute('disabled')
        btn_guardar.removeAttribute('disabled')
        } else {
            btn_modificar.removeAttribute('disabled')
            document.getElementById('txt_nombre').value =respuesta[0].nombre
            document.getElementById('txt_correo').value = respuesta[0].correo
            document.getElementById('txt_direccion').value = respuesta[0].direccion
            document.getElementById('txt_id').value = respuesta[0].id
            document.getElementById('txt_telefono').value = respuesta[0].telefono
            document.getElementById('txt_cod').value = respuesta[0].direccion
            document.getElementById('txt_nit').value = respuesta[0].nit
            document.getElementById('txt_fax').value = respuesta[0].fax
            document.getElementById('txt_web').value = respuesta[0].web
            document.getElementById('txt_pais').value = respuesta[0].pais
            document.getElementById('txt_ciu').value = respuesta[0].ciudad


        }
    }).catch(error => {
        alert('Ocurrio un error conectando al servidor, intente de nuevo')
    })
}

//FUNCION QUE MUESTRA LOS MENSAJES AL USUARIO
function mensaje(encabezado, msj, icono) {
    swal(encabezado, msj, icono)
}