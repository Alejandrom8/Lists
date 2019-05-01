function Anuncio(titulo, font_color, texto, background, color){
        $(document).ready(function(){
            let display = $("#display");
            let cont = $("#slider");
            cont.css({"color": font_color});
            if(background != null){
                cont.css({"background-image": "url(" + background + ")", "background-color": color});
            }else{
                cont.css({"background-image": 'url(null)', "background-color": color});
            }
            let anuncio = "<div class='anuncio'>";
            anuncio += "<h1>"+ titulo +"</h1>";
            anuncio += "<p>"+ texto +"</p></div>";
            display.empty();
            display.append(anuncio);
        });
}

let anuncios = JSON.parse(JSON.stringify(contenido));

function nuevoAnuncio(index){
    //propiedades del texto
    let titulo = anuncios[index].titulo.texto;
    let texto = anuncios[index].texto;
    let font_color = anuncios[index].titulo.font_color;
    //propiedades del background
    let background = anuncios[index].background.image;
    let color = anuncios[index].background.color;
    Anuncio(titulo, font_color, texto, background, color);
}

nuevoAnuncio(0);

let contador = 0;

const botones = document.querySelectorAll(".boton-slider");
botones.forEach(boton => {
    boton.addEventListener("click", function(){
        if(contador >= 0 && contador < Object.keys(anuncios).length){
            nuevoAnuncio(contador);
            let where = this.dataset.where;
            contador = where == "mas" ? contador + 1 : contador -1;
        }else{
            contador = 0;
        }
        console.log(contador);
    });
});

let notas = JSON.parse(JSON.stringify(bloques));
let display_bloque = $("#swip-app");
let bloque_log = "";
for(let i = 0; i < Object.keys(notas).length; i++){
    let img = notas[i].img;
    let titulo = notas[i].title;
    let texto = notas[i].text;
        bloque_log += "<div class='swiper-slide'><div class='cont'>";
        bloque_log += "<div class='bloque-image'>" + 
                    "<img src='" + img + "'>" +
                  "</div>";
        bloque_log += "<div class='text'>" + 
                    "<h3>"+ titulo +"</h3>" + 
                    "<p>"+ texto +"</p>" +
                    "<center><button class='btn btn-primary'>Más</button></center>" +  
                  "</div>";
        bloque_log += "</div></div>";
}
display_bloque.append(bloque_log);