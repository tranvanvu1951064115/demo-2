// PHẦN CHƯƠNG TRÌNH XỬ LÝ COMMENT
function handleComment(event, userReply, forTweet) {
    event.preventDefault();
    event.stopPropagation();
    const buttonComment = event.target;
    if(buttonComment.classList.contains('content__tweet-btn')) {
        $.ajax({
            url: 'backend/functions/process/handleComment.php',
            type: 'POST',
            data: {
                userReply,
                forTweet,
                statusComment: buttonComment.parentElement.querySelector('textarea.content__tweet-input').value
            },
            success(amountofComment) { 
                if(location.href.indexOf('tweetWithComments') > 0) {
                    location.reload();
                } else {
                    $('.content__tweet-reply').attr('data-comments', amountofComment);
                }
                // XỬ LÝ PHẦN AJAX ĐỂ HIỂN THỊ THÔNG BÁO CHO NGƯỜI DÙNG
                // 1. CHÈN DỮ LIỆU CHO NGƯỜI DÙNG
                insertNotification(userReply, forTweet, "comment");
            }                  
        });
    }   

    // Ẩn box
    $(`.content__tweet-reply-content[data-tweet="${forTweet}"]`).css('display', 'none');
}


function insertNotification(userReply, forTweet, type) {
    // 2. GỬI ĐỂ XỬ LÝ 
    $.ajax({
        url: 'backend/functions/process/sendNotification.php',
        type: 'POST',
        data: {
            userReply,
            forTweet,
            type,
        },
        success(data) {
            // console.log(data);
        }                  
    });
}