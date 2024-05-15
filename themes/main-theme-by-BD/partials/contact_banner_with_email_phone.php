<?php if (get_sub_field('visible')) : ?>
    
    <section id="contact_banner-2" class="mardello_section contact_banner py-5">
        <div class="container">
            <div class="contact_banner__body p-5">
                <div class="contact_banner__body__content text-center mb-5">
                <?php if(get_sub_field('title')):?>
                    <h1 class="contact_banner__body__content__heading"><?php echo get_sub_field('title');?></h1>
                <?php endif;?>
                </div>
                <div class="d-flex flex-wrap justify-content-center align-items-baseline">
                <?php if(get_field('phone','option')):?>
                    <a class="contact_banner__body__link me-5 d-flex align-items-center" href="tel:<?php echo get_field('phone','option');?>">
                        <i class="fa fa-phone fa-2x me-3"></i><?php echo get_field('phone','option');?>
                    </a>
                <?php endif;?>

                 
                <?php if(get_field('email','option')):?>
                        <a class="contact_banner__body__link d-flex align-items-center" href="mailto:<?php echo get_field('email','option');?>">
                            <i class="fa fa-envelope-o fa-2x me-3"></i><?php echo get_field('email','option');?></a>
                <?php endif;?>
                    </div>
            </div>
        </div>
    </section>
    <?php endif;?>