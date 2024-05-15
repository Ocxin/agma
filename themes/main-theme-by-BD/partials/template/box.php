<?php
$title=get_sub_field('title') ?: null;
$text=get_sub_field('text') ?: null;
$image=get_sub_field('image') ?: null;
$layout=get_sub_field('layout') ?: null;
if ($layout === 'null') {
    $layout = '';
}
?>
<div class="component box col-10 offset-1">
    <?php include ('item.php'); 
    
    ?>
</div>

