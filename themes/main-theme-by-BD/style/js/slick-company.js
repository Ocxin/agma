jQuery(document).ready(function() {
    var mediaQuery = window.matchMedia('(max-width: 575px)');
    var slickInitialized = false;
    var slickOptions = {
        arrows: false,
        centerMode: true,
        centerPadding: '80px',
        slidesToShow: 1,
        slidesToScroll: 1
    };

    function initSlick() {
        if (mediaQuery.matches && !slickInitialized) {
            jQuery('.slick-company').slick(slickOptions);
            slickInitialized = true;
        } else if (!mediaQuery.matches && slickInitialized) {
            jQuery('.slick-company').slick('unslick');
            slickInitialized = false;
        }
      
             jQuery('.custom-prev').click(function() {
            jQuery('.slick-company').slick('slickPrev');
        });

        jQuery('.custom-next').click(function() {
            jQuery('.slick-company').slick('slickNext');
        });
    }

    initSlick();

    jQuery(window).on('resize', function() {
        initSlick();
    });
});
