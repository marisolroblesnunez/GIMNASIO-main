// ADMIN/js/sesiones.js
// Aviso si el usuario está inactivo por cierto tiempo

let tiempoInactividad = 0;
const tiempoLimite = 10 * 60; // 10 minutos

setInterval(() => {
    tiempoInactividad++;
    if (tiempoInactividad >= tiempoLimite) {
        alert("Has estado inactivo demasiado tiempo. Por seguridad, se cerrará la sesión.");
        window.location.href = "logout.php";
    }
}, 1000);

// Reinicia el contador al mover el mouse o pulsar teclas
["mousemove", "keydown", "click"].forEach(evento => {
    document.addEventListener(evento, () => tiempoInactividad = 0);
});
