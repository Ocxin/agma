import Swiper from "swiper/bundle";

export function initializeProductSwiper() {
    if (document.querySelector(".main-slider") && document.querySelector(".thumb-slider")) {
        var mainSlider = new Swiper('.main-slider', {
            navigation: false,
            keyboard: true,
            thumbs: {
                swiper: {
                    el: '.thumb-slider',
                    slidesPerView: 4,
                    spaceBetween: 10,
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        1024: {
                            slidesPerView: 4,
                        },
                    },
                }
            }
        });

        var thumbSlider = new Swiper('.thumb-slider', {
            spaceBetween: 15,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });

        mainSlider.controller.control = thumbSlider;
        thumbSlider.controller.control = mainSlider;
    }
}
