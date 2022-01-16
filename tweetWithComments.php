<?php
// Thiết lập tiêu đề tương ứng với từng trang
$pageTitle = "Tweets / Twitter";

// Kết nối cơ sở dữ liệu
include 'backend/initialize.php';

// Lấy dữ liệu header từ tệp header
include 'backend/shared/header.php';

// KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0)) {
    header("location: index.php");
}

$user = userData($_SESSION['isLogginOK']); // USER ĐANG LOGGIN
$tweet = getInfo('tb_tweets', ['*'], ['tweet_id' => $_GET['tweetId']], null, null)['0'];
$userOfTweet = userData($tweet['tweet_by']); // CHỦ TWEET
$tweetComments = getInfo('tb_comment', ['*'], ['comment_on' => $_GET['tweetId']], null, null);

echo "<script src='./frontend/assets/js/leftSideBar/active.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/leftSideBar/popUpUserLogout.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/app.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/handleReply.js' defer></script>";
// echo "<script src='./backend/ajax/handleTweet.js' type='module' defer></script>";
echo "<script src='./backend/ajax/handleDelTweet.js' defer></script>";
echo "<script src='./backend/ajax/handleLoveTweet.js' defer></script>";
echo "<script src='./backend/ajax/handleComment.js' defer></script>";
echo "<script src='./backend/ajax/handleDisplayTweet.js' defer></script>";
echo "<script src='./backend/ajax/handleDelComment.js' defer></script>";
echo "<script src='./backend/ajax/handleFollow.js' defer></script>";

// LẤY DỮ LIỆU ẢNH NGƯỜI ĐANG LOGIN
$imageAvatarOfUserLogined = getLinkImage($user)['imageAvatar'];
$imageCoverOfUserLogined = getLinkImage($user)['imageCover'];

// LẤY DỮ LIỆU ẢNH CỦA CHỦ TWEET
$imageForOwnTweet = getLinkImage($userOfTweet)['imageAvatar'];

// THÔNG BÁO CỦA NGƯỜI DÙNG
$notifications = getInfo('tb_notifications', ['*'], ['notification_for' => $user->user_id, 'notification_state' => 1], null, null);
if (count($notifications) > 0) {
    $activeNotif = 'active';
} else {
    $activeNotif = 'none';
}

