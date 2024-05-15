<?php
$new_args = get_field('su_misura_per_te', 'option');

if (is_array($new_args)) {
    foreach ($new_args as $key => $value) {
        if (!array_key_exists($key, $args)) {
            $args[$key] = $value;
        }
    }
}


$title = $args['title'] ?? 'Lorem Ipsum Dolor Sit Amet';
$subtitle = $args['subtitle'] ?? 'Consectetur Adipiscing Elit';
$cta_text = $args['cta_text'] ?? 'Lorem Ipsum';
$cta_url = $args['cta_url'] ?? '#';
$term = $args['term'] ?? '';

if ($term === 'case-in-legno-a-telaio') {?>
<section id="su-misura-per-te" class="su-misura-per-te d-flex align-item-center">
<?php echo file_get_contents(get_stylesheet_directory() . "/dist/images/background.svg"); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title text-center"><?php echo esc_html($title); ?></h2>
                <p class="subtitle text-center"><?php echo esc_html($subtitle); ?></p>
                <a class="component button white" href="<?php echo $cta_url ?>"><?php echo $cta_text ?></a>
            </div>
            <?php if ($boxes) : ?>
                <?php foreach ($boxes as $box) : ?>
                    <div class="col-4 text-center box">
                        <img src="<?php echo $box['image'] ?>" alt="Come funziona">
                        <h3><?php echo esc_html($box['title']); ?></h3>
                        <p><?php echo esc_html($box['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php } 