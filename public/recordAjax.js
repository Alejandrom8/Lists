$(document).ready(function(){

        $("#newRecord").on('submit', function(e){
            e.preventDefault();
            let cont = $(this);
            let data = getFiles();
            data = getFormData("newRecord",data);
            let boton = $("boton-enviar");
            $.ajax({
                type: cont.attr("method"),
                url: cont.attr("action"),
                dataType: 'JSON',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    boton.attr("disabled", "disabled");
                    boton.val("Registrando...");
                },
                complete: function(){
                    boton.removeAttr("disabled");
                    boton.val("Registrar");
                },
                success: function(data){
                    let datos = JSON.parse(JSON.stringify(data));
                    let estado = datos[0];
                    let mensaje = datos[1];

                    if(estado){
                        let where = datos[2];
                        window.alert(mensaje);
                        window.location = where;
                    }else{
                        window.alert(mensaje);
                    }
                },
                error: function(){
                    console.log("error");
                } 
            });
            return false;
        });
});
function getFiles(){
	var idFiles=document.getElementById("file");
	// Obtenemos el listado de archivos en un array
	var archivos = idFiles.files;
	// Creamos un objeto FormData, que nos permitira enviar un formulario
	// Este objeto, ya tiene la propiedad multipart/form-data
	var data=new FormData();
	// Recorremos todo el array de archivos y lo vamos añadiendo all
	// objeto data
	// Al objeto data, le pasamos clave,valor
	data.append("foto",archivos[0]);
	return data;
}
function getFormData(id,data){
	$("#"+id).find("input,select").each(function(i,v) {
        if(v.type!=="file") {
            if(v.type==="checkbox" && v.checked===true) {
                data.append(v.name,"on");
            }else{
                data.append(v.name,v.value);
            }
        }
	});
	return data;
}