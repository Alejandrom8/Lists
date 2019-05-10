
<div id="message" class="toggle toggle-message">
    <div class="row">
        <div class="section col-sm-2 fotos">
            <div id="friends-cont" style="width:100%;display:inline-block;">

            </div>
        </div>
        <div class="section col-sm-10">
            <section id="friend-box" class="friend-box"></section>
            <section class="message-box" id="message-box"></section>
            <section class="submit-box">
                <form action="<?php echo constant("URL");?>home/sendMessage" name="messageSection" id="messageSection">
                    <div class="row">
                        <div class="col-sm-10">
                            <input type="text" name="message" id="message_input" class="form-control" autofocus="true">
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
<?php 
    echo "let globalId = '" . $_SESSION['idanfree'] . "'";
?>
</script>