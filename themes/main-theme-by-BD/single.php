 <?php
 get_header(); 
 $image = get_the_post_thumbnail_url(get_the_ID(),'full');?>

<?php
    if (have_rows('main_content')) :
        while (have_rows('main_content')) : the_row();
        ?>
         
        <?php
         get_template_part('partials/' . get_row_layout());
     
      endwhile;
    endif;
    ?>


<?php get_footer(); ?>