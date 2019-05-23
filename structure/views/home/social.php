<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once 'structure/views/headers.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/style/own/tools.css">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/style/own/social.css">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>public/libs/node_modules/swiper/dist/css/swiper.min.css">
    <title>Home</title>
</head>
<body>
    <div class="webpage">
        <?php include_once 'structure/views/app/tools.php'; ?>
        <div class="container-own" style="height:100vh;background:#eee;overflow-y:scroll;">
            <div id="social-head">
            <h1>Sección social</h1>
                <header id="social-header">
                </header>
                <section id="menu-social">
                    <ul class="nav nav-tabs nav-justified">
                        <li id="s-s-l" class="nav-item" data-where="search" style="background:#ffdd7e;">
                            <span class="nav-link">Buscador</span>
                        </li>
                        <li id="n-s-l" class="nav-item" data-where="notification">
                            <span class="nav-link">Peticiónes de amistad</span>
                        </li>
                    </ul>
                </section>
            </div>
            <div id="search-section" class="module search-section">
                <section class="search">
                    <h2>Buscador</h2> 
                    <div class="form-group">
                        <div id="searchFriends" class="input-group" style="background:#ddd;border-radius:25px;">
                            <span class="input-group-addon" style="display:flex;justify-content:space-around;align-items:center;">
                                <i class="fas fa-search fa-2x" aria-hidden="true"></i>
                            </span>
                            <input type='text' class="form-control" id="consulta" placeholder="Buscar amigos" maxlength="50">
                        </div>
                    </div>
                </section>
                <section id="StatusSearch"></section>
                <section id="displayPeople"></section>
            </div>
            <div id="notification-section" class="module notification-section">
                <div id="nt-s" style="padding:5%;" class="swiper-container">
                        <div class="swiper-wrapper" id="swip-app">

                        </div>
                        <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo constant('URL');?>public/libs/node_modules/swiper/dist/js/swiper.min.js"></script>
