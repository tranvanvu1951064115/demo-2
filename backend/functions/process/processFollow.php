<?php 
    include '../../initialize.php';

    // KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
    if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0) || !isset($_POST['followUser'])) {
        redirect_to(url_for('index'));
    }
    
    $inforFollow = getInfo('tb_follows', ['*'], ['follow_user'=>$_POST['followUser'], 'follow_following'=>$_POST['followingUser']], null, null);
    if(count($inforFollow) > 0) {
        delete('tb_follows', ['follow_id'=>$inforFollow[0]['follow_id']]);
        echo 'Follow';
    } else {
        // TRẢ VỀ ID VỪA MỚI THÊM VÀO
        insert('tb_follows', ['follow_user'=>$_POST['followUser'], 'follow_following'=>$_POST['followingUser']]);
        echo 'Following';
    }
?>