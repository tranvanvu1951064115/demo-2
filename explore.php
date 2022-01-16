<?php
// Thiết lập tiêu đề tương ứng với từng trang
$pageTitle = "Explore / Twitter";

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

// HIỂN THỊ THIẾT LẬP NHỮNG BÀI ĐĂNG NHIỀU NGƯỜI TƯƠNG TÁC NHẤT
$_SESSION['isExplore'] = true;

echo "<script src='./frontend/assets/js/leftSideBar/active.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/leftSideBar/popUpUserLogout.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/app.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/handleReply.js' defer></script>";
echo "<script src='./frontend/assets/js/home/navProfile.js' defer></script>";
echo "<script src='./frontend/assets/js/home/processDistImg.js' defer></script>";
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
                        <h2 class="mb-0 text-primary">
                            <a href="home.php">
                                <i class="fas fa-arrow-left d-inline-block me-3"></i>
                            </a>
                            Explore | Top Tweets
                        </h2>
                        <a href="$" class="content__topTweet">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-18jsvk2 r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03">
                                <g>
                                    <path d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <?php echo "<script src='./backend/ajax/handleSearchForRSideBar.js' defer></script>";?>
                    <!-- SEARCH SECTION -->
                    <div class="r-sidebar__header header-for-search">
                        <span class="search">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="searchTwitter" class="searchTwitter" placeholder="Search Twitter">
                        <!-- RESULT OF SEARCH -->
                        <ul class="r-sidebar__boxResultSearch r-sidebar__main-menu"></ul>
                    </div>
                    <div></div>
                    <!-- DISPLAY FOR TWEET -->
                    <ul class="content__tweets"></ul>
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