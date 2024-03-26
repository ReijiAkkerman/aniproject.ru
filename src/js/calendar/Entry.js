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

    static repeatUpTo_changingYear() {
        let year_input = document.querySelector('.RepeatUpTo .Date input[name="year"]');
        let year_output = document.querySelector('.NewEntry .Supplement .Hidden input[name="repeatUpTo_year"]');
        year_output.value = year_input.value;
    }

    static repeatUpTo_changingMonth() {
        let month_input = document.querySelector('.RepeatUpTo .Date input[name="month"]');
        let month_output = document.querySelector('.NewEntry .Supplement .Hidden input[name="repeatUpTo_month"]');
        month_output.value = month_input.value;
    }

    static repeatUpTo_changingDay() {
        let day_input = document.querySelector('.RepeatUpTo .Date .Hidden input[name="day"]');
        let day_output = document.querySelector('.NewEntry .Supplement .Hidden input[name="repeatUpTo_day"]');
        day_output.value = day_input.value;
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
        let full_selector;
        let main_selector = '.NewEntry .Main .Date ';
        let date_array = this.parentNode.parentNode.className.split('_');
        for(let i = 0; i < types.length; i++) {
            for(let j = 0; j < labels.length; j++) {
                full_selector = main_selector + '[name="' + types[i] + '_' + labels[j] + '"]';
                element = document.querySelector(full_selector);
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
        if($date.getHours() + 1 > 23) {
            form_elements[8].value = 23;
            form_elements[9].value = 59;
        }
        else {
            form_elements[8].value = $date.getHours() + 1;
            form_elements[9].value = $date.getMinutes();
        }
    }

    repeatUpTo_selectDate() {
        let date = this.className.split('_');
        let year = document.querySelector('.RepeatUpTo .Date input[name="year"]');
        let month = document.querySelector('.RepeatUpTo .Date input[name="month"]');
        let day = document.querySelector('.RepeatUpTo .Date input[name="day"]');
        let repeatUpTo_year = document.querySelector('.NewEntry .Supplement .Hidden input[name="repeatUpTo_year"]');
        let repeatUpTo_month = document.querySelector('.NewEntry .Supplement .Hidden input[name="repeatUpTo_month"]');
        let repeatUpTo_day = document.querySelector('.NewEntry .Supplement .Hidden input[name="repeatUpTo_day"]');
        repeatUpTo_year.value = year.value = date[3];
        repeatUpTo_month.value = month.value = date[2];
        repeatUpTo_day.value = day.value = date[1];
    }
}

export {Entry};

var entry = new Entry();

document.addEventListener('DOMContentLoaded', function() {
    let element;
    let elements;
    element = document.querySelector('#save_button');
    element.addEventListener('click', Entry.sendEntries);
    elements = document.querySelectorAll('.Calendar .Day button');
    for(let i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', entry.completeDateTime);
    }
    elements = document.querySelectorAll('.RepeatUpTo .Calendar > button');
    for(let i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', entry.repeatUpTo_selectDate);
    }
    element = document.querySelector('.RepeatUpTo .Date input[name="year"]');
    element.addEventListener('change', Entry.repeatUpTo_changingYear);
    element = document.querySelector('.RepeatUpTo .Date input[name="month"]');
    element.addEventListener('change', Entry.repeatUpTo_changingMonth);
    element = document.querySelector('.RepeatUpTo .Date input[name="day"]');
    element.addEventListener('change', Entry.repeatUpTo_changingDay);
});