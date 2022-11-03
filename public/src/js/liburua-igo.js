'use strict';

const inputSerie = document.querySelector('#serie');
const inputSerieNum = document.querySelector('#serie_num');
inputSerie.addEventListener('input', (e) => {
  const serieVacia = e.target.value === '';
  inputSerieNum.disabled = serieVacia;
  if (serieVacia) inputSerieNum.value = '';
});

selectorArchivo();

const form = document.querySelector('#form-subir-libro');
const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();
  const [campos, valoresEnviados] = buscarCampos();

  if (!/^(?=.*[A-Za-zÀ-ÖØ-öø-ÿ\-])[0-9A-Za-zÀ-ÖØ-öø-ÿ,.\-:; ]{1,100}$/.test(valoresEnviados.titulo))
    return mostrarMensajeError('Izenburua bakarrik letrak izan ditzake', campos.titulo);

  if (!/^(?=.*[0-9A-Za-zÀ-ÖØ-öø-ÿ\-])[A-Za-zÀ-ÖØ-öø-ÿ,. ]{1,100}$/.test(valoresEnviados.autor))
    return mostrarMensajeError('Egilea bakarrik letrak eta koma bat izan ditzake', campos.autor);

  if (valoresEnviados.serie !== '') {
    if (!/^[A-Za-zÀ-ÖØ-öø-ÿ,.\- ]{1,50}$/.test(valoresEnviados.serie)) return mostrarMensajeError('Saila bakarrik letrak izan ditzake', campos.serie);

    if (!/^[\d,.]{1,5}$/.test(valoresEnviados.serie_num)) return mostrarMensajeError('Saila zenbakia zenbaki bat izan behar da', campos.serie_num);
  }

  if (valoresEnviados.fecha === '') return mostrarMensajeError('Idatzi data bat', campos.fecha);

  if (valoresEnviados.formato === '-') return mostrarMensajeError('Aukeratu formatu bat', campos.formato);

  if (valoresEnviados.imagen === undefined) return mostrarMensajeError('Aukeratu azal bat', document.querySelector('.file-input-text'));
  if (valoresEnviados.imagen['type'].split('/')[0] !== 'image')
    return mostrarMensajeError('Fitxategia argazkia izan behar da', document.querySelector('.file-input-text'));

  if (valoresEnviados.sinopsis.length === 0) return mostrarMensajeError('error, la sinopsis no puede estar vacía', campos.sinopsis);

  form.submit();
});
