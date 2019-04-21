$(document).ready(function(){

    let height = $(window).height();
    let flag = false;
    let scroll;

    $(window).scroll(function(){
        scroll = $(window).scrollTop();
        if(scroll > height/4){
            if(!flag){
                $("#menu").css({'background-color':'#333', 'color': "#fff"});
                flag = true;
            }
        }else{
            if(flag){
                $("#menu").css({'background-color':'transparent', 'color': "#fff"});
                flag = false;
            }
        }
    });
});