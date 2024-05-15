<?php
$icon_texts = get_sub_field('icon_texts');
?>
<div class="component icon_text col-9 offset-3 col-md-8 offset-md-2">
    <?php foreach ($icon_texts as $icon_text) { ?>
        <div class="icon_text">
            <div class="icon-image">
                <img loading="lazy" src="<?php echo $icon_text['image']['url']; ?>" alt="<?php echo $icon_text['image']['alt']; ?>">
            </div>
            <h3><?php echo $icon_text['title']; ?></h3>
            <p><?php echo $icon_text['text']; ?></p>
        </div>
    <?php } ?>
</div>