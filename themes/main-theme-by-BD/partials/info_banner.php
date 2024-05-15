<?php if (get_sub_field('visible')) : ?>

    <section id="info_banner" class=" info_banner py-2">
        <div class="container">
            <div class="info_banner__body d-flex justfiy-content-center align-items-center">
                <h1 class="info_banner__body__heading me-auto p-0 m-0"><?php echo get_field('contact_us_title','options');?></h1>
                <div class="info_banner__body__contact"><a class="info_banner__body__contact__link" href="tel:<?php echo get_field('phone','options');?>"><strong><?php echo get_field('phone','options');?></strong></a>
                    <div class="d-inline-block me-3 ms-3"><span>|</span></div><a class="info_banner__body__contact__link" href="mailto:<?php echo get_field('email','options');?>"><?php echo get_field('email','options');?></a>
                    <div class="d-inline-block me-3 ms-3">
                </div>
            </div>
        </div>
    </section>
<?php endif;?>