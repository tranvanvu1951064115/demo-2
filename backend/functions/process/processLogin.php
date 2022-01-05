<?php 
    // BƯỚC 1: LẤY THÔNG TIN NGƯỜI DÙNG
    if(is_post_request()) {
        $user = getInfo("tb_users", ["user_id", "user_email", "user_password"], array('user_email'=>$_POST['userOrEmail']), null, null);
        
        // KIỂM TRA CÓ NGƯỜI DÙNG HAY KHÔNG
        if($user) {
            // LẤY TRẠNG THÁI XÁC THỰC CỦA NGƯỜI DÙNG
            $user = $user['0'];
            $status = getInfo("tb_verification", ["status"], array('user_id'=>$user['user_id']), null, null);
            $status = $status['0'];
            if(isset($status) && $status['status'] == 1) { // NGƯỜI DÙNG ĐÃ XÁC THỰC TÀI KHOẢN
                // KIỂM TRA THÔNG TIN MẬT KHẨU NGƯỜI DÙNG NHẬP VÀO
                if(password_verify($_POST['password'], $user['user_password'])) { // CHÍNH XÁC
                    $_SESSION['isLogginOK'] = $user['user_id'];
                    redirect_to(url_for("home"));
                } else { // CHƯA CHÍNH XÁC
                    echo "<script src='frontend/assets/js/login/passwordError.js' type='module' defer></script>";
                }
            } else { // NGƯỜI DÙNG CHƯA XÁC THỰC TÀI KHOẢN
                echo "<script src='frontend/assets/js/login/verifyError.js' type='module' defer></script>";
            }
        } else { // NẾU KHÔNG CÓ THÔNG TIN NGƯỜI DÙNG THÌ IN RA THÔNG BÁO LỖI KHÔNG CÓ TÊN ĐĂNG NHẬP CHÍNH XÁC
            echo "<script src='frontend/assets/js/login/getErrorOfUserNameOrEmail.js' type='module' defer></script>";
        }
    }
?>