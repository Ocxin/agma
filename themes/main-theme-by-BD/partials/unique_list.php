<?php if (get_sub_field('visible')) : ?>
<section id="unique_list" class="unique_list py-5 mardello_section " style="background-color: #D5D5D533;">
        <div class="container">
            <div class="row gy-3">
                <div class="col-12 col-md-12 col-lg-2">
                <?php if(get_sub_field('title')):?>
                       
                <h1 class="unique_list__heading"><?php echo get_sub_field('title');?></h1>
                <?php endif;?>
                  
                </div>
                <div class="col-12 col-md-12 col-lg-10">
                    <div class="row">
                    <?php if( have_rows('content_repeater') ):?>
                            <?php   while( have_rows('content_repeater') ) : the_row();?>
                            <?php if(get_sub_field('icon')):?>
                            <?php  
                                        $src = null;
                                        $src = wp_get_attachment_image_src(get_sub_field('icon'), 'full');
                                        $img = $src[0]; ?>
                                        <div class="col-6 col-md-6 col-lg-3 mb-4">
                                        <div class="unique_list__card p-5 d-flex flex-column justify-content-start">
                                            <div class="text-center unique_list__card__img mb-4"><img class="img-fluid" src="<?php echo $img;?>"></div>
                                            <div class="unique_list__card__paragraph">
                                                
                                                <?php if(get_sub_field('title')):?>
                                                    <p><?php echo get_sub_field('title');?></p>
                                                    <?php endif;?>

                                        
                                            </div>
                                        </div>
                                    </div>
                            
                            <?php endif;?>
                            <?php endwhile;?>
                            <?php endif;?>
                    </div>
               
                </div>
     
               
                
            </div>
            
        </div>
    </section>
    <?php endif;?>