'use strict';

agregarContadorPalabras(300);

const form = document.querySelector('#form-iritzia');
const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();
  const [campos, valoresEnviados] = buscarCampos();

  if (valoresEnviados.nota === '-') return mostrarMensajeError('Aukeratu nota bat', campos.nota);
  if (valoresEnviados.idioma === '-') return mostrarMensajeError('Aukeratu hizkuntz bat', campos.idioma);

  if (
    'texto' in valoresEnviados &&
    valoresEnviados.texto.length > 0 &&
    (contarPalabras(valoresEnviados.texto) > 300 || valoresEnviados.texto.length > 2295)
  )
    return mostrarMensajeError('Iritzia 300 hitz edo gutxiago izan behar du', campos.texto);

  const campoEdad = form.querySelector('#edad');
  campoEdad.value = calcularEdad(campoEdad.value);

  form.submit();
});
