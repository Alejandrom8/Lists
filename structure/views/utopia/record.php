<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'structure/views/headers.php'; ?>
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>public/style/own/record.css">
</head>
<body>
    <div class="webpage">
        <?php include_once 'structure/views/menu.php'; ?>
        <div class="container-own">
            <section class="registZone">
                <div class="box">
                    <div>
                        <br>
                        <center><h1>Crea tu cuenta de Anfree</h1></center>
                    </div>
                    <br>
                    <form method="POST" role="form" name="registro" id="newRecord"
                    enctype="multipart/form-data" autocomplete="on"
                    action="<?php echo constant('URL');?>record/newRecord" class="row">
                        <div class="col-md-6" id="card">
                                <div class="card">
                                    <div class="card-header">
                                        <center>
                                            <img class="logo" srC="<?php echo constant("URL"); ?>public/img/av2.png">
                                        </center>
                                    </div>
                                    <div class="card-body">
                                        <div  class="foto-cont-2">
                                            <center>
                                                <label id="preview" for="file"></label>
                                            </center>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo constant('MAX_FOTO_SIZE');?>" />
                                            <div class="input-group" style="margin-top:10%;">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file" name="file" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="file">Elige una foto</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p id="nombre-display"></p>
                                        <p id="correo-display"></p>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" autocomplete="name" 
                                id="nombre" class="input-interactivo form-control" placeholder="escribe tu nombre"
                                spellcheck="false" aria-label="Nombre del usuario" data-name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" name="email" autocomplete="email" 
                                id="email" class="input-interactivo form-control" placeholder="anfree@example.com"
                                spellcheck="false" aria-label="email" data-name="correo" required>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="pass">Contraseña</label>
                                    <input type="password" name="pass" id="pass" class="form-control" 
                                    placeholder="contraseña" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="passre">Repite tu contraseña</label>
                                    <input type="password" name="passre" id="passre" class="form-control" 
                                    placeholder="confirmación" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="age">Cumpleaños</label>
                                <input type="date" name="age" id="age" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="genero">Género</label>
                                <select name="genero" id="genero" class="form-control">
                                    <option value="">Selecciona...</option>
                                    <option value="0">Femenino</option>
                                    <option value="1">Masculino</option>
                                    <option value="2">Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="apodo">Apodo <span style="color:#777;font-family:'roboto';">(identificador)</span></label>
                                <input type="text" name="apodo" id="apodo" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <br><br>
                            <center>
                                <input type="submit" class="btn btn-primary" style="width:40vw;" value="Siguiente">
                            </center>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <?php include_once 'structure/views/footer.php'; ?>
    </div>
</body>
<script src="<?php echo constant('URL');?>public/recordAjax.js"></script>
<script>

document.getElementById("file").onchange = function(e) {
  let reader = new FileReader();
  
  reader.onload = function(){
    let preview = document.getElementById('preview'),
    		image = document.createElement('img');

    image.src = reader.result;
    
    preview.innerHTML = '';
    preview.append(image);
  };
 
  reader.readAsDataURL(e.target.files[0]);
}

const inputs_interactivos = document.querySelectorAll(".input-interactivo");

const putTheValue = ctx => {
    const value = $(ctx).val();
    const name = ctx.dataset.name;
    $("#" + name + "-display").html(
        name.charAt(0).toUpperCase() + 
        name.slice(1) + 
        ": " + 
        value
    );
};

inputs_interactivos.forEach( input => {
    input.addEventListener("change", function (){
        putTheValue(this);
    });
    input.addEventListener("keyup", function (){
        putTheValue(this);
    });
});
</script>
</html>