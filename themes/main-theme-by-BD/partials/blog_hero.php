
<?php if (get_sub_field('visible')) : ?>
    
    <?php $img = null;?>  
    <?php if(get_sub_field('image')):?>
        <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
                     $img = $src[0]; ?>
        
        <?php endif;?>

    <section id="hero"  class="hero blog_archive_hero hero-bg py-5 h-auto d-flex align-items-end "  
    style="filter: unset;background: linear-gradient(0deg, rgba(40, 99, 101, 0.5), rgba(40, 99, 101, 0.5)), url(<?php echo $img;?>);background-repeat:no-repeat;background-size:cover;background-color:<?php echo get_sub_field('background_color');?>;">
        <div class="container h-100">
            <div class="d-flex flex-column justify-content-end hero__body h-100">
                <div class="hero__body__path">
                    <p><?php get_breadcrumb(); ?></p>
                </div>
               
                <h1 class="hero__body__heading"><?php echo get_the_title();?></h1>
           
               
            </div>
        </div>
    </section>


    <section id="hero-phone" class="hero--sm h-auto blog_archive_hero_mobile" style="background-color:<?php echo get_sub_field('background_color');?>"  >
        <?php $img_mobile = null;?>  
    <?php if(get_sub_field('image_mobile')):?>
        <?php  
                     $src_mobile = null;
                     $src_mobile = wp_get_attachment_image_src(get_sub_field('image_mobile'), 'full');
                     $img_mobile = $src_mobile[0]; ?>
       
        <?php endif;?>
        <div class="d-flex flex-column justify-content-end hero__body h-100 px-5" 
        style="filter: unset;min-height: 30vh;background: linear-gradient(0deg, rgba(40, 99, 101, 0.5), rgba(40, 99, 101, 0.5)), url(<?php echo $img_mobile;?>);background-repeat:no-repeat;background-size:cover;background-color:<?php echo get_sub_field('background_color');?>;">
            <div class="hero__body__path">
                <p><?php get_breadcrumb(); ?></p>
            </div>
         
                <h1 class="hero__body__heading"><?php echo get_the_title();?></h1>

        </div>
    </section>
<?php endif;?>
<style>@media (max-width: 47.99em) {
.hero {
    display: none !important;
}
}
</style>