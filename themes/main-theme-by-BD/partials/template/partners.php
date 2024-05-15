<?php
$title = get_sub_field('title');
$partners = get_sub_field('partners');
?>
<section id="partners" class="partners d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title text-center"><?php echo esc_html($title); ?></h2>
            </div>
            <?php if (!empty($partners)) : ?>
                <?php foreach ($partners as $partner) : ?>
                    <div class="col-6 col-md-3 mb-3 d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name'] ?? 'Partner Logo'); ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>