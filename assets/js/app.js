import '../css/app.scss';
import { Dropdown } from "bootstrap";
import { async } from 'regenerator-runtime';

document.addEventListener('DOMContentLoaded', () => {
    new App();
});

// Enable Bootstrap dropdowns
const enableDropdowns = () => {
    const aDropDownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    aDropDownElementList.map(
        function (dropDownToggleElement) {
            return new Dropdown(dropDownToggleElement);
        }
    );
}

class App {
    constructor() {
        this.enableDropdowns();
        this.handleCommentFrom();
    }

    enableDropdowns() {
        const aDropDownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        aDropDownElementList.map(
            function (dropDownToggleElement) {
                return new Dropdown(dropDownToggleElement);
            }
        );
    }

    handleCommentFrom() {
        const oCommentForm = document.querySelector('form.comment-form');
        if (oCommentForm === null) {
            return;
        }
        oCommentForm.addEventListener('submit', async (oEvent) => {
            oEvent.preventDefault();
            const $oResponse = await fetch('/ajax/comments', {
                method: 'POST',
                body: new FormData(oEvent.target)
            });

            if (!$oResponse.ok) {
                return;
            }

            const aJson = await $oResponse.json();
            if (aJson.code === 'COMMENT_ADDED_SUCCESSFULLY') {
                const oCommentList = document.querySelector('.comment-list');
                const oCommentCount = document.querySelector('.comment-count');
                const oCommentAreaContent = document.querySelector('#comment_content');
                oCommentList.insertAdjacentHTML('beforeend', aJson.message);
                oCommentList.lastElementChild.scrollIntoView();
                oCommentCount.innerText = aJson.numberOfComment;
                oCommentAreaContent.value = '';
            }
        })
    }
}