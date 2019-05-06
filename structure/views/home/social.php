<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once 'structure/views/headers.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/style/own/tools.css">
    <title>Home</title>
</head>
<body>
    <div class="webpage">
        <?php include_once 'structure/views/app/tools.php'; ?>
        <div class="container-own" style="padding-top:10%;height:130vh; background-color:tomato;">
           <div class="form-group">
           <input type="text" name="buscador" class='form-control'>
           <button class="btn btn-primary">
                Buscar
           </button>
           </div>
        </div>
    </div>
</body>
<script src="<?php echo constant("URL"); ?>public/message.js"></script>
</html>