<script>
    $("#consulta").on("keyup", function(){
        let search = $(this).val();
        if(search != "" && search != " "){
            $.ajax({
                type: "GET",
                url: URLConst + "home/search",
                data: { search: search },
                dataType: "JSON",
                success: (data) => {
                    if(data.success){
                        $("#StatusSearch").empty();
                        if((!data.message || data.message == null) && data.data != null){
                            createFormat(data.data);
                        }else{
                            $("#StatusSearch").append("<p>" + data.message + "</p>");
                            $("#displayPeople").empty();
                        }
                    }else{
                        console.log(data.errors);
                    }
                },
                error: () => {
                    window.alert("error");
                }
            });
        }else{
            $("#StatusSearch").empty();
            $("#displayPeople").empty();
        }
    });

    const createFormat = async (people) => {
        // $("#displayPeople").empty();
        let cont = Object.keys(people).length;
        $("#StatusSearch").append("<p>Se encontraron " + cont + " resultados coincidentes</p>");
        let display = "<table class='people table'>";
        for(let i = 0; i < Object.keys(people).length; i++){
            display += "<div class='person'>" + 
                        "<div class='contP row'>" + 
                            "<div class='dataPerson'>" + 
                                "<p><h4>"+ people[i].nombre +"</h4></p>" + 
                                "<p><span>apodo: </span> "+ people[i].apodo +"</p>" + 
                                "<p><span>correo: </span> "+ people[i].correo +"</p>" + 
                                "<p><button class='addFriend btn btn-primary' data-id='"+ people[i].id +"' data-nombre='"+ people[i].nombre +"'>Agregar amigo</button></p>" + 
                            "</div>" + 
                            "<div class='fotoPerson'>" + 
                                "<div class='contFoto'>" + 
                                    "<img src='"+ people[i].foto +"'>" +
                                "</div>" +
                            "</div>" + 
                        "</div>" + 
                    "</div>";
        }
        $("#displayPeople").html(display);

        createEventAddFriend();
    };

    const createEventAddFriend = () => {
        const people = document.querySelectorAll(".addFriend");
        people.forEach(p => {
            p.addEventListener("click", function (){
                let id = this.dataset.id;
                let nombre = this.dataset.nombre;
                let confirm = swal({
                    title: "Confirmar",
                    text: "¿ Estas segur@ de que deseas agregar a " + nombre + " como amig@ ?",
                    buttons: ["no","si"],
                }).then((conf) => {
                    if(conf){
                        $.ajax({
                            url: URLConst + "home/registPetition",
                            type: "POST",
                            data: {id: id},
                            dataType: "JSON",
                            success: (data) => {
                                let alertData;
                                if(data.success){
                                    alertData = {
                                        title: "Petición enviada",
                                        text: "Ahora, " + nombre + " tendra que confirmar que son amigos",
                                        icon:"success",
                                        button: "ok",
                                    };
                                    $(this).attr("disabled","disabled");
                                }else{
                                    alertData = {
                                        title: data.message.title,
                                        text: data.message.text + nombre,
                                        icon: data.onErrorEvent,
                                        button: "Vaya...",
                                    };
                                    console.log(data.errors);
                                }
                                swal(alertData);
                            },
                            error: () => {
                                alert("error");
                            }
                        });
                    }
                });
            });
        });
    }

    const navButtons = document.querySelectorAll(".nav-item");
    navButtons.forEach(item => {
        item.addEventListener("click", function(){
            change(this.dataset.where);
            $(".nav-item").css("background-color","transparent");
            $(this).css({"background-color": "#ffdd7e"});

            $('.container-own').animate({
                scrollTop: $("#menu-social").offset().top
            }, 1000)
        });
    });

    const change = (id) => {
        $(".module").css("display", "none");
        $("#" + id + "-section").css("display", "block");
    };

    change("search");

    const sendto = (url, data, call) => {
        $.ajax({
            url: URLConst + url,
            type: "POST",
            data: {id: data},
            dataType: "JSON",
            success: (logear) => {
                call(logear);
            },
            error: (e) => {
                alert("error sendTo");
            }
        });
    };

    const CreateEventforNoti = () => {
        const aceptar = document.querySelectorAll(".aceptar");
        const borrar = document.querySelectorAll(".borrar");

        aceptar.forEach(a => {
            a.addEventListener("click", function(){
                const id = this.dataset.id;
                sendto("home/aceptPetition", id, (res) => {
                    if(res.success){
                        $("#" + id).remove();
                        swal({
                            title: "Aceptado!",
                            text: "Ahora son amigos!",
                            icon: "success",
                            button: "Yei!",
                        });
                    }else{
                        console.log(res.errors)
                    }
                });
            });
        });

        borrar.forEach(b => {
            b.addEventListener("click", function(){
                const id = this.dataset.id;
                sendto("home/deletePetition", id, (res) => {
                    if(res.success){
                            $("#" + id).remove();
                            swal({
                                title: "Borrado",
                                text: "Se ha borrado la solicitud",
                                icon: "success",
                                button: "ok",
                            });
                    }else{
                        console.log(res.errors)
                    }
                });
            });
        });
    };

    const formatNoti = (n) => {

        let notiDisplay = "";
        $("#swip-app").empty();

        for(let i = 0; i < Object.keys(n).length; i++){
            notiDisplay += 
            "<div id='"+ n[i].id +"' class='swiper-slide'><div class='card' style='width:100%;'>" +
                "<img class='card-img-top' src='"+ n[i].foto +"' alt='Card image'>" +
                "<div class='card-body'>" + 
                    "<h4 class='card-title'>"+ n[i].nombre +"</h4>" + 
                    "<p class='card-text'>apodo: " + n[i].apodo + "</p>" + 
                    "<a data-id = '"+ n[i].id +"' class='aceptar btn btn-primary'>Aceptar</a>" +
                    "<a data-id = '"+ n[i].id +"' class='borrar btn btn-danger'>Borrar</a>" + 
                "</div>" + 
                "<div class='card-footer'><p>Fecha de llegada: </p><p class='card-text'>"+ n[i].fecha +"<p></div>" + 
            "</div></div>";
        }

        $("#swip-app").append(notiDisplay);
    }

    $("#n-s-l").on("click", function(){
        $.ajax({
            url: URLConst + "home/getPetitions",
            dataType: "JSON",
            success: (noti) => {
                if(noti.success){
                    formatNoti(noti.data);
                    var swiper = new Swiper('.swiper-container', {
                            slidesPerView: 4,
                            spaceBetween: 10,
                            freeMode: true,
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                            breakpoints: {
                                768: {
                                slidesPerView: 3,
                                spaceBetween: 30,
                                },
                                640: {
                                slidesPerView: 1,
                                spaceBetween: 20,
                                },
                                320: {
                                slidesPerView: 1,
                                spaceBetween: 10,
                                }
                            }
                    });
                    CreateEventforNoti();
                }else{
                    swal(noti.errors);
                }
            },
            error: () => {
                swal("notification error");
            }
        });
    });
</script>
<script src="<?php echo constant("URL"); ?>public/message.js"></script>
</html>