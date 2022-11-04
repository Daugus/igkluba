'use strict';

const form = document.querySelector('#form-hizkuntza');

const selectIdioma = document.querySelector('#idioma');
const divIdiomaNuevo = document.querySelector('#nuevo-idioma');
selectIdioma.addEventListener('input', e => {
    if (e.target.value === 'otro'){
        divIdiomaNuevo.classList.remove("hidden");
    } else {
        divIdiomaNuevo.classList.add("hidden");
    }
})

const btnLogin = document.querySelector('#login');
btnLogin.addEventListener('click', (e) => {
    e.preventDefault();
    eliminarMensajesError();
    const [campos, valoresEnviados] = buscarCampos();
  
    if (!/^[A-Za-zÀ-ÖØ-öø-ÿ\- ]{1,50}$/.test(valoresEnviados.liburuIzena)) return mostrarMensajeError('Liburuaren izena ezin da egon utzik', campos.liburuIzena);
  
    if (valoresEnviados.idioma === '-') return mostrarMensajeError('Hizkuntza ezin da egon utzik', campos.idioma);
  
    if (valoresEnviados.idioma === 'otro' && !/^[A-Z][A-Za-zÀ-ÖØ-öø-ÿ\- ]{1,49}$/.test(valoresEnviados.hizkuntzaBerria)) return mostrarMensajeError('Letra larriz hasi behar da', campos.hizkuntzaBerria);
    
    form.submit();
  });