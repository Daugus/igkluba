'use strict';

const form = document.querySelector('form');
const btnLogin = document.querySelector('#login');
btnLogin.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();
  const [campos, valoresEnviados] = buscarCampos();

  console.table(valoresEnviados);
  if (valoresEnviados.apodo === '') return mostrarMensajeError('Idatzi ezizen bat', campos.apodo);
  if (valoresEnviados.pass === '') return mostrarMensajeError('Idatzi pasahitz bat', campos.pass);
  if (valoresEnviados.clase !== undefined && !/^[A-Za-z0-9]{6,6}$/.test(valoresEnviados.clase))
    return mostrarMensajeError('Klasearen kodea ez da egokia', campos.clase);

  form.submit();
});
