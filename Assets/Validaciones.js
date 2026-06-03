// Validaciones básicas en frontend
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    if (form) {
        form.addEventListener("submit", function(event) {
            const password = document.querySelector("input[name='password']");
            const password2 = document.querySelector("input[name='password2']");
            const email = document.querySelector("input[name='correo']");

            // Validar contraseñas coincidentes
            if (password && password2 && password.value !== password2.value) {
                alert("Las contraseñas no coinciden.");
                event.preventDefault();
                return;
            }

            // Validar formato de correo
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                alert("Correo electrónico inválido.");
                event.preventDefault();
                return;
            }
        });
    }
});
