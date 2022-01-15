// handleLoveTweet(event, {$row['tweet_id']}, {$user->user_id});
function handleLoveTweet(event, tweet, user) {
    // TĂNG SỐ LƯỢNG LOVE UI
    event.preventDefault();
    event.stopPropagation();
    const loveBtn = event.target;
    if(loveBtn.classList.contains('content__tweet-love')) {
        $.ajax({
            url: 'backend/functions/process/handleLoveTweet.php',
            type: 'POST',
            data: {
                forTweet: tweet,
                loveBy: user
            },
            success: function(amountLove) {
                if(amountLove > 0) {
                    loveBtn.setAttribute('data-loves', amountLove);
                    loveBtn.classList.add('active');
                } else {
                    loveBtn.setAttribute('data-loves', '');
                    loveBtn.classList.remove('active');
                }
                insertNotification(user, tweet, "love");
            }                    
        });
    }
}

function insertNotification(user, tweet, type) {
    // 2. GỬI ĐỂ XỬ LÝ
    $.ajax({
        url: 'backend/functions/process/sendNotification.php',
        type: 'POST',
        data: {
            userReply: user,
            forTweet: tweet,
            type,
        },
        success(data) {
            console.log(data);
        }                  
    });
}