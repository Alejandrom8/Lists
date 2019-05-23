<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once 'structure/views/headers.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/style/own/tools.css">
    <title>Proyectos</title>
    <style>
        #menu-tools{
            background-color:#333;
            
        }
        .menu-proyect{
            height:calc(100vh - var(--tools-height));
            background-color:#eee;
        }
        #buscador{
            display:none;
        }
        .container-own{
            height:100vh;
            padding-top:var(--tools-height);
        }
        #proyect-display{
            display:flex;
            width:80%;
            height:100vh;
            justify-content:space-around;
            align-content:center;
            align-items:center;
            padding:4%;
            text-align:justify;
        }
        #proyect-display .margen{
            width:90%;
            height:90%;
            webkit­shape­inside: rectangle(0,0,100%,100%,50px,50px);
        }
        .form-control.description-box{
            resize:none;
            border:0;
            box-shadow:none;
            overflow:hidden;
            display:block;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #update-desc, #delete-desc{
            display:none;
            margin:1% 2%;
        }
        #color{
            width:3rem;
            height:3rem;
            border-radius:50%;
            margin-left:3%;
            margin-right:3%;
        }
    </style>
</head>
<body>
    <div class="webpage">
        <?php include_once 'structure/views/app/tools.php'; ?>
        <div class="container-own container-fluid">
            <div class="row">
                <nav style="position:fixed;" class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar menu-proyect">
                    <br>
                    <h4>Proyectos</h4>
                    <hr>
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link active"><?php  echo $this->ProyectCreated->data[0]->name; ?></a>
                        </li>
                        <hr>
                        <?php foreach($this->Proyects as $i => $val){ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo constant('URL') . "proyects/getProyectById/" . $val->proyectID; ?>"><?php echo $val->name; ?></a>
                            </li>
                        <?php }?>
                    </ul>
                </nav>
                <main id="proyect-display" class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
                    <div class="margen">
                        <div class="row">
                            <label for="title" id="color" style="background:<?php echo $this->ProyectCreated->data[0]->color; ?>;"></label>
                            <h1 id="title"><?php  echo $this->ProyectCreated->data[0]->name; ?></h1>
                        </div>
                        <hr>
                        <form id="updateDesc">
                            <div class="form-group">
                                <textarea id="txtarea" class="form-control description-box" rows="4" ><?php echo $this->ProyectCreated->data[0]->description; ?></textarea>
                                <button id="update-desc" type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                        <div class="col-sm-12">
                            <h2>Tareas</h2>
                            <div class="table-responsive">
                                <p>Tienes un total de <?php echo $this->ProyectCreated->data[1]->numTasks; ?> tareas</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo constant("URL"); ?>public/message.js"></script>
<script>
    const description = $(".description-box");
    let f = false;

    function autoTextarea(id) {
        document.getElementById(id).addEventListener('keyup', function() {
            this.style.overflow = 'hidden';
            this.style.height = 0;
            this.style.height = this.scrollHeight + 'px';
        }, false);
    }

    autoTextarea('txtarea');
    
    const onFunc = () => {
        description.css({
                border: "1px solid #ddd"
        });
        $("#update-desc").css("display", "block");
        // description.on("keydown", function() {
        //     $("#delete-desc").css("display", "block");
        // });
        f = true;
    };

    const offFunc = () => {
        description.css({
                border: "0"
        });
        $("#update-desc").css("display", "none");
        // $("#delete-desc").css("display", "none");
        f = false;
    };

    description.on("mousedown", function(){
        if(!f){
            onFunc();
        }else{
            offFunc();
        }
    });

</script>
</html>