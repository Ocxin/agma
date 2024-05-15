<?php if (get_sub_field('visible')) : ?>

    <section id="home-hero" class="home-hero" style="background-color: #F3F5F5;">
  
        <div class="container-fluid">
            <div class="home-hero__img">
            <?php if(get_sub_field('image')):?>
        <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
                     $img = $src[0]; ?>
       
        <img class="img-fluid w-100 d-none d-sm-block" src="<?php echo $img;?>">
        <?php endif;?>

            <?php if(get_sub_field('image')):?>
        <?php  
                     $src_mobile = null;
                     $src_mobile = wp_get_attachment_image_src(get_sub_field('mobile_image'), 'full');
                     $img_mobile = $src_mobile[0]; ?>
        
        <img class="img-fluid w-100 d-block d-sm-none" src="<?php echo $img_mobile;?>">
        <?php endif;?>
        </div>
        </div>
    </section>
<?php endif;?>
