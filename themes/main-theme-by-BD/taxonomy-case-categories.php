<?php
/*
Template Name: Custom Archive Template
*/

use function DeliciousBrains\WPMDB\Container\DI\get;

get_header();
?>



<?php
$the_query = "";
$tax_terms = get_terms($taxonomy, array('hide_empty' => false));
$mq = [];
$taxonomy = get_queried_object();
$request_params = [
  'mq' => @$_GET['mq'] ?? [],
  'category' => @$_GET['category'] ?? [],
  'bagno' => @$_GET['bagno'] ?? [],
  'livelli' => @$_GET['livelli'] ?? [],
  'prezzo' => @$_GET['prezzo'] ?? ['0-1000000']
];
$tax_args = [
  'relation' => 'AND',
  array(
    'taxonomy' => 'case-categories',
    'field' => 'term_id',
    'terms' => $taxonomy->term_id,
  ),
];
foreach ($request_params['category'] as $reqCategory) {
  array_push(
    $tax_args,
    [
      'taxonomy' => 'case-categories',
      'field' => 'term_id',
      'terms' => $reqCategory
    ]
  );
}

$the_filters_query = new WP_Query(array(
  'posts_per_page' => -1,               // Number of posts to retrieve
  'post_status' => 'publish',           // Post status (change as needed)
  'orderby' => 'date',                  // Order posts by date
  'post_type'   => 'casetta',
  'order' => 'DESC',                 // Sort in descending order
  'tax_query' => array(
    array(
      'taxonomy' => 'case-categories',
      'field' => 'term_id',
      'terms' => $taxonomy->term_id,
    ),
  )

));
$the_query = new WP_Query(array(
  'posts_per_page' => -1,               // Number of posts to retrieve
  'post_status' => 'publish',           // Post status (change as needed)
  'orderby' => 'date',                  // Order posts by date
  'post_type'   => 'casetta',
  'order' => 'DESC',                 // Sort in descending order
  'tax_query' => array(
    $tax_args,
  ),
  'meta_query'    => array(
    'relation'      => 'AND',
    array(
      'key'       => 'mq',
      'value'     => $request_params['mq'],
      'compare'   => 'IN'
    ),
    array(
      'key'       => 'bagno',
      'value'     => $request_params['bagno'],
      'compare'   => '='
    ),
    array(
      'key'       => 'livelli',
      'value'     => $request_params['livelli'],
      'compare'   => 'IN'
    ),
    array(
      'key'       => 'prezzo_base',
      'value'     => explode('-', $request_params['prezzo'][0]),
      'compare'   => 'BETWEEN',
      'type' => 'NUMERIC'
    )
  )

));
?>
<?php
while ($the_filters_query->have_posts()) : $the_filters_query->the_post();
  $mq[] = get_field('mq');
endwhile;
wp_reset_postdata();
$mq = array_unique($mq);
sort($mq)
?>


<?php
$term = get_queried_object();
$term = get_queried_object();

get_template_part('partials/template/hero_pages')
?>




<section id="products" class="products py-5 px-4" style="background-color: #F3F5F5;">
  <div class="container">
    <div class="row gy-5">
      <div class="col-12 col-lg-3 col-xl-3">
        <div class="dropdown products__dropdown">
          <div id="dropdownMenu" class="dropdown-menu show">
            <div class="products__filter px-2">
              <form method="get" id="filters" class="container">
                <!-- Accordion container -->
                <div class="accordion" id="filterAccordion">

                  <!-- Special Offers Accordion Item -->
                  <!-- Square Meters Accordion Item -->
                  <div class="accordion-item">
                    <h3 class="accordion-header" id="headingSquareMeters">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSquareMeters" aria-expanded="false" aria-controls="collapseSquareMeters">
                        Metri Quadri
                      </button>
                    </h3>
                    <div id="collapseSquareMeters" class="accordion-collapse collapse" aria-labelledby="headingSquareMeters" data-bs-parent="#filterAccordion">
                      <div class="accordion-body">
                        <div class="row gx-3">
                          <?php foreach ($mq as $key => $mq_item) : ?>
                            <div class="col-12 mt-3">
                              <div class="form-check">
                                <input <?php if (in_array($mq_item, $request_params['mq'])) : ?> checked <?php endif; ?> value="<?php echo $mq_item; ?>" name="mq[]" id="mqformCheck-<?php echo $key; ?>" class="form-check-input" type="checkbox" />
                                <label class="form-check-label" for="mqformCheck-<?php echo $key; ?>"><?php echo $mq_item; ?> MQ</label>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Levels Accordion Item -->
                  <div class="accordion-item">
                    <h3 class="accordion-header" id="headingLevels">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLevels" aria-expanded="false" aria-controls="collapseLevels">
                        Livelli
                      </button>
                    </h3>
                    <div id="collapseLevels" class="accordion-collapse collapse" aria-labelledby="headingLevels" data-bs-parent="#filterAccordion">
                      <div class="accordion-body">
                        <div class="row gx-3">
                          <div class="col-12 mt-3">
                            <div class="form-check">
                              <input value="1" <?php if (in_array(1, $request_params['livelli'])) : ?> checked <?php endif; ?> name="livelli[]" id="levelsformCheck1" class="form-check-input" type="checkbox" />
                              <label class="form-check-label" for="levelsformCheck1">1 Livello</label>
                            </div>
                          </div>
                          <div class="col-6 mt-4">
                            <div class="form-check">
                              <input value="2" <?php if (in_array(2, $request_params['livelli'])) : ?> checked <?php endif; ?> name="livelli[]" id="levelsformCheck2" class="form-check-input" type="checkbox" />
                              <label class="form-check-label" for="levelsformCheck2">2 Livelli</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Price Accordion Item -->
                  <div class="accordion-item">
                    <h3 class="accordion-header" id="headingPrice">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
                        Prezzo
                      </button>
                    </h3>
                    <div id="collapsePrice" class="accordion-collapse collapse" aria-labelledby="headingPrice" data-bs-parent="#filterAccordion">
                      <div class="accordion-body">
                        <div class="form-check">
                          <input name="prezzo[]" value="0-1000" <?php if (in_array('0-1000', $request_params['prezzo'])) : ?> checked <?php endif; ?> id="formCheck-43" class="form-check-input" type="radio" />
                          <label class="form-check-label" for="formCheck-43">€0 - 1000</label>
                        </div>
                        <div class="form-check">
                          <input name="prezzo[]" value="1001-10000" <?php if (in_array('1001-10000', $request_params['prezzo'])) : ?> checked <?php endif; ?> id="formCheck-44" class="form-check-input" type="radio" />
                          <label class="form-check-label" for="formCheck-44">€1001 - 10,000</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <input class="btn btn-primary py-4 w-100 mt-3" type="submit" value="APPLICA IL FILTRO" />
              </form>
              <a class="component button secondary" href="<?php echo get_post_type_archive_link('casetta'); ?>"><img src="<?php echo get_stylesheet_directory_uri() . "/style/assets/img/catalogo.svg"?>" alt="Catalogo">Scarica il catalogo della collezione Mardello 2024</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-9 col-xl-9">
        <div class="row gy-5">
          <?php if ($the_query->have_posts()) : ?>
          <?php while ($the_query->have_posts()) : $the_query->the_post();
              get_template_part('partials/tile/tile.archive');
            endwhile;
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
    </div>
</section>


<?php
$term = get_queried_object();
$term = get_queried_object();
if (have_rows('main_content', $term)) :
  while (have_rows('main_content', $term)) : the_row();
?>

    <?php if (get_row_layout() != 'category_banner' && get_row_layout() != 'info_banner') :
      get_template_part('partials/' . get_row_layout());
    endif;
    ?>
<?php
  endwhile;
endif;
?>

<script>
  var $ = jQuery;
  $(document).ready(function() {
    $('#filters input').change(function() {
      $('#filters').submit();
    });
  })
</script>

<?php get_footer();
?>