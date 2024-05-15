import Swiper from "swiper/bundle";

export function initializeAggregatorSwiper() {
    if (document.querySelector(".contentlist .swiper-container")) {
        return new Swiper(".contentlist .swiper-container", {
            slidesPerView: "auto",
            centeredSlides: true,
            spaceBetween: 0,
            loop: true,
            keyboard: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    }
    return null;
}
