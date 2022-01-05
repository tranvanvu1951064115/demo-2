<?php 
    include '../../initialize.php';
    if(is_post_request() && $_POST['forTweet'] && $_POST['loveBy']) {
        // KIỂM TRA NGƯỜI DÙNG ĐÃ CLICK LOVE TWEET THÀNH CÔNG => CHÈN VÀO TRONG CSDL
        $amountLovedByUser = getInfo('tb_loves', ['love_id'], ['love_by'=>$_POST['loveBy'], 'love_forTweet'=>$_POST['forTweet']], null, null);
        if(count($amountLovedByUser) > 0) {
            delete('tb_loves', ['love_by'=> $_POST['loveBy'], 'love_forTweet'=>$_POST['forTweet']]);
        } else {
            insert('tb_loves', ['love_by' => $_POST['loveBy'], 'love_forTweet' => $_POST['forTweet']]);
        }
        $love =  getInfo('tb_loves', ['love_id'], ['love_forTweet'=>$_POST['forTweet']], null, null);
        echo count($love);
    }
?>