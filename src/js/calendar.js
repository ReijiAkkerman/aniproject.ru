import {Popup} from "./calendar/popup.js";

document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener("keydown", function(event) {
        console.log("Нажата клавиша Home. Код: 0x" + event.keyCode.toString(16));
    });
});