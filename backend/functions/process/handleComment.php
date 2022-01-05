<?php 
    include '../../initialize.php';
    // KIỂM TRA NGƯỜI DÙNG ĐÃ CLICK COMMENT THÀNH CÔNG HAY CHƯA
    if(is_post_request() && $_POST['forTweet'] && $_POST['userReply']) {
        // KIỂM TRA XEM CÓ TWEET VỚI ID $_POST['forTweet'] TRONG CSDL HAY KHÔNG
        $tweet = getInfo('tb_tweets', ['tweet_id'], ['tweet_id'=>$_POST['forTweet']], null, null);
        // KIỂM TRA XEM CÓ USER VỚI ID $_POST['userReply'] TRONG CSDL HAY KHÔNG
        $commentBy = getInfo('tb_users', ['user_id'], ['user_id'=>$_POST['userReply']], null, null);

        if(count($tweet) > 0 && count($commentBy) > 0) { // DỮ LIỆU ĐÚNG
            // CHÈN COMMENT VÀO TRONG CSDL
            insert('tb_comment', ['comment_by' => $_POST['userReply'], 'comment_on' => $_POST['forTweet'], 'comment_status'=>$_POST['statusComment']]);
            // LẤY RA SỐ LƯỢNG COMMENT CỦA TWEET TƯƠNG ỨNG
            $tweetComments = getInfo('tb_comment', ['*'], ['comment_on'=>$_POST['forTweet']], null, null);
            echo count($tweetComments);
        }
    }
?>
