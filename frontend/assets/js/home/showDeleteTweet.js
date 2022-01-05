import {$,$$} from '../variables.js';

export function showDeleteTweet() {
    const detailTweetBtn = $$('.content__tweet-detail');
    [...detailTweetBtn].forEach(button => {
        let event = new MouseEvent("click", {
            bubbles: false,
            cancelable: false,
            view: window,
        });
        
        // Send the event to the checkbox element
        button.dispatchEvent(event);
        button.addEventListener('click', function() {
            const deleteButton = button.querySelector('.content__tweet-delete');
            if(deleteButton) {
                deleteButton.classList.toggle('active');
            }
        })
    })
}