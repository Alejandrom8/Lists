$(document).ready(function(){

    let height = $(window).height();
    let flag = false;
    let scroll;

    $(window).scroll(function(){
        scroll = $(window).scrollTop();
        if(scroll > 0){
            if(!flag){
                $("#menu").css({'background-color':'#333'});
                $("#menu .bloque ul li,a").css({"color": "#fff"});
                flag = true;
            }
        }else{
            if(flag){
                $("#menu").css({'background-color':'transparent'});
                $("#menu .bloque ul li,a").css({"color": "#fff"});
                flag = false;
            }
        }
    });
});