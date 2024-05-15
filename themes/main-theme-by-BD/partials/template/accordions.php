<?php
$accordions = get_sub_field('accordion');
$accordion_id = uniqid('accordion_'); 
?>
<div class="component accordion col-12 offset-0 col-md-8 offset-md-2" id="<?php echo $accordion_id ?>">
    <?php
    $index = 0; 
    foreach ($accordions as $accordion) {
        $title = $accordion['title'];
        $text = $accordion['text'];
        $item_id = $accordion_id . '_item_' . $index;
        ?>
        <div class="accordion-item">
            <h3 class="accordion-header" id="heading<?php echo $index ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index ?>" aria-expanded="false" aria-controls="collapse<?php echo $index ?>">
                    <?php echo $title ?>
                </button>
            </h3>
            <div id="collapse<?php echo $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $index ?>" data-bs-parent="#<?php echo $accordion_id ?>">
                <div class="accordion-body">
                    <p><?php echo $text ?></p>
                </div>
            </div>
        </div>
        <?php
        $index++; // Incrementa l'indice per il prossimo item
    }
    ?>
</div>
