import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    drop(e) {
        fetch(`/page/slide/drop/${e.params.id}`)
            .then(res => res.json())
            .then(result => {
                if (result.success)
                    document.getElementById(`box-slide-${e.params.id}`).remove();
            });
    }
}