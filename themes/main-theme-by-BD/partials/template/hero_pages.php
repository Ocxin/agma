<?php
if (is_singular()) {
    $post_id = get_the_ID();
    $img_url = get_the_post_thumbnail_url($post_id, 'full');  // Ottiene l'URL dell'immagine in primo piano
    $lazy_attribute = "data-bg='lazy' data-src='$img_url'";  // Attributo per il lazy loading
    $title = get_the_title($post_id);
} elseif (is_tax()) {
    $term = get_queried_object();
    $image = get_field('image', $term);  // Ottiene l'URL dell'immagine in primo piano
    $img_url = $image['url'];
    $lazy_attribute = "data-bg='lazy' data-src='$img_url'";  // Attributo per il lazy loading
    $title = $term->name;
    $description = $term->description;
} else {
    $img_url = get_field('immagine', 'option');  // Ottiene l'URL dell'immagine in primo piano
    $lazy_attribute = "data-bg='lazy' data-src='$img_url'";  // Attributo per il lazy loading
    $title = get_field('titolo', 'option');
}

?>
<section id="hero" class="hero hero-bg py-5 d-flex align-items-end" <?php echo $lazy_attribute ?>>
    <div class="container h-100">
        <div class="d-flex flex-column <?php if (is_singular()) {
                                            echo 'justify-content-end';
                                        } ?> hero__body h-100">
            <h1 class="hero__body__heading"> <?php echo $title; ?></h1>
            <?php if (is_tax()) : ?>
                <p class="hero__body__content"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>