// click en mostrar grupos
function grupos() {

    // obtengo la id de los contenedores y oculto todos menos el q me interesa
    document.getElementById("contenedorClase").style.display = "block";
    document.getElementById("contenedorReviews").style.display = "none";
    document.getElementById("contenedorIdioma").style.display = "none";
    document.getElementById("contenedorAdmision").style.display = "none";
  
}

// click en mostrar reviews
function reviews() {
    // obtengo la id de los contenedores y oculto todos menos el q me interesa
    document.getElementById("contenedorClase").style.display = "none";
    document.getElementById("contenedorReviews").style.display = "block";
    document.getElementById("contenedorIdioma").style.display = "none";
    document.getElementById("contenedorAdmision").style.display = "none";
} 

// click en mostrar solicitud de idiomas
function solIdiomas() {
    // obtengo la id de los contenedores y oculto todos menos el q me interesa
    document.getElementById("contenedorClase").style.display = "none";
    document.getElementById("contenedorReviews").style.display = "none";
    document.getElementById("contenedorIdioma").style.display = "block";
    document.getElementById("contenedorAdmision").style.display = "none";
} 

// click en mostrar solicitud de admision
function solAdmision() {
    // obtengo la id de los contenedores y oculto todos menos el q me interesa
    document.getElementById("contenedorClase").style.display = "none";
    document.getElementById("contenedorReviews").style.display = "none";
    document.getElementById("contenedorIdioma").style.display = "none";
    document.getElementById("contenedorAdmision").style.display = "block";
}