
<?php if (get_sub_field('visible')) : ?>

    <section id="team" class="team py-5 mardello_section " <?php if (get_sub_field('background_color')) : ?>style="background-color: <?php echo get_sub_field('background_color');?>"<?php endif;?>>
        <div class="container">
            <h1 class="team__heading">Il team</h1>
            <div class="row gy-5  mt-3">
            <?php if( have_rows('content_repeater') ):?>
        <?php   while( have_rows('content_repeater') ) : the_row();?>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 ">
                    <div class="team__card p-4">
                        <div class="team__card__img">
                        <?php if(get_sub_field('image')):?>
                        <?php  
                        $src = null;
                        $src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
                        $img = $src[0]; ?>
                        
                        <img class="img-fluid w-100" src="<?php echo $img;?>">
                        <?php endif;?>
                        
                        
                        </div>
                        <div class="team__card__body mt-4">
                            <?php if(get_sub_field('title')):?>
                                <h1 class="team__card__body__heading"><?php echo get_sub_field('title');?></h1>
                                <?php endif;?>
                            <div class="team__card__body__paragraph">
                                <?php if(get_sub_field('position')):?>
                                 <p><?php echo get_sub_field('position');?></p>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile;?>
        <?php endif;?>
            </div>
        </div>
    </section>
    <?php endif;?>