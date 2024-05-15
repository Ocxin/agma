<?php
/* Template Name: Main Theme */
get_header();
?>

<!-- Main content area -->
<div id="main" class="site-main" role="main" <?php echo is_front_page() ? '' : 'class="not-front-page"'; ?>>

  <?php

  // Include the hero section for pages
  get_template_part('partials/template/hero_pages');
  ?>

  <!-- Container for the article content -->
  <div class="container">
    <article class="row">
      <!-- Display the page or post subtitle using the excerpt -->
      <h2 class="col-12 offset-0 col-md-8 offset-md-2  subtitle"><?php echo get_the_excerpt(); ?></h2>

      <?php
      // Check if 'main' custom fields have rows of data
      if (have_rows('main')) :
        // Loop through the rows of data
        while (have_rows('main')) : the_row();
          // Dynamically include the template part based on the layout field
          get_template_part('partials/template/' . get_row_layout());
        endwhile;
      endif;
      ?>
    </article>
  </div>

</div>

<?php
get_footer();
?>