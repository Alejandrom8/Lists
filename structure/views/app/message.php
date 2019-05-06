<style>
.contFotoFriend{
    width:100%;
    height:50px;
    background-color:#5d67b0;
    display:flex;
    align-items:center;
}
.fotoAmigo{
    margin:0 auto;
    width:40px;
    height:40px;
    border-radius:50%;
    background-color:#fff;
}
.conversation{
    width:100%;
    height:100%;
    padding:4%;
    background-color:#5d67b0;
    border-radius:15px;
    overflow-y:scroll;
}
.mensaje{
    border-radius:20px;
    text-align:center;
    max-width:60%;
    padding-left:10px;
    padding-right:10px;
}
.anfitrion{
    /* margin-left:30%; */
    float:right;
    background-color:#fff;
}
.invitado{
    float:left;
    background-color:#ccc;
}
</style>
<div id="message" class="toggle toggle-message">
    <div class="row">
        <div class="section col-sm-2 fotos">
            <div id="friends-cont" style="width:100%;display:inline-block;">

            </div>
        </div>
        <div class="section col-sm-10">
            <section id="friend-box" class="friend-box">

            </section>
            <section class="message-box" id="message-box">
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
                            <input type="text" name="message" id="message_input" class="form-control">
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
<?php 

print("<script>

    let globalId = '". $_SESSION['idanfree'] ."';

</script>");

?>
<script>
    let archivo_anfree;

    function amigO(){
        this.nombre;
        this.id;
        this.foto;
    }

    let amigo1id, amigo1nombre;

        $(document).ready(function(){
            $.ajax({
                url: "http://192.168.1.71/social_network/home/getDataFriends",
                dataType: "JSON",
                success: function(friends){

			init(friends);

                },
                error: function(){
                    alert("error al cargar el archivo");
                }
            });
 
	});
	
	function init(friends){

                    archivo_anfree = friends;
                    let box = $("#friends-cont");
                    let add = "";

                    for(let i = 0; i < Object.keys(archivo_anfree).length; i++){

			let amigoObj = new amigO();
			
                        amigoObj.nombre = archivo_anfree[i].nombre;
                        amigoObj.id = archivo_anfree[i].idanfree;
                        amigoObj.foto = archivo_anfree[i].foto;

                        add += "<div class=\"contFotoFriend\" onclick=\"nuevaConversacion('" + amigoObj.id + "', '" + amigoObj.nombre + "');\">";
                        add += "<img src='" + amigoObj.foto + "' class='fotoAmigo'><br>";
                        add += "</div>";
                        box.append(add);
                        add = "";
                    }
    }

		let nuevaConversacion = function(id, nombre){
		    amigo1id = id; amigo1nombre = nombre;
		    let app = new MessageBox($("#message-box"),amigo1id);
		    $("#friend-box").empty().append("<p>" + amigo1nombre + "</p>");
		    $("#messageSection input[type='hidden']").remove();
		    $("#messageSection").append("<input type='hidden' name='friend' value='" + amigo1id +"'>");
		    app.createPanel();
		    app.obtenerMensajes();
		    console.log("update");
		}

		setInterval(nuevaConversacion(archivo_anfree[0].idanfree, archivo_anfree[0].nombre), 3000);

		$("#messageSection").bind("submit", function(){
		    $.ajax({
		        type: $(this).attr("method"),
		        url: $(this).attr("action"),
		        data: $(this).serialize(),
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(data){
		           console.log(data);
		        },
		        error: function(){
		            alert("error");
		        }
		    });
		    $("#message_input").val("");
		    return false;
		});

	    function MessageBox(display,idanfree){

		this.idanfree = idanfree;
		this.data = archivo_anfree;
		this.area = display;
		
		this.createPanel = function(){
		    this.area.empty();
		    this.area.append("<div class='conversation'></div>");
		}; 

		this.obtenerMensajes = function(data = this.idanfree){

		    let mensajes;

		    $.ajax({
		        type: "POST",
		        data: {data, data},
		        dataType: "JSON",
		        url: "http://192.168.1.71/social_network/home/getConversation",
		        success: function(respuesta){
		            llenarPanel(respuesta, globalId);
		        }
		    });
		};

		llenarPanel = function(data, id){

		    let divs = "";

		    for(let i = 0; i < Object.keys(data).length; i++){
		        let indice = "mensaje" + i;
		        if(data[indice].id == id){
		            divs += "<div class='mensaje anfitrion'><span>";
		        }else{
		            divs += "<div class='mensaje invitado'><span>";
		        }
		        divs +=  data[indice].mensaje + 
		                "</span></div></br>";
		    }
		    $("#message-box").children().append(divs);
		};
	    }
</script>
