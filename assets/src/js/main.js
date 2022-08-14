import '../scss/style.scss';

// Slide
import '@splidejs/splide/css/core';
import '@splidejs/splide/css';

import Splide from '@splidejs/splide';

new Splide('.splide', {
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
}).mount();
