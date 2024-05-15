<?php
$base_price_value_raw = $args['base_price_value_row'];
$terms = get_the_terms(get_the_ID(), 'case-categories');
$variant = $args['variant'];

function get_formatted_terms($terms, $property)
{
    if ($terms && !is_wp_error($terms)) {
        return implode(', ', array_map(function ($term) use ($property) {
            return $term->$property;
        }, $terms));
    }
    return '';
}

$term_slugs = get_formatted_terms($terms, 'slug');
$term_names = get_formatted_terms($terms, 'name');
?>

<div class="component product-feature">
    <a href="/case-categories/<?php echo $term_slugs; ?>" class="product-term"><?= esc_html($term_names); ?></a>
    <h1 class="product-title">
        <?= esc_html(get_the_title()); ?>
    </h1>
    <p id="selected_variant"><?php echo $variant ?></p>

    <?php if (get_field('brief_description')) : ?>
        <p class="product-description">
            <?= esc_html(get_field('brief_description')); ?>
        </p>
    <?php endif; ?>
    <div class="feature">
        <?php if (get_field('mq')) : ?>
            <div class="d-flex align-items-center">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/style/assets/img/square.svg">
                <p><span><?php echo get_field('mq'); ?></span> mq</p>
            </div>
        <?php endif; ?>
        <?php if (get_field('livelli')) : ?>
            <div class="d-flex align-items-center">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/style/assets/img/layer.svg">
                <p><span><?php echo get_field('livelli'); ?></span> <?php echo get_field('livelli') > 1 ? 'livelli' : 'livello'; ?></p>
            </div>
        <?php endif; ?>

        <?php if (get_field('camere')) : ?>
            <div class="d-flex align-items-center">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/style/assets/img/beds.svg">
                <p><span><?php echo get_field('camere'); ?></span> <?php echo get_field('camere') > 1 ? 'camere' : 'camera'; ?></p>
            </div>
        <?php endif; ?>

        <?php if (get_field('infissi')) : ?>
            <div class="d-flex align-items-center">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/style/assets/img/infissi.svg">
                <p><span><?php echo get_field('infissi'); ?></span> <?php echo get_field('infissi') > 1 ? 'infissi' : 'infisso'; ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php if (get_field('prezzo_base')) : ?>
        <div class="price">
            <?php if (get_field('prezzo_scontato')) : ?>
                <p><del class="span_discounted" id="original-price"><?php echo number_format(get_field('prezzo_base'), 2, '.', ''); ?> €</del></p>
                <p class="current-price" data-type="price"><?php echo number_format(get_field('prezzo_scontato'), 2, '.', ''); ?> €</p>
            <?php else : ?>
                <p class="current-price" id="original-price" data-type="price"><?php echo number_format(get_field('prezzo_base'), 2, '.', ''); ?> €</p>
            <?php endif; ?>
            <input type="hidden" id="base_price" name="base_price" value="<?php echo $base_price_value_raw; ?>" />
        </div>
    <?php endif; ?>
    <?php if (get_field('variant')) : ?>
        <div class="selector">
            <label for="varianti" class="form-label">Spessore delle pareti</label>
            <select class="form-select" id="varianti" name="varianti">
                <?php foreach (get_field('variant') as $variant) : ?>
                    <option value="<?php echo $variant['price']; ?>"><?php echo $variant['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>
    <p class="delivery-info">Tempi di consegna <span><?php echo get_field('delivery_info') ?></span></p>
    <?php if (get_field('rates_payment')) : ?>
        <!-- <div class="d-flex align-items-baseline view-product__container__content__item">
            <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/style/assets/img/coin.svg">
            <div class="view-product__container__content__item__paragraph ms-3">
                <p>Calcola rata Findomestic</p>
            </div>
        </div> -->
    <?php endif; ?>
    <div class="view-product__container__footer">
        <button class="component button secondary mb-4 py-4 w-100" type="button" data-bs-toggle="modal" data-bs-target="#orderModal">
            RICHIEDI PREVENTIVO
        </button>
    </div>
</div>