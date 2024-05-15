<?php
// Recupera tutti i campi necessari
$title = get_sub_field('title');
$image = get_sub_field('image');
$pins = get_sub_field('pin');
$image_attributes = "data-bg='lazy' data-src='$image'";
$feature = get_sub_field('feature');
$features = [
    ['title' => get_sub_field('title_feature_1'), 'text' => get_sub_field('txt_feature_1')],
    ['title' => get_sub_field('title_feature_2'), 'text' => get_sub_field('txt_feature_2')],
    ['title' => get_sub_field('title_feature_3'), 'text' => get_sub_field('txt_feature_3')],
    ['title' => get_sub_field('title_feature_4'), 'text' => get_sub_field('txt_feature_4')]
];

// CSS e classe opzionali
?>

<section id="image-with-pin" class="image-with-pin d-none d-md-flex align-items-end p-0" style="" <?php echo $image_attributes ?>>
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-12">
                <h2 class="title"><?php echo esc_html($title); ?></h2>
                <!-- Loop per i pin -->
                <?php if ($pins) : ?>
                    <?php foreach ($pins as $pin) :
                        $image = wp_get_attachment_image_src($pin['pin_image']);
                    ?>
                        <div class="pin" style="position: absolute; top: <?php echo $pin['pin_y'] ?>%; left: <?php echo $pin['pin_x'] ?>%">
                            <div class="pop-up">
                                <div class="pin-popup" style="display: none;">
                                    <img loading="lazy" src="<?php echo esc_url($image[0]);
                                                                ?>" alt="Pin">
                                    <h4><?php echo esc_html($pin['pin_title']); ?></h4>
                                    <p><?php echo esc_html($pin['pin_txt']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- Riga per le caratteristiche -->

    </div>
</section>
<?php if ($feature != false) : ?>
    <section id="feature-text" class="feature-text d-flex align-item-center">
        <div class="container">
            <div class="row">
                <?php foreach ($features as $feature) : ?>
                    <div class="col-3 d-flex align-items-center flex-column flex-md-row">
                        <h5><?php echo esc_html($feature['title']); ?></h5>
                        <p><?php echo esc_html($feature['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>