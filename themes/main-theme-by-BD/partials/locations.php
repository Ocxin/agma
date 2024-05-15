<?php if (get_sub_field('visible')) : ?>
    <section id="locations" class="mardello_section locations py-5" <?php if (get_sub_field('background_color')) : ?>style="background-color: <?php echo get_sub_field('background_color');?>"<?php endif;?>>
        <div class="container">
            <?php if(get_sub_field('title')):?>
                <h1 class="locations__heading text-center mb-5"><?php echo get_sub_field('title');?></h1>
            <?php endif;?>
            <div class="row gy-5">
            <?php if( have_rows('content_repeater') ):?>
        <?php   while( have_rows('content_repeater') ) : the_row();?>
                <div class="col-sm-12 col-md-6">
                    <div class="locations__card">
                        <div class="locations__card__body p-4">
                            <?php if(get_sub_field('title')):?>
                                <h1 class="locations__card__body__heading mb-3"><?php echo get_sub_field('title');?></h1>
                            <?php endif;?>
                          
                            <div class="locations__card__body__paragraph">
                                <?php if(get_sub_field('sub_title')):?>
                                    <p><?php echo get_sub_field('sub_title');?></p>
                                <?php endif;?>
                            </div>
                            <div class="locations__card__body__list">
                                <div class="locations__card__body__list__item d-flex align-items-center"><img class="img-fluid me-3" src="/site/themes/main-theme/style/assets/img/location.svg">
                                    <div class="locations__card__body__list__item__paragraph">
                                    <?php if(get_sub_field('address_line')):?>
                                    <p><?php echo get_sub_field('address_line');?></p>
                                    <?php endif;?>
                                    </div>
                                </div>
                                <div class="locations__card__body__list__item d-flex align-items-center"><img class="img-fluid me-3" src="/site/themes/main-theme/style/assets/img/phone.svg">
                                <?php if(get_sub_field('phone')):?>
                                   
                                   <a class="locations__card__body__list__item__link" href="tel:<?php echo get_sub_field('phone');?>"><?php echo get_sub_field('phone');?></a>
                                    <?php endif;?>
                              
                            </div>
                                <div class="locations__card__body__list__item d-flex align-items-start"><img class="img-fluid me-3" src="/site/themes/main-theme/style/assets/img/apetura.svg">
                                    <div class="locations__card__body__list__item__paragraph">
                                    <?php if(get_sub_field('hours')):?>
                                   <?php echo get_sub_field('hours');?>
                                    <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <?php if(get_sub_field('link')):?>
                            <?php $link = get_sub_field('link');?>
                            <a class="btn locations__card__body__btn w-100 py-4 mt-4" target="<?php echo $link['target'];?>" href="<?php echo $link['url'];?>"><?php echo $link['title'];?></a>
                            <?php endif;?>

                        </div>
                        <div class="locations__card__map">
                            <div>
                                <div class="chile-no-m" style="width:100%;">
                                <?php if(get_sub_field('map_iframe')):?>
                                <?php echo get_sub_field('map_iframe');?>
                                <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile;?>
        <?php endif;?>
                
            </div>
        </div>
    </section>
    <style>.chile-no-m p {
        margin: 0 !important;
        padding: 0 !important;
    }
    .chile-no-m iframe {
        height: 100% !important;
        min-height: 260px;
    }
    </style>
    <?php endif;?>