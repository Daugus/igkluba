'use strict';

const form = document.querySelector('form');
const btnLogin = document.querySelector('#login');
btnLogin.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.mensaje-error').forEach((mensaje) => mensaje.remove());

  const campos = [...form.querySelectorAll('.campo')];
  let elementosCampos = {};

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input');
    valoresEnviados[valor.name] = valor.value;
    elementosCampos[valor.name] = valor;
  });

  if (valoresEnviados.apodo === '') return mostrarMensajeError('Ezizena ezin', elementosCampos.apodo);
  if (valoresEnviados.pass === '') return mostrarMensajeError('error, la contraseña no puede estar vacía', elementosCampos.pass);

  form.submit();
});
