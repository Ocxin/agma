<section class="component slider-gallery-medium fullwidth">
    <div class="row">
        <div class="col-12">
            <h3 class="title text-center"> <?php the_sub_field('title'); ?> </h3>
            <div class="swiper-medium swiper">
                <div class="swiper-wrapper">

                    <?php
                    $slide = get_sub_field('slide');
                    foreach ($slide as $slide) {
                        $image = $slide['image'];
                        $text = $slide['text'];
                        $title = $slide['title'];
                        get_template_part('partials/tile/tile.feature', null, array('slide' => $slide));
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>

        </div>
    </div>
</section>