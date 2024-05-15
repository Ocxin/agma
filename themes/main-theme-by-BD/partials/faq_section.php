<?php if (get_sub_field('visible')) : 
    $r = rand(1,20);
    ?>
    <section id="mini_faq" class="mardello_section  mini_faq py-5" style=<?php if (get_sub_field('background_color')) : ?>"background-color: <?php echo get_sub_field('background_color');?>"<?php endif;?>>
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                <?php if(get_sub_field('title')):?>
                    <h1><?php echo get_sub_field('title');?></h1>
                 <?php endif;?>
        
                </div>
            </div>
            <div class="accordion" role="tablist" id="accordion-<?php echo $r;?>">
              
            <?php if( have_rows('content_repeater') ):?>
                <?php $x = 1;?>
        <?php   while( have_rows('content_repeater') ) : the_row();?>

        <div class="accordion-item">
                    <h2 class="accordion-header py-4" role="tab"><button class="accordion-button collapsed pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-<?php echo $r;?> .item-<?php echo $x;?>" aria-expanded="true" aria-controls="accordion-<?php echo $r;?> .item-<?php echo $x;?>">
                    <?php if(get_sub_field('question')):?>
                    <?php echo get_sub_field('question');?>
                    <?php endif;?>
                </button></h2>
                    <div class="accordion-collapse collapse  item-<?php echo $x;?>" role="tabpanel" data-bs-parent="#accordion-<?php echo $r;?>">
                        <div class="accordion-body">
                            <div class="mini_faq__content__paragraph mb-0">
                            <?php if(get_sub_field('answer')):?>
                    <?php echo get_sub_field('answer');?>
                    <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>

               


            <?php $x++;?>
        <?php endwhile;?>
        <?php endif;?>
               
              
            </div>
        </div>
    </section>

    <?php endif;?>