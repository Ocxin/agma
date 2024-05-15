import Swiper from "swiper/bundle";

export function initializeBigSwiper() {
  if (document.querySelector(".slider-big .swiper-container")) {
    return new Swiper(".slider-big .swiper-container", {
      speed: 1000,
      slidesPerView: "auto",
      centeredSlides: true,
      spaceBetween: 0,
      loop: true,
      keyboard: {
        enabled: true,
        onlyInViewport: true,
      },
      grabCursor: true,
      effect: "coverflow",
      coverflowEffect: {
        rotate: 30,
        stretch: 0,
        depth: -100,
        modifier: 1,
        slideShadows: true,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: false,
    });
  }
}
