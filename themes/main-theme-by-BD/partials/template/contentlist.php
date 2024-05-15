<?php

use DeliciousBrains\WPMDB\Container\PhpOption\LazyOption;

$title = get_sub_field('title') ?: null;
$subtitle = get_sub_field('subtitle') ?: null;
$layout = get_sub_field('layout') ?: null;
$layout_tile = get_sub_field('layout_tile') ?: null;
$post_type = get_sub_field('post_type') ?: null;
$post_number = get_sub_field('post_number') ?: null;
$filter = get_sub_field('filter') ?: null;
$filter_for = get_sub_field('filter_for') ?: null;
$selected_term = get_sub_field('selected_term') ?: null;
$cta = get_sub_field('cta') ?: null;
$cta_position = get_sub_field('cta_position') ?: null;
$cta_text = get_sub_field('cta_text') ?: null;
$cta_link = get_sub_field('cta_link') ?: null;
$image = get_sub_field('image_url') ?: null;

$class = ($layout === 'swiper') ? 'swiper-container swiper' : 'default-container';
$is_slider = ($layout === 'swiper');

$term_slugs = $selected_term ? array_map(function ($term) {
    return $term->slug;
}, $selected_term) : [];


?>

<section class="component contentlist d-flex align-items-center <?php if ($layout !== 'swiper') {
                                                            echo $layout;
                                                        } ?>">
    <?php if ($layout === "left_image_grid") : ?>
        <div class="container h-100">
        <?php endif ?>

        <div class="container-fluid h-100">
            <div class="row h-100">
                <?php
                if ($layout === "left_image_grid") : ?>
                    <div class="col-5 d-none d-md-block">
                        <figure class="image">
                            <img src=<?php echo $image ?>>
                        </figure>
                    </div>
                    <div class="col-12 col-md-7 text-center <?php if ($is_slider) : echo "p-0";
                                                    endif ?> ">
                    <?php endif ?>


                    <div class="col-12 text-center <?php if ($is_slider) : echo "p-0";
                                                    endif ?> ">

                        <?php if (!empty($title)) : ?>
                            <h2 class="title"><?php echo esc_html($title); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($subtitle)) : ?>
                            <p class="subtitle"><?php echo esc_html($subtitle); ?></p>
                        <?php endif; ?>

                        <?php if ($filter) :
                            get_template_part('partials/component/filter', null, array('filter_for' => $filter_for, 'post_type' => $post_type, 'is_slider' => $is_slider, 'layout_tile' => $layout_tile, 'selected_term' => $selected_term));
                        endif;
                        ?>



                        <div class="content <?php echo esc_attr($class); ?>">
                            <?php
                            if ($cta && $cta_position === "before") : ?>
                                <a class="component button secondary" href="<?php echo $cta_link ?>"><?php echo $cta_text ?></a>
                            <?php endif; ?>
                            <?php if ($is_slider) : ?>
                                <div class="swiper-wrapper">
                                <?php endif; ?>

                                <?php
                                $args = array(
                                    'post_type' => $post_type,
                                    'posts_per_page' => $post_number,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => $filter_for,
                                            'field' => 'slug',
                                            'terms' => $term_slugs,
                                            'status' => 'published'
                                        )
                                    )
                                );

                                $query = new WP_Query($args);
                                if ($query->have_posts()) :
                                    while ($query->have_posts()) : $query->the_post();
                                        get_template_part('partials/tile/' . "$layout_tile", null, array('is_slider' => $is_slider));
                                    endwhile;
                                endif;
                                wp_reset_postdata();
                                wp_reset_query();
                                ?>

                                <?php if ($is_slider) : ?>
                                </div>
                                <div class="swiper-pagination">
                                </div>
                            <?php endif; ?>
                            <?php
                            if ($cta && $cta_position === "after") : ?>
                                <a class="component button secondary" href="<?php echo $cta_link ?>"><?php echo $cta_text ?></a>
                            <?php endif; ?>

                        </div>
                    </div>
                    </div>
            </div>
</section>