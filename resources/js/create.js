var $ = require('jquery');

// jQuery(function(){
// $("#pj-tshirt").empty();
// $("#pj-logo").empty();
// $("#title").empty();
// });

$(document).on('click', '.tshirt-panel .box', function() {
    $(".tshirt-chosen").empty();
    var $img = $(this).children("img").clone();
    console.log($img);
    $(".tshirt-chosen").append($img);
    var $url= $(".tshirt-chosen img").attr('alt');
    $('#pj-tshirt').attr('value', $url);
    console.log($url);
    console.log($("#pj-tshirt"));
    console.log($("#pj-logo"));
});

$(document).on('click', '.logo-panel .box', function() {
    $(".logo-chosen").empty();
    var $img = $(this).children("img").clone();
    $(".logo-chosen").append($img);
    var $url2= $(".logo-chosen img").attr('alt');
    $('#pj-logo').attr('value', $url2);
    console.log($("#pj-tshirt"));
    console.log($("#pj-logo"));
});
