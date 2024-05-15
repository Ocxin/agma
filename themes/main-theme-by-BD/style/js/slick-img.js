jQuery(document).ready(function() {
  // Initialize the Slick Slider with default options
  jQuery('.slider').slick({
    arrows: true,
    centerMode: true,
    centerPadding: '0',
    slidesToShow: 6,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          centerPadding: '40px',
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]
  });

  // Change the main image based on the slider change event
  jQuery('.slider').on('afterChange', function(event, slick, currentSlide) {
    var currentImage = jQuery('.slider').find('.slick-current img').attr('src');
    jQuery('#mainImage').attr('src', currentImage);
  });

  // Change the main image when clicking on an image in the slider
  jQuery('.slider img').click(function() {
    var clickedImage = jQuery(this).attr('src');
    jQuery('#mainImage').attr('src', clickedImage);
  });

  // Custom prev and next buttons
  jQuery('.custom-prev').click(function() {
    jQuery('.slider').slick('slickPrev');
  });

  jQuery('.custom-next').click(function() {
    jQuery('.slider').slick('slickNext');
  });

  // Adjust container class on window resize
  // function adjustContainerClass() {
  //   if (jQuery(window).width() <= 991) {
  //     jQuery('.view-product .container').removeClass('container').addClass('container-fluid');
  //     jQuery('.view-product').removeClass('py-5').addClass('pb-5');
  //   } else {
  //     jQuery('.view-product .container-fluid').removeClass('container-fluid').addClass('container');
  //     jQuery('.view-product').removeClass('pb-5').addClass('py-5');
  //   }
  // }

  // Call the adjustment function on initial page load
  adjustContainerClass();

  // Call the adjustment function on window resize
  jQuery(window).resize(adjustContainerClass);
});
