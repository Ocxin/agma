
<?php if (get_sub_field('visible')) : ?>
    <?php 
    $rgba = ('0 , 0 ,0');
    if (get_sub_field('gradient_color')) {
        $r = get_sub_field('gradient_color');
        $rgba = $r['red'].','.$r['green'].','.$r['blue'];
        $alpha = $r['alpha'];
        if ($alpha > 0.5) {
            $alpha = 0.5;
        }
    }
   
    ;?>
    <?php $img = null;?>  
    <?php if(get_sub_field('image')):?>
        <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
                     $img = $src[0]; ?>
        
        <?php endif;?>

    <section id="hero"  class="hero hero-bg py-5 h-auto d-flex align-items-end "  
    style="filter: unset;min-height: 35vh;background: linear-gradient(0deg, rgba(<?php echo $rgba;?>, <?php echo $alpha;?>), rgba(<?php echo $rgba;?>, <?php echo $alpha;?>)), url(<?php echo $img;?>);background-repeat:no-repeat;background-size:cover;background-position:center;background-color:<?php echo get_sub_field('background_color');?>;">
        <div class="container h-100">
            <div class="d-flex flex-column justify-content-end hero__body h-100">
                <div class="hero__body__path d-none">
                    <p>home /&nbsp;</p>
                </div>
                <?php if(get_sub_field('title')):?>
                <h1 class="hero__body__heading"> <?php echo get_sub_field('title');?></h1>
                <?php endif;?>
                <div class="hero__body__paragraph">
                              <?php if(get_sub_field('content')):?>
               <?php echo get_sub_field('content');?>
                <?php endif;?>
                </div>
            </div>
        </div>
    </section>


    <section id="hero-phone" class="hero--sm h-auto" style="background-color:<?php echo get_sub_field('background_color');?>"  >
        <?php $img_mobile = null;?>  
    <?php if(get_sub_field('image_mobile')):?>
        <?php  
                     $src_mobile = null;
                     $src_mobile = wp_get_attachment_image_src(get_sub_field('image_mobile'), 'full');
                     $img_mobile = $src_mobile[0]; ?>
       
        <?php endif;?>
        <div class="d-flex flex-column justify-content-end hero__body h-100 px-5" 
        style="filter: unset;min-height: 30vh;background: linear-gradient(0deg, rgba(<?php echo $rgba;?>, <?php echo $alpha;?>), rgba(<?php echo $rgba;?>, <?php echo $alpha;?>)), url(<?php echo $img_mobile;?>);background-repeat:no-repeat;background-size:cover;background-position:center;background-color:<?php echo get_sub_field('background_color');?>;">
            <div class="hero__body__path d-none">
                <p>home /&nbsp;</p>
            </div>
            <?php if(get_sub_field('title')):?>
                <h1 class="hero__body__heading"> <?php echo get_sub_field('title');?></h1>
                <?php endif;?>
        </div>
        <?php if(get_sub_field('content')):?>
        <div class="hero__body--2 p-5" 
        <?php if(get_sub_field('image_mobile')):?>
        style="background-color: #286365;"
        <?php else: ?>
        style="background-color: <?php echo get_sub_field('background_color');?>;" 
        <?php endif;?>
        >
            <div class="hero__body__paragraph">
                          <?php if(get_sub_field('content')):?>
                 <?php echo get_sub_field('content');?>
                <?php endif;?>
            </div>
        </div>
        <?php endif;?>
    </section>
<?php endif;?>
<style>@media (max-width: 47.99em) {
.hero {
    display: none !important;
}
}
</style>