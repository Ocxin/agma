jQuery(document).ready(function() {
    function initSlick() {
        jQuery('.slick-row').slick({
            arrows: true,
            centerMode: true,
            centerPadding: '0',
            slidesToScroll: 3,
            slidesToShow: 3,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        arrows: true,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        jQuery('.custom-prev').click(function() {
            jQuery('.slick-row').slick('slickPrev');
        });

        jQuery('.custom-next').click(function() {
            jQuery('.slick-row').slick('slickNext');
        });
      
    
    }

    initSlick();
});

jQuery('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    jQuery('.slick-row').slick('setPosition');
  
})


jQuery(document).ready(function() {
    var jQueryslickTeam = jQuery('.slick-team');
    var isSlickInitialized = false;

    function teamslick() {
        var screenWidth = jQuery(window).width(); // Get the current screen width

        if (screenWidth <= 991 && !isSlickInitialized) { // Check if screen width is less than or equal to 992 and slick is not initialized
            jQueryslickTeam.slick({
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 2,
                slidesToScroll: 2,
               responsive: [
                {
                    breakpoint: 500,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
            });
            isSlickInitialized = true;
        } else if (screenWidth > 991 && isSlickInitialized) { // Check if screen width is greater than 992 and slick is initialized
            jQueryslickTeam.slick('unslick'); // Disable slick slider
            isSlickInitialized = false;
        }
    }

    teamslick();

    jQuery(window).resize(function() {
        teamslick(); 
    });
});


jQuery(document).ready(function() {
    function imgSlick() {
        jQuery('.slick-img').slick({
            arrows: true,
            centerMode: false,
            centerPadding: '0',
            slidesToScroll: 4,
            slidesToShow: 4,
            responsive: [
                {
                    breakpoint: 1280,
                    settings: {
                        arrows: true,
                        centerMode: false,
                        centerPadding: '40px',
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                       {
                    breakpoint: 991,
                    settings: {
                        arrows: true,
                        centerMode: false,
                        centerPadding: '40px',
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: false,
                        centerPadding: '40px',
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        jQuery('.custom-prev').click(function() {
            jQuery('.slick-img').slick('slickPrev');
        });

        jQuery('.custom-next').click(function() {
            jQuery('.slick-img').slick('slickNext');
        });
      
    
    }

    imgSlick();
});
  







