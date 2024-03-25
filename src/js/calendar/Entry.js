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

    completeDateTime() {
        let element;
        let form_elements = [];
        let types = [
            'start',
            'end'
        ];
        let labels = [
            'year',
            'month',
            'day',
            'hour',
            'minute'
        ];
        let main_selector = '.NewEntry .Main .Date ';
        let date_array = this.className.split('_');
        for(i = 0; i < types.length; i++) {
            for(j = 0; j < labels.length; j++) {
                element = document.querySelector(main_selector + types[i] + '_' + labels[j]);
                form_elements.push(element);
            }
        }
        let $date = new Date();
        form_elements[0].value = date_array[3];
        form_elements[1].value = date_array[2];
        form_elements[2].value = date_array[1];
        form_elements[5].value = date_array[3];
        form_elements[6].value = date_array[2];
        form_elements[7].value = date_array[1];

        form_elements[3].value = $date.getHours();
        form_elements[4].value = $date.getMinutes();
        if($date.getHours()++ > 23) {
            form_elements[8].value = 23;
            form_elements[9].value = 59;
        }
        else {
            form_elements[8].value = $date.getHours();
            form_elements[9].value = $date.getMinutes();
        }
    }
}

export {Entry};

document.addEventListener('DOMContentLoaded', function() {
    let element;
    element = document.querySelector('#save_button');
    element.addEventListener('click', Entry.sendEntries);
});