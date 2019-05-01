<div id="message" class="toggle toggle-message">
    <div class="row">
        <div class="section col-sm-3" style="background:red;">
            <div id="friends-cont">

            </div>
        </div>
        <div class="section col-sm-9" style="background:blue;">
            <section class="friend-box">

            </section>
            <section class="message-box">
                <div>
                    <span>persona</span>
                    <span>mensaje</span>
                    <span></span>
                </div>
            </section>
            <section class="submit-box">
                <form action="<?php echo constant("URL");?>home/sendMessage" name="messageSection" id="messageSection">
                    <div class="row">
                        <div class="col-sm-10">
                            <input type="text" name="message" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" name="enviar" class="enviar">
                                <i class="fas fa-arrow-circle-right fa-2x"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        function ajaxfunc(){
            $.ajax({
                url: "http://192.168.1.71/social_network/home/readFriends",
                dataType: "JSON",
                success: function(friends){
                    let friendsarr = JSON.parse(friends);
                    let box = $("#friends-cont");
                    let add ="";
                    for(let i = 0; i < Object.keys(friendsarr["amigos"]).length; i++){
                        let index = String("friend" + i);
                        add += "<p>" + friendsarr["amigos"][index] +"</p>";
                    }
                    box.append(add);
                },
                error: function(){
                    alert("error al cargar el archivo");
                }
            });
        }
        ajaxfunc();
    });
</script>