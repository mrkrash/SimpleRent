import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    addProductToCart(evt) {
        fetch(`/book/addToCart`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: evt.params.id,
                type: 'product',
                size: evt.params.size
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
                    var pageloaderTimeout = setTimeout(function() {
                        pageloader.classList.toggle('is-active');
                        clearTimeout(pageloaderTimeout);
                    }, 3000);
                }
                document.getElementById('conclude-button').classList.remove('is-hidden');
            })
    }

    openTab(evt) {
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
}