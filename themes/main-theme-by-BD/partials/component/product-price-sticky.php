<?php
$cleanedPrice = str_replace(['€', ','], '', $args['base_price']); // Rimuovi il simbolo dell'euro e la virgola
$cleanedPrice = floatval($cleanedPrice); // Converti la stringa pulita in un float
$variant = $args['variant'];
?>

<div class="component product-price-sticky view-product__container__purchase">
    <div class="d-flex justify-content-between view-product__container__purchase__price">
        <div class="view-product__container__purchase__price__paragraph">
            <p><?php echo get_the_title(); ?></p>
            <p id="selected_variant_sticky"><?php echo $variant ?></p>
        </div>
        <div class="view-product__container__purchase__price__paragraph d-flex">
            <button class="component button orange" id="subtotal" data-type="price" data-bs-toggle="collapse" data-bs-target="#addons">
                <?php echo number_format($cleanedPrice, 2, ',', '.') . ' €'; ?></button>
            <button class="component button secondary" type="button" data-bs-toggle="modal" data-bs-target="#orderModal">
                Richiedi preventivo
            </button>
        </div>
    </div>
    <div id="addons" class="collapse">
        <div class="d-flex align-items-center view-product__container__warning mt-4 ms-3"><img class="img-fluid" src="<?php echo (get_stylesheet_directory_uri()."/style/assets/img/info.svg")?>">
            <div class="view-product__container__warning__paragraph ms-3">
                <p>Attenzione: il costo del trasporto verrà quantificato richiedendo il preventivo</p>
            </div>
        </div>
    </div>

</div>