//C0NSTANTES
const btn_ingresar = document.getElementById('btn_ingresar')
const txt_pass = document.getElementById('txt_pass')
const txt_correo = document.getElementById('txt_correo')
//HASTA QUE LA PAGINA SE CARGA SE INICIAN LOS EVENTOS
window.addEventListener("load", inicio)
function inicio() {
    btn_ingresar.addEventListener("click", ingresar)
    txt_correo.addEventListener("keyup", limpiarError)
    txt_pass.addEventListener("keyup", limpiarError)
}
function limpiarError() {
    document.getElementById('errorLogin').innerHTML = ""
}
function ingresar() {
    btn_ingresar.value = "ESPERE"
    btn_ingresar.setAttribute('disabled', 'true')
    let $valid = $('#cuadroFormulario form').valid()
    if (!$valid) {
        btn_ingresar.value = "INGRESAR"
        btn_ingresar.removeAttribute('disabled')
        return false
    } else {
        verificarCredenciales()
    }
}
function verificarCredenciales() {
    const datos = new FormData(document.getElementById('frm_login'))
    datos.append('opcion', 'entrar')
    fetch('../controlador/LoginController.php', {
        method: 'POST',
        body: datos
    }).then(function (respuesta) {
        if (respuesta.ok) {
            return respuesta.json()
        }
    }).then(respuesta => {
        if (respuesta[0].estado == 0) {
            document.getElementById('errorLogin').innerHTML = "<span class='error roboto-medium'>" + respuesta[0].mensaje + "</span>"
        } else {
            btn_ingresar.removeAttribute('disabled')
            document.getElementById('errorLogin').innerHTML = ""
            if (respuesta[0].primera == 1) {
                window.location.replace('../vista/administracion.php');
            } else {
                window.location.replace('../vista/ventas.php');
            }
        }
        btn_ingresar.value = "INGRESAR"
        btn_ingresar.removeAttribute('disabled')
    }).catch(error => {
        btn_ingresar.value = "INGRESAR"
        btn_ingresar.removeAttribute('disabled')
        alert('OCURRIO UN ERROR CONECTANDO AL SERVIDOR, INTENTE DE NUEVO.')
    })
}