<?php if (get_sub_field('visible')) : ?><section id="certified-products" class="mardello_section certified-products py-5" style=<?php if (get_sub_field('background_color')) : ?>"background-color: <?php echo get_sub_field('background_color');?>"<?php endif;?>>
        <div class="container">
            <div class="certified-products__body text-center">
                
                <?php if(get_sub_field('title')):?>
        <h1 class="certified-products__body__heading mb-5"><?php echo get_sub_field('title');?></h1>
        <?php endif;?>
        <?php if(get_sub_field('img')):?>
        <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('img'), 'full');
                     $img = $src[0]; ?>
        
        <div class="certified-products__body__img"><img class="img-fluid" src="<?php echo $img;?>"></div>
        <?php endif;?>
               
            </div>
        </div>
    </section>
    <?php endif;?>