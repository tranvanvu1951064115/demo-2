<?php
// Thiết lập tiêu đề tương ứng với từng trang
$pageTitle = "Notification / Twitter";

// Kết nối cơ sở dữ liệu
include 'backend/initialize.php';

// Lấy dữ liệu header từ tệp header
include 'backend/shared/header.php';

// KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0)) {
    header("location: index.php");
}

$isPageNotice = true;

$user = userData($_SESSION['isLogginOK']);

// XÓA PHIÊN PROFILE
unset($_SESSION['userProfile']);

// LẤY DỮ LIỆU ẢNH NGƯỜI ĐANG LOGIN
$imageAvatarOfUserLogined = getLinkImage($user)['imageAvatar'];
$imageCoverOfUserLogined = getLinkImage($user)['imageCover'];

// THÔNG BÁO CỦA NGƯỜI DÙNG
$notifications = getInfo('tb_notifications', ['*'], ['notification_for' => $user->user_id], 'DESC', 'notification_on');
if(count($notifications) > 0) {
    $activeNotif = 'active';
} else {
    $activeNotif = 'none';
}

echo "<script src='./frontend/assets/js/leftSideBar/active.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/leftSideBar/popUpUserLogout.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/navProfile.js' defer></script>";
echo "<script src='./frontend/assets/js/home/app.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/notification/navTweet.js' defer></script>";

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
                            Notification
                        </h2>
                        <a href="$" class="content__topTweet">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-18jsvk2 r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03">
                                <g>
                                    <path d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    
                    <!-- NỘI DUNG PHẦN NOTIFICATION -->
                    <div class="content__notification-container">
                        <ul class="content__notifications-menu">
                            <?php 
                                if(count($notifications) > 0) {
                                    $sql = "UPDATE tb_notifications SET notification_state = '0' WHERE notification_for = ?";
                                    // THIẾT LẬP LẠI TRẠNG THÁI CỦA THÔNG BÁO
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(1, $user->user_id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    foreach($notifications as $row) {
                                        // LẤY DỮ LIỆU NGƯỜI DÙNG
                                        $userForNoti = userData($row['notification_by']);
                                        // LẤY KIỂU THÔNG BÁO
                                        if($row['notification_type'] == 'comment') $imgType = "<svg width='30px' height='30px' class='rounded-circle text-primary xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><g><path d='M11.55 12.082c.273.182.627.182.9 0L22 5.716V5.5c0-1.24-1.01-2.25-2.25-2.25H4.25C3.01 3.25 2 4.26 2 5.5v.197l9.55 6.385z'/><path d='M13.26 13.295c-.383.255-.82.382-1.26.382s-.877-.127-1.26-.383L2 7.452v11.67c0 1.24 1.01 2.25 2.25 2.25h15.5c1.24 0 2.25-1.01 2.25-2.25V7.47l-8.74 5.823z'/></g></svg>";
                                        else if($row['notification_type'] == 'love') $imgType = "<svg width='30px' height='30px' class='rounded-circle text-danger xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><g><path d='M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z'/></g></svg>"; 
                                        // LẤY AVATAR NGƯỜI ĐƯA NOTI
                                        $imageAvatarOfUserNoti = getLinkImage($userForNoti)['imageAvatar'];

                                        echo "<li class='content__notifications-item d-flex align-items-center p-3 border-bottom border-light mb-2' onclick='navTweet({$row['notification_fromTweet']})'>
                                                <div class='content__notifications-type me-5'>
                                                    $imgType
                                                </div>
                                                <div class='content__notifications-desc flex-grow-1'>
                                                    <div class='content__notifications-from d-flex align-items-center'>
                                                        <div class='content__notifications-from-avatar me-3'>
                                                            <img width='30px' height='30px' class='rounded-circle' src='$imageAvatarOfUserNoti' alt=''>
                                                        </div>
                                                        <div class='content__notifications-main me-5 d-flex flex-column justify-content_center fw-bold'>
                                                            From @{$userForNoti->user_firstName} {$userForNoti->user_lastName} 
                                                            <span class='content__notifications-type mt-2 text-muted fw-normal'>{$row['notification_type']} your tweet</span>
                                                        </div>
                                                        <div class='content__notifications-on d-block ms-auto fw-bold time-post-tweet'>
                                                            {$row['notification_on']}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>";
                                        
                                    }
                                }
                            ?>
                            
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