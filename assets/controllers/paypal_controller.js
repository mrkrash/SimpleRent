import { Controller } from '@hotwired/stimulus';
import { loadScript } from '@paypal/paypal-js';

const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const email = document.getElementById('email');
const phone = document.getElementById('phone');
const delivery = document.getElementById('delivery');
const privacy = document.getElementById('privacy');
const newsletter = document.getElementById('newsletter');
const totalEl = document.getElementById('total');
const products = document.getElementById('products');

let rate = 0;
let total = 0;

export default class extends Controller {
    connect() {
        const paypal_client_id = document.head.querySelector("meta[name=paypal_client_id]").content;
        rate = document.getElementById('rate').value;
        total = rate;

        loadScript({"client-id": paypal_client_id, "intent": "authorize", "currency": "EUR"}).then((paypal) => {
            paypal.Buttons({
                onClick: (data, actions) => {
                    let valid = true;
                    firstname.classList.remove('is-danger');
                    lastname.classList.remove('is-danger');
                    email.classList.remove('is-danger');
                    phone.classList.remove('is-danger');
                    privacy.classList.remove('is-danger');
                    if (!firstname.validity.valid) {
                        valid = false;
                        firstname.classList.add('is-danger');
                    }
                    if (!lastname.validity.valid) {
                        valid = false;
                        lastname.classList.add('is-danger');
                    }
                    if (!email.validity.valid) {
                        valid = false;
                        email.classList.add('is-danger');
                    }
                    if (!phone.validity.valid) {
                        valid = false;
                        phone.classList.add('is-danger');
                    }
                    if (!privacy.validity.valid) {
                        valid = false;
                        privacy.classList.add('is-danger');
                    }
                    if (valid) {
                        return actions.resolve();
                    } else {
                        return actions.reject();
                    }
                },
                createOrder: (data, actions) => {
                    return fetch("/rest/paypal/create", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            customer: {
                                firstname: firstname.value,
                                lastname: lastname.value,
                                email: email.value,
                                phone: phone.value,
                                delivery: delivery.value,
                                privacy: privacy.value,
                                newsletter: newsletter.value,
                            }
                        })
                    }).then((res) => res.json()).then((order) => order.id);
                },
                onApprove: (data) => {
                    console.log(data)
                }
            }).render('#paypal-button');
        }).catch((err) => {
            console.error("Failed to load the PayPal JS SDK script", err);
        });
    }
    delivery(e) {
        if (e.params.delivery === 'others') {
            delivery.innerHTML = '15.00';
            total = parseInt(rate) + 15;
            totalEl.innerHTML = '€ ' + total.toFixed(2);
        } else {
            delivery.innerHTML = '-.--';
            totalEl.innerHTML = '€ ' + parseFloat(rate).toFixed(2);
        }
    }
}
