import { Controller } from '@hotwired/stimulus';
import { loadScript } from '@paypal/paypal-js';

export default class extends Controller {
    connect() {
        loadScript({"client-id": process.env.PAYPAL_CLIENT_ID}).then((paypal) => {}).catch((err) => {
            console.error("Failed to load the PayPal JS SDK script", err);
        });
    }
}
