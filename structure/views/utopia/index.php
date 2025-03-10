<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'structure/views/headers.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/style/own/landingPage.css">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>public/libs/node_modules/swiper/dist/css/swiper.min.css">
    <title>Anfree</title>
</head>
<body>
    <div class="webpage">
        <!--<script src="<?php echo constant('URL');?>public/style/dropdown-up.js"></script>-->
        <?php include_once 'structure/views/menu.php'; ?>
        <div class="container-own">
            <header id="slider" class="slider">
                <div class="row">
                    <div class="col-sm-1" title="see -">
                        <div class="boton-slider" id="left" data-where='menos'></div>
                    </div>
                    <div class="col-sm-10" id="display">
                    
                    </div>
                    <div class="col-sm-1" title="see +">
                        <div class="boton-slider" id="right" data-where="mas"></div>
                    </div>
                </div>
            </header>
            <section class="after c">
                <section id="carrusel">
                    <div class="swiper-container">
                        <div class="swiper-wrapper" id="swip-app">

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </section>
            </section>
            <section class="after T">
              <div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vitae ipsum interdum, scelerisque quam eget, facilisis leo. Nullam massa quam, feugiat in augue sed, blandit aliquam ex. Nulla faucibus suscipit egestas. Suspendisse nec turpis arcu. Nullam varius, tellus id rutrum pulvinar, sem metus pulvinar diam, ut sagittis enim felis ut sem. Etiam leo felis, congue quis felis sit amet, placerat feugiat leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Cras mollis accumsan tincidunt. Curabitur scelerisque ex non augue viverra tincidunt. </p>
              </div>
            </section>
        </div>
        <?php include_once 'structure/views/footer.php'; ?>
    </div>
</body>
<?php include_once 'content.php'; ?>
<script src="<?php echo constant('URL');?>public/libs/node_modules/swiper/dist/js/swiper.min.js"></script>
<script src="<?php echo constant('URL'); ?>public/app.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
      slidesPerView: 3,
      spaceBetween: 21,
      freeMode: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        1024: {
          slidesPerView: 3,
          spaceBetween: 40,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        640: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        320: {
          slidesPerView: 1,
          spaceBetween: 10,
        }
      }
    });
  </script>
</html>
