<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'structure/views/headers.php'; ?>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>public/style/own/login.css">
</head>
<body>
    <div class="webpage">
        <?php include_once 'structure/views/menu.php';?>
        <div class="container-own">
            <section class="login">
                <div class="inside-login">
                    <div class="cont">
                        <div class="col-sm-12">
                            <h2>Login</h2>
                        </div>
                        <div class="col-sm-12">
                            <form id="login" class="form" name="login" method="POST" action="<?php echo constant('URL'); ?>login/logear">
                                <div class="form-group">
                                    <label for="nombre-correo">Nombre o email</label>
                                    <input type="text" name="nombre-correo" id="nombre-correo" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="pass">Contraseña</label>
                                    <input type="password" name="pass" id="pass" class="form-control">
                                </div>
                                <input type="submit" name="send" id="send" class="btn btn-primary" value="Entrar">
                            </form>
                        </div>
                        <div class="col-sm-12" id="debug">
                            <!-- errors -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include_once 'structure/views/footer.php';?>
    </div>
</body>
<script src="<?php echo constant('URL')?>public/loginAjax.js"></script>
</html>