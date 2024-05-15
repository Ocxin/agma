<?php if (get_sub_field('visible')) : ?>

    <section id="slide-box" class="mardello_section slide-box py-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                   
                        <?php if(get_sub_field('title')):?>
                            <h1 class="upper_footer__card__heading mb-5 py-5 ">
        <?php echo get_sub_field('title');?>
        </h1>
        <?php endif;?>
                </div>
            </div>
            <div class=" slick-img g-5 py-5">
             
        <?php if( have_rows('content_repeater') ):?>
        <?php   while( have_rows('content_repeater') ) : the_row();?>
    
       
              
                <div class="col-sm-12 col-md-6 col-lg-3 slick-col">
                    <div class="slide-box__card">
                        <div class="slide-box__card__img">
                            
                        <?php if(get_sub_field('image')):?>
        <?php  
        $src = null;
        $src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
        $img = $src[0]; ?>
        
        <img class="img-fluid w-100" src="<?php echo $img;?>">
        <?php endif;?>
                    </div>
                        <div class="slide-box__card__body py-2 px-3">
                            <h1 class="slide-box__card__body__heading mt-3 mb-3">
                            <?php if(get_sub_field('title')):?>
        <?php echo get_sub_field('title');?>
        <?php endif;?>
                            </h1>
                            <div class="slide-box__card__body__paragraph">
                                <p>       <?php if(get_sub_field('sub_title')):?>
        <?php echo get_sub_field('sub_title');?>
        <?php endif;?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php endwhile;?>
        <?php endif;?>



            </div>
            <div class="justify-content-evenly custom-arrows"><button class="custom-prev"></button><button class="custom-next"></button></div>
            
            
        <?php if(get_sub_field('link')):?>
        <?php $link = get_sub_field('link');?>
        
        <div class="text-center mt-5">
                <a target="<?php echo $link['target'];?>" class="btn btn-primary slide-box__btn py-4 px-5" href="<?php echo $link['url'];?>"><?php echo $link['title'];?></a>
            
            </div>
        <?php endif;?>
            
        </div>
    </section>

    <?php endif;?>
