$(function(){

    //menu
    var moHeader = $(".mo-header");
    var menu = moHeader.find('.menu');
    var menuBox = moHeader.find('.menu-box');
    
    menu.on('click', function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            menuBox.removeClass('show');
        }else{
            $(this).addClass('active');
            menuBox.addClass('show');
        }
    });

});

function showToast(msg, time){
    var body = $('body');
    t = time || 1000;
    if(body.find('#toast')){
        body.find('#toast').remove();
    }
    var text = $('<span id="toast">'+msg+'</toast>');
    $('body').append(text);
    hideTost(t);
}
function hideTost(t){
    setTimeout(function(){
        $('#toast').remove();
    }, t)
}