import { Controller } from '@hotwired/stimulus';
import { loadScript } from '@paypal/paypal-js';

const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const email = document.getElementById('email');
const phone = document.getElementById('phone');
const delivery = document.getElementById('delivery');
const privacy = document.getElementById('privacy');
const newsletter = document.getElementById('newsletter');

export default class extends Controller {
    connect()
    {
        const paypal_client_id = document.head.querySelector("meta[name=paypal_client_id]").content;

        loadScript({"client-id": paypal_client_id, "currency": "EUR"}).then((paypal) => {
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
                    return fetch("/paypal/create", {
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
                    return fetch("/paypal/capture", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(({
                            order: data
                        }))
                    }).then((res) => {
                        window.location = res.url;
                    })
                }
            }).render('#paypal-button');
        }).catch((err) => {
            window.location = '/payment/cancel'
        });
    }
}
