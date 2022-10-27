'use strict';

const form = document.querySelector('form');
const btnLogin = document.querySelector('#login');
btnLogin.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input');
    valoresEnviados[valor.name] = valor.value;
  });

  if (valoresEnviados.apodo === '') return mostrarMensajeError('error, el apodo no puede estar vacío');
  if (valoresEnviados.pass === '') return mostrarMensajeError('error, la contraseña no puede estar vacía');

  form.submit();
});
