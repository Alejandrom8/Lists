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
                    window.alert(mensaje);
                }else{ 
                    $error = "<div class='alert alert-danger'>" + 
                                "<strong>Error!</strong>" + 
                                "<p>" + mensaje + "</p>" +  
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