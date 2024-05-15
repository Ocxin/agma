<?php
$args = get_field('come_funziona', 'option');
$boxes = $args['boxes'] ?? [];
$title = $args['title'] ?? 'Lorem Ipsum Dolor Sit Amet';
$subtitle = $args['subtitle'] ?? 'Consectetur Adipiscing Elit';
$cta_text = $args['cta_text'] ?? 'Lorem Ipsum';
$cta_url = $args['cta_url'] ?? '#';
?>
<section id="how-work" class="how-work d-flex align-item-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title text-center"><?php echo esc_html($title); ?></h2>
                <p class="subtitle text-center"><?php echo esc_html($subtitle); ?></p>
                <a class="component button secondary" href="<?php echo $cta_url ?>"><?php echo $cta_text ?></a>
            </div>
            <?php if ($boxes) : ?>
                <?php foreach ($boxes as $box) : ?>
                    <div class="col-10 offset-1 col-md-4 offset-md-0 text-center box">
                        <img src="<?php echo $box['image'] ?>" alt="Come funziona">
                        <h3><?php echo esc_html($box['title']); ?></h3>
                        <p><?php echo esc_html($box['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>