?>
<div class="wrapper">
    <div class='overlay'></div>
    <div class="container">
        <div class="row">
            <!----- LEFT SIDE BAR ----->
            <?php include 'backend/shared/leftSidebar.php'; ?>
            <!-- MAIN SECTION -->
            <div class="main col-xl-6 col-lg-9 col-md-10 col-sm-10">
                <!-- CONTENT SECTION -->
                <div class="content">
                    <div class="content__header">
                        <h2 class="mb-0 text-primary">
                            <a href="home.php">
                                <i class="fas fa-arrow-left d-inline-block me-3"></i>
                            </a>
                            Tweet
                        </h2>
                        <a href="$" class="content__topTweet">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-18jsvk2 r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03">
                                <g>
                                    <path d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <?php
                    // XỬ LÝ LẤY NHỮNG LOVES CỦA TWEET
                    $love =  getInfo('tb_loves', ['love_id'], ['love_forTweet' => $tweet['tweet_id']], null, null);
                    $amountLove = count($love);
                    $activeLove = '';
                    if ($amountLove > 0) {
                        $activeLove = 'active';
                    } else {
                        $amountLove = '';
                    }

                    // XỬ LÝ ĐỂ LẤY NHỮNG COMMENT CỦA TWEET
                    $comment =  getInfo('tb_comment', ['comment_id'], ['comment_on' => $tweet['tweet_id']], null, null);
                    $amountComment = count($comment);

                    // 1. CHO PHÉP NGƯỜI DÙNG XÓA TWEET HAY KHÔNG
                    //    CÓ KHI VÀ CHỈ KHI NGƯỜI DÙNG LÀ NGƯỜI ĐÃ TẠO RA TWEET
                    // 2. XỬ LÝ HIỆN RA 'YOU' NẾU NHƯ NGƯỜI DÙNG ĐANG TỰ COMMENT CHÍNH TWEET
                    $deleteFuntion = false;
                    $isYourComment = $userOfTweet->user_userName; // LÀ NGƯỜI DÙNG KHÁC
                    if ($tweet['tweet_by'] == $user->user_id) {
                        $deleteFuntion = "<a class='content__tweet-delete' onclick = 'handleDelTweet(event,{$tweet['tweet_id']});'>
                                                    <i class='far fa-trash-alt'></i>
                                                    Delete
                                                </a>";
                        $isYourComment = 'you';
                    }

                    // LINK PROFILE
                    $linkProfile = "profile?userProfile=$userOfTweet->user_id";

                    // LẤY DỮ LIỆU ẢNH CHỦ TWEET
                    $avatarOwnTweet = getLinkImage($userOfTweet)['imageAvatar'];

                    // LẤY ẢNH CỦA NGƯỜI DÙNG ĐÃ ĐĂNG TẢI
                    $imagesOfTweet = getInfo('tb_uploadedimages', ['uploadedImage_link'], ['uploadedImage_forTweet' => $tweet['tweet_id']], null, null);
                    $imageForDisplay = '';
                    if (count($imagesOfTweet) > 0) {
                        foreach ($imagesOfTweet as $image) {
                            $imageForDisplay .= "<div class='container-post-image'><img src='backend/uploads/$userOfTweet->user_id/tweet-{$tweet['tweet_id']}-{$image['uploadedImage_link']}' alt=''></div>";
                        }
                    }
                    echo "<div class='content__tweet-main'>
                                        <li class='content__tweet' data-id='{$tweet['tweet_id']}' onclick='handleDisplayTweet(event, {$tweet['tweet_id']});'>
                                            <div class='content__tweet-reply-user-avatar content__tweet-reply-user-avatar-forcomment'>
                                                <img width='48px' height='48px' src='$avatarOwnTweet' alt='' class='content__tweet-user-avatar'>
                                            </div>
                                            <div class='content__tweet-content'>
                                                <div class='content__tweet-user-info'>
                                                    <div class='content__tweet-user-name d-flex align-items-center'>
                                                        <a href='$linkProfile' class='content__tweetby fs-5'>$userOfTweet->user_firstName $userOfTweet->user_lastName</a>
                                                        <span>@$userOfTweet->user_userName</span>
                                                        <span class='time-post-tweet'>{$tweet['tweet_postedOn']}</span>
                                                    </div>
                                                    <div class='content__tweet-user-status'>
                                                        <p class='fs-6'>{$tweet['tweet_status']}</p>
                                                    </div>
                                                </div>
                                                <div class='content__new-tweet-box-image content__new-tweet-box-image--uploaded mt-3 d-flex mb-3'>$imageForDisplay</div>
                                                <div class='content__tweet-react'>
                                                    <div class='content__tweet-reply' onclick='openReply(event);' data-comments='$amountComment'>
                                                        <svg width='30px' height='30px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                                                            <g>
                                                                <path
                                                                    d='M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z' />
                                                            </g>
                                                        </svg>
                                                        <div class='content__tweet-reply-content fixed-top' data-tweet='{$tweet['tweet_id']}'>
                                                            <span class='close' onclick='closeReply(event);'>
                                                                <i class='bi bi-x-lg'></i>
                                                            </span>
                                                            <div class='content__tweet-reply-user d-flex'>
                                                                <div class='content__tweet-reply-user-avatar'>
                                                                    <img width='40px' height='40px' src='$imageForOwnTweet' alt='' class='content__tweet-user-avatar'>
                                                                </div>
                                                                <div class='content__tweet-user-info'>
                                                                    <div class='content__tweet-user-name'>
                                                                        <b>$userOfTweet->user_firstName $userOfTweet->user_lastName</b>
                                                                        <span>@$userOfTweet->user_userName</span>
                                                                        <span class='time-post-tweet'>{$tweet['tweet_postedOn']}</span>
                                                                    </div>
                                                                    <div class='content__tweet-user-status'>
                                                                        <p class='mt-0 mb-3'>{$tweet['tweet_status']}</p>
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
                                                                            name='replyBtn' value='replyBtn' onclick='handleComment(event, $user->user_id, {$tweet['tweet_id']});' disabled>Tweet</button>
                                                                        </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href='#' class='content__tweet-retweet'>
                                                        <svg width='30px' height='30px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                                                            <g>
                                                                <path
                                                                    d='M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z' />
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <a class='content__tweet-love $activeLove' data-loves='$amountLove' onclick='handleLoveTweet(event, {$tweet['tweet_id']}, {$user->user_id});'>
                                                        <svg  width='30px' height='30px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
                                                            <g>
                                                                <path
                                                                    d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z' />
                                                            </g>
                                                        </svg>
                                                        <svg  width='30px' height='30px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>
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
                                        </li>
                                    </div>";
                    ?>
                    <div class="content__tweet-comments">
                        <!-- DISPLAY COMMENTS -->
                        <ul class="content__tweet-comments-menu">
                            <?php include 'backend/shared/dataComments.php'; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- RIGHT SIDE BAR SECTION -->
            <div class="r-sidebar col-xl-3 col-lg-3 col-md-3">
                <?php include 'backend/shared/r-sidebar.php'; ?> 
            </div>
        </div>

    </div>
</div>
<?php
// Thực hiện gọi footer
include 'backend/shared/footer.php';
?>