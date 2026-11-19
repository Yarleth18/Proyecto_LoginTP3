const regexGmail = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

// Muestra o limpia un mensaje de error. Devuelve true si NO hay error.
function mostrarError(idSpan, mensaje) {
    document.getElementById(idSpan).textContent = mensaje;
    return mensaje === "";
}

function valor(id) {
    return document.getElementById(id).value.trim();
}

// ---------- LOGIN ----------
const formLogin = document.getElementById("formLogin");
if (formLogin) {
    formLogin.addEventListener("submit", function (e) {
        let ok = true;

        ok = mostrarError("errorCorreo",
            regexGmail.test(valor("correo")) ? "" : "Email @gmail.com obligatorio") && ok;

        ok = mostrarError("errorPassword",
            document.getElementById("password").value.length >= 8
                ? "" : "La contraseña es obligatoria (mín 8)") && ok;

        if (!ok) e.preventDefault();
    });
}

// ---------- REGISTRO ----------
const formRegistro = document.getElementById("formRegistro");
if (formRegistro) {
    formRegistro.addEventListener("submit", function (e) {
        let ok = true;
        const pass = document.getElementById("password").value;
        const pass2 = document.getElementById("password2").value;

        ok = mostrarError("errorNombre",
            valor("nombre") !== "" ? "" : "El nombre es obligatorio") && ok;

        ok = mostrarError("errorApellido",
            valor("apellido") !== "" ? "" : "El apellido es obligatorio") && ok;

        ok = mostrarError("errorCorreo",
            regexGmail.test(valor("correo")) ? "" : "Email @gmail.com obligatorio") && ok;

        ok = mostrarError("errorPassword",
            regexPassword.test(pass)
                ? "" : "Mín 8 chars, mayúscula, minúscula, número y símbolo") && ok;

        ok = mostrarError("errorPassword2",
            pass === pass2 ? "" : "Las contraseñas no coinciden") && ok;

        if (!ok) e.preventDefault();
    });
}

// ---------- OLVIDÉ MI CONTRASEÑA ----------
const formOlvide = document.getElementById("formOlvide");
if (formOlvide) {
    formOlvide.addEventListener("submit", function (e) {
        let ok = true;
        const pass = document.getElementById("password").value;
        const pass2 = document.getElementById("password2").value;

        ok = mostrarError("errorCorreo",
            regexGmail.test(valor("correo")) ? "" : "Email @gmail.com obligatorio") && ok;

        ok = mostrarError("errorApellido",
            valor("apellido") !== "" ? "" : "El apellido es obligatorio") && ok;

        ok = mostrarError("errorPassword",
            regexPassword.test(pass)
                ? "" : "Mín 8 chars, mayúscula, minúscula, número y símbolo") && ok;

        ok = mostrarError("errorPassword2",
            pass === pass2 ? "" : "Las contraseñas no coinciden") && ok;

        if (!ok) e.preventDefault();
    });
}