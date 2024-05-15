<?php if (get_sub_field('visible')) : ?>
    <section id="contact_banner" class="mardello_section contact_banner py-5">
        <div class="container">
            <div class="contact_banner__body d-flex flex-wrap align-items-center justify-content-center p-5">
                <div class="contact_banner__body__img me-5">
                <?php if(get_sub_field('icon')):?>
            <?php  
                     $src = null;
                     $src = wp_get_attachment_image_src(get_sub_field('icon'), 'full');
                     $img = $src[0]; ?>
        
        <img class="img-fluid" src="<?php echo $img;?>">
        <?php endif;?>
         
                </div>
                <div class="contact_banner__body__content me-auto">
                <?php if(get_sub_field('title')):?>
                <h1 class="contact_banner__body__content__heading mb-4"><?php echo get_sub_field('title');?></h1>
                <?php endif;?>
                
                    <div class="contact_banner__body__content__paragraph">
                        <?php if(get_sub_field('sub_title')):?>
                            <p> <?php echo get_sub_field('sub_title');?></p>
                        <?php endif;?>
                    </div>
                </div>
                <div class="text-center">
                <?php if(get_sub_field('link')):?>
                <?php $link = get_sub_field('link');?>
                <a target="<?php echo $link['target'];?>" class="text-center d-inline-block contact_banner__body__btn py-4 px-5" href="<?php echo $link['url'];?>"><?php echo $link['title'];?></a>
                <?php endif;?>
              
            
            </div>
            </div>
        </div>
    </section>
    <?php endif;?>