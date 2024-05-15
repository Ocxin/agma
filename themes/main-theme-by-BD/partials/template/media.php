<div class="media-container col-12 offset-0 col-md-10 offset-md-1">
    <?php
    $video = get_sub_field('video');
    $image = get_sub_field('image'); // Questo sarà ora un array come hai descritto

    if (!empty($video)) {
        echo $video;
    } elseif (!empty($image)) {
        $url = $image['url'];
        $alt = $image['alt'];
        $caption = $image['caption'];

        echo "<figure class='media'>";
        echo "<img class='img-fluid' src='" . esc_url($url) . "' alt='" . esc_attr($alt) . "' width='" . $image['width'] . "' height='" . $image['height'] . "'>";
        if (!empty($caption)) {
            echo "<figcaption>" . esc_html($caption) . "</figcaption>";
        }
        echo "</figure>";
    } else {
        echo '<p>Nessun contenuto disponibile.</p>';
    }
    ?>
</div>
