    <?php
   
     ?>
    <section id="category_header" class="category_header py-5 px-4" style="background-color: <?php echo get_sub_field('background_color');?>">
        <div class="container">
            <div class="row gy-5">
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <?php if (get_sub_field('use_category_defaults')):?>
                    <h1 class="category_header__heading"><?php echo single_cat_title();?></h1>
                    <?php else:?>
                        <?php if(get_sub_field('title')):?>
                        
                        <h1 class="category_header__heading"><?php echo get_sub_field('title');?></h1>
                        <?php endif;?>
                    
                    <?php endif;?>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-9">
                    <div class="category_header__paragraph">
                    <?php if (get_sub_field('use_category_defaults')):?>
                        <p><?php the_archive_description();?></p>
                        <?php else:?>
                            <?php if(get_sub_field('description')):?>
                        
                   <?php echo get_sub_field('description');?>
                        <?php endif;?>
                    
                    <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
<?php if (get_sub_field('visible')) : ?>
    </section>
    <?php endif;?>
