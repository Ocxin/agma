<?php
$title = get_sub_field('title');
$subtitle = get_sub_field('subtitle');
$cta_url = get_sub_field('cta_url');
$cta_text = get_sub_field('cta_text');
$images = get_sub_field('images');
?>
<section id="slider-big" class="slider-big d-flex align-items-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="title text-center"><?php echo esc_html($title); ?></h2>
                <p class="subtitle text-center"><?php echo esc_html($subtitle); ?></p>
                <a class="component button secondary" href="<?php echo esc_url($cta_url); ?>"><?php echo esc_html($cta_text); ?></a>
            </div>
            <?php if ($images): ?>
                <!-- Inizializza Swiper -->
                <div class="swiper-container swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $image): ?>
                            <div class="swiper-slide">
                                <?php if ($image['video'] != false): ?>
                                    <video loop muted autoplay>
                                        <source src="<?php echo esc_url($image['video']); ?>"  type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php else: 
                                    $image_url = wp_get_attachment_image_src($image['image'], 'large')
                                    ?>
                                    <img src="<?php echo $image_url[0]; ?>" alt="">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Se necessario, aggiungi controlli di navigazione -->
                    <div class="swiper-pagination"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
