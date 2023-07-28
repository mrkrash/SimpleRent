import { Controller } from '@hotwired/stimulus';
import Quill from 'quill';

export default class extends Controller {

    static targets = ['container', 'hidden', 'toolbar'];

    connect() {
        this.quillInit();
    }

    /**
     * Fire up quill wyswig editor
     */
    quillInit() {
        const quill = new Quill(this.containerTarget, this.quillOption);
        console.log(quill);
        let _this = this;

        // While we type, copy the text to our hidden form field so it can be saved.
        quill.on('text-change', function(delta) {
            _this.hiddenTarget.value = quill.root.innerHTML;
        });

        // Capture focus on and off events
        // quill.on('selection-change', function(range, oldRange, source) {
        //     if (range === null && oldRange !== null) {
        //         _this.onFocusOut();
        //     } else if (range !== null && oldRange === null)
        //         _this.onFocus();
        // });
    }
    //
    // /**
    //  * Fires when the editor receives focus
    //  */
    // onFocus() {
    //     // Add a border and reveal the toolbar
    //     this.element.classList.add("is-primary");
    //     this.toolbarTarget.classList.remove("is-hidden");
    // }
    //
    // /**
    //  * Fires when the editor loses focus
    //  */
    // onFocusOut() {
    //     // Hide the border and toolbar
    //     this.element.classList.remove("is-primary");
    //     this.toolbarTarget.classList.add("is-hidden");
    //
    //     // Submit the form to save our updates
    //     //this.formTarget.requestSubmit();
    // }

    // Quill configuration options
    get quillOption() {
        return {
            placeholder: 'Compose an epic...',
            theme: 'snow',
        }
    }
}
