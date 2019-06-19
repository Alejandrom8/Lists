$(document).ready(function(){
    $("#login").bind("submit", function(){
        let boton = $("#send");
        let valboton = boton.val();
        let errorSection = $("#debug");

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            dataType: 'JSON',
            data: $(this).serialize(),
            beforeSend: function(){
                boton.attr('disabled', 'disabled');
                boton.val('Verificando...');
            },
            complete: function(){
                boton.removeAttr('disabled');
                boton.val(valboton);
            },
            success: function(data){
                let respuesta = JSON.parse(JSON.stringify(data));
                let estado = respuesta.estado;
                let mensaje = respuesta.mensaje;
                if(estado){
                    window.location = respuesta.donde;
                }else{ 
                    $error = "<div class='alert alert-danger'>" + 
                                "<svg xmlns='https://www.w3.org/2000/svg' aria-hidden='true' focusable='false' width='16px' height='16px' viewBox='0 0 24 24' fill='currentColor'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z'></path><path d='M0 0h24v24H0z' fill='none'></path></svg>" + 
                                "<span> " + mensaje + "</span>" +  
                              "</div>";
                    errorSection.empty();
                    errorSection.append($error);
                }
            },
            error: function(jqxhr, status, exception) {
                console.log('Exception:', exception);
            }
        });
        return false;
    });
});