<?php 
    // THAO TÁC 1: VALIDATE FORM 
    // THAO TÁC 2: NẾU DỮ LIỆU ĐẦU VÀO LÀ CHÍNH XÁC THÌ THÊM NGƯỜI DÙNG VÀO TRONG BẢNG USER
    // THAO TÁC 3: GỬI USER_ID CỦA NGƯỜI DÙNG VỪA ĐĂNG KÍ SANG TRANG XÁC THỰC VERIFICATION
    // Kiểm tra form có dùng POST
    if(is_post_request()) {
        // Nếu có chúng ta sẽ validate form
        if(isset($_POST['firstName']) && !empty($_POST['firstName'])) {
            // Gọi hàm để thực hiện validate cho từng input của form
            $firstName = filterName($_POST['firstName']);
            $lastName = filterName($_POST['lastName']);
            $email = filterString($_POST['email']);
            $password = filterString($_POST['password']);
            $confirmPassword = filterString($_POST['confirm-password']); 
            // Tạo ra user name bằng firstName và last Name
            $userName = generateUsername($firstName, $lastName);
            
            // Gọi hàm register để validate sau đó đăng kí tài khoản cho người dùng
            $userId = register($firstName, $lastName,$userName, $email,$password, $confirmPassword);
            // Nếu biến userId có giá trị tức là người dùng đã được thêm vào trong cơ sở dữ liệu
            if($userId > 0) {
                // Thiết lập phiên để xác thực trong trang verificaton
                $_SESSION['userSubmited'] = $userId;
                // Nếu người dùng nhấn vào nút nhớ mật khẩu khi đó sẽ  thiết lập sesion cho biến remember phục vụ lưu trữ dữ liệu
                // if(isset($_POST['remember'])) { 
                //     $_SESSION['remember'] = $_POST['remember'];// if on is user checked
                // }
                // Chuyển hướng tới trang xác thực
                redirect_to(url_for("verification"));
            }
        }
    }
?>