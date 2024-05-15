<?php
$slide= $args['slide'];
$image = $slide['image'];
$text = $slide['text'];
$title = $slide['title'];    ?>

<div class="tile swiper-slide">
    <div class="tilehead">
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
    </div>
    <div class="tilebody">
        <h3><?php 
        echo $title; ?></h3>
        <p><?php echo $text; ?></p>
    </div>
</div>