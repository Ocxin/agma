<!-- Main Slider for large images -->
<?php 
$gallery = get_field('gallery');
?>
<div class="swiper-product main-slider swiper">
    <div class="swiper-wrapper">
        <?php 
        if ($gallery) : ?>
            <?php foreach ($gallery as $item) : ?>
                <?php $image_id = $item['id']; // Assuming 'image' is the correct sub field key ?>
                <?php if ($image_id) : ?>
                    <?php
                    $src = wp_get_attachment_image_src($image_id, 'large');
                    $img = $src[0]; ?>
                    <div class="swiper-slide">
                        <img src="<?php echo $img; ?>" class="img-fluid" loading="lazy">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Thumb Slider for smaller thumbnails -->
<div class="swiper-product thumb-slider swiper">
    <div class="swiper-wrapper">
        <?php if ($gallery) : ?>
            <?php foreach ($gallery as $item) : ?>
                <?php $image_id = $item['id']; // Assuming 'image' is the correct sub field key ?>
                <?php if ($image_id) : ?>
                    <?php
                    $src = wp_get_attachment_image_src($image_id, 'thumbnail');
                    $img = $src[0]; ?>
                    <div class="swiper-slide">
                        <img src="<?php echo $img; ?>" class="img-fluid" loading="lazy">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
