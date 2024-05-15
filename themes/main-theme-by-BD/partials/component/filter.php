<?php
$filter_for = $args['filter_for'];
$post_type = $args['post_type'];
$is_slider = $args['is_slider'];
$layout_tile = $args['layout_tile'];
$selected_term = $args['selected_term'];  // Assumendo che questo sia un array di ID di termini
?>

<div class="component filters" data-post-type="<?= esc_attr($post_type); ?>" data-filter-for="<?= esc_attr($filter_for); ?>" data-is-slider="<?= esc_attr($is_slider); ?>" data-layout-tile="<?= esc_attr($layout_tile); ?>">
    <?php foreach ($selected_term as $term) :
        $icon = get_field('icon_category', $term);
    ?>
        <button class="filter-btn" data-filter="<?= esc_attr($term->slug) ?>" data-term-id="<?= esc_attr($term->term_id); ?>">
            <?= esc_html($term->name) ?>
            <?php if ($icon) : ?>
                <img src="<?= esc_url($icon) ?>" alt="<?= esc_attr($term->name) ?> Icon" />
            <?php endif; ?>
        </button>
    <?php endforeach; ?>
</div>