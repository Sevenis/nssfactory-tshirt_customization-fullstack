var $ = require('jquery');

//al click sull'img della tshirt scelta, quest'ultima viene copiata
//nel box preview
$(document).on('click', '.tshirt-panel .box', function() {
    //svuota il campo preview
    $(".tshirt-chosen").empty();
    // crea un clone dell'img scelta tramite click
    var $img = $(this).children("img").clone();
    // appende il clone nella sezione preview
    $(".tshirt-chosen").append($img);
    // assegno ad una variabile il valore di alt dell'img della tshirt scelta e passo quindi "nometshirt.png"
    var $url= $(".tshirt-chosen img").attr('alt');
    // incollo il valore scelto nell'input HIDDEN
    $('#pj-tshirt').attr('value', $url);
});

//al click sull'img del logo scelto, quest'ultimo viene copiato
//nel box preview
$(document).on('click', '.logo-panel .box', function() {
    //svuota il campo preview
    $(".logo-chosen").empty();
    // crea un clone del logo scelto tramite click
    var $img = $(this).children("img").clone();
    // appende il clone nella sezione preview
    $(".logo-chosen").append($img);
    // assegno ad una variabile il valore di alt dell'img del logo scelto e passo quindi "nomelogo.png"
    var $url2= $(".logo-chosen img").attr('alt');
    // incollo il valore scelto nell'input HIDDEN
    $('#pj-logo').attr('value', $url2);
});
