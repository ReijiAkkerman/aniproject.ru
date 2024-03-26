class Popup {
    static week_status;
    static set_time_status;
    static interval_status;
    static repeat_prompt_status;
    static without_time_status;
    static to_end_day_status;
    static cathegories_disabled;
    static tasks_disabled;
    static links_status;

    constructor() {
        Popup.repeat_prompt_status = 0;
        Popup.cathegories_disabled = false;
        Popup.tasks_disabled = true;
    }

    static showForm() {
        let element = document.querySelector('.NewEntry');
        element.style.display = 'flex';
    }

    static hideForm() {
        let element = document.querySelector('.NewEntry');
        element.style.display = 'none';
    }

    static stop(event) {
        event.stopPropagation();
    }

    static showFormWeek() {
        if(typeof Popup.week_status === 'undefined')
            Popup.week_status = false;
        let element = document.querySelector('.NewEntry .Supplement .Week');
        if(Popup.week_status) {
            element.style.display = 'none';
            Popup.week_status = false;
        }
        else {
            element.style.display = 'flex';
            Popup.week_status = true;
        }
    }

    static showFormSetTime() {
        if(typeof Popup.set_time_status === 'undefined')
            Popup.set_time_status = false;
        let elements = document.querySelectorAll('.NewEntry .Supplement .SetTime');
        if(Popup.set_time_status) {
            for(let i = 0; i < elements.length; i++) {
                elements[i].style.display = 'none';
            }
            Popup.set_time_status = false;
        }
        else {
            for(let i = 0; i < elements.length; i++) {
                elements[i].style.display = 'block';
            }
            Popup.set_time_status = true;
        }
    }

    static showFormInterval() {
        if(typeof Popup.interval_status === 'undefined')
            Popup.interval_status = false;
        let element = document.querySelector('.NewEntry .Supplement .Interval');
        let set_time_button = document.querySelector('.NewEntry .set_time');
        if(Popup.interval_status) {
            element.style.display = 'none';
            set_time_button.style.display = 'none';
            Popup.interval_status = false;
        }
        else {
            element.style.display = 'flex';
            set_time_button.style.display = 'block';
            Popup.hideDefaultRepeats();
            Popup.interval_status = true;
        }
    }

    static showFormRepeatPrompt() {
        if(typeof Popup.repeat_prompt_status === 'undefined')
            Popup.repeat_prompt_status = 0;
        let element = document.querySelector('.RepeatUpTo');
        if(Popup.repeat_prompt_status) 
            element.style.display = 'block';
        else 
            element.style.display = 'none';
    }

    static hideDefaultRepeats() {
        let element;
        let $array = ['#every_year', '#every_day', '#every_month', '#every_week'];
        for(let i = 0; i < $array.length; i++) {
            element = document.querySelector($array[i]);
            element.checked = false;
        }
        Popup.repeat_prompt_status = 0;
        Popup.week_status = true;
        Popup.showFormWeek();
        Popup.showFormRepeatPrompt();
    }

    static checkWithoutTime(event) {
        event.preventDefault();
        if(typeof Popup.without_time_status == 'undefined')
            Popup.without_time_status = false;
        let to_end_day_input = document.querySelector('input[name="to_end_day"]');
        let without_time_input = document.querySelector('input[name="without_time"]');
        let button_start = document.querySelector('#DateTime_start');
        let button_end = document.querySelector('#DateTime_end');
        let inputs = document.querySelectorAll('.NewEntry form .Date input[type="text"]');
        let labels = document.querySelectorAll('.NewEntry form .Date p');
        if(Popup.without_time_status == false) {
            button_start.style.textDecoration = 'line-through';
            button_end.style.textDecoration = 'line-through';
            for(let i = 0; i < inputs.length; i++) {
                inputs[i].style.borderColor = '#aaa';
                inputs[i].setAttribute('readonly', '');
                labels[i].style.color = '#aaa';
            }
            without_time_input.value = 'on';
            to_end_day_input.value = '';
            Popup.without_time_status = true;
        }
        else {
            button_start.style.textDecoration = 'none';
            button_end.style.textDecoration = 'none';
            for(let i = 0; i < inputs.length; i++) {
                inputs[i].style.borderColor = '#000';
                inputs[i].removeAttribute('readonly');
                labels[i].style.color = '#000';
            }
            without_time_input.value = '';
            Popup.without_time_status = false;
            Popup.keepToEndDay_status();
        }
    }

    static checkToEndDay(event) {
        event.preventDefault();
        if(!Popup.without_time_status) {
            if(typeof Popup.to_end_day_status == 'undefined')
                Popup.to_end_day_status = false;
            let to_end_day_input = document.querySelector('input[name="to_end_day"]');
            let button_end = document.querySelector('#DateTime_end');
            let end_inputs = document.querySelectorAll('.NewEntry form .Date .end input[type="text"]');
            let end_labels = document.querySelectorAll('.NewEntry form .Date .end p');
            if(Popup.to_end_day_status == false) {
                button_end.textContent = 'До конца дня';
                for(let i = 0; i < end_inputs.length; i++) {
                    end_inputs[i].style.borderColor = '#aaa';
                    end_inputs[i].setAttribute('readonly', '');
                    end_labels[i].style.color = '#aaa';
                }
                to_end_day_input.value = 'on'
                Popup.to_end_day_status = true;
            }
            else {
                button_end.textContent = 'Конец';
                for(let i = 0; i < end_inputs.length; i++) {
                    end_inputs[i].style.borderColor = '#000';
                    end_inputs[i].removeAttribute('readonly');
                    end_labels[i].style.color = '#000';
                }
                to_end_day_input.value = '';
                Popup.to_end_day_status = false;
            }
        }
    }

    static keepToEndDay_status() {
        let to_end_day_input = document.querySelector('input[name="to_end_day"]');
        let button_end = document.querySelector('#DateTime_end');
        let end_inputs = document.querySelectorAll('.NewEntry form .Date .end input[type="text"]');
        let end_labels = document.querySelectorAll('.NewEntry form .Date .end p');
        if(Popup.to_end_day_status == true) {
            button_end.textContent = 'До конца дня';
            for(let i = 0; i < end_inputs.length; i++) {
                end_inputs[i].style.borderColor = '#aaa';
                end_inputs[i].setAttribute('readonly', '');
                end_labels[i].style.color = '#aaa';
            }
            to_end_day_input.value = 'on';
        }
        else {let title = document.querySelector('.NewEntry .Adds p.bold');
        let caths = document.querySelector('.NewEntry .Adds .changeable.cathegories');
        let tasks = document.querySelector('.NewEntry .Adds .changeable.tasks');
            button_end.textContent = 'Конец';
            for(let i = 0; i < end_inputs.length; i++) {
                end_inputs[i].style.borderColor = '#000';
                end_inputs[i].removeAttribute('readonly');
                end_labels[i].style.color = '#000';
            }
            to_end_day_input.value = '';
        }
    }

    static switchToCathegories(event) {
        event.preventDefault();
        if(Popup.cathegories_disabled) {
            let caths_button = document.querySelector('.NewEntry .Adds .switchTo > button:first-of-type > svg');
            let tasks_button = document.querySelector('.NewEntry .Adds .switchTo > button:last-of-type > svg');
            let title = document.querySelector('.NewEntry .Adds p.bold');
            let caths = document.querySelector('.NewEntry .Adds .changeable.cathegories');
            let tasks = document.querySelector('.NewEntry .Adds .changeable.tasks');
            title.textContent = 'Категории';
            tasks.style.display = 'none';
            caths.style.display = 'flex';
            caths_button.style.fill = '#aaa';
            tasks_button.style.fill = '#000';
            Popup.cathegories_disabled = false;
            Popup.tasks_disabled = true;
        }
    }

    static switchToTasks(event) {
        event.preventDefault();
        if(Popup.tasks_disabled) {
            let caths_button = document.querySelector('.NewEntry .Adds .switchTo > button:first-of-type > svg');
            let tasks_button = document.querySelector('.NewEntry .Adds .switchTo > button:last-of-type > svg');
            let title = document.querySelector('.NewEntry .Adds p.bold');
            let caths = document.querySelector('.NewEntry .Adds .changeable.cathegories');
            let tasks = document.querySelector('.NewEntry .Adds .changeable.tasks');
            title.textContent = 'Задачи';
            caths.style.display = 'none';
            tasks.style.display = 'flex';
            caths_button.style.fill = '#000';
            tasks_button.style.fill = '#aaa';
            Popup.cathegories_disabled = true;
            Popup.tasks_disabled = false;
        }
    }

    hideRestRepeats() {
        let element;
        let $array = ['#every_year', '#every_day', '#every_month', '#every_week'];
        for(let i = 0; i < $array.length; i++) {
            element = document.querySelector($array[i]);
            if(element.id == this.id && element.id == 'every_week') {
                if(element.checked) 
                    Popup.week_status = false;
                else 
                    Popup.week_status = true;
                Popup.showFormWeek();
                continue;
            }
            else if(element.id == this.id) {
                Popup.week_status = true;
                Popup.showFormWeek();
                continue;
            }
            else {
                element.checked = false;
            }
        }
    }

    isCheckedInput() {
        let element = document.querySelector('#interval');
        if(this.checked) {
            Popup.repeat_prompt_status = 1;
            element.checked = false;
            Popup.interval_status = true;
            Popup.showFormInterval();
        }
        else {
            Popup.repeat_prompt_status = 0;
        }
    }

    focus() {
        if(this.localName == 'form') {
            let prompt = document.querySelector('.RepeatUpTo');
            prompt.style.zIndex = 11;
        }
        else {
            this.style.zIndex = 20;
        }
    }
}

export {Popup};

var calendar_popup = new Popup();

document.addEventListener('DOMContentLoaded', function() {
    let element;
    for(let element of document.querySelectorAll('.calendar .Calendar .Day .Header > button')) {
        element.addEventListener('click', Popup.showForm);
    }
    element = document.querySelector('.NewEntry');
    element.addEventListener('click', Popup.hideForm);
    element = document.querySelector('.NewEntry > form');
    element.addEventListener('click', calendar_popup.focus);
    element.addEventListener('click', Popup.stop);
    element = document.querySelector('#set_time');
    element.addEventListener('click', Popup.showFormSetTime);
    element = document.querySelector('#interval');
    element.addEventListener('click', Popup.showFormInterval);
    let $array = ['#every_year', '#every_day', '#every_month', '#every_week'];
    for(let i = 0; i < $array.length; i++) {
        element = document.querySelector($array[i]);
        element.addEventListener('click', calendar_popup.hideRestRepeats);
        element.addEventListener('click', calendar_popup.isCheckedInput);
        element.addEventListener('click', Popup.showFormRepeatPrompt);
    }
    element = document.querySelector('.RepeatUpTo');
    element.addEventListener('click', calendar_popup.focus);
    element.addEventListener('click', Popup.stop);
    element = document.querySelector('#DateTime_start');
    element.addEventListener('click', Popup.checkWithoutTime);
    element = document.querySelector('#DateTime_end');
    element.addEventListener('click', Popup.checkToEndDay);
    element = document.querySelector('.NewEntry .Adds .switchTo > button:first-of-type');
    element.addEventListener('click', Popup.switchToCathegories);
    element = document.querySelector('.NewEntry .Adds .switchTo > button:last-of-type');
    element.addEventListener('click', Popup.switchToTasks);
});