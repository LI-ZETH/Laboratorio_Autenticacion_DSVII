// Validaciones unificadas en frontend
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    const pwdInput = form.querySelector("input[name='password']");
    const confInput = form.querySelector("input[name='confirm_password']");
    const emailInput = form.querySelector("input[name='correo']");

    const pwd = pwdInput ? pwdInput.value : '';
    const conf = confInput ? confInput.value : '';

    // Contraseña: longitud y complejidad
    const okLength = pwd.length >= 8;
    const okComplex = /[A-Z]/.test(pwd) && /[a-z]/.test(pwd) && /\d/.test(pwd);
    if (!okLength || !okComplex) {
      e.preventDefault();
      alert('La contraseña debe tener al menos 8 caracteres, mayúscula, minúscula y número.');
      return;
    }

    // Coincidencia de contraseñas
    if (pwd !== conf) {
      e.preventDefault();
      alert('Las contraseñas no coinciden.');
      return;
    }

    // Validar formato de correo
    if (emailInput && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
      e.preventDefault();
      alert('Correo electrónico inválido.');
      return;
    }
  });
});
