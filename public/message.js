let URl = "http://192.168.1.71/social_network/";
let firstFriendGlobalId, firstFriendGlobalNombre;

function getRelationData(){
    $.ajax({
        url: "http://192.168.1.71/social_network/home/getUserRelationData",
        type: "POST",
        dataType: "JSON",
        success: function(response){
            let success = response.success;
            let data = response.data;
            if(success){
                formatFriends(data)
            }else{
                console.log(response.errors);
            }
        },
        error: function(){
            alert("error relation");
        }
    });
    return true;
}

function Amigo(){
    this.id;
    this.foto;
    this.nombre;
    this.crearFotoSpace = function(){
        let div = "<div class='contFotoFriend' onclick='crearNuevaVista(\""+ this.id +"\", \""+ this.nombre +"\");' >" + 
                    "<img class='fotoAmigo' src='http://192.168.1.71/intranet/uploads/" + this.foto + "' alt='" + this.nombre + "'>" +
                   "</div>";
        return div;
    }
}

function formatFriends(data){

    let displayFotos = $("#friends-cont");
    let friends = [];
    let newF;

    for(let i = 0; i < Object.keys(data).length; i++){
        newF = new Amigo();
        newF.id = data[i].id;
        newF.foto = data[i].foto;
        newF.nombre = data[i].nombre;
        displayFotos.append(newF.crearFotoSpace());
        friends.push(newF);
    }
}

function crearNuevaVista(id, nombre){
    let displayTitle = $("#friend-box");
    displayTitle.empty();
    $("#message-box").empty();
    displayTitle.append("<p>"+ nombre +"</p>");
    $("#messageSection input[type='hidden']").remove();
    $("#messageSection").append("<input type='hidden' name='amigo' value='"+ id +"'>");
    getMensajes(id);
}

function getMensajes(id = null){
    if(id != null){
        $.ajax({
            url: "http://192.168.1.71/social_network/home/getUserRelationMessage",
            type:"POST",
            data: {amigo: id},
            cache: false,
            dataType: "JSON",
            success: function(html){
                let div = "";
                for(let i = 0; i < Object.keys(html).length; i++){
                    if(globalId == html[i].emisor){
                      div += "<div class='mensaje anfitrion'>";
                    }else{
                      div += "<div class='mensaje invitado'>";
                    }
                    div += html[i].mensaje +"</div></br>";
                }
                $("#message-box").html(div);	
            },
        });
    }
    console.log("ejecutando");
}


$(document).ready(function(){

    getRelationData();
    $("#messageSection").on("submit", function(){
        $.ajax({
            url:"http://192.168.1.71/social_network/home/registMessage", 
            data: $(this).serialize(),
            type: "POST",
        });
        $("#message_input").val("");
        return false;
    });
    // setInterval(crearNuevaVista(), 3000);
});