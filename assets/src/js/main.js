import '../scss/style.scss';

// Slide
import '@splidejs/splide/css/core';
import '@splidejs/splide/css';

import Splide from '@splidejs/splide';

if (document.querySelector('.js-main-carousel')) {
    const mainCarousel = new Splide('.js-main-carousel', {
        arrows: 'false',
        type: 'loop',
        perPage: 5,
        keyboard: true,
        breakpoints: {
            640: {
                destroy: true,
            },
            900: {
                perPage: 4,
            },
        },
    });
    mainCarousel.mount();
}

if (document.querySelector('.js-portfolio-carousel')) {
    const portfolioCarousel = new Splide('.js-portfolio-carousel', {
        arrows: 'false',
        type: 'loop',
        perPage: 5,
        keyboard: true,
        breakpoints: {
            640: {
                perPage: 1,
            },
            900: {
                perPage: 4,
            },
        },
    });
    portfolioCarousel.mount();
}



