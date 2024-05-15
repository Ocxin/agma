<?php
if ($args['post']) {
    $post = $args['post'];
}
$is_slider = $args['is_slider']; // Recupera lo stato del slider
$base_price = get_field('prezzo_base', $post->ID);

// Assicurati di accedere alle proprietà di $post come oggetti
$title = get_the_title($post->ID);
$thumbnail_url = get_the_post_thumbnail_url($post->ID, 'medium_large');
$permalink = get_the_permalink($post->ID);
// Utilizzo delle variabili nel markup
?>

<div class="tile <?php echo $is_slider ? 'swiper-slide' : ''; ?>">
    <a href="<?php echo $permalink ?>">
        <div class="tilehead">
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
        </div>
        <div class="tiletitle">
            <h3><?php echo esc_html($title); ?></h3>
        </div>
        <div class="tilebody">
            <?php if ($base_price) : ?>
                <p class="price"><?php echo esc_html($base_price); ?> €</p>
            <?php endif; ?>
        </div>
    </a>
</div>
