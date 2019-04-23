<style>
</style>
<div id="menu" class="menu">
    <nav class="nav-menu">
        <div class="row">
            <div class="bloque left">
                <ul>
                    <li><img src="<?php echo constant('URL'); ?>public/img/a.png"></li>
                    <li><a href="#">ANFREE</a></li>
                </ul>
            </div>
            <div class="bloque right">
                <ul>
                    <li><a href="<?php echo constant('URL'); ?>">Inicio</a></li>
                    <li><a href="#">Acerca de</a></li>
                    <li><a href="<?php echo constant('URL'); ?>record">Registrate</a></li>
                    <li><a href="#">Login</a></li>
                </ul>
            </div>
            <div class="bloque rightMovile">
                <button class="btn" onclick="show(true)"><i class="fa fa-bars fa-2x fa-lg"></i></button>
                <div id="menumovile">
                    <table class="table">
                        <tr>
                            <td>
                                <h4><a href="<?php echo constant('URL'); ?>">Inicio</a></h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4><a href="#">Acerca de</a></h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4><a href="<?php echo constant('URL'); ?>record">Registrarte</a></h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4><a href="#">Login</a></h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </nav>
</div>
<script>
let estado = false;
function show(){
    $(document).ready(function(){
        if(!estado){
            $("#menumovile").css({"right":"0"});
            $(".container-own").css({"opacity": "0.9"});
            estado = true;
        }else{
            $("#menumovile").css({"right":"-220vh"});
            $(".container-own").css({"opacity": "1"});
            estado = false;
        }
    });
}
</script>