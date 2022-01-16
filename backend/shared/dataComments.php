<?php 
    $listComment = '';
    if (count($tweetComments) > 0) {
        foreach ($tweetComments as $row) {
            // 1. CHO PHÉP NGƯỜI DÙNG XÓA TWEET HAY KHÔNG
            //    CÓ KHI VÀ CHỈ KHI NGƯỜI DÙNG LÀ NGƯỜI ĐÃ TẠO RA TWEET
            // 2. XỬ LÝ HIỆN RA 'YOU' NẾU NHƯ NGƯỜI DÙNG ĐANG TỰ COMMENT CHÍNH MÌNH
            $deleteFuntion = false;
            if($row['comment_by'] == $user->user_id) {
                $deleteFuntion = "<a class='content__tweet-delete' onclick = 'handleDelComment(event,{$row['comment_id']});'>
                                    <i class='far fa-trash-alt'></i>
                                    Delete
                                </a>";
            }
            // LẤY DỮ LIỆU NGƯỜI ĐÃ COMMENT 
            $userComment = userData($row['comment_by']);        
            $linkProfile = "profile?userProfile=$userComment->user_id";    
            // LẤY LINK ẢNH NGƯỜI DÙNG
            $imageAvatar = getLinkImage($userComment)['imageAvatar'];

            $listComment .= "<li class='content__tweet-comments-item content__tweet' data-id='{$row['comment_id']}'>
                        <img width='40px' height='40px' src='$imageAvatar' alt='' class='content__tweet-user-avatar'>
                        <div class='content__tweet-content'>
                            <div class='content__tweet-user-info'>
                                <div class='content__tweet-user-name'>
                                    <a href='$linkProfile' class='content__tweetby'>$userComment->user_firstName $userComment->user_lastName</a>
                                    <span>@$userComment->user_userName</span>
                                    <span class='time-post-tweet'>{$row['comment_at']}</span>
                                </div>
                                <div class='content__tweet-user-status'>
                                    <p>{$row['comment_status']}</p>
                                </div>
                            </div>
                        </div>
                        <div class='content__tweet-detail'>
                            <i class='fas fa-ellipsis-h'></i>
                            $deleteFuntion
                        </div>
                    </li>";
        }
    }
    echo $listComment;
?>