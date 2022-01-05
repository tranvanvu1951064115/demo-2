import {$,$$} from '../variables.js';
export function enablePostTweet() {
    let postTweetBtn = $$('.content__tweet-btn');
    postTweetBtn = [...postTweetBtn];
    const postText = $$('.content__tweet-input');
    [...postText].forEach((input, index) => {
        input.addEventListener('input', function(e) {  
            const amountOfImageUploaded = document.querySelectorAll('.content__new-tweet-box-image > div').length;
            if(this.value == '' && amountOfImageUploaded == 0) {
                postTweetBtn[index].disabled = true;
            } else {
                postTweetBtn[index].disabled = false;
            }
        })
    })
} 