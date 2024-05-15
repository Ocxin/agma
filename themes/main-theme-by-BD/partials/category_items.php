<?php
exit('x');
	$the_query = "";
	$category  = get_category( get_query_var( 'cat' ) );
   // var_dump(get_query_var( 'casettie-category' ));
	$the_query = new WP_Query( array(
		'posts_per_page' => -1,               // Number of posts to retrieve
		'post_status' => 'publish',           // Post status (change as needed)
        'taxonomy'   => 'case-in-legno',
        'post_type'   => 'cassete',  
		'orderby' => 'date',                  // Order posts by date
		'order' => 'DESC'                     // Sort in descending order
	)); 
	?>

<section id="products" class="products py-5 px-4" style="background-color: #F3F5F5;">
        <div class="container-fluid"><div class="row gy-5">
    <div class="col-12 col-lg-4 col-xl-3">
        <div class="dropdown products__dropdown"><button id="dropdownToggle" class="btn btn-primary dropdown-toggle d-flex justify-content-between align-items-center py-3 w-100 show" aria-expanded="false" data-bs-toggle="dropdown" type="button">Filtri </button>
            <div id="dropdownMenu" class="dropdown-menu py-5 mb-5 show">
                <div class="products__filter px-2">
                    <form>
                        <div class="products__filter__category mb-5">
                            <h1 class="products__filter__category__title">Offerte speciali</h1>
                            <div class="form-check"><input id="formCheck-24" class="form-check-input" type="checkbox" />
                            <label class="form-label form-label form-label form-check-label" for="formCheck-24">Offerte speciali</label></div>
                        </div>
                        <div class="products__filter__category mb-5">
                            <h1 class="products__filter__category__title">Spessore pareti</h1>
                            <div class="form-check"><input id="formCheck-25" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-25">44 mm </label></div>
                            <div class="form-check"><input id="formCheck-26" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-26">Coibentata, 44 mm + rivestimento</label></div>
                            <div class="form-check"><input id="formCheck-27" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-27">Coibentata PLUS, 44 mm </label></div>
                            <div class="form-check"><input id="formCheck-28" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-28">Coibentata, doppie pareti</label></div>
                            <div class="form-check"><input id="formCheck-29" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-29">Coibentata, 34 mm + rivestimento</label></div>
                            <div class="form-check"><input id="formCheck-30" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-30">Coibentata, pannelli SIP</label></div>
                        </div>
                        <div class="products__filter__category mb-5">
                            <h1 class="products__filter__category__title">Metratura</h1>
                            <div class="row gx-3">
                                <div class="col-6">
                                    <div class="form-check"><input id="formCheck-31" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-31">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-32" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-32">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-33" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-33">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-34" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-34">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-35" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-35">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-36" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-36">44 mm </label></div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check"><input id="formCheck-37" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-37">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-38" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-38">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-39" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-39">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-40" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-40">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-41" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-41">44 mm </label></div>
                                    <div class="form-check"><input id="formCheck-42" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-42">44 mm </label></div>
                                </div>
                            </div>
                        </div>
                        <div class="products__filter__category mb-5">
                            <h1 class="products__filter__category__title">Prezzo</h1>
                            <div class="form-check"><input id="formCheck-43" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-43">€0 - 20 000</label></div>
                            <div class="form-check"><input id="formCheck-44" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-44">€20 001 - 40 000</label></div>
                            <div class="form-check"><input id="formCheck-45" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-45">€40 001 - 60 000</label></div>
                            <div class="form-check"><input id="formCheck-46" class="form-check-input" type="checkbox" /><label class="form-label form-label form-label form-check-label" for="formCheck-46">€60 001 +</label></div>
                        </div><input class="btn btn-primary py-4 w-100" type="submit" value="APPLICA IL FILTRO" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8 col-xl-9">
        <div class="row gy-5">
        <?php if ( $the_query->have_posts() ) : ?>
            <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                    $title = get_the_title();
                    $date = get_the_date();
                    $short = get_the_excerpt();
                    $categories = get_the_category();
                    $link = get_permalink();                   
                     $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
                    ?>

            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="products__card">
                    <div class="products__card__img">  <a href="#" class="products__card__body__link"><img class="img-fluid w-100" src="assets/img/house-cards.png" />
                    </a>
                    </div>
                    <div class="products__card__body p-4">
                        <div class="products__card__body__paragraph">
                            <p>CONSEGNA: 3 - 5 Settimana</p>
                        </div>
                        <a href="#" class="products__card__body__link">
                        <h1 class="products__card__body__heading py-3">Casa in Legno, lorem</h1>
                        </a>
                        <div class="d-flex products__card__body__info py-3">
                            <div class="products__card__body__items">
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="assets/img/square.svg" />
                                    <p>44 square meter</p>
                                </div>
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="assets/img/beds.svg" />
                                    <p>#538284</p>
                                </div>
                            </div>
                            <div class="products__card__body__items">
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="assets/img/layer.svg" />
                                    <p>3 ply layer</p>
                                </div>
                                <div class="d-flex align-items-baseline products__card__body__items__paragraph"><img class="products__iconm me-3" src="assets/img/bath.svg" />
                                    <p>1 bath</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5"><a class="btn btn-primary products__card__body__btn py-4 w-100" role="button" href="#">30,000€ + IVA</a></div>
                    </div>
                </div>
            </div>
            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>
        </div>
        <nav class="justify-content-center products__pagination mt-5 d-none">
            <ul class="pagination">
                <li class="page-item"><a class="page-link page-link--prev" aria-label="Previous" href="#"></a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><span class="page-link">…</span></li>
                <li class="page-item"><a class="page-link" href="#">10</a></li>
                <li class="page-item"><a class="page-link page-link--next" aria-label="Previous" href="#"></a></li>
            </ul>
        </nav>
    </div>
</div></div>
    </section>