<?php echo "<script src='./backend/ajax/handleSearchForRSideBar.js' defer></script>";?>
<div class="r-sidebar__header header-for-search">
    <span class="search">
        <i class="bi bi-search"></i>
    </span>
    <input type="text" name="searchTwitter" id="searchTwitter" placeholder="Search Twitter">
    <!-- RESULT OF SEARCH -->
    <ul class="r-sidebar__boxResultSearch r-sidebar__main-menu"></ul>
</div>
<div class="r-sidebar__main">
    <h3 class="r-sidebar__main-header">You might like</h3>
    <ul class="r-sidebar__main-menu">
        <?php 
            $amountOfUser = count(getInfo('tb_users', ['*'], [''], null, null));
            $smallestID = getInfo('tb_users', ['MIN(user_id)'], [''], null, null)['0']['MIN(user_id)'];
            $highestID = getInfo('tb_users', ['MAX(user_id)'], [''], null, null)['0']['MAX(user_id)'];
            $arrayUserId = [];
            for($i = 0; $i < $amountOfUser - 1; $i++) {
                // CHỈ HIỂN THỊ 5 NGƯỜI
                if($i == 5) break;
                // lẤY SỐ RANDOM NẾU ĐÃ HIỂN THỊ THÌ KHÔNG HIỂN THỊ LẠI
                while(true) {
                    $randomNumber = (int)(mt_rand($smallestID, $highestID ));
                    if(!in_array($randomNumber, $arrayUserId) && $randomNumber != $user->user_id ) {
                        // LẤY NGƯỜI DÙNG
                        $userRandom = userData($randomNumber);
                        if($userRandom != null) {
                            break;
                        }
                    }
                }
                
                // CHO VÀO MẢNG USER_ID ĐÃ ĐƯỢC HIỂN THỊ RA
                array_push($arrayUserId, $randomNumber);

                // LẤY ẢNH NGƯỜI DÙNG
                $imageAvatar = getLinkImage($userRandom)['imageAvatar'];

                // TẠO LIÊN KẾT TỚI TRANG CÁ NHÂN CỦA NGƯỜI DÙNG
                $linkProfile = url_for("profile?userProfile=$userRandom->user_id");

                // LẤY THÔNG TIN NGƯỜI FOLLOW
                $inforFollow = getInfo('tb_follows', ['*'], ['follow_user'=>$user->user_id, 'follow_following'=>$randomNumber], null, null);
                $status = (count($inforFollow) > 0) ? 'Following' : 'Follow';

                echo "<li class='r-sidebar__main-item'>
                        <img class='rounded-circle' width='40px' height='40px' src='$imageAvatar' alt='Avatar'>
                        <div class='r-sidebar__main-item-name'>
                            <a class='r-sidebar__main-item-name-top d-flex' href='$linkProfile'>
                                $userRandom->user_firstName $userRandom->user_lastName 
                            </a>
                            <div class='r-sidebar__main-item-name-bottom'>
                                <span>$userRandom->user_userName</span>
                            </div>
                        </div>
                        <button class='btn btn--primary follow-button' data-follow-user='{$user->user_id}' data-following-user='$randomNumber'>$status</button>
                    </li>";
            }   
        ?>
        <button class="read-more-user text-primary">Read more ...</button>
    </ul>
</div>