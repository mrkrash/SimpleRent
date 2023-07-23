import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    burger(e) {
        e.target.classList.toggle('is-active');
        document.getElementById('main-menu').classList.toggle('is-active')
    }
}