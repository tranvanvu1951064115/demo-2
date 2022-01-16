<?php
// Thiết lập tiêu đề tương ứng với từng trang
$pageTitle = "Home / Twitter";

// Kết nối cơ sở dữ liệu
include 'backend/initialize.php';

// Lấy dữ liệu header từ tệp header
include 'backend/shared/header.php';

// KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0)) {
    header("location: index.php");
}

$user = userData($_SESSION['isLogginOK']);

// XÓA PHIÊN PROFILE
unset($_SESSION['userProfile']);

// LẤY DỮ LIỆU ẢNH NGƯỜI ĐANG LOGIN
$imageAvatarOfUserLogined = getLinkImage($user)['imageAvatar'];
$imageCoverOfUserLogined = getLinkImage($user)['imageCover'];

// THÔNG BÁO CỦA NGƯỜI DÙNG
$notifications = getInfo('tb_notifications', ['*'], ['notification_for' => $user->user_id, 'notification_state' => 1], null, null);
if(count($notifications) > 0) {
    $activeNotif = 'active';
} else {
    $activeNotif = 'none';
}

// RESET SESSION
unset($_SESSION['isExplore']);

echo "<script src='./frontend/assets/js/leftSideBar/active.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/leftSideBar/popUpUserLogout.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/processDisplayImageWhenUpload.js' defer></script>";
echo "<script src='./frontend/assets/js/home/app.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/handleReply.js' defer></script>";
echo "<script src='./frontend/assets/js/home/navProfile.js' defer></script>";
echo "<script src='./frontend/assets/js/home/processDistImg.js' defer></script>";
echo "<script src='./frontend/assets/js/profile/profileSetUpPopUp.js' defer></script>";
echo "<script src='./backend/ajax/handleTweet.js' type='module' defer></script>";
echo "<script src='./backend/ajax/handleDelTweet.js' defer></script>";
echo "<script src='./backend/ajax/handleLoveTweet.js' defer></script>";
echo "<script src='./backend/ajax/handleComment.js' defer></script>";
echo "<script src='./backend/ajax/handleDisplayTweet.js' defer></script>";
echo "<script src='./backend/ajax/handleFollow.js' defer></script>";
?>
<div class="wrapper">
    <div class='overlay'></div>
    <div class="container">
        <div class="row">
            <!----- LEFT SIDE BAR ----->
            <?php include 'backend/shared/leftSidebar.php'; ?>
            <!-- MAIN SECTION -->
            <div class="main col-xl-6 col-lg-9 col-md-10 col-sm-10 p-0">
                <!-- CONTENT SECTION -->
                <div class="content">
                    <div class="content__header">
                        <h2 class="mb-0 text-primary">Home</h2>
                        <a href="$" class="content__topTweet">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-18jsvk2 r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03">
                                <g>
                                    <path d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="content__post">
                        <form id="postTweetForm" action="#" method="post" class="content__post-form" enctype="multipart/form-data">
                            <div class="content__new-tweet">
                                <div class="content__new-tweet-input">
                                    <img width="48px" height="48px" src='<?php echo $imageAvatarOfUserLogined; ?>' alt="">
                                    <textarea id="contentText" class="content__tweet-input" name="contentText" maxlength="200" value="contentText" placeholder="What's happening?" required></textarea>
                                </div>
                                <div class="content__new-tweet-sub-post">
                                    <span class="control-post post-emoji">
                                        <!-- <input type="file" name="post-file-emoji" id="post-file-emoji"> -->
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-1cvl2hr r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03"><g><path d="M12 22.75C6.072 22.75 1.25 17.928 1.25 12S6.072 1.25 12 1.25 22.75 6.072 22.75 12 17.928 22.75 12 22.75zm0-20C6.9 2.75 2.75 6.9 2.75 12S6.9 21.25 12 21.25s9.25-4.15 9.25-9.25S17.1 2.75 12 2.75z"></path><path d="M12 17.115c-1.892 0-3.633-.95-4.656-2.544-.224-.348-.123-.81.226-1.035.348-.226.812-.124 1.036.226.747 1.162 2.016 1.855 3.395 1.855s2.648-.693 3.396-1.854c.224-.35.688-.45 1.036-.225.35.224.45.688.226 1.036-1.025 1.594-2.766 2.545-4.658 2.545z"></path><circle cx="14.738" cy="9.458" r="1.478"></circle><circle cx="9.262" cy="9.458" r="1.478"></circle></g></svg>
                                    </span>
                                    <span class="control-post post-location">
                                        <!-- <input type="file" name="post-file-location" id="post-file-location"> -->
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-1cvl2hr r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03"><g><path d="M12 14.315c-2.088 0-3.787-1.698-3.787-3.786S9.913 6.74 12 6.74s3.787 1.7 3.787 3.787-1.7 3.785-3.787 3.785zm0-6.073c-1.26 0-2.287 1.026-2.287 2.287S10.74 12.814 12 12.814s2.287-1.025 2.287-2.286S13.26 8.24 12 8.24z"></path><path d="M20.692 10.69C20.692 5.9 16.792 2 12 2s-8.692 3.9-8.692 8.69c0 1.902.603 3.708 1.743 5.223l.003-.002.007.015c1.628 2.07 6.278 5.757 6.475 5.912.138.11.302.163.465.163.163 0 .327-.053.465-.162.197-.155 4.847-3.84 6.475-5.912l.007-.014.002.002c1.14-1.516 1.742-3.32 1.742-5.223zM12 20.29c-1.224-.99-4.52-3.715-5.756-5.285-.94-1.25-1.436-2.742-1.436-4.312C4.808 6.727 8.035 3.5 12 3.5s7.192 3.226 7.192 7.19c0 1.57-.497 3.062-1.436 4.313-1.236 1.57-4.532 4.294-5.756 5.285z"></path></g></svg>
                                    </span>
                                    <span class="control-post post-image">
                                        <input type="file" name="file[]" id="post-file-image" multiple>
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-1cvl2hr r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03"><g><path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z"></path><circle cx="8.868" cy="8.309" r="1.542"></circle></g></svg>
                                    </span>
                                    <span class="control-post post-poll">
                                        <!-- <input type="file" name="post-file-poll" id="post-file-poll"> -->
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-1cvl2hr r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03"><g><path d="M20.222 9.16h-1.334c.015-.09.028-.182.028-.277V6.57c0-.98-.797-1.777-1.778-1.777H3.5V3.358c0-.414-.336-.75-.75-.75s-.75.336-.75.75V20.83c0 .415.336.75.75.75s.75-.335.75-.75v-1.434h10.556c.98 0 1.778-.797 1.778-1.777v-2.313c0-.095-.014-.187-.028-.278h4.417c.98 0 1.778-.798 1.778-1.778v-2.31c0-.983-.797-1.78-1.778-1.78zM17.14 6.293c.152 0 .277.124.277.277v2.31c0 .154-.125.28-.278.28H3.5V6.29h13.64zm-2.807 9.014v2.312c0 .153-.125.277-.278.277H3.5v-2.868h10.556c.153 0 .277.126.277.28zM20.5 13.25c0 .153-.125.277-.278.277H3.5V10.66h16.722c.153 0 .278.124.278.277v2.313z"></path></g></svg>
                                    </span>
                                </div>
                                <!-- IMAGE FOR UPLOADING -->
                                <div class="content__new-tweet-box-image content__new-tweet-box-image--uploading mt-3 d-flex">
                                    <!-- CONTENT -->
                                </div>
                                <button type="submit" id="submitBtn" class="content__tweet-btn btn btn--primary" name="tweetSubmit" value="tweetSubmit" disabled>Tweet</button>
                            </div>
                        </form>
                    </div>
                    <!-- DISPLAY FOR TWEET -->
                    <ul class="content__tweets"></ul>
                </div>
            </div>
            <!-- RIGHT SIDE BAR SECTION -->
            <div class="r-sidebar col-xl-3 col-lg-3 col-md-3">
                <div class="r-sidebar__container">
                    <?php include 'backend/shared/r-sidebar.php'; ?> 
                </div>
            </div>
        </div>

    </div>
</div>
<?php
// Thực hiện gọi footer
include 'backend/shared/footer.php';
?>