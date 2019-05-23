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
            height:35vh;
            background-color:#2e5bc2;
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
            height:90%;
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
            background-color:transparent;
            border:4px dashed #fff;
            outline:none;
            width:100%;
            height:100%;
            display:flex;
            justify-content:space-around;
            align-items:center;
            align-content:center;
        }
        #create-new-proyect.card:hover{
            color:#ffde0b;
        }
        #create-new-proyect.card:active{
            color:#33ffe0;
            border:6px solid #888;
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
        background-color:#eee;
    }
    #windowCreateNewProyect{
        position:fixed;
        float:left;
        z-index:10;
        background-color:#fff;
        margin:0 auto;
        width:50%;
        height:90%;
        left:25%;
        top:5%;
        display:flex;
        justify-content:space-around;
        align-content:center;
        align-items:center;
        -webkit-box-shadow: 10px 10px 14px 0px rgba(0,0,0,0.61);
-moz-box-shadow: 10px 10px 14px 0px rgba(0,0,0,0.61);
box-shadow: 10px 10px 14px 0px rgba(0,0,0,0.61);
    }
    #windowCreateNewProyect  .margen{
        width:90%;
        height:90%;
        margin:0 auto;
    }
    #windowCreateNewProyect .cerrar{
        float:right;
        background-color:tomato;
        border-radius:50%;
        color:#333;
        font-weight:bold;
        border:0;
        width:1.3rem;
        height:1.3rem;
        outline:none;
        margin-right:-1.4rem;
        margin-top:-1.6rem;
        text-align:center;
    }
    #windowCreateNewProyect .cerrar span {
        margin:0 auto;
    }
    #tus-proyectos{
        font-family:"pierSans bold";
        font-size:2.5rem;
        line-height:4rem;
        text-align:center;
    }
    </style>
</head>
<body>
    <div class="webpage">
        <?php include_once 'structure/views/app/tools.php'; ?>
        <div class="container-own">
            <div style="width:100%;background-image:url();">
            <br><br>
            <h2 id="tus-proyectos">Tus proyectos</h2>
            </div>
            <section id="Proyects">
                <div class="margin row" style="padding:0;">
                    <div class="col-sm-3 cont-button" style="padding-left:0;">
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


                return `<div class="swiper-slide card" style="border-bottom:4px solid ${this.color};">
                                <div class="card-body">
                                    <h5 class="card-title">${this.titulo}</h5>
                                    <p class="card-text">${textoManejado}</p>
                                </div>
                                <div class="card-footer" style="width:100%;">
                                    <a href="${URLConst + 'proyects/getProyectById/' + this.id}" class="card-link btn btn-warning" title="abrir proyecto"><i class="fas fa-edit"></i></a>
                                    <button onclick="delete(${this.id})" class="btn btn-danger" title="borrar proyecto"><i class="fas fa-trash-alt"></i></button>
                                    <span class="card-link">${this.fecha}</span>
                                </div>
                        </div>`;
            },
        };
    };

    const loadProyects =  () => {
        let abrir = '';
        let url = URLConst + "home/getProyects";
        $.ajax({
            url: url,
            dataType: "JSON",
            success: function (data) {
                console.log(data);
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
            freeMode: true,
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
                    <form id="crearProyectoForm" method="POST" action="<?php echo constant('URL'); ?>home/new_proyect">
                        <div class="form-group">
                            <label for="NombreDelProyecto">Nombre del proyecto</label>
                            <input type="text" name="NombreDelProyecto" id="NombreDelProyecto" class="form-control" placeholder="Nuevo Proyecto" maxlenght="100">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea form="crearProyectoForm" class="form-control" rows="5" name="description" id="description" style="resize:none;" maxlenght="250"></textarea>
                        </div>
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
                        <center><button type="submit" class="btn btn-outline-primary">Crear Proyecto</button></center>
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

            let state, title = "Campo incorrecto", message;
            
            if(nombre == null || nombre == ""){
                //campo de nombre bacio
                pintRed($("#NombreDelProyecto"));
                state = false, message = "Debe llenar el campo del nombre de su proyecto";
            }else if(de == "" || a == ""){
                //campos de fecha bacios
                pintRed($("#fecha-desde"));
                pintRed($("#fecha-hasta"));
                state = false, message = "Favor de llenar el campo de la fecha";
            }else if(a < de){
                //fecha incongruente: fecha de inicio mayor a la fecha de termino
                pintRed($("#fecha-hasta"));
                state = false, message = "Las fechas introducidas no son congruentes";
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

            return false;
        });
    };

    const pintRed = element => {
        element.css("border", "1px solid tomato");
    };

  </script>
</html>