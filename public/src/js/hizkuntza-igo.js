'use strict';

const form = document.querySelector('#form-hizkuntza');

function recoger_usuario(){
    if(document.formHizkuntza.otro[0].checked == true){
        document.getElementById('Hizkuntza-berria').style.display='block';
        document.getElementById('Hizkuntza-berria').required = true;
    }else{
        document.getElementById('Hizkuntza-berria').style.display='none';
        document.getElementById('Hizkuntza-berria').required = false;
        var ele = document.getElementsByName("Hizkuntza-berria");
        for(var i=0;i<ele.length;i++){
          ele[i].checked = false;
        }
    }
}