function openReply(event) {
    event.stopPropagation();
    const buttonReply = event.target;
    if(buttonReply.classList.contains('content__tweet-reply')) { 
        const replyBox = buttonReply.querySelector('.content__tweet-reply-content');
        replyBox.style.display = 'unset';
    }
}

function closeReply(event) {
    event.stopPropagation();
    const closeReply = event.target;
    const replyBox = closeReply.parentElement;
    replyBox.style.display = 'none';
}
