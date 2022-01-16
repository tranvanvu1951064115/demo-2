<?php
// Thiết lập tiêu đề tương ứng với từng trang
$pageTitle = "Profile / Twitter";

// Kết nối cơ sở dữ liệu
include 'backend/initialize.php';

// Lấy dữ liệu header từ tệp header
include 'backend/shared/header.php';

// KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0)) {
    header("location: index.php");
}

$user = userData($_SESSION['isLogginOK']); //NGƯỜI DÙNG ĐANG ĐĂNG NHẬP
$userProfile = userData($_GET['userProfile']); // NGƯỜI ĐƯỢC XEM PROFILE

// THIẾT LẬP CHỨC NĂNG CHO NGƯỜI DÙNG
$profileFunctionality = '';
if($user->user_id == $userProfile->user_id) {
    $profileFunctionality = "<div class='profile__edit'>
                                <button class='btn btn--secondary'>Edit profile</button>
                            </div>";
} else {
    $inforFollow = getInfo('tb_follows', ['*'], ['follow_user'=>$user->user_id, 'follow_following'=>$userProfile->user_id], null, null);
    $status = (count($inforFollow) > 0) ? 'Following' : 'Follow';
    $profileFunctionality = "<div class='profile__follow-button'>
                                <button class='btn btn--secondary follow-button' data-follow-user = '$user->user_id' data-following-user = '$userProfile->user_id'>$status</button>
                            </div>";
}

// XỬ LÝ LẤY LINK ẢNH NGƯỜI DÙNG
$imageCover = getLinkImage($userProfile)['imageCover'];
$imageAvatar = getLinkImage($userProfile)['imageAvatar'];

$imageAvatarOfUserLogined = getLinkImage($user)['imageAvatar'];
$imageCoverOfUserLogined = getLinkImage($user)['imageCover'];

// THIẾT LẬP SESSION PROFILE
$_SESSION['userProfile'] = $userProfile->user_id;

// THÔNG BÁO CỦA NGƯỜI DÙNG
$notifications = getInfo('tb_notifications', ['*'], ['notification_for' => $user->user_id, 'notification_state' => 1], null, null);
if(count($notifications) > 0) {
    $activeNotif = 'active';
} else {
    $activeNotif = 'none';
}

// RESET SESSION
unset($_SESSION['isExplore']);

// LẤY THÔNG TIN FOLLOWER/ING CỦA NGƯỜI DÙNG
$sql = "SELECT COUNT(*) as amount FROM tb_follows WHERE follow_user = $userProfile->user_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$amountOfFollowing = $stmt->fetch(PDO::FETCH_OBJ)->amount;

$sql = "SELECT COUNT(*) as amount FROM tb_follows WHERE follow_following = $userProfile->user_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$amountOfFollower = $stmt->fetch(PDO::FETCH_OBJ)->amount;
echo $amountOfFollowing;

echo "<script src='./frontend/assets/js/leftSideBar/active.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/leftSideBar/popUpUserLogout.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/app.js' type='module' defer></script>";
echo "<script src='./frontend/assets/js/home/handleReply.js' defer></script>";
echo "<script src='./frontend/assets/js/home/navProfile.js' defer></script>";
echo "<script src='./frontend/assets/js/profile/profileSetUpPopUp.js' defer></script>";
echo "<script src='./frontend/assets/js/profile/processWhenChangeFile.js' defer></script>";
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
                            Profile | <?php echo "<span>$userProfile->user_firstName $userProfile->user_lastName</span>" ?>
                        </h2>
                        <a href="$" class="content__topTweet">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" aria-hidden="true" class="r-18jsvk2 r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03">
                                <g>
                                    <path d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <!-- PROFILE SECTION -->
                    <div class="profile">
                        <div class="profile__info">
                            <div class="profile__background">
                                <img src="<?php echo $imageCover; ?>" width="100%" height="200px" alt="">
                            </div>
                            <div class="profile__info-main">
                                <div class="profile__avatar">
                                    <img class="rounded-circle" src="<?php echo $imageAvatar; ?>" alt="avartar" width="150px" height="150px">
                                </div>
                                <?php echo $profileFunctionality; ?>
                                <div class="profile__name">
                                    <b class="profile__fullname"><?php echo $userProfile->user_firstName . ' ' . $userProfile->user_lastName ?></b>
                                    <span>@<?php echo $userProfile->user_userName ?></span>
                                </div>
                                <div class="profile__follow">
                                    <a href="" class="profile__following me-5">
                                        <b class="me-2"><?php echo $amountOfFollowing ?></b>Flowings
                                    </a>
                                    <a href="" class="profile__follower">
                                        <b class="me-2"><?php echo $amountOfFollower ?></b>Follower
                                    </a>
                                </div>
                            </div>
                            <div class="profile__tweet">
                                <h6 class="profile__tweet-header text-center pt-3 pb-3 text-primary">
                                    Tweets
                                </h6>
                                <!-- DISPLAY FOR TWEET -->
                                <ul class="content__tweets" data-owner-tweet='<?php echo $userProfile->user_id?>'></ul>
                            </div>
                        </div>
                        <!-- PROFILE SETUP -->
                        <?php 
                            if($user->user_id == $userProfile->user_id) {
                            $location = "backend/functions/process/processEditProfile.php";
                            $errorMessage = (isset($_GET['errorMessage'])) ? $_GET['errorMessage'] : '';
                            $activeBoxEdit = '';
                            if($errorMessage) {
                                $activeBoxEdit = 'active';
                            }
                            echo "<form action='$location' method='post' class='profile__setup $activeBoxEdit' enctype='multipart/form-data'>
                                    <div class='profile__setup-main'>
                                        <div class='profile__setup-header d-flex justify-content-between align-items-center'>
                                            <div class='profile__setup-header-left d-flex align-items-center'>
                                                <span class='close me-3 closeBoxEdit'>
                                                    <i class='bi bi-x-circle fs-5'></i>
                                                </span>
                                                <span class='fw-bold fs-5'>Edit profile</span>
                                            </div>
                                            <button type='submit' value='upload' name='uploadProfile' class='btn btn--primary button-edit'>Save</button>
                                        </div>
                                        <div class='profile__background'>
                                            <input type='file' name='file-background' id='file-background'>
                                            <img src='$imageCover' width='100%' height='200px' alt=''>
                                            <i class='far fa-folder-open fs-5'></i>
                                        </div>
                                        <div class='profile__info-main'>
                                            <div class='profile__avatar'>
                                            <input type='file' name='file-avatar' id='file-avatar'>
                                                <img class='rounded-circle' src='$imageAvatar' alt='avartar' width='150px' height='150px'>
                                                <i class='fas fa-file-upload fs-5'></i>
                                            </div>
                                            <div class='profile__setup-name d-flex flex-column'>
                                                <label for='input-setup-fname'>First Name...</label>
                                                <input class='mt-2 d-inline-block fs-5 p-2 mb-4' type='text' name='input-setup-fname' id='input-setup-fname' placeholder='First Name...' value='$user->user_firstName'>
                                                <label for='input-setup-lname'>Last Name...</label>
                                                <input class='mt-2 d-inline-block fs-5 p-2' type='text' name='input-setup-lname' id='input-setup-lname' placeholder='Last Name...' value='$user->user_lastName'>
                                            </div>
                                            <p class='errorMessage mt-3 text-danger'>$errorMessage</p>
                                        </div>
                                    </div>
                                 </form>";
                            }
                        ?>
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