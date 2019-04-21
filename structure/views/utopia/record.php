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
                    <div class="all">
                        <h1>Registro</h1>
                        <br>
                        <div class="row">
                                <form action="<?php echo constant('URL');?>record/newRecord" method="POST" id="newRecord" enctype="multipart/form-data">
                                    <div class="row">
                                    <div class="col-sm-4 foto">
                                        <div class="foto-cont">
                                            <div  class="foto-cont-2">
                                                <h3>Foto de perfil</h3>
                                                <label id="preview" for="file"></label>
                                                <br>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo constant('MAX_FOTO_SIZE');?>" />
                                                <div class="input-group" style="margin-top:10%;">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="file" name="file" aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="file">Elige una foto</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <h3>Datos personales</h3>
                                        <br>
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="escribe tu nombre" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="age">Cumpleaños</label>
                                            <input type="date" name="age" id="age" class="form-control" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pass">Contraseña</label>
                                            <input type="password" name="pass" id="pass" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="passre">Repite tu contraseña</label>
                                            <input type="password" name="passre" id="passre" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <h3>Algúnos datos más</h3>
                                        <br>
                                        <div class="form-group">
                                            <label for="email">Correo Electrónico</label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="ukelele@ejemplo.com" required>
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
                                        <br>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" id="boton-enviar" value="Registrar datos">
                                        </div>
                                    </div>
                                    </div>
                                </form>
                        </div>
                    </div>
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
</script>
</html>