<?php if (get_sub_field('visible')) : ?>

    <section id="blog_banner" class="blog_banner py-5 my-5" style="background-color: <?php echo get_sub_field('background_color');?>;
    <?php if (get_sub_field('padding') != 0):?>
    padding-top:<?php echo get_sub_field('padding')?>rem !important;
    padding-bottom:<?php echo get_sub_field('padding');?>rem !important;
    <?php endif;?>
    ">
        <div class="container">
            <?php if(get_sub_field('title')):?>
            <div class="row"> 
                <div class="col mb-5">
                <h1 class="text_with_image__text__heading mb-4"><?php echo get_sub_field('title');?></h1>
                </div>
            </div>        
            <?php endif;?>
            <div class="row g-5">
           <?php 
   
   //$current_post_category = get_the_category();
            $args = array(
                'posts_per_page' => get_sub_field('number_of_posts'),               // Number of posts to retrieve
                'post_status' => 'publish',           // Post status (change as needed)
                'orderby' => 'date',                  // Order posts by date
                'order' => 'DESC',                     // Sort in descending order
                //'category__in' => wp_get_post_categories($current_post_id),
                
            );
            $current_post_id = @get_the_ID();
            if ($current_post_id) {
                $args['post__not_in'] =  array($current_post_id);
            }
            $the_query = new WP_Query($args);
            ?>
                <?php if ( $the_query->have_posts() ) : ?>
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                    $title = get_the_title();
                    $date = get_the_date();
                    $short = get_the_excerpt();
                    $categories = get_the_category();
                    $link = get_permalink();                   
                     $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
                    ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="blog_banner__card">
                        <div class="blog_banner__card__img mb-4"><img class="img-fluid w-100" src="<?php echo $image[0];?>"></div>
                        <div class="blog_banner__card__body">
                            <div class="blog_banner__card__body__date py-2 px-4 w-25">
                                <p><?php echo $date;?></p>
                            </div>
                            <h1 class="blog_banner__card__body__heading mt-3 mb-3">
                                <a href="<?php echo $link?>">
                            <?php echo $title;?></a>
                            </h1>
                            <div class="blog_banner__card__body__paragraph">
                                <p><?php echo $short;?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile;
                endif;
                wp_reset_postdata(); ?>
                
            </div>
        </div>
    </section>
    <?php endif;?>