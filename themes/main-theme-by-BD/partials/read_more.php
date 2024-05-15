<?php if (get_sub_field('visible')) : ?>

    <section id="read_more" class="mardello_section px-4 read_more py-5" style="background-color:#D5D5D533;">
        <div class="container">
            <div class="row gy-3">
                <div class="col-12 col-md-12 col-lg-3">
                <?php if(get_sub_field('title')):?>
                    <h1 class="read_more__heading"><?php echo get_sub_field('title');?></h1>
                    <?php endif;?>
                </div>
                <?php if( have_rows('content_repeater') ):?>
        <?php   while( have_rows('content_repeater') ) : the_row();?>
        <?php if(get_sub_field('icon')):?>
        <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('icon'), 'full');
                     $img = $src[0]; ?>
        
        <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="d-flex flex-column justify-content-between read_more__card p-5">
                        <div class="text-center read_more__card__img mb-4"><img class="img-fluid" src="<?php echo $img;?>"></div>
                        <?php if(get_sub_field('link')):?>
                        <?php $link = get_sub_field('link');?>
                        <a target="<?php echo $link['target'];?>" class="text-center d-inline-block read_more__card__btn w-100 py-4" href="<?php echo $link['url'];?>"><?php echo $link['title'];?></a>
                        <?php endif;?>
                    </div>
                </div>
        <?php endif;?>
        <?php endwhile;?>
        <?php endif;?>
                
               
                
            </div>
        </div>
    </section>
    <?php endif;?>