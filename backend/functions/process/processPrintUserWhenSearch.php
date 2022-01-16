<?php 
    include '../../initialize.php';

    // KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
    if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0) || !isset($_POST['valueInput'])) {
        redirect_to(url_for('index'));
    }

    // LẤY NHỮNG NGƯỜI DÙNG TỪ VIỆC TÌM KIẾM
    $sql = "SELECT * FROM tb_users WHERE user_userName like ? AND user_isAdmin = '0'";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, "%{$_POST['valueInput']}%", PDO::PARAM_STR);
    // Thực thi sql
    $stmt->execute();
    // Lấy ra vị trí vừa mới chèn vào
    $userForSearch = $stmt->fetchAll(PDO::FETCH_OBJ);  

    $html = '';
    foreach($userForSearch as $key => $value) {
        // ẢNH NGƯỜI DÙNG
        $imageAvatar = getLinkImage($value)['imageAvatar'];

        // LIÊN KẾT TỚI TRANG CÁ NHÂN CỦA NGƯỜI DÙNG
        $linkProfile = url_for("profile?userProfile={$value->user_id}");

        $html.= "<li class='r-sidebar__main-item'>
                <img class='rounded-circle' width='40px' height='40px' src='$imageAvatar' alt='Avatar'>
                <div class='r-sidebar__main-item-name'>
                    <a class='r-sidebar__main-item-name-top d-flex' href='$linkProfile'>
                        {$value->user_firstName} {$value->user_lastName}
                    </a>
                    <div class='r-sidebar__main-item-name-bottom'>
                        <span>@{$value->user_userName}</span>
                    </div>
                </div>
            </li>";
    }
    echo $html;
?>