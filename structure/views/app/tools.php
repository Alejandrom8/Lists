<div class="menu-tools" id="menu-tools">
    <div class="menu-tools-cont"> 
        <div style="width:70%;">
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
        <div style="width:30%;">
            <section class="tools">
                    <i id="tools-button" class="far fa-caret-square-left fa-3x fa-lg"></i>
                    <i id="message-button" class="fas fa-comments fa-2x fa-lg" style="margin-top:5%;"></i>
            </section>
        </div>
    </div>
    <div id="tools" class="toggle toggle-menu">
        <div class="col-sm-12">
            <img src="<?php echo $_SESSION['user_foto'];?>" alt="user foto" class="foto">
        </div>
        <table class="table">
            <tr class="boton-menu-tools">
                <td>
                    <i class="fas fa-user-alt"></i>
                    Actualizar datos
                </td>
            </tr>
            <tr class="boton-menu-tools">
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
    // const toggles = document.querySelectorAll(".toggle");
    // let flag = false;
    // toggles.forEach(toggle =>{
    //     toggle.addEventListener("click", function(){
    //         const id = this.dataset.iddiv;
    //         $(document).ready(function(){
    //             if(!flag){
    //                 // this.removeClass("fa-caret-square-left").addClass("fa-caret-square-right");
    //                 $("#"+id).css({"right": "0"});
    //                 flag = true;
    //             }else{
    //                 // this.removeClass("fa-caret-square-right").addClass("fa-caret-square-left");
    //                 $("#"+id).css({"right": "-50vh"});
    //                 flag = false;
    //             }
    //         });
    //     });
    // });
    $(document).ready(function(){
        let flag = false;
        $("#tools-button").on("click", function(){
            if(!flag){
                $(this).removeClass("fa-caret-square-left").addClass("fa-caret-square-right");
                $("#tools.toggle-menu").css({"right": "0"});
                flag = true;
            }else{
                $(this).removeClass("fa-caret-square-right").addClass("fa-caret-square-left");
                $("#tools.toggle-menu").css({"right": "-50vh"});
                flag = false;
            }
        });
        let flag2 = false;
        $("#message-button").on("click", function(){
            if(!flag2){
                $("#message.toggle-message").css({"right": "0"});
                flag2 = true;
            }else{
                $("#message.toggle-message").css({"right": "-60vh"});
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