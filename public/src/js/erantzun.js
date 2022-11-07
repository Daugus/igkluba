'use strict';

const form = document.querySelector('#form-iritzia');
const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();
  const [campos, valoresEnviados] = buscarCampos();

  if (valoresEnviados.texto.length === 0) return mostrarMensajeError('Idatzi erantzun bat', campos.texto);

  if (valoresEnviados.texto.trim().split(/[\n ]/).length > 100 || valoresEnviados.texto.length > 765)
    return mostrarMensajeError('Erantzuna 100 hitz edo gutxiago izan behar du', campos.texto);

  form.submit();
});
