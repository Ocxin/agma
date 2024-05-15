<?php if (get_sub_field('visible')) : ?>
    <section id="intro_banner" class="mardello_section intro_banner py-5" style="background-color: #F3F5F5;">
        <div class="container">
            
            <?php if(get_sub_field('intro_text')):?>
                <h1 class="intro_banner__heading mb-4"><?php echo get_sub_field('intro_text');?></h1>
        <?php endif;?>
           
            <div class="intro_banner__paragraph text-black">
            <?php if(get_sub_field('content')):?>
               <?php echo get_sub_field('content');?>
            <?php endif;?>
             
            </div>
        </div>
    </section>
    
<?php endif;?>