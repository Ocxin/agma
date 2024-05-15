<?php
if ($args['post']) {
    $post = $args['post'];
}
$is_slider = $args['is_slider']; // Recupera lo stato del slider
$base_price = get_field('prezzo_base', $post->ID);

// Assicurati di accedere alle proprietà di $post come oggetti
$variants = [];
$title = get_the_title($post->ID);
$thumbnail_url = get_the_post_thumbnail_url($post->ID, 'medium_large');
$permalink = get_the_permalink($post->ID);
$rooms = get_field('camere', $post->ID);
$floors = get_field('livelli', $post->ID);
$size = get_field('mq', $post->ID);
$variants = get_field('variant', $post->ID);
$offer = get_field('offer', $post->ID);
$prompt_delivery = get_field('prompt_delivery', $post->ID);
// Utilizzo delle variabili nel markup
?>

<div class=" tile archive <?php echo $is_slider ? 'swiper-slide' : ''; ?>">
    <a href="<?php echo $permalink ?>">
        <div class="tilehead" data-bg="lazy" data-src="<?php echo esc_url($thumbnail_url); ?>" style="background-size:cover; background-repeat:no-repeat; background-position:center;">
            <?php if ($offer == true || $prompt_delivery == true) : ?>
                <div class="ribbon">
                    <?php if ($offer = true) : ?>
                        <p class="component button orange ">OFFERTA</p>
                    <?php endif; ?>
                    <?php if ($prompt_delivery = true) : ?>
                        <p class="component button primary">PRONTA CONSEGNA</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
        <div class="tiletitle">
            <h3><?php echo esc_html($title); ?></h3>
        </div>
        <div class="tilebody">
            <?php
            if (!empty($variants) && is_array($variants)) {
                echo "<p>" . esc_html($variants[0]['name']) . "<br>";
            } else {
                echo "<p>";
            }
            if ($rooms && $floors) {
                echo "$floors <span>piani</span><span class=\"separator\">|</span>$rooms <span>stanze</span></p>";
            }
            if ($base_price) {
                echo "<p class=\"price\">$base_price €</p>";
            }
            if (!empty($variants) && is_array($variants)) {
                echo "<p class=\"variant_number\">" . count($variants) . " Formati</p>";
            } else {
                echo "<p class=\"variant_number\">1 Formato</p>";
            }
            ?>

        </div>
    </a>
</div>