<?php
$roundeds = get_sub_field('rounded');

?>
<div class="component rounded col-10 offset-1">
    <?php foreach ($roundeds as $rounded) { ?>
        <div class="rounded">
            <div class="rounded-image">
                <img class="cover" loading="lazy" src="<?php echo $rounded['image']['url']; ?>" alt="<?php echo $rounded['image']['alt']; ?>">
            </div>
            <h3><?php echo $rounded['title']; ?></h3>
            <p><?php echo $rounded['text']; ?></p>
        </div>
    <?php } ?>
</div>