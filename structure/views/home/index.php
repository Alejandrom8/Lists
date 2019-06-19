<?php 

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once 'structure/views/headers.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/style/own/tools.css">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/libs/node_modules/swiper/dist/css/swiper.min.css">
    <title>Home</title>
    <style>
        #Proyects {
            width:100%;
            height:33vh;
            /* background-color:#ead94c; */
            /* background:#ffca3a; */
            background:#ffd400;
            /* padding:4%; */
            display:flex;
            justify-content:space-around;
            align-content:center;
            align-items:center;
        }
        .container-own{
            padding-top:40px;
            position:relative;
            float:left;
            height:100vh;
            width:100%;
        }
        #Proyects .margin{
            /* margin:5%; */
            width:95%;
            height:95%;
            /* background-color:#999; */
            /* float:left; */
            margin:0 auto;
            border-radius:0.25rem;
            overflow:;
            
        }
        @media only screen and (max-width: 800px){
            #Proyects .cont-button{
                display:none;
            }
        }

        #Proyects .card-deck, #Proyects .swiper-container {
            width:100%;
            height:100%;
            margin:0;
        }
        #Proyects .card{
            max-width:400px;
            max-height:100%;
            margin-left:0.5rem;
            margin-right:0.5rem;
        }
        #create-new-proyect.card{
            background-color:#fff;
            /* border:4px dashed #fff; */
            outline:none;
            width:100%;
            height:100%;
            display:flex;
            justify-content:space-around;
            align-items:center;
            align-content:center;
            color:gray;
        }
        #create-new-proyect.card:hover{
            color:#453a49;
        }
        #create-new-proyect.card:active{
            color:#282f44;
            /* border:6px solid #888; */
        }
        .swiper-container{
            /* background:#333; */
        }
    .swiper-slide {
        overflow:hidden;
      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }
    .swiper-slide.card p{
        font-size:0.85rem;
    }
    .btn{
        border-radius:10px;
        font-weight:100;
    }
    #other-proyects{
        width:100%;
        height:100%;
        padding:1.5%;
    }
    #other-proyects .margin{
        width:100%;
        height:100%;
        /* border:2px dashed #aaa; */
        /* background-color:#E6E6EA; */
    }
    #windowCreateNewProyect{
        position:fixed;
        float:left;
        z-index:10;
        background-color:#eee;
        margin:0 auto;
        width:95%;
        height:90%;
        left:2.5%;
        top:5%;
        display:flex;
        justify-content:space-around;
        align-content:center;
        align-items:center;
        -webkit-box-shadow: rgba(0, 0, 0, 0.2) 0px 3px 9px 0px;
        -moz-box-shadow: rgba(0, 0, 0, 0.2) 0px 3px 9px 0px;
        box-shadow:rgba(0, 0, 0, 0.2) 0px 3px 9px 0px;
        border-radius:2px;
    }

    #windowCreateNewProyect  .margen{
        width:90%;
        height:90%;
        margin:0 auto;
    }

    .cerrar{
        float:right;
        background-color:#aaa;
        border-radius:5px;
        color:#fff;
        /* font-weight:bold; */
        border:0;
        width:1.3rem;
        height:1.3rem;
        outline:none;
        margin-right:-1.4rem;
        margin-top:-0.4rem;
        text-align:center;
        padding:0;
        display:flex;
    }
    .cerrar:hover{background-color:tomato;}
    .cerrar span {
        margin:0 auto;
    }
    .form-control.newProyectInput{
        width:96%;
        padding-top:4%;
        padding-bottom:4%;
        padding-left:4%;
        margin:2%;
        margin-bottom:4%;
        background-color:#b6d6cc;
        color:#333;
        font-size:2rem;
    }
    #tus-proyectos{
        font-family:"pierSans bold";
        font-size:2.5rem;
        line-height:4rem;
        text-align:center;
    }
    .swiper-slide.card .btn{
        padding:0.2rem;
        padding-left:0.6rem;
        padding-right:0.6rem;
    }
    .contenedor-flotante{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        display:flex;
        justify-content:space-around;
        align-items:center;
        align-content:center;
        z-index:11;
    }
    #friends-list{
        margin:0 auto;
        width:40vw;
        height:auto;
        /* top:10vh;
        left:30vw; */
        background:#fff;
        max-height:80vh;
        box-shadow:rgba(0, 0, 0, 0.2) 0px 3px 9px 0px;
        border-radius:6px;
        color:#555;
    }
    #friends-list .margen{
        height:100%;
        width:100%;
    }
    </style>
