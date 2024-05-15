
<?php
get_header(); ?>
<div id="main" class="site-main"  role="main" <?php if(!is_front_page()):?>  <?php endif;?>>
    archive
  <?php
    if (have_rows('category_content')) :
        while (have_rows('category_content')) : the_row();
        ?>
         
        <?php
         get_template_part('partials/' . get_row_layout());
     
      endwhile;
    endif;
    ?>
</div><!-- #main -->

<?php
get_footer();