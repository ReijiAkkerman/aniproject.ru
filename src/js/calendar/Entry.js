class Entry {
    static sendEntries(event) {
        event.preventDefault();
        let element = document.querySelector('.NewEntry > form');
        let data = new FormData(element);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../calendar/entry/saveEntries');
        xhr.send(data);
        xhr.responseType = 'text';
        xhr.onload = () => {
            alert(xhr.response);
        };
    }
}

export {Entry};

document.addEventListener('DOMContentLoaded', function() {
    let element;
    element = document.querySelector('#save_button');
    element.addEventListener('click', Entry.sendEntries);
});