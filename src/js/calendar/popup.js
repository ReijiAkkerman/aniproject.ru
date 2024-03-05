class Popup {
    static week_status;
    static set_time_status;
    static interval_status;
    static repeat_prompt_status;

    constructor() {
        Popup.repeat_prompt_status = 0;
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
        let $array = ['#year', '#day', '#month', '#week'];
        for(let i = 0; i < $array.length; i++) {
            element = document.querySelector($array[i]);
            element.checked = false;
        }
        Popup.repeat_prompt_status = 0;
        Popup.week_status = true;
        Popup.showFormWeek();
        Popup.showFormRepeatPrompt();
    }

    hideRestRepeats() {
        let element;
        let $array = ['#year', '#day', '#month', '#week'];
        for(let i = 0; i < $array.length; i++) {
            element = document.querySelector($array[i]);
            if(element.id == this.id && element.id == 'week') {
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
            Popup.repeat_prompt_status++;
            element.checked = false;
            Popup.interval_status = true;
            Popup.showFormInterval();
        }
        else {
            Popup.repeat_prompt_status--;
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
    let $array = ['#year', '#day', '#month', '#week'];
    for(let i = 0; i < $array.length; i++) {
        element = document.querySelector($array[i]);
        element.addEventListener('click', calendar_popup.hideRestRepeats);
        element.addEventListener('click', calendar_popup.isCheckedInput);
        element.addEventListener('click', Popup.showFormRepeatPrompt);
    }
    element = document.querySelector('.RepeatUpTo');
    element.addEventListener('click', calendar_popup.focus);
    element.addEventListener('click', Popup.stop);
});