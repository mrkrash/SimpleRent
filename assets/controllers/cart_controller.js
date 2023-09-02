import {Controller} from "@hotwired/stimulus";

const deliveryEl = document.getElementById('delivery');
const subtotalEl = document.getElementById('subtotal');
const totalEl = document.getElementById('total');

let rate = 0;
let delivery = 0;
let total = 0;

export default class extends Controller {
    connect()
    {
        rate = document.getElementById('rate').value;
        total = rate;
    }

    addProductToCart(evt)
    {
        fetch(` / cart / addToCart`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: evt.params.id,
                type: 'product',
                size: document.getElementById(`size - ${evt.params.id}`).value
            })
        })
            .then(res => res.json())
            .then(result => {
                if (result.thereisnomore) {
                    evt.target.parentElement.setAttribute('disabled', 'disabled');
                }
                if (result.count > 0) {
                    document.getElementById('cart-badge').textContent = result.count;
                }
                var pageloader = document.getElementById("pageloader");
                if (pageloader) {
                    pageloader.classList.toggle('is-active');
                    var pageloaderTimeout = setTimeout(function () {
                        pageloader.classList.toggle('is-active');
                        clearTimeout(pageloaderTimeout);
                    }, 3000);
                }
                document.getElementById('conclude-button').classList.remove('is-hidden');
            })
    }

    removeProductFromCart(evt)
    {
        fetch(
            ` / cart / deleteFromCart / ${evt.params.id}`,
            {method: "DELETE", headers: {"Content-Type": "application/json"}}
        ).then(res => res.json()).then(result => {
            if (result.success) {
                document.getElementById(`item - ${evt.params.id}`).remove();
                document.getElementById('cart-badge').textContent = result.cart.count;
                document.getElementById('rate').value = result.cart.rate;
                subtotalEl.innerHTML = '€ ' + parseFloat(result.cart.rate).toFixed(2);
                total = parseInt(result.cart.rate) + delivery;
                totalEl.innerHTML = '€ ' + total.toFixed(2);
            }
        });
    }

    openTab(evt)
    {
        let i, x, tablinks;
        x = document.getElementsByClassName("content-tab");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" is-active", "");
        }
        document.getElementById(evt.params.tab).style.display = "block";
        evt.currentTarget.className += " is-active";
    }
    delivery(e)
    {
        if (e.params.delivery === 'others') {
            deliveryEl.innerHTML = '15.00';
            delivery = 15;
            total = parseInt(rate) + 15;
            totalEl.innerHTML = '€ ' + total.toFixed(2);
        } else {
            delivery = 0;
            deliveryEl.innerHTML = '-.--';
            totalEl.innerHTML = '€ ' + parseFloat(rate).toFixed(2);
        }
    }
}