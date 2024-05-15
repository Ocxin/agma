
<?php if (get_sub_field('visible')) : ?>
    <section id="split_section" class="split_section mardello_section py-5" 
    style=<?php if (get_sub_field('background_color')) : ?>"background-color: <?php echo get_sub_field('background_color');?>"<?php endif;?>
    >
        <div class="container">
            <div class="row split_section__row gy-5">
                <div class="col-sm-12 col-md-6">
                    <div class="split_section__content">
                        
        <?php if(get_sub_field('title')):?>
        <h1 class="split_section__content__heading mb-4"><?php echo get_sub_field('title');?></h1>
        <?php endif;?>

                       
                        <div class="split_section__content__paragraph">
                        <?php if(get_sub_field('content')):?>
                    <?php echo get_sub_field('content');?>
                        <?php endif;?>
                        </div>
                        <?php if(get_sub_field('link')):?>
                            <?php $link = get_sub_field('link');?>
                            <div class="mt-5">
                                                <a href="<?php echo $link['url'];?>" class="btn btn-primary split_section__content__btn py-4 px-5" target="<?php echo $link['target'];?>"><?php echo $link['title'];?></a>
                                            </div>
                            <?php endif;?>
                       
                    </div>
                </div>
                <div class="col-sm-12 col-md-6  <?php if(get_sub_field('image_left')):?>order-md-first order-lg-first<?php endif;?>">
                <?php if(get_sub_field('image')):?>
                    <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
                     $img = $src[0]; ?>
        
                    <div class="split_section__img"><img class="img-fluid w-100" src="<?php echo $img;?>"></div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </section>
    <?php endif;?>
    