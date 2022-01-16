<?php
// Thiết lập tiêu đề tương ứng với từng trang
$pageTitle = "Message / Twitter";

// Kết nối cơ sở dữ liệu
include 'backend/initialize.php';

// Lấy dữ liệu header từ tệp header
include 'backend/shared/header.php';

// KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0)) {
    header("location: index.php");
}

$user = userData($_SESSION['isLogginOK']);

// THÔNG BÁO CỦA NGƯỜI DÙNG
$notifications = getInfo('tb_notifications', ['*'], ['notification_for' => $user->user_id, 'notification_state' => 1], null, null);
if(count($notifications) > 0) {
    $activeNotif = 'active';
} else {
    $activeNotif = 'none';
}

// LẤY DỮ LIỆU ẢNH NGƯỜI ĐANG LOGIN
$imageAvatarOfUserLogined = getLinkImage($user)['imageAvatar'];

echo "<script src='./frontend/assets/js/leftSideBar/active.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/leftSideBar/popUpUserLogout.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/message/popUpBoxMessage.js' defer></script>";

?>
<div class="wrapper">
    <div class='overlay'></div>
    <div class="container">
        <div class="row">
            <!----- LEFT SIDE BAR ----->
            <?php include 'backend/shared/leftSidebar.php'; ?>
            <!-- MAIN SECTION -->
            <div class="main col-md-9 p-0 row">
                <!-- CONTENT SECTION -->
                <div class="content col-md-7">
                    <div class="content__header">
                        <h2 class="mb-0 text-primary">
                            <a href="home.php">
                                <i class="fas fa-arrow-left d-inline-block me-3"></i>
                            </a>
                            Message
                        </h2>
                        <a class="content__openBoxSearchUser">
                            <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M23.25 3.25h-2.425V.825c0-.414-.336-.75-.75-.75s-.75.336-.75.75V3.25H16.9c-.414 0-.75.336-.75.75s.336.75.75.75h2.425v2.425c0 .414.336.75.75.75s.75-.336.75-.75V4.75h2.425c.414 0 .75-.336.75-.75s-.336-.75-.75-.75zm-3.175 6.876c-.414 0-.75.336-.75.75v8.078c0 .414-.337.75-.75.75H4.095c-.412 0-.75-.336-.75-.75V8.298l6.778 4.518c.368.246.79.37 1.213.37.422 0 .844-.124 1.212-.37l4.53-3.013c.336-.223.428-.676.204-1.012-.223-.332-.675-.425-1.012-.2l-4.53 3.014c-.246.162-.563.163-.808 0l-7.586-5.06V5.5c0-.414.337-.75.75-.75h9.094c.414 0 .75-.336.75-.75s-.336-.75-.75-.75H4.096c-1.24 0-2.25 1.01-2.25 2.25v13.455c0 1.24 1.01 2.25 2.25 2.25h14.48c1.24 0 2.25-1.01 2.25-2.25v-8.078c0-.415-.337-.75-.75-.75z"/></g></svg>
                        </a>
                    </div>
                    <div class="content__new-message-box">
                        <div class="content__new-message-box-main">
                            <div class="content__new-message-box-header">
                                <div class="content__new-message-box-control d-flex justify-content-between align-items-center">
                                    <div class="content__new-message-box-control-left">
                                        <span class="close me-3">
                                            <i class="bi bi-x-circle fs-5"></i>
                                        </span>
                                        <span class="fw-bold">New message</span>
                                    </div>
                                    <a href="#" class="btn btn--primary">Next</a>
                                </div>
                                <div class="content__new-message-box-search">
                                    <input class="w-100" type="text" name="searchUsername" id="searchUsername" placeholder="Search for user...">
                                    <span>
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- RIGHT SIDE BAR SECTION -->
                <div class="r-sidebar col-md-5 d-flex flex-column justify-content-center">
                    <div class="r-sidebar__context ms-5">
                        <p class="text-primary fw-bolder">You don’t have a message selected</p>
                        <span class="d-block text-secondary mb-3 mt-3">Choose one from your existing messages, or start a new one.</span>
                        <a href="#" class="btn btn--primary content__openBoxSearchUser">New message</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
// Thực hiện gọi footer
include 'backend/shared/footer.php';
?>