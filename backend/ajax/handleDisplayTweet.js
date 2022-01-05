function handleDisplayTweet(event, tweetId) {
    event.preventDefault();
    event.stopPropagation();
    // // CHUYỂN HƯỚNG ĐẾN TRANG XỬ LÝ
    const box = event.target;
    const mustnotTargets = ['content__tweetby', 'content__tweetby fs-5', 'content__tweet-detail'];
    if(!mustnotTargets.includes(box.classList.value)) {
        location.href = `http://localhost/twitter/tweetWithComments?tweetId=${tweetId}`;
    }
}