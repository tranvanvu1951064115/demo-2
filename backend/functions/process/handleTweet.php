<?php
include '../../initialize.php';
// KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0)) {
    header("location: ../../../index.php");
}

// LẤY DỮ LIỆU NGƯỜI DÙNG
$user = userData($_SESSION['isLogginOK']);


// ************************************************************************ XỬ LÝ CHÈN DỮ LIỆU ******************************************************************************** 
// ************************************************************************ XỬ LÝ CHÈN DỮ LIỆU ******************************************************************************** 
// ************************************************************************ XỬ LÝ CHÈN DỮ LIỆU ********************************************************************************

// XỬ LÝ TWEETS CỦA NGƯỜI DÙNG
if (isset($_POST['tweetSubmit']) && isset($_POST['status']) && $_POST['tweetSubmit'] && $_POST['status']) {
    $userId = $user->user_id;
    $status = $_POST['status'];
    // CHÈN TWEET VÀO TRONG CSDL
    $indexTweetInserted = insert('tb_tweets', array('tweet_status' => $status, 'tweet_by' => $userId));
    // header("Location: " . $_SERVER['REQUEST_URI']); // Reset POST với việc load lại trang
}

// XỬ LÝ CHÈN ẢNH VÀO TRONG CSDL
// CẬP NHẬT DỮ LIỆU ẢNH CỦA NGƯỜI DÙNG
if(is_array($_FILES) && isset($indexTweetInserted)) {
    $errorMessage = '';
    
    if($_POST['amountFile'] > 0) {
        // File upload path
        $targetDir =  $_SERVER['DOCUMENT_ROOT'].'/twitter/backend/uploads/'.$user->user_id.'/';

        for($i = 0; $i < $_POST['amountFile']; $i++) {
            // Lấy đường dẫn + tên file
            $targetFilePath = $targetDir ."tweet-$indexTweetInserted-". $_FILES['file']['name'][$i];
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
            // Tạo một thư mục mới trên server
            if(!file_exists($targetDir)) {
                mkdir("$targetDir", 0700);
            }
            // Upload file to serverbackend
            if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $targetFilePath)){
                // Insert image file name into database
                $sql = "INSERT INTO tb_uploadedimages(uploadedImage_link, uploadedImage_forTweet) VALUES (?, ?)";
                
                $stmt = $conn->prepare($sql);

                //Gán các biến (lúc này chưa mang giá trị) vào các placeholder theo thứ tự tương ứng
                $stmt->bindParam(1, $_FILES['file']['name'][$i]);
                $stmt->bindParam(2, $indexTweetInserted);
                
                // Thực thi sql
                $stmt->execute();
            } else {
                $errorMessage = "Sorry, there was an error uploading your file.";
            }
        }
    } 
    if($errorMessage != '') {
        echo $errorMessage;
    }
}

// ************************************************************************ XỬ LÝ TRẢ DỮ LIỆU ******************************************************************************** 
// ************************************************************************ XỬ LÝ TRẢ DỮ LIỆU ******************************************************************************** 
// ************************************************************************ XỬ LÝ TRẢ DỮ LIỆU ********************************************************************************

// XỬ LÝ LỌC NHỮNG TWEET CỦA NGƯỜI DÙNG
// NẾU KHÔNG PHẢI YÊU CẦU TỪ TRANG PROFILE THÌ RENDER THÊM NHỮNG TWEETS CỦA NGƯỜI ĐANG FOLLOW
if(isset($_SESSION['userProfile']) && $_SESSION['userProfile']) {
    $tweets = getInfo('tb_tweets', ['*'], ['tweet_by'=>$_SESSION['userProfile']], 'DESC', 'tweet_postedOn');
} else if(isset($_SESSION['isExplore'])){
    $sql = "SELECT * FROM VIEW_TOP_TWEET";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $tweets = getInfo('tb_tweets', ['*'], ['tweet_by'=>$user->user_id], 'DESC', 'tweet_postedOn');
    $userFollowing = getInfo('tb_follows', ['follow_following'], ['follow_user'=>$user->user_id], null, null);
    if(count($userFollowing) > 0) {
        foreach ($userFollowing as $row) {
            $tweetsByFollowing = getInfo('tb_tweets', ['*'], ['tweet_by'=>$row['follow_following']], 'DESC', 'tweet_postedOn');
            foreach($tweetsByFollowing as $row) {
                array_push($tweets, $row);
            }
        }
    }
}

