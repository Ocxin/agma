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
$rooms = get_field('camere', $post->ID);
$floors = get_field('livelli', $post->ID);
$size = get_field('mq', $post->ID);
// Utilizzo delle variabili nel markup
?>

<div class=" tile specific <?php echo $is_slider ? 'swiper-slide' : ''; ?>">
    <a href="<?php echo $permalink ?>">
    <div class="tilehead" data-bg="lazy" data-src="<?php echo esc_url($thumbnail_url); ?>" style="background-size:cover; background-repeat:no-repeat; background-position:center;"></div>
        <div class="tiletitle">
            <h3><?php echo esc_html($title); ?></h3>
        </div>
        <div class="tilebody">

            <?php
            if ($size) {
                echo "<p>$size <span>mq</span><br>";
            }
            if ($rooms && $floors) {
                echo "$floors <span>piani</span><span class=\"separator\">|</span>$rooms <span>stanze</span></p>";
            }
            if ($base_price) {
                echo "<p class=\"price\">$base_price €</p>";
            }
            ?>

        </div>
    </a>
</div>