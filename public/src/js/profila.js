'use strict';

const form = document.querySelector('#form-clase');
const btnEnviar = document.querySelector('#enviar');
btnEnviar?.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();
  const [campos, valoresEnviados] = buscarCampos();

  if (valoresEnviados.nombre === '') return mostrarMensajeError('Idatzi izen bat', campos.nombre);
  if (valoresEnviados.nombre.length > 30) return mostrarMensajeError('Izena luzeegia da', campos.nombre);
  if (valoresEnviados.nivel === '-') return mostrarMensajeError('Aukeratu maila bat', campos.nivel);

  form.submit();
});