if (count($tweets) > 0) {
    foreach ($tweets as $row) {
        // XỬ LÝ LẤY NHỮNG USER CỦA TWEETS
        $userOfTweet = userData($row['tweet_by']);

        // XỬ LÝ LẤY NHỮNG LOVES CỦA TWEET
        $love =  getInfo('tb_loves', ['love_id'], ['love_forTweet' => $row['tweet_id']], null, null);
        $amountLove = count($love);
        $activeLove = '';
        if ($amountLove > 0) {
            $activeLove = 'active';
        } else {
            $amountLove = '';
        }

        // XỬ LÝ ĐỂ LẤY NHỮNG COMMENT CỦA TWEET
        $comment =  getInfo('tb_comment', ['comment_id'], ['comment_on' => $row['tweet_id']], null, null);
        $amountComment = count($comment);

        // 1. CHO PHÉP NGƯỜI DÙNG XÓA TWEET HAY KHÔNG
        //    CÓ KHI VÀ CHỈ KHI NGƯỜI DÙNG LÀ NGƯỜI ĐÃ TẠO RA TWEET
        // 2. XỬ LÝ HIỆN RA 'YOU' NẾU NHƯ NGƯỜI DÙNG ĐANG TỰ COMMENT CHÍNH TWEET
        $deleteFuntion = false;
        $isYourComment = $userOfTweet->user_userName; // LÀ NGƯỜI DÙNG KHÁC
        if($row['tweet_by'] == $user->user_id) {
            $deleteFuntion = "<a class='content__tweet-delete' onclick = 'handleDelTweet(event,{$row['tweet_id']});'>
                                <i class='far fa-trash-alt'></i>
                                Delete
                              </a>";
            $isYourComment = 'you';
        }

        // LINK PROFILE
        $linkProfile = "profile?userProfile=$userOfTweet->user_id";

        // LẤY LINK ẢNH NGƯỜI DÙNG
        $imageCover = getLinkImage($userOfTweet)['imageCover'];
        $imageAvatar = getLinkImage($userOfTweet)['imageAvatar'];

        $imageAvatarOfUserLogined = getLinkImage($user)['imageAvatar'];
        $imageCoverOfUserLogined = getLinkImage($user)['imageCover'];

        // LẤY ẢNH CỦA NGƯỜI DÙNG ĐÃ ĐĂNG TẢI
        $imagesOfTweet = getInfo('tb_uploadedimages', ['uploadedImage_link'], ['uploadedImage_forTweet'=>$row['tweet_id']], null, null);
        $imageForDisplay = '';
        if(count($imagesOfTweet) > 0) {
            foreach($imagesOfTweet as $image) {
                if(count($imagesOfTweet) == 1)
                    $imageForDisplay .= "<div class='container-post-image w-100'><img src='backend/uploads/$userOfTweet->user_id/tweet-{$row['tweet_id']}-{$image['uploadedImage_link']}' alt=''></div>";
                else
                    $imageForDisplay .= "<div class='container-post-image'><img src='backend/uploads/$userOfTweet->user_id/tweet-{$row['tweet_id']}-{$image['uploadedImage_link']}' alt=''></div>";
            }
        }
        if(count($imagesOfTweet) == 1)
            $containerImgForEachTweet = "<div class='content__new-tweet-box-image content__new-tweet-box-image--uploaded mt-3 d-flex ms-0 me-0'>$imageForDisplay</div>";
        else 
            $containerImgForEachTweet = "<div class='content__new-tweet-box-image content__new-tweet-box-image--uploaded mt-3 d-flex '>$imageForDisplay</div>";


        // TRẢ VỀ DỮ LIỆU CỦA NGƯỜI DÙNG
        echo "
            <li class='content__tweet-container'>
                <div class='content__tweet' data-id='{$row['tweet_id']}' onclick='handleDisplayTweet(event, {$row['tweet_id']});'>
                    <img width='48px' height='48px' src='$imageAvatar' alt='' class='content__tweet-user-avatar'>
                    <div class='content__tweet-content'>
                        <div class='content__tweet-user-info'>
                            <div class='content__tweet-user-name'>
                                <a href='$linkProfile' class='content__tweetby' onclick='navProfile($userOfTweet->user_id);'>$userOfTweet->user_firstName $userOfTweet->user_lastName</a>
                                <span>@$userOfTweet->user_userName</span>
                                <span class='time-post-tweet'>{$row['tweet_postedOn']}</span>
                            </div>
                            <div class='content__tweet-user-status'>
                                <p>{$row['tweet_status']}</p>
                            </div>
                            $containerImgForEachTweet
                        </div>
                        <div class='content__tweet-react'>
                            <div class='content__tweet-reply' onclick='openReply(event);' data-comments='$amountComment'>
                                <svg width='20px' height='20px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                                    <g>
                                        <path
                                            d='M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z' />
                                    </g>
                                </svg>
                                <div class='content__tweet-reply-content fixed-top' data-tweet='{$row['tweet_id']}'>
                                    <span class='close' onclick='closeReply(event);'>
                                        <i class='bi bi-x-lg'></i>
                                    </span>
                                    <div class='content__tweet-reply-user d-flex'>
                                        <div class='content__tweet-reply-user-avatar'>
                                            <img width='40px' height='40px' src='$imageAvatar' alt='' class='content__tweet-user-avatar'>
                                        </div>
                                        <div class='content__tweet-user-info'>
                                            <div class='content__tweet-user-name'>
                                                <b>$userOfTweet->user_firstName $userOfTweet->user_lastName</b>
                                                <span>@$userOfTweet->user_userName</span>
                                                <span class='time-post-tweet'>{$row['tweet_postedOn']}</span>
                                            </div>
                                            <div class='content__tweet-user-status'>
                                                <p class='mt-0 mb-3'>{$row['tweet_status']}</p>
                                                <span class='content__tweet-post-owner'>Replying to <b>@$isYourComment</b></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='content__post'>
                                        <form id='postTweetForm' action='' method='post' class='content__post-form'>
                                            <div class='content__new-tweet'>
                                                <div class='content__new-tweet-input'>
                                                    <img width='40px' height='40px' src='$imageAvatarOfUserLogined'
                                                        alt=''>
                                                    <textarea class='content__tweet-input' name='contentText' maxlength='200'
                                                        value='contentText' placeholder='Tweet your reply...'></textarea>
                                                </div>
                                                <button id='replyBtn' class='content__tweet-btn btn btn--primary'
                                                    name='replyBtn' value='replyBtn' onclick='handleComment(event, $user->user_id, {$row['tweet_id']});' disabled>Tweet</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href='#' class='content__tweet-retweet'>
                                <svg width='20px' height='20px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                                    <g>
                                        <path
                                            d='M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z' />
                                    </g>
                                </svg>
                            </a>
                            <a class='content__tweet-love $activeLove' data-loves='$amountLove' onclick='handleLoveTweet(event, {$row['tweet_id']}, {$user->user_id});'>
                                <svg width='20px' height='20px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                                    <g>
                                        <path
                                            d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z' />
                                    </g>
                                </svg>
                                <svg width='20px' height='20px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                                    <g>
                                        <path
                                            d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z' />
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class='content__tweet-detail'>
                        <i class='fas fa-ellipsis-h'></i>
                        $deleteFuntion
                    </div>
                </div>
            </li>";
            
    }
}