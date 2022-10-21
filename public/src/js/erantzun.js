'use strict';

const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const form = document.querySelector('#form-iritzia');
  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('select, textarea');
    if (valor !== null) valoresEnviados[valor.name] = valor.value;
  });

  if (valoresEnviados.texto.length === 0) return mostrarMensajeError('error, la respuesta no puede estar vacía', form.querySelector('#texto'));

  if (valoresEnviados.texto.trim().split(/[\n ]/).length > 100 || valoresEnviados.texto.length > 765)
    return mostrarMensajeError('error, la respuesta es demasiado larga', form.querySelector('#texto'));

  form.submit();
});

const mostrarMensajeError = (texto, campo) => {
  const div = document.createElement('div');
  div.classList.add('error');
  const p = document.createElement('p');
  p.innerText = texto;
  div.appendChild(p);
  campo.insertAdjacentElement('afterend', div);
};