</head>
<body>
    <div class="webpage">
        <?php include_once 'structure/views/app/tools.php'; ?>
        <div class="container-own">
            <div style="width:100%;">
            <br><br>
            <h2 id="tus-proyectos">Tus proyectos</h2>
            <br><br>
            </div>
            <section id="Proyects">
                <div class="margin row" style="padding:0;margin:0;">
                    <div class="col-sm-3 cont-button" style="padding-left:0;margin:0;">
                            <button 
                                id="create-new-proyect" 
                                class="card" 
                                onClick="newProyectButton();"
                                title="Añadir proyecto">
                                <i class="fas fa-plus-circle fa-4x fa-lg"></i>
                            </button>
                    </div>
                    <div class="swiper-container col-md-9">
                        <div class="swiper-wrapper">
                        <!-- <button 
                                id="create-new-proyect" 
                                class="swiper-slide card" 
                                onClick="newProyectButton();">
                                <i class="fas fa-plus-circle fa-4x fa-lg"></i>
                            </button> -->
                        </div>
                    </div>
                </div>
            </section>
            <section id="other-proyects">
                <div class="margin">
                </div>
            </section>
        </div>
    </div>
</body>
<script src="<?php echo constant('URL'); ?>public/libs/node_modules/swiper/dist/js/swiper.min.js"></script>
<script src="<?php echo constant("URL"); ?>public/message.js"></script>
<script>

