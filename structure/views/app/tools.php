<div class="menu-tools" id="menu-tools">
    <div class="menu-tools-cont"> 
        <div style="width:70%;">
            <section class="show-data">
                <div class="row">
                    <input type="text" id="buscador" name="buscador" class="form-control" placeholder="Busca algun proyecto" maxlength="100">
                </div>
            </section>
        </div>
        <div style="width:30%;">
            <section class="tools">
                    <i id="message-button" class="fas fa-comments fa-lg" title="mensajes"></i>
                    <i id="notification-button" class="fas fa-envelope fa-lg" title="notificaciónes"></i>
                    <i id="tools-button" class="far fa-caret-square-left fa-lg" title="menú"></i>
                    <div class="foto-cont">
                        <img src="<?php echo $_SESSION['user_foto'];?>" alt="user foto" class="foto">
                    </div>
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
            <tr class="boton-menu-tools" data-href="<?php echo constant('URL'); ?>salir/saliendo" >
                <td class="salir">
                    <i class="fas fa-sign-out-alt"></i> 
                    Salir
                </td>
            </tr>
        </table>
    </div>
    <div id="notifications">
        <ul id="displayNotifi" class="list-group">
        </ul>
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
                $(this).css("color", "#999");
                flag2 = true;
            }else{
                $(this).removeClass("fa-caret-square-right").addClass("fa-caret-square-left");
                $("#tools.toggle-menu").css({"right": "-100vh"});
                $(this).css("color", "#eee");
                flag2 = false;
            }
        });

        function refreshNotifi(){
            $.ajax({
                url: URLConst + "home/getNotifications",
                dataType: "HTML",
                success: (data) =>{
                    $("#displayNotifi").html(data);
                    setTimeout(() => {
                        refreshNotifi();
                    }, 60000);
                },
                error: () => {
                    console.log("No se logragon cargar las notificacónes");
                }
            });
        }
        refreshNotifi();
    });

    const trs = document.querySelectorAll(".boton-menu-tools");
    trs.forEach(tr =>{
        tr.addEventListener("click", function(){
            const link = this.dataset.href;
            window.location = link;
        });
    });

    let flag3 = false;
        $("#notification-button").on("click", function(){
            if(!flag3){
                $("#notifications").css("display", "block");
                $(this).css("color", "#999");
                flag3 = true;
            }else{
                $("#notifications").css("display", "none");
                $(this).css("color", "#eee");
                flag3 = false;
            }
    });
</script>
