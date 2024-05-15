<?php
$post_id = get_the_ID(); // Ottiene l'ID del post corrente
$related_products = get_field('correlated', $post_id); // Ottiene i prodotti correlati

if ($related_products) : ?>
    <section class="component contentlist related-products">
        <h2 class="title text-center">Prodotti correlati</h2>
        <div class="content container">
            <?php foreach ($related_products as $product) :
                $title = get_the_title($product->ID);
                $thumbnail_url = get_the_post_thumbnail_url($product->ID, 'medium_large');
                $permalink = get_the_permalink($product->ID);

                get_template_part('partials/tile/tile', null, array('post' => $product, 'is_slider' => false));
            
             endforeach; ?>
        </div>
            </section>
<?php endif; ?>