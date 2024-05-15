<?php if (get_sub_field('visibile')) : ?>

    <?php
    $bg_style = '';
    $content = '';
    $class = '';

    // Gestione del video come sfondo
    if (!empty(get_sub_field('video_hero'))) {
        $video_src = wp_get_attachment_image_src(get_sub_field('video_hero'), 'full')[0];
        $content = "<video autoplay muted loop playsinline>
            <source src=\"$video_src\" type=\"video/mp4\">
        </video>";
        $class = 'hero--video';
    }
    // Gestione dell'immagine come sfondo
    elseif (!empty(get_sub_field('hero_image'))) {
        $image = get_sub_field('hero_image');  // Assicurati che 'hero_image' sia configurato per restituire un ID.
        $image_attributes = wp_get_attachment_image_src($image, 'full');  // 'full' per la dimensione più grande disponibile.
    
        if ($image_attributes) {
            $img_url = $image_attributes[0];  // URL dell'immagine
            $bg_style = "background-size: cover; background-position: center;";
            $lazy_attribute = "data-bg='lazy' data-src='$img_url'";  // Attributo per il lazy loading
        }
    }
    
    // Gestione della gallery come swiper
    elseif (!empty(get_sub_field('hero_gallery'))) {
        $gallery_images = get_sub_field('hero_gallery');
        $swiper_slides = '';
        foreach ($gallery_images as $image) {
            $img_src = wp_get_attachment_image_src($image, 'full')[0];
            $swiper_slides .= "<div class='swiper-slide' style='background-image: url($img_src); background-size: cover; background-position: center;'></div>";
        }
        $content = "<div class=\"swiper-container\">
        <div class=\"swiper-wrapper\">
            $swiper_slides
        </div>
        <!-- Add Pagination -->
        <div class=\"swiper-pagination\"></div>
        <!-- Add Navigation -->
        <div class=\"swiper-button-prev\"></div>
        <div class=\"swiper-button-next\"></div>
    </div>";
    }
    ?>

    <section id="hero" class="hero hero-bg py-5 d-flex align-items-end <?php echo $class ?>" style="filter: unset;<?php echo $bg_style ?>;" <?php echo $lazy_attribute?>>
        <div class="container h-100">
            <div class="d-flex flex-column justify-content-end hero__body h-100">
                <?php echo $content; ?>
                <div class="hero__body__paragraph">
                    <?php if (get_sub_field('pre_title')) : ?>
                        <?php echo get_sub_field('pre_title'); ?>
                    <?php endif; ?>
                </div>
                <?php if (get_sub_field('title')) : ?>
                    <h1 class="hero__body__heading"> <?php echo get_sub_field('title'); ?></h1>
                <?php endif; ?>
                <?php if (get_sub_field('cta')) :
                    echo get_sub_field('cta');
                endif;
                ?>
            </div>
        </div>
    </section>


    <!-- <section id="hero-phone" class="hero--sm h-auto" style="background-color:<?php echo get_sub_field('background_color'); ?>">
        <?php $img_mobile = null; ?>
        <?php if (get_sub_field('image_mobile')) : ?>
            <?php
            $src_mobile = null;
            $src_mobile = wp_get_attachment_image_src(get_sub_field('image_mobile'), 'full');
            $img_mobile = $src_mobile[0]; ?>

        <?php endif; ?>
        <div class="d-flex flex-column justify-content-end hero__body h-100 px-5" style="filter: unset;min-height: 30vh;background: linear-gradient(0deg, rgba(<?php echo $rgba; ?>, <?php echo $alpha; ?>), rgba(<?php echo $rgba; ?>, <?php echo $alpha; ?>)), url(<?php echo $img_mobile; ?>);background-repeat:no-repeat;background-size:cover;background-position:center;background-color:<?php echo get_sub_field('background_color'); ?>;">
            <div class="hero__body__path d-none">
                <p>home /&nbsp;</p>
            </div>
            <?php if (get_sub_field('title')) : ?>
                <h1 class="hero__body__heading"> <?php echo get_sub_field('title'); ?></h1>
            <?php endif; ?>
        </div>
        <?php if (get_sub_field('content')) : ?>
            <div class="hero__body--2 p-5" <?php if (get_sub_field('image_mobile')) : ?> style="background-color: #286365;" <?php else : ?> style="background-color: <?php echo get_sub_field('background_color'); ?>;" <?php endif; ?>>
                <div class="hero__body__paragraph">
                    <?php if (get_sub_field('content')) : ?>
                        <?php echo get_sub_field('content'); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </section> -->
<?php endif; ?>
