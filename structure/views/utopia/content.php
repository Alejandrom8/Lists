<script>
const carpetaImg = "<?php echo constant('URL'); ?>public/img/";
let contenido = {
    0:{
        "titulo": {
            font_size: 20,
            font_color: "#fff",
            texto: "ANFREE"
        },
        "texto": "<p>Este es un texto de prueba para probar toda la funcionalidad de anfree</p><p>- o -</p>",
        "background" : {
            image: carpetaImg + 'vector1.jpg',
            color: "#151726"
        }
    },
    1:{
        "titulo": {
            font_size: 20,
            font_color: "#333", 
            texto: "!Apertura de Anfree!"
        },
        "texto": "<p>Este es un texto de prueba para probar toda la funcionalidad de anfree</p><p>- a -</p>",
        "background": {
            image: null,
            color: "#31d6f7"
        }        
    }
};
let bloques = {
    0:{
        img: carpetaImg + "cultivo.jpg",
        title: "Botánica",
        text: "Este es un texto de prueba para probar toda la funcionalidad de anfree"
    },
    1:{
        img: carpetaImg + "supernova.jpg",
        title: "Espacio",
        text: "Este es un texto de prueba para probar toda la funcionalidad de anfree"
    },
    2:{
        img: carpetaImg + "fisica.jpg",
        title: "Física",
        text: "Este es un texto de prueba para probar toda la funcionalidad de anfree"
    },
    3:{
        img: carpetaImg + "davinci.jpg",
        title: "Maquinaria",
        text: "Este es un texto de prueba para probar toda la funcionalidad de anfree"
    },
    4:{
        img: carpetaImg + "matematicas.jpg",
        title: "Matemáticas",
        text: "Este es un texto de prueba para probar toda la funcionalidad de anfree"
    },
}
</script>