<?php if (get_sub_field('visible')) : ?>
    <section id="text_with_image" class="text_with_image py-5 mardello_section " style="background-color: <?php echo get_sub_field('background_color');?>">
        <div class="container">
            <div class="row text_with_image__row g-5">
                <div class="col-sm-12 col-md-6 col-lg-8">
                    <div class="text_with_image__text">
                        
                        <?php if(get_sub_field('title')):?>
                            <h1 class="text_with_image__text__heading mb-4"><?php echo get_sub_field('title');?></h1>
                        <?php endif;?>
                      
                        <div class="text_with_image__text__paragraph">
                            
                        <?php if(get_sub_field('content')):?>
                        <?php echo get_sub_field('content');?>
                        <?php endif;?>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 <?php if(get_sub_field('image_left')):?>order-md-first order-lg-first<?php endif;?>">
                    <div class="text_with_image__text__img">
                    <?php if(get_sub_field('image')):?>
                        <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
                     $img = $src[0]; ?>
                    <img class="img-fluid w-100" src="<?php echo $img;?>">
                    <?php endif;?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif;?>