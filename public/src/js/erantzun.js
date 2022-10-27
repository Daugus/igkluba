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

  if (valoresEnviados.texto.length === 0) return mostrarMensajeError('error, la respuesta no puede estar vacía');

  if (valoresEnviados.texto.trim().split(/[\n ]/).length > 100 || valoresEnviados.texto.length > 765)
    return mostrarMensajeError('error, la respuesta es demasiado larga');

  form.submit();
});
