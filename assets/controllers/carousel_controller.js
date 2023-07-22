import { Controller } from '@hotwired/stimulus';
import bulmaCarousel from "bulma-carousel/src/js";

const options = {
    autoplay: true,
    infinite: true,
    loop: true,
};
export default class extends Controller {
    connect() {
        const carousels = bulmaCarousel.attach('.carousel', options);

    }
}
