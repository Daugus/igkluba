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

  if (valoresEnviados.nota === '-') return mostrarMensajeError('error, nota inválida');
  if (valoresEnviados.idioma === '-') return mostrarMensajeError('error, idioma inválido');

  if ('texto' in valoresEnviados && valoresEnviados.texto.length > 0 && valoresEnviados.texto.trim().split(/[\n ]/).length > 300)
    return mostrarMensajeError('error, la review demasiado larga', form.querySelector('#texto'));

  const campoEdad = form.querySelector('#edad');
  campoEdad.value = calcularEdad(campoEdad.value);

  form.submit();
});
