<?php
get_header();
$post_id = get_the_ID();
$image = get_the_post_thumbnail_url(get_the_ID(), 'full');
$title = get_the_title();
$base_price = number_format(get_field('prezzo_base'), 2, '.');
$base_price_value_raw = get_field('prezzo_base');
$variant = get_field('variant');
$taxonomy = 'case-categories';
$terms = get_the_terms($post_id, $taxonomy);
$term = $terms[0]->slug;

if (get_field('prezzo_scontato')) {
    $base_price = number_format(get_field('prezzo_scontato'), 2, '.');
    $base_price_value_raw = get_field('prezzo_scontato');
}
?>
<section id="view-product" class="view-product container">
    <div class="row g-5">
        <div class="col-md-12 col-lg-7 col-xl-7">
            <?php get_template_part('partials/component/product-gallery'); ?>
        </div>
        <div class="col-md-12 col-lg-5 col-xl-5">
            <?php get_template_part('partials/component/product-feature', '', ['base_price_value_row' => $base_price_value_raw, 'variant' => $variant[0]['name']]); ?>
        </div>
    </div>
</section>
<?php
if ($term != 'case-in-legno-a-telaio') {
    get_template_part('partials/component/product-customization');
} else {
    if (have_rows('main')) :
        while (have_rows('main')) : the_row();
            get_template_part('partials/template/' . get_row_layout(), '');
        endwhile;
    endif;
}
?>
<?php get_template_part('partials/component/product-price-sticky', '', ['base_price' => $base_price, 'variant' => $variant[0]['name']]); ?>


</section>
<!-- <section id="contact-us" class="contact-us py-5" style="background-color: #D4E0E0;">
    <div class="container">
        <div class="row gy-5">
            <div class="col-md-12 col-lg-6">
                <div class="d-flex justify-content-between align-items-baseline flex-wrap contact-us__body p-5">
                    <div class="contact-us__body__img me-5"><img class="img-fluid" src="/site/themes/main-theme/style/assets/img/phone-Icons.svg"></div>
                    <div class="me-auto contact-us__body__content">
                        <h1 class="contact-us__body__content__heading mb-4">Chiama ora per ordinare</h1>
                        <div class="contact-us__body__content__paragraph"></div>
                    </div>
                    <div class="text-center">
                        <a class="text-center d-inline-block contact-us__body__btn py-4 px-5" href="tel:<?php echo get_field('phone', 'option'); ?>">CONTATTACI</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="d-flex justify-content-between align-items-baseline flex-wrap contact-us__body p-5">
                    <div class="contact-us__body__img me-5"><img class="img-fluid" src="/site/themes/main-theme/style/assets/img/ticket-Icons.svg"></div>
                    <div class="me-auto contact-us__body__content">
                        <h1 class="contact-us__body__content__heading mb-4">Hai visto un'offerta migliore?</h1>
                        <div class="contact-us__body__content__paragraph"></div>
                    </div>
                    <div class="text-center">
                        <a class="text-center d-inline-block contact-us__body__btn py-4 px-5" href="mailto:<?php echo get_field('email', 'option'); ?>">CONTATTACI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<section id="tabs" class="component tabs">
    <div class="container">
        <h2 class="title text-center">
            Scopri le qualità del prodotto
        </h2>
        <?php if (get_field('breve_testo')) : ?>
            <p class="subtitle text-center"> <?php echo get_field('breve_testo'); ?></p>
        <?php endif; ?>

        <div class="d-flex justify-content-center flex-wrap">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1"> <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/icons/descrizione.svg">
                        Descrizione del prodotto</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2"> <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/icons/scheda.svg">
                        Specifiche tecniche</a></li>
                <?php if (get_field('warranty_support')) : ?>
                    <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-3"> <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/icons/garanzia.svg">
                            Garanzia e supporto</a></li>
                <?php endif; ?>
                <?php if (get_field('delivery')) : ?>
                    <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-4"> <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/icons/montaggio.svg">
                            Montaggio e consegna</a></li>
                <?php endif; ?>
                <?php if (get_field('payment_options')) : ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-5"> <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/icons/pagamento.svg">
                            Opzioni di pagamento</a>
                    </li>
                <?php endif; ?>

            </ul>
            <div class="tab-content w-100">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <div class="row gy-4">
                        <div class="col-12">
                            <?php if (get_field('additional_description')) : ?>
                                <?php echo get_field('additional_description'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <div class="row gy-4">
                        <div class="col-12">
                            <h3 class="text-center">Specifiche tecniche</h3>

                            <div class="tabs__tabel py-2 px-3">
                                <?php if (get_field('total_mq')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Mq</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p><?php echo get_field('total_mq'); ?> effettivi</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('line_height')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Altezza linea di gronda</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('line_height'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('column_height')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Altezza al colmo</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p><?php echo get_field('column_height'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('external_dimentions')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Dimensioni esterne (larghezza x profondità)</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('external_dimentions'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('materials')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Materiale</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p><?php echo get_field('materials'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('roof')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Tetto</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p><?php echo get_field('roof'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('root_material')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Materiale di copertura del tetto</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('root_material'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('flooring')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Pavimento</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('flooring'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('roof_mq')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Metri quadrati tetto</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('roof_mq'); ?> mq</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('roof_overhang')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Sbalzo del tetto</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('roof_overhang'); ?> mm</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('root_grade')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Pendenza del tetto</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('root_grade'); ?> °</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_field('rooms_number')) : ?>
                                    <div class="row gy-2 tabs__tabel__item">
                                        <div class="col-6 col-md-5 tabs__tabel__item__key">
                                            <p>Numero stanze</p>
                                        </div>
                                        <div class="col-6 col-md-7 tabs__tabel__item__value">
                                            <p> <?php echo get_field('rooms_number'); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-center mt-5">
                                <?php
                                $file = get_field('planimetria_file');
                                if ($file) : ?>

                                    <a class="btn btn-primar tabs__btn py-3 px-5" target="_blank" href="<?php echo $file['url']; ?>">SCARICA PLANIMETRIA
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="ms-3 tabs__btn__icon">
                                            <path d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z" fill="currentColor"></path>
                                            <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor"></path>
                                        </svg></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (get_field('warranty_support')) : ?>
                    <div class="tab-pane box" role="tabpanel" id="tab-3">
                        <div class="row gy-4">
                            <div class="col-12">
                                <h3 class="text-center">Garanzia e supporto</h3>
                                <p class="text-center"> <?php echo get_field('warranty_support'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (get_field('delivery')) : ?>
                    <div class="tab-pane box" role="tabpanel" id="tab-4">
                        <div class="row gy-4">
                            <div class="col-12">
                                <h3 class="text-center">Consegna e montaggio</h3>
                                <?php echo get_field('delivery'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (get_field('payment_options')) : ?>
                    <div class="tab-pane box" role="tabpanel" id="tab-5">
                        <div class="row gy-4">
                            <div class="col-12">
                                <h3 class="text-center">Opzioni di pagamento</h3>
                                <?php echo get_field('payment_options'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php get_template_part('partials/template/su_misura_per_te', '', ['term' => $term]); ?>
<?php get_template_part('partials/template/how_we_work'); ?>
<?php get_template_part('partials/component/related-products'); ?>
<?php include('order-popup.php'); ?>


<?php
get_footer();
