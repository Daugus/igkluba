'use strict';

const form = document.querySelector('form');
const btnLogin = document.querySelector('#login');
btnLogin.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();
  const [campos, valoresEnviados] = buscarCampos();

  if (valoresEnviados.apodo === '') return mostrarMensajeError('Idatzi ezizen bat', campos.apodo);
  if (valoresEnviados.pass === '') return mostrarMensajeError('Idatzi pasahitz bat', campos.pass);

  form.submit();
});
