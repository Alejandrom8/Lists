const URLConst = "http://192.168.1.71/social_network/";
const displayMensajes = $("#message-box");
const displayFotoFriend = $("#friends-cont");
const form = $("#messageSection");
const input = $("#message_input");
const displayNameFriend = $("#friend-box");
let loop, flag = false, cantM = 0;

function AppMessage(url = URLConst) {

    function httpRequest(ide, url, data, dt, callback) {
        /*
         *   This func is the worker that makes all the sends to the server
         *   @param Integer ide, the id of the function in the line-process, this help us to have more control of where aperes a problem.
         *   @param String url, the url of the request.
         *   @param void data, if you want to send data.
         *   @param String dt, type of returns data.
         *   @param callback, the function that continues with the process.
         */
        $.ajax({
            url: url,
            data: data,
            dataType: dt,
            type: "POST",
            success: function(data) {
                callback(data);
            },
            error: function() {
                console.log(ide);
            }
        });
    }

    let onLoad = (callback, u = url) => {
        httpRequest(1, u + "home/getUserRelationData", null, "JSON", function(a) {
            callback(a);
        });
    };

    let play = (friend) => {

        /*
         *   This is the initializer of all the process of get data in a time loop,
         *   @param Object JSON friend {
         *       id: String, the idanfree
         *       nombre: String data, the name of his friend,
         *       foto: String data, the url of the photo
         *   }
         *   @return true when the process has finished
         */

        displayNameFriend.html("<p>" + friend.nombre + "</p>");
        displayFotoFriend.html(
            "<div class='contFotoFriend' data-id = '" + friend.id + "' data-name = '" + friend.nombre + "'>" +
            "<img class='fotoAmigo' src=" + friend.foto + ">" +
            "</div>"
        );
        form.append("<input type='hidden' name='amigo' value='" + friend.id + "'>");


        httpRequest(2, url + "home/getUserRelationMessage", { amigo: friend.id }, "JSON", function(a) {
            if (format(a)) {
                init(friend.id);
            }
        });

        return true;
    };

    let format = (conversation, empty = true) => {

        /*
         *   This gives the format for the messages that commes with the conversation param
         *   @param Object JSON conversation {
         *      emisor: String, idanfree of who send the message,
         *      fecha: Date, date when the message was send,
         *      mensaje: String, message that send the emisor,
         *      receptor: String, idanfree of who recive the message,
         *   }
         *   @param boolean empty, true if you want to clear the message section before display the new messages
         *   @return true when the process has finished
         */

        if (empty) { displayMensajes.empty(); }

        let display = "";
        cantMinside = 0;

        for (let i = 0; i < Object.keys(conversation).length; i++) {
            if (globalId == conversation[i].emisor) {
                display += "<div class='col-sm-12'><div class='mensaje anfitrion'>";
            } else {
                display += "<div class='mensaje invitado'>";
            }

            display += conversation[i].mensaje + "</div></div></br>";
            cantMinside += i;
        }

        displayMensajes.append(display);
        displayMensajes.css({"overflow-y":"scroll"});
        if(cantMinside > cantM){
            displayMensajes.animate({ scrollTop: displayMensajes.prop("scrollHeight")}, 1000);
        }
        cantM = cantMinside;
        return true;
    };

    let init = (i) => {
        clearInterval(loop);
        loop = setInterval(function() {
            continueRe(i);
        }, 1000);
    };

    let continueRe = (id) => {
        httpRequest(3, url + "home/getUserRelationMessage", { amigo: id }, "JSON", function(a) {
            format(a);
        });
    };

    let loadOtherFriends = async(other) => {
        displayFotoFriend.empty();
        for (let i = 0; i < Object.keys(other).length; i++) {
            // displayNameFriend.html("<p>" + friend.nombre + "</p>");
            displayFotoFriend.append(
                "<div class='contFotoFriend' data-id = '" + other[i].id + "' data-name = '" + other[i].nombre + "'>" +
                "<img class='fotoAmigo' src=" + other[i].foto + ">" +
                "</div>"
            );
        }
        return true;
    };

    let createEventClickForFriendsFoto = () => {
        const allFotos = document.querySelectorAll(".contFotoFriend");
        allFotos.forEach(foto => {
            foto.addEventListener("click", function() {
                $(".contFotoFriend").css({ "background": "transparent" });
                $(this).css({ "background": "#5d67b0" });
                displayMensajes.empty();
                changeFor(this.dataset.id, this.dataset.name);
            });
        });
        return true;
    };

    let changeFor = (id, name) => {
        displayNameFriend.html(`<p> ${name} </p>`);
        form.remove("input[type='hidden']");
        form.append(`<input type='hidden' name='amigo' value='${id}'>`);
        init(id);
    };

    onLoad((result) => {
        //En cuanto cargue todo, esta función se iniciara
        //aqui tenemos las id, fotos y nombres de los amigos del usuario

        /*
         *   @param Object JSON result {
         *       success: boolean, true if success,
         *       errors: JSON, all the errors in the request,
         *       data: almost always JSON, that server returns
         *   }
         */

        // The info that the server returns
        let data = result.data;
        // Status of the query
        let status = result.success;

        if (status) {
            if (Object.keys(data).length > 0) {
                if (play(data[0])) { //se ejecuta esta funcio asincrona para cargar fotos id y nombres
                    if (loadOtherFriends(data)) {
                        createEventClickForFriendsFoto();
                    }
                }
            } else {
                console.log("No hay conversaciones");
            }
        } else {
            console.log(result.errors);
        }
    });
}

function startAll(){
    $("#message.toggle-message").css({"right": "0"});
    AppMessage();
    $('body').css("overflow-y","hidden");
    $("#message-button").css("color", "#999");
    flag = true;
}

function stopAll(){
    $("#message.toggle-message").css({"right": "-170vh"});
    clearInterval(loop);
    $('body').css("overflow-y","auto");
    $("#message-button").css("color", "#eee");
    flag = false;
}

$("#message-button").on("click", function(){
    if(!flag){
        startAll();
        $(".container-own").on("click", function(){
            stopAll();
        });
    }else{
        stopAll();
    }
});

form.on("submit", function() {
    $.ajax({
        url: "http://192.168.1.71/social_network/home/registMessage",
        data: $(this).serialize(),
        type: "POST"
    });
    input.val("");
    return false;
});