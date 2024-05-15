<?php
$text = get_sub_field('text');
$image = get_sub_field('immagine');
$author = get_sub_field('autor'); ?>

<section class="component media-cit fullwidth">
    <div class="row">
        <div class="col-12 col-md-6 content">
            <p class="text">
                <?php echo $text; ?>
            </p>
            <p class="author">
                <?php echo $author; ?>
            </p>

        </div>
        <?php
        $url = $image['url'];
        $alt = $image['alt'];
        $caption = $image['caption'];

        echo "<figure class='media d-none d-md-block col-6 p-0'>";
        echo "<img class='cover' src='" . esc_url($url) . "' alt='" . esc_attr($alt) . "' width='" . $image['width'] . "' height='" . $image['height'] . "'>";
        if (!empty($caption)) {
            echo "<figcaption>" . esc_html($caption) . "</figcaption>";
        }
        echo "</figure>";

        ?>
    </div>
</section>