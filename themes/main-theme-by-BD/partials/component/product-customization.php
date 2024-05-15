<?php
$customizations = [
    ['nome' => 'Servizio di Installazione', 'id' => 'servizio_di_installazione_per_mq', 'prezzo_per_mq' => get_field('servizio_di_installazione_per_mq', 'option'), 'mq' => get_field('mq')], 
    ['nome' => 'Servizio di Installazione Garage', 'id' => 'servizio_di_installazione_per_mq_b', 'prezzo_per_mq' => get_field('servizio_di_installazione_per_mq_b', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Servizio di Installazione Casa in Legno', 'id' => 'servizio_di_installazione_per_mq_c', 'prezzo_per_mq' => get_field('servizio_di_installazione_per_mq_c', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Servizio di Installazione Tettoia', 'id' => 'servizio_di_installazione_per_mq_d', 'prezzo_per_mq' => get_field('servizio_di_installazione_per_mq_d', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Base con Telaio Legno', 'id' => 'base_con_telaio_legno', 'prezzo_per_mq' => get_field('base_con_telaio_legno', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Grondaie in Lamiera', 'id' => 'grondaie_in_lamiera', 'prezzo_per_mq' => get_field('grondaie_in_lamiera', 'option'), 'ml' => get_field('ml')],
    ['nome' => 'Kit per Patio WPC', 'id' => 'kit_per_patio_wpc', 'prezzo_per_mq' => get_field('kit_per_patio_wpc', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Copertura Tegole Bituminose', 'id' => 'copertura_tegole_bituminose', 'prezzo_per_mq' => get_field('copertura_tegole_bituminose', 'option'), 'mq' => get_field('mq'), 'varianti' => [['value' => 'ROSSA', 'label' => 'Rossa', 'prezzo' => get_field('copertura_tegole_bituminose', 'option')], ['value' => 'VERDE', 'label' => 'Verde', 'prezzo' => get_field('copertura_tegole_bituminose', 'option')], ['value' => 'NERA', 'label' => 'Nera', 'prezzo' => get_field('copertura_tegole_bituminose', 'option')], ['value' => 'No', 'label' => 'N/A', 'prezzo' => 'Incluso']], 'mq' => get_field('mq')],
    ['nome' => 'Impregnante Esterno', 'id' => 'impregnante_esterno', 'prezzo_per_mq' => get_field('impregnante_esterno', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Vernice Colorata', 'id' => 'vernice_colorata', 'prezzo_per_mq' => get_field('vernice_colorata', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Tegole in PVC', 'id' => 'tegole_in_pvc', 'prezzo_per_mq' => get_field('tegole_in_pvc', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Copertura in Lamiera Zincata', 'id' => 'copertura_in_lamiera_zincata', 'prezzo_per_mq' => get_field('copertura_in_lamiera_zincata', 'option'), 'mq' => get_field('mq')],
    ['nome' => 'Porta Garage', 'id' => 'porta_garage', 'varianti' => [['value' => 'No', 'label' => 'N/A', 'prezzo' => 'Incluso'], ['value' => 'porta_garage_basculante', 'label' => 'Basculante', 'prezzo' => get_field('porta_garage_basculante', 'option')], ['value' => 'porta_garage_motorizzata', 'label' => 'Motorizzata', 'prezzo' => get_field('porta_garage_motorizzata', 'option')]]],

];

foreach ($customizations as $key => $customization) {
    if ($customization['id'] !== 'porta_garage') {
        if (get_field($customization['id']) === false) {
            unset($customizations[$key]);
        }
    } else {
        foreach ($customization['varianti'] as $key_variant => $variant) {
            if (get_field($variant['value']) === false) {
                unset($customizations[$key]['varianti'][$key_variant]);
            }
        }
        if (empty($customizations[$key]['varianti'])) {
            unset($customizations[$key]);
        }
    }
}
?>
<section class="component product-customization container-fluid">
    <div class="row">
        <h2 class="col-12 text-center title">Seleziona gli accessori più adatti alle tue esigenze</h2>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="container">
                <form id="items_of_order row">
                    <div class="accessories_wrapper col-12">
                        <?php foreach ($customizations as $customization) : ?>
                            <div class="form-item">
                                <div class="content">
                                    <h3><?php echo $customization['nome']; ?></h3>
                                    <?php if (!empty($customization['varianti'])) : ?>
                                        <?php foreach ($customization['varianti'] as $variante) : ?>
                                            <div class="form-check relative">
                                                <input type="radio" id="<?php echo strtolower($variante['value']); ?>" name="<?php echo $customization['id']; ?>" data-id="<?php echo $customization['id']; ?>" value="<?php echo $variante['value']; ?>" class="form-check-input" data-price="<?php
                                                                                                                                                                                                                                                                                                if (isset($customization['mq']) && $variante['prezzo'] !== 'Incluso') {
                                                                                                                                                                                                                                                                                                    // Se ci sono i metri quadri e il prezzo non è "Incluso", moltiplica il prezzo per i mq
                                                                                                                                                                                                                                                                                                    echo isset($variante['prezzo']) ? $variante['prezzo'] * $customization['mq'] . ' €' : 'Prezzo non disponibile';
                                                                                                                                                                                                                                                                                                } elseif (!isset($customization['mq'])) {
                                                                                                                                                                                                                                                                                                    // Se non ci sono i metri quadri, stampa il prezzo come è
                                                                                                                                                                                                                                                                                                    echo $variante['prezzo'] . ' €';
                                                                                                                                                                                                                                                                                                } elseif ($variante['prezzo'] === 'Incluso') {
                                                                                                                                                                                                                                                                                                    // Se il prezzo è "Incluso", anche se ci sono i mq, non moltiplicare, stampa solo "Incluso"
                                                                                                                                                                                                                                                                                                    echo 'Incluso';
                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                ?>" data-lable="<?php echo ($customization['id'] === 'copertura_tegole_bituminose' || $customization['id'] === 'porta_garage') ? $customization['nome'] . ' - ' . $variante['label'] : $variante['label']; ?>">
                                                <label class="form-check-label" for="<?php echo strtolower($variante['value']); ?>">


                                                    <?php if (isset($variante['prezzo']) && $variante['prezzo'] > 0 && $variante['prezzo'] != 'Incluso' && isset($customization['mq'])) : ?>
                                                        <?php echo '<span class="price">+' . $variante['prezzo'] *  $customization['mq'] . '€ </span>' . '&nbsp;'; ?>
                                                    <?php elseif ($variante['mq'] == null && $variante['prezzo'] != 'Incluso') : ?>
                                                        <?php echo '<span class="price">+' . $variante['prezzo'] . '€ </span>' . '&nbsp;'; ?>
                                                    <?php elseif ($variante['prezzo'] == 'Incluso') : ?>
                                                        Incluso
                                                    <?php else : ?>
                                                        Su richiesta
                                                    <?php endif; ?>
                                                    <?php echo $variante['label']; ?>
                                                </label>
                                                <div class="background"></div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="<?php echo $customization['id']; ?>" name="<?php echo $customization['id']; ?>" data-price="<?php echo ($customization['prezzo_per_mq'] ?? 0) * $customization['mq']; ?>" data-lable="<?php echo $customization['nome'] ?>">
                                            <label for="<?php echo $customization['id']; ?>" class="form-label">
                                                <?php if ($customization['id'] != "grondaie_in_lamiera") { ?>
                                                    <?php echo (($customization['prezzo_per_mq'] ?? 0) * $customization['mq']) ? ('<span class="price">' . ($customization['prezzo_per_mq'] * $customization['mq']) . ' €</span>') : 'Su richiesta'; ?>
                                                <?php } else { ?>
                                                    <?php echo (($customization['prezzo_per_mq'] ?? 0) * $customization['ml']) ? ('<span class="price">' . ($customization['prezzo_per_mq'] * $customization['ml']) . ' €</span>') : 'Su richiesta'; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="image-wrapper">
                                    <img class="default-image" src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/accessori/<?php echo $customization['id'] . '.webp' ?>" alt="<?php echo $customization['nome'] ?>">
                                    <?php if (isset($customization['varianti'])) : ?>
                                        <?php foreach ($customization['varianti'] as $variante) : ?>
                                            <?php if ($variante['label'] != 'N/A') :  ?>
                                                <img class="variant <?php echo strtolower($variante['value']) ?>" src="<?php echo get_stylesheet_directory_uri() ?>/dist/images/accessori/<?php echo $customization['id'] .  '_' . $variante['label'] . '.webp' ?>" alt="<?php echo $customization['nome'] . ' ' . $variante['label'] ?>">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- <div class="accordion-item">
                <h2 class="accordion-header" role="tab">
                    <button class="accordion-button collapsed d-flex flex-column justify-content-center align-items-start" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-14" aria-expanded="true" aria-controls="accordion-1 .item-14">
                        SERVIZIO DI SPEDIZIONE
                        <span class="accordion-button__title ms-3"></span>
                    </button>
                </h2>
                <div class="accordion-collapse collapse  item-14" role="tabpanel" data-bs-parent="#accordion-1">
                    <div class="accordion-body mt-0 pt-0">
                        <div class="d-flex align-items-start form-check pb-3 pt-0 px-0">
                            <input name="SERVIZIO DI SPEDIZIONE" data-lable="SERVIZIO DI SPEDIZIONE" data-price="A RICHIESTA" type="checkbox" class="mt-2" name="servizio_di_spedizione" id="servizio_di_spedizione">
                            <img class="img-fluid d-none" src="/site/themes/main-theme/style/assets/img/Frame%2094.png">
                            <div class="ms-3">
                                <label for="base_con_telaio_legno" class="form-label">Si: su richiesta</label>
                                <div class="form-check__paragraph">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>