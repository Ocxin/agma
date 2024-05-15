<?php if (get_sub_field('visible')) : ?>
    <section class="mardello_section row_layout">
        <div class="<?php echo get_sub_field('cotainer_type'); ?>">
            <div class="row">

                <?php for ($i = 1; $i <= get_sub_field('columns_number'); $i++) { ?>
                    <?php //var_dump(get_sub_field('column_'.$i));
                    if (get_sub_field('column_' . $i)) :
                        $coulmn = get_sub_field('column_' . $i);
                    ?>
                        <div class="<?php echo $coulmn[0]["class_name"] ?> col-sm-<?php echo $coulmn[0]["column_class"][0]["sm"]; ?> col-md-<?php echo $coulmn[0]["column_class"][0]["md"]; ?> col-lg-<?php echo $coulmn[0]["column_class"][0]["lg"]; ?>">

                            <!-- start text_content -->
                            <?php if ($coulmn[0]["content_type"] == 'text_content') : ?>

                                <?php if ($coulmn[0]["text_content"][0]["title"] != null) : ?>
                                    <div class="title">
                                        <?php echo $coulmn[0]["text_content"][0]["title"]; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($coulmn[0]["text_content"][0]["content"] != null) : ?>
                                    <div class="content">
                                        <?php echo $coulmn[0]["text_content"][0]["content"]; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($coulmn[0]["text_content"][0]["url_text"] != null) : ?>
                                    <div class="url_text">
                                        <a href="<?php echo $coulmn[0]["text_content"][0]["url"]; ?>"><?php echo $coulmn[0]["text_content"][0]["url_text"] ?></a>
                                    </div>
                                <?php endif; ?>


                            <?php endif; ?>
                            <!-- end text_content -->

                            <!-- start image -->
                            <?php if ($coulmn[0]["content_type"] == 'image') : ?>

                                <?php if ($coulmn[0]["image"][0]["title"] != null) : ?>
                                    <div class="title">
                                        <?php echo $coulmn[0]["image"][0]["title"]; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($coulmn[0]["image"][0]["image"] != null) : ?>
                                    <div class="image">
                                        <?php $image = wp_get_attachment_image_src($coulmn[0]["image"][0]["image"], 'meduim'); ?>
                                        <img class="img-fluid" src="<?php echo $image[0]; ?>" />
                                    </div>
                                <?php endif; ?>

                                <?php if ($coulmn[0]["image"][0]["image_tilte"] != null) : ?>
                                    <div class="image_title">
                                        <?php echo $coulmn[0]["image"][0]["image_tilte"]; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($coulmn[0]["image"][0]["description"] != null) : ?>
                                    <div class="description">
                                        <?php echo $coulmn[0]["image"][0]["description"]; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($coulmn[0]["image"][0]["url_text"] != null) : ?>
                                    <div class="url_text">
                                        <a href="<?php echo $coulmn[0]["image"][0]["url"]; ?>"><?php echo $coulmn[0]["image"][0]["url_text"] ?></a>
                                    </div>
                                <?php endif; ?>


                            <?php endif; ?>
                            <!-- end image -->

                            <!-- start text_content -->
                            <?php if ($coulmn[0]["content_type"] == 'slider') : ?>

                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="http://localhost/wp-template/site/uploads/2021/11/logo.png" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="http://localhost/wp-template/site/uploads/2021/11/logo.png" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="http://localhost/wp-template/site/uploads/2021/11/logo.png" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


                            <?php endif; ?>
                            <!-- end text_content -->

                        </div>
                <?php
                    endif;
                }
                ?>

            </div>
        </div>
    </section>
<?php endif; ?>


<script>
 jQuery(document).ready(
     function(){
        jQuery('#myCarousel').on('slide.bs.carousel', function () {
  
}) ;
     }
 );
</script>