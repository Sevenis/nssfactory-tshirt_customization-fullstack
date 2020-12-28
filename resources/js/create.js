var $ = require('jquery');

//al click sull'img della tshirt scelta, quest'ultima viene copiata
//nel box preview
$(document).on('click', '.tshirt-panel .box', function() {
    $(".tshirt-chosen").empty();
    var $img = $(this).children("img").clone();
    $(".tshirt-chosen").append($img);
    var $url= $(".tshirt-chosen img").attr('alt');
    $('#pj-tshirt').attr('value', $url);
});

//al click sull'img del logo scelto, quest'ultimo viene copiato
//nel box preview
$(document).on('click', '.logo-panel .box', function() {
    $(".logo-chosen").empty();
    var $img = $(this).children("img").clone();
    $(".logo-chosen").append($img);
    var $url2= $(".logo-chosen img").attr('alt');
    $('#pj-logo').attr('value', $url2);
});