let friends;
    
    $.ajax({
        url: URLConst + "home/getUserRelationData",
        dataType: "JSON",
        success: function ( datos ){
            friends = datos.data;
        },
        error: function (){
            alert("Hubo un error al cargar a tus amigos");
        }
    });


    const newProyectButton = () => {
        $("#create-new-proyect").attr("disabled", "disabled");
        $("#create-new-proyect").css("color", "#ffde0b");
        $(".webpage").css({
            overflow: "hidden"
        });
        $(".container-own").append(
        `
            <section id="windowCreateNewProyect">
                <div class="margen">
                    <button class="cerrar" id="closeNewProyect"><span>X</span></button>
                    <form id="crearProyectoForm" method="POST" action="<?php echo constant('URL'); ?>home/new_proyect" class="row">
                    <input type="text" name="NombreDelProyecto" id="NombreDelProyecto" class="form-control newProyectInput" placeholder="Nombre del Proyecto" maxlenght="100">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo de proyecto</label><br>
                                <input type="radio" name="tipo" id="tipo" value="solo" checked>Personal </br>
                                <input type="radio" name="tipo" id="tipo" value="grupo">En grupo
                            </div>
                            <div class="form-group">
                                <label for="colaboradores">Colaboradores</label>
                                <input onclick="ap_list_friends();" type="text" name="colaboradores" id="colaboradores" class="form-control" placeholder="da click para ver lista de amigos" maxlenght="100" readonly>
                            </div>
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea form="crearProyectoForm" class="form-control" rows="5" name="description" id="description" style="resize:none;" maxlenght="250"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <center><label>Fechas estimadas</label></center>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="fecha-desde">De: </label>
                                        <input type="date" name="fecha-desde" id="fecha-desde" class="form-control" value="<?php echo $today; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fecha-hasta">A: </label>
                                        <input type="date" name="fecha-hasta" id="fecha-hasta" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="color">Color del proyecto:</label>
                                <input type="color" name="color" id="color" class="form-control" value="#ffde0b">
                            </div>
                        </div>
                        <input type='hidden' name='friends_Arr' id="friends_Arr" value=''>
                        <center><button style="width:60vw;margin-left:12vw;margin-right:12vw;" type="submit" class="btn btn-outline-primary" style="">Crear Proyecto</button></center>
                    </form>
                </div>
            </section>
            `
        );
        
        $("#closeNewProyect").on("click", function () {
            $("#windowCreateNewProyect").remove();
            $("#create-new-proyect").removeAttr("disabled");
            $("#create-new-proyect").css("color", "#d9d9d9");
            $(".webpage").css({
                overflow: "auto"
            });
        });

        $("#crearProyectoForm").on("submit", function (){
            // let currentDate = new Date();
            let nombre = $("#NombreDelProyecto").val();
            let desc   = $("#description").val();
            let de     = new Date($("#fecha-desde").val());
            let a      = new Date($("#fecha-hasta").val());
            let color  = $("#color").val();
            let amigos = $("#friends").val();

            let state, title = "Campo incorrecto", message;
            
            if(nombre == null || nombre == ""){
                //campo de nombre bacio
                pintRed("#NombreDelProyecto");
                state = false;
                message = "Debe llenar el campo del nombre de su proyecto";
            }else if(de == "" || a == ""){
                //campos de fecha bacios
                pintRed("#fecha-desde");
                pintRed("#fecha-hasta");
                state = false;
                message = "Favor de llenar el campo de la fecha";
            }else if(a < de){
                //fecha incongruente: fecha de inicio mayor a la fecha de termino
                pintRed("#fecha-hasta");
                state = false;
                message = "Las fechas introducidas no son congruentes";
            }else{
                state = true;
            }

            if(!state){
                swal({
                    title: title,
                    text: message,
                    icon: "warning",
                    button: "ok"
                });
            }else{
                if(amigos != ""){
                    swal({
                        title: "confirmar",
                        text: "La gente a la que invitaste al proyecto tendra que aceptar unirse para estar en el",
                        buttons: ["cancelar","ok"]
                    }).then( conf => {
                        if(conf){
                            $.ajax({
                                url: $(this).attr("action"),
                                type: "POST",
                                data: $(this).serialize(),
                                dataType: "JSON",
                                success: ( datos ) => {
                                    console.log(datos);
                                    if(datos.success){
                                        window.location = datos.onSuccessEvent;
                                    }else{
                                        console.log("error al transferir al usuario: " + datos.errors);
                                    }
                                },
                                error: () => {
                                    console.log('error');
                                }
                            });
                        }
                    });
                }else{
                    $.ajax({
                        url: $(this).attr("action"),
                        type: "POST",
                        data: $(this).serialize(),
                        dataType: "JSON",
                        success: ( datos ) => {
                            console.log(datos);
                            if(datos.success){
                                window.location = datos.onSuccessEvent;
                            }else{
                                console.log("error al transferir al usuario");
                            }
                        },
                        error: () => {
                            console.log('error');
                        }
                    });
                }
            }
            return false;
        });
    };

    const getFriendsInListFormat = (fr = friends) => {

        let list = "";

        for(let i = 0; i < Object.keys(fr).length; i++){
            list += `
                <tr>
                    <td colspan="1"><img class="foto" src="${fr[i].foto}" alt="${fr[i].nombre}"></td>
                    <td colspan="2">${fr[i].nombre}</td>
                    <td colspan="1">
                        <button class="btn" title="agregar al proyecto" onclick="agregarAlProyecto('${fr[i].id}');">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </td>
                </tr>
            `;
        }

        return list;
    };

    const agregarAlProyecto = id => {
        let cont = $("#colaboradores").val();
        if(cont == ""){
            $("#colaboradores").val(id);
        }else{
            $("#colaboradores").val($("#colaboradores").val() + ";" + id);
        } 
    };

    const ap_list_friends = () => {

        if($(".contenedor-flotante").length){ $(".contenedor-flotante").remove(); }

        $(".container-own").append(`
            <div class="contenedor-flotante">
            <div id="friends-list">
                <div class="margen">
                    <button class="cerrar" style="margin:0.4rem;" id="closeFriendsList"><span>X</span></button>
                    <div class="jumbotron" style="margin-bottom:4vh;padding-top:5%;padding-bottom:5%;height:12vh;">
                        <h3>Lista de amigos</h3>
                    </div>
                    <div class="col-md-12" style="overflow-y:scroll;max-height:64vh;">
                        <table class="table table-striped">
                            ${ getFriendsInListFormat() }
                        </table>
                    </div>
                </div>
            </div>
            </div>
        `);

        $("#closeFriendsList").on("click", function () {
            $(".contenedor-flotante").remove();
        });
    };

    const proyectCardConstructor = (titulo, texto, id, fecha, color) => {
        return {
            titulo,
            texto,
            id,
            fecha,
            color,
            recortar (txt, comp) {
                let textoManejado = txt.reduce((acumulator, current) => {
                    acumulator += current;
                    return acumulator;
                });
                if(comp.length - txt.length > 0){
                    textoManejado += ' ...';
                }
                return textoManejado;
            },
            get htmlFormat () {

                let textoManejado = this.texto.split('').slice(0,59);
                textoManejado = this.recortar(textoManejado, this.texto);

                let titleManejado = this.titulo.split('').slice(0,25);
                titleManejado = this.recortar(titleManejado, this.titulo);

                return `<div id="p_${this.id}" class="swiper-slide card" style="border-bottom:4px solid ${this.color};">
                                <div class="card-body">
                                    <h5 class="card-title">${this.titulo}</h5>
                                    <p class="card-text">${textoManejado}</p>
                                </div>
                                <div class="card-footer" style="width:100%;">
                                    <a href="${URLConst + 'proyects/getProyectById/' + this.id}" class="card-link btn btn-warning" title="abrir proyecto"><i class="fas fa-edit"></i></a>
                                    <button onclick="deleteProject('p_${this.id}');" class="btn btn-danger" title="borrar proyecto"><i class="fas fa-trash-alt"></i></button>
                                    <span class="card-link">${this.fecha}</span>
                                </div>
                        </div>`;
            }
        };
    };

    const loadProyects = () => {

        let abrir = '';
        let url = URLConst + "home/getProyects";
        
        $.ajax({
            url: url,
            dataType: "JSON",
            success: function (data) {
                if(data.success){
                    createCards(data.data);
                }else{
                    swal({
                        title: "error",
                        text: "hubo un error al cargar tus proyectos",
                        icon: "error",
                        button: "0.0"
                    });
                    console.log(data.errors);
                }
            },
            error: function () {
                alert("error al cargar proyectos");
            }
        });
    };

    const createCards = cards => {

        let abrir = '';

        for(let i = 0; i < Object.keys(cards).length; i++){
            let proyecto = proyectCardConstructor(
                cards[i].name, 
                cards[i].description,
                cards[i].proyectID,
                cards[i].creationDate,
                cards[i].color
            );

            abrir += proyecto.htmlFormat;
        }

        $('.swiper-container .swiper-wrapper').append(abrir);

        let swiper = new Swiper('.swiper-container', {
            slidesPerView: 2,
            spaceBetween: 2,
            // freeMode: true,
            // pagination: {
            //     el: '.swiper-pagination',
            //     clickable: true,
            // },
            breakpoints: {
                768: {
                slidesPerView: 1,
                }
            },
        });
    };

    loadProyects();

    let flagNewProyect = false;

    const pintRed = element => {
        $(element).css("border", "1px solid tomato");
    };

    const deleteProject = id => {
        id = id.substr(2, id.length);
        const confirm = swal({
            title: "Estas segur@?",
            text: "confirma que deseas borrar este proyecto",
            buttons: ["no", "si"]
        }).then( conf => {
            if(conf){
                $.ajax({
                    url: URLConst + "home/deleteProyect",
                    type: "GET",
                    data: {id: id},
                    dataType: "JSON",
                    success: function ( estado ){
                        if(estado.success){
                            $("#p_" + id).fadeOut("slow", function (){
                                $("#p_" + id).remove();
                            });
                            swal({
                                title: "Se ha borrado tu proyecto",
                                text: "Se borro correctamente tu proyecto, si quisieras recuperarlo podras hacerlo dentro de 24 hrs, despues de este tiempo sera irrecuperable!",
                                icon: "success",
                                button: "ok"
                            });
                        }else{
                            console.log(estado.errors);
                        }
                    },
                    error: function (){
                        swal({
                            title: "Hubo un error al borrar tu proyecto",
                            text: "Puedes intentar borrarlo de nuevo, si continuas teniendo problemas contactanos <a>anfree@gmail.com</a>",
                            icon: "error",
                            button: "deacuerdo"
                        });
                    }
                });
            }
        });
    };
  </script>
</html>