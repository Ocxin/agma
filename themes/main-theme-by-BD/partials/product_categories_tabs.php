<section id="home_product_tabs" class="mardello_section home_product_tabs py-5">
        <div class="container"><div class="d-flex justify-content-center flex-wrap">
            <?php $rand = rand(1,200);?>
    <ul class="nav nav-tabs" role="tablist">
    <?php if( have_rows('content_repeater') ):?>
        <?php $a = 1;  while( have_rows('content_repeater') ) : the_row();?>
        <?php    $term_slug = get_sub_field('slug');
            $term = get_term_by('slug', $term_slug, 'case-categories');
        ?>
        <li class="nav-item me-4" role="presentation"><a class="nav-link <?php if ($a == 1 ) :?>active<?php endif;?>" role="tab" data-bs-toggle="tab" href="#tab-<?php echo $rand;?><?php echo $a;?>"><?php echo $term->name;?></a></li>
        <?php $a++; endwhile;?>
        <?php endif;?>
    </ul>
    <div class="tab-content w-100">
    <?php if( have_rows('content_repeater') ):?>
        <?php $x = 1;  while( have_rows('content_repeater') ) : the_row();?>
            <?php 
                $term_slug = get_sub_field('slug');
                $the_query = new WP_Query( array(
                        'posts_per_page' => 6,              
                        'post_status' => 'publish',           
                        'orderby' => 'date',                 
                        'post_type'   => 'casetta',
                        'order' => 'DESC',               
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'case-categories',
                                'field' => 'slug',
                                'terms' => $term_slug,
                            ),
                        )
                    )); 
                $term = get_term_by('slug', $term_slug, 'case-categories');  ?>

                    <?php if ( $the_query->have_posts() ) : ?>
                        <div id="tab-<?php echo $rand;?><?php echo $x;?>" class="tab-pane <?php if ($x == 1 ) :?>active<?php endif;?>" role="tabpanel">
                            <div class="text-center home_product_tabs__paragraph mt-5">
                                <p><?php echo $term->description;?></p>
                            </div>
                            <div class="home_product_tabs__slider-wrapper">
                                <div class="row gx-5 slick-row mt-5">
                                

                                
                                    <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                                    $title = get_the_title();
                                    $date = get_the_date();
                                    $short = get_the_excerpt();
                                    $categories = get_the_category();
                                    $link = get_permalink();                   
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
                                    ?>
                                    <div class="col-sm-12 col-md-6 col-lg-4 slick-col">
                                           <div class="products__card" style="display: flex;flex-direction: column;justify-content: space-between;">
                    <div class="products__card__img"  >  <a href="<?php echo $link;?>" class="products__card__body__link"><img class="img-fluid w-100" src="<?php echo $image[0];?>" />
                    </a>
                    </div>
                    <div class="products__card__body p-4"  >
                        <div class="products__card__body__paragraph">
                            <p><?php echo get_field('delivery_info') ?></p>
                        </div>
                        <a href="<?php echo $link;?>" class="products__card__body__link">
                        <h2 class="products__card__body__heading py-3"><?php echo $title;?></h2>
                        </a>
                        <div class="d-flex products__card__body__info py-3">
                            <div class="products__card__body__items">
                            <?php if(get_field('mq')):?>
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="/site/themes/main-theme/style/assets/img/square.svg" />
                                    <p><?php echo get_field('mq');?> mq</p>
                                </div>
                                <?php endif;?>

                                <?php if(get_field('camere')):?>
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="/site/themes/main-theme/style/assets/img/beds.svg" />
                                    <p><?php echo get_field('camere');?> Camere</p>
                                </div>
                                <?php endif;?>
                            </div>
                            <div class="products__card__body__items">
                            <?php if (get_field('livelli')):?>
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="/site/themes/main-theme/style/assets/img/layer.svg" />
                                    <p><?php echo get_field('livelli');?> livelli</p>
                                </div>
                                <?php endif;?>
                                <?php if (get_field('bagno')):?>
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="/site/themes/main-theme/style/assets/img/bath.svg" />
                                <p><?php echo get_field('bagno');?> bagno</p>
                                </div>
                                <?php endif;?>

                            </div>
                        </div>
                        <div class="text-center mt-5"><a class="btn btn-primary products__card__body__btn py-4 w-100" role="button" href="<?php echo $link;?>"><?php echo number_format(get_field('prezzo_base'),2,',','.');?> €</a></div>
                    </div>
                                    </div>
                                    </div>
                                    <?php endwhile;
                                    wp_reset_postdata(); ?>




                                </div>
                            </div>
                            <div class="justify-content-evenly custom-arrows"><button class="custom-prev"></button><button class="custom-next"></button></div>
                            <?php if(get_sub_field('link')):?>
                            <?php $link = get_sub_field('link');?>
            
                            <div class="text-center mt-5"><a class="btn btn-primary home_product_tabs__btn py-4 px-5" href="<?php echo $link['url'];?>"> <?php echo $link['title'];?></a></div>
                            <?php endif;?>

                        </div>
                        <?php endif;?>

        <?php $x++; endwhile;?>
        <?php endif;?>
        
    </div>
</div>
</div>
    </section>