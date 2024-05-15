<?php if (get_sub_field('visible')) : ?>

    <section id="text_banner" class="text_banner py-5 mardello_section " style="background-color: <?php echo get_sub_field('background_color');?>">
        <div class="container">
            <div class="text_banner__body">
                
                <?php if(get_sub_field('title')):?>
                <h1 class="text_banner__body__heading"><?php echo get_sub_field('title');?></h1>
                <?php endif;?>
                <div class="text_banner__body__paragraph mt-5">
                <?php if(get_sub_field('content')):?>
        <?php echo get_sub_field('content');?>
        <?php endif;?>
                </div>
            </div>
        </div>
    </section>
    <?php endif;?>