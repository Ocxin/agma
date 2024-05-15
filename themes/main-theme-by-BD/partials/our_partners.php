<?php if (get_sub_field('visible')) : ?>
<section id="our_partners" class="mardello_section our_partners py-5">
        <div class="container">
            <div class="row gy-5">
                <div class="col-12 col-md-12 col-lg-2">
                <?php if(get_sub_field('title')):?>
                
                <h1 class="our_partners__heading"><?php echo get_sub_field('title');?></h1>
                <?php endif;?>
               
                </div>
                <div class="col-12 col-md-12 col-lg-10">
                    <div class="row gy-4 slick-company">
                    <?php if( have_rows('content_repeater') ):?>
                    <?php   while( have_rows('content_repeater') ) : the_row();?>
                    <?php if(get_sub_field('logo')):?>
                    <?php  
                                $src = null;
                                $src = wp_get_attachment_image_src(get_sub_field('logo'), 'full');
                                $img = $src[0]; ?>
                        <div class="col-6 col-md-6 col-lg-3">
                        <div class="our_partners__card">
                        <div class="text-center our_partners__card__img"><img class="img-fluid" src="<?php echo $img;?>"></div>
                        </div>
                        </div>
                    
                    <?php endif;?>
                    <?php endwhile;?>
                    <?php endif;?>


                      
                     
                    </div>
                </div>
            </div>
            <div class="justify-content-evenly custom-arrows"><button class="custom-prev"></button><button class="custom-next"></button></div>
        </div>
    </section>
    <?php endif;?>
    <script>jQuery(document).ready(function() {
    var mediaQuery = window.matchMedia('(max-width: 768px)');
    var slickInitialized = false;
    var slickOptions = {
        arrows: false,
        centerMode: true,
        centerPadding: '80px',
        slidesToShow: 1,
        slidesToScroll: 1
    };

    function initSlick() {
        if (mediaQuery.matches && !slickInitialized) {
            jQuery('.slick-company').slick(slickOptions);
            slickInitialized = true;
        } else if (!mediaQuery.matches && slickInitialized) {
            jQuery('.slick-company').slick('unslick');
            slickInitialized = false;
        }
      
             jQuery('.custom-prev').click(function() {
            jQuery('.slick-company').slick('slickPrev');
        });

        jQuery('.custom-next').click(function() {
            jQuery('.slick-company').slick('slickNext');
        });
    }

    initSlick();

    jQuery(window).on('resize', function() {
        initSlick();
    });
});</script>