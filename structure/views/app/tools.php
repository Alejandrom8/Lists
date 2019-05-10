<div class="menu-tools" id="menu-tools">
    <div class="menu-tools-cont"> 
        <div style="width:60%;">
            <section class="show-data">
                <div class="row">
                    <div class="foto-cont">
                        <img src="<?php echo $_SESSION['user_foto'];?>" alt="user foto" class="foto">
                    </div>
                    <div class="nombre">
                        <?php echo $_SESSION['nombre']; ?>
                    </div>
                </div>
            </section>
        </div>
        <div style="width:40%;">
            <section class="tools">
                    <div id="searchFriends" class="input-group" style="background:#ddd;border-radius:25px;">
					    <span class="input-group-addon" style="display:flex;justify-content:space-around;align-items:center;"><i class="fas fa-search fa-2x" aria-hidden="true"></i></span>
						<input type='text' class="form-control" id="consulta" placeholder="Buscar amigos" maxlength="50">
					</div>
                    <i id="message-button" class="fas fa-comments fa-2x fa-lg" title="mensajes"></i>
                    <i id="tools-button" class="far fa-caret-square-left fa-2x fa-lg" title="menú"></i>
            </section>
        </div>
    </div>
    <div id="tools" class="toggle toggle-menu">
        <div class="col-sm-12">
            <img src="<?php echo $_SESSION['user_foto'];?>" alt="user foto" class="foto">
        </div>
        <table class="table">
            <tr class="boton-menu-tools" data-href="<?php echo constant('URL'); ?>home">
                <td>
                    <i class="fas fa-home"></i>
                    Inicio
                </td>
            </tr>
            <tr class="boton-menu-tools">
                <td>
                    <i class="fas fa-user-alt"></i>
                    Actualizar datos
                </td>
            </tr>
            <tr class="boton-menu-tools" data-href="<?php echo constant('URL'); ?>home/social">
                <td>
                    <i class="fas fa-user-friends"></i>
                    Social
                </td>
            </tr>
            <tr class="boton-menu-tools">
                <td>
                    <i class="fas fa-cog"></i>
                    Configuración
                </td>
            </tr>
            <tr class="boton-menu-tools" data-href="<?php echo constant('URL'); ?>salir/saliendo">
                <td class="salir">
                    <i class="fas fa-sign-out-alt"></i> 
                    Salir
                </td>
            </tr>
        </table>
    </div>
    <?php include_once "message.php";?>
</div>
<script>
    $(document).ready(function(){
        let flag2 = false;
        $("#tools-button").on("click", function(){
            if(!flag2){
                $(this).removeClass("fa-caret-square-left").addClass("fa-caret-square-right");
                $("#tools.toggle-menu").css({"right": "0"});
                flag2 = true;
            }else{
                $(this).removeClass("fa-caret-square-right").addClass("fa-caret-square-left");
                $("#tools.toggle-menu").css({"right": "-100vh"});
                flag2 = false;
            }
        });
    });

    const trs = document.querySelectorAll(".boton-menu-tools");
    trs.forEach(tr =>{
        tr.addEventListener("click", function(){
            const link = this.dataset.href;
            window.location = link;
        });
    });
</script>
