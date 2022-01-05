function handleDelTweet(event, tweetId) {
    event.preventDefault();
    event.stopPropagation();
    $.ajax({
        url: 'backend/functions/process/processDelTweet.php',
        type: 'POST',
        data: {
            tweetId: tweetId,
        },
        success: function(tweetId) {
            const currentLink = location.href;
            if(currentLink.indexOf('tweetWithComments') > 0) {
                location.href = 'http://localhost/twitter/home';
            }
            const tweet = $(`.content__tweet[data-id=${tweetId}]`);
            tweet.attr('style',  'display: none');
            tweet.parent().attr('style',  'margin: unset');
        }                    
    });
}