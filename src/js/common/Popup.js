class Popup {
    static links_status;
    static activities_status;

    static showLinks() {
        if(typeof Popup.links_status === 'undefined') 
            Popup.links_status = false;
        let element = document.querySelector('.Header .Links > div:first-of-type');
        if(Popup.links_status) {
            element.style.display = 'none';
            Popup.links_status = false;
        }
        else {
            element.style.display = 'flex';
            Popup.links_status = true;
        }
    }

    static showActivities() {
        if(typeof Popup.activities_status === 'undefined') 
            Popup.activities_status = false;
        let element = document.querySelector('.Header .Actions > div');
        if(Popup.activities_status) {
            element.style.display = 'none';
            Popup.activities_status = false;
        }
        else {
            element.style.display = 'flex';
            Popup.activities_status = true;
        }
    }

    showTitle() {
        let element = document.querySelector('.Header .Info > p');
        element.textContent = this.dataset['title'];
    }

    hideTitle() {
        let element = document.querySelector('.Header .Info > p');
        element.textContent = '';
    }
}

export {Popup};

let common = new Popup;

document.addEventListener('DOMContentLoaded', function() {
    let element;
    element = document.querySelector('.Header .Links .View > button');
    element.addEventListener('click', Popup.showLinks);
    let elements = document.querySelectorAll('button[data-title]');
    for(let i = 0; i < elements.length; i++) {
        element = elements[i];
        element.addEventListener('mouseover', common.showTitle);
        element.addEventListener('mouseout', common.hideTitle);
    }
    element = document.querySelector('.Header .Actions > button');
    element.addEventListener('click', Popup.showActivities);
});