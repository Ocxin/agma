<?php if (get_sub_field('visible')) : ?>
<section id="upper_footer" class="upper_footer py-5 mardello_section ">
        <div class="container">
            <div class="row gy-5">

            <?php if (!get_sub_field('hide_showroom_box')):?>
            <?php if(get_sub_field('layout') == 'half'):?>
                <div class="col-sm-12 col-md-6">
                <?php endif;?>
                <?php if(get_sub_field('layout') == 'third'):?>
                <div class="col-sm-12 col-md-7">
                <?php endif;?>
                <div class="upper_footer__card p-5">
                    <?php if(get_field('upper_footer_showroom_block_title','option')):?>
                        <h1 class="upper_footer__card__heading mb-4"><?php echo get_field('upper_footer_showroom_block_title','option');?></h1>
                        <?php endif;?>
                        <div class="upper_footer__card__paragraph mb-5">
                        <?php if(get_field('upper_footer_showroom_block_content','option')):?>
                        <?php echo get_field('upper_footer_showroom_block_content','option');?>
                        <?php endif;?>
                        </div>
                        <?php if(get_field('upper_footer_showroom_block_url','option')):?>
                        <?php $link = get_field('upper_footer_showroom_block_url','option');?>
                        <a target="<?php echo $link['target'];?>" class="btn btn-primary upper_footer__card__btn p-4" href="<?php echo $link['url'];?>" ><?php echo $link['title'];?></a>
                        <?php endif;?>
                   
                    </div>
                </div>
            <?php endif;?>


                <?php if(get_sub_field('layout') == 'half' && !get_sub_field('hide_showroom_box')):?>
                <div class="col-sm-12 col-md-6">
                <?php endif;?>
                <?php if(get_sub_field('layout') == 'third' && !get_sub_field('hide_showroom_box')):?>
                <div class="col-sm-12 col-md-5">
                    <?php elseif (get_sub_field('hide_showroom_box')):?>
                        <div class="col-sm-12 col-md-12">
                <?php endif;?>
                    <div class="upper_footer__card p-5">
                        <h1 class="upper_footer__card__heading mb-4"><?php echo get_field('form_subscription_title','option');?></h1>
                        <?php $form_string = '[contact-form-7 id="'.get_field('form_id','option').'"  html_class="upper_footer__card__form d-flex flex-wrap justify-content-between align-items-center"]';?>
                        <?php echo do_shortcode($form_string);?>

                      
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (get_sub_field('hide_showroom_box')): ?>

        <style>
            .upper_footer form input[type="email"] {
                width: calc(100% - 210px);
            }
            .upper_footer form input[type="submit"] {
                width: 200px;
                margin-left: 10px;
            }
            @media only screen and (max-width: 768px) {
                .upper_footer form input[type="email"] {
                width: 100%;
            }
            .upper_footer form input[type="submit"] {
                width: 250px;
                margin: 20px auto;
                order: 3;
            }
            }
        </style>
        
    <?php endif;?>
    <style>.wpcf7-spinner {display:none !important}</style>
    <?php endif;?>
