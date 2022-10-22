'use strict';

const form = document.querySelector('#form-iritzia');
const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('select, textarea');
    if (valor !== null) valoresEnviados[valor.name] = valor.value;
  });

  if (valoresEnviados.nota === '-') return mostrarMensajeError('error, nota inválida', form.querySelector('#nota').parentElement);
  if (valoresEnviados.idioma === '-') return mostrarMensajeError('error, idioma inválido', form.querySelector('#idioma'));

  if ('texto' in valoresEnviados && valoresEnviados.texto.length > 0 && valoresEnviados.texto.trim().split(/[\n ]/).length > 300)
    return mostrarMensajeError('error, la review demasiado larga', form.querySelector('#texto'));

  const campoEdad = form.querySelector('#edad');
  campoEdad.value = calcularEdad(campoEdad.value);

  form.submit();
});

const calcularEdad = (fecha) => {
  const hoy = new Date();
  const fechaNacimiento = new Date(fecha);

  let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
  const m = hoy.getMonth() - fechaNacimiento.getMonth();
  if (m < 0 || (m === 0 && hoy.getDate() < fechaNacimiento.getDate())) edad--;

  return edad;
};

const mostrarMensajeError = (texto, campo) => {
  const div = document.createElement('div');
  div.classList.add('error');
  const p = document.createElement('p');
  p.innerText = texto;
  div.appendChild(p);
  campo.insertAdjacentElement('afterend', div);
};
