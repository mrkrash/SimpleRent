import { Controller } from '@hotwired/stimulus';
import bulmaCarousel from "bulma-carousel/src/js";

export default class extends Controller {
    connect() {
        bulmaCarousel.attach('.hero-carousel.carousel', {
            autoplay: true,
            infinite: true,
            loop: true,
        });
        bulmaCarousel.attach('.product.carousel', {
            autoplay: false,
            infinite: true,
            loop: true,
            slidesToScroll: 4,
            slidesToShow: 4
        });
    }
}
