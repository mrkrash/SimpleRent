import { Controller } from '@hotwired/stimulus';
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from '@fullcalendar/daygrid';
import itLocale from '@fullcalendar/core/locales/it';

const calendarEl = document.getElementById('calendar');
const calendar = new Calendar(calendarEl, {
    plugins: [ dayGridPlugin, interactionPlugin ],
    headerToolbar: {
        left: 'prev',
        center: 'title',
        right: 'next'
    },
    locales: [ itLocale ],
    locale: 'it',
    selectable: true,
    selectOverlap: false,
});

export default class extends Controller {
    changeSize(e) {
        calendar.setOption("events", function (info, successCallback, failureCallback) {
            fetch(`/rest/booked/${e.params.id}/${e.target.value}/${info.start.valueOf()}/${info.end.valueOf()}`)
                .then(res => res.json())
                .then(json => successCallback(json));
        });
        calendar.setOption("select", function (info) {
            fetch(`/rest/calc/${e.params.id}/${info.start.valueOf()}/${info.end.valueOf()}`)
                .then(res => res.json())
                .then(json => {
                    document.getElementById('rate').value = json.rate;
                    document.getElementById("id").value = e.params.id;
                    document.getElementById("size").value = e.target.value;
                    document.getElementById("start").value = info.start.valueOf();
                    document.getElementById("end").value = info.end.valueOf();
                    document.getElementById('rentCTA').innerHTML = `Noleggia per sole € ${json.rate},00`;
                    document.getElementById('rentCTA').classList.remove('is-hidden');
                })
        });
        calendar.render();

    }
}