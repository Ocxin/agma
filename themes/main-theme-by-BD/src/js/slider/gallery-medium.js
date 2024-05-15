import Swiper from "swiper/bundle";

export function initializeMediumSwiper() {
    console.log("initializeMediumSwiper");
  if (document.querySelector(".swiper-medium")) {
    console.log("initializeMediumSwiper");
    return new Swiper(".swiper-medium", {

        speed: 1000,
        slidesPerView: 1,
        loop: true,
        spaceBetween: 20,
        loop: true,
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        grabCursor: true,
        pagination:{
            el: '.swiper-pagination',
            clickable: true 
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
        });
    }

}

