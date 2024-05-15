<?php
/* Template Name: Home Page */

get_header();
?>

<div id="main" class="site-main" role="main">
    <?php
    if (have_rows('main')) :
        while (have_rows('main')) : the_row();
            get_template_part('partials/template/' . get_row_layout());
        endwhile;
    endif;
    ?>
    <?php
    get_template_part('partials/template/how_we_work');
    ?>
</div>
<?php
get_footer();
