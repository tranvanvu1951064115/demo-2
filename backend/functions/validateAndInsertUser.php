<?php  
    // Hàm đăng kí tài khoản cho người dùng
    function register($firstName, $lastName, $userName, $email, $password, $confirmPassword) {
        if(checkEmailInUse($email)) {
            redirect_to(url_for("signUp.php?errorEmail=Email in use"));
        } else {
            return insertUser($firstName, $lastName, $userName, $email, $password);
        }
    }

    // Hàm tạo nên tên của người dùng
    function generateUsername($firstName, $lastName) {
        // Kiểm tra xem hai đối số có rỗng hay không
        if(!empty($firstName) && !empty($lastName)) {
            // Kiểm tra xem hai biến này có đang lỗi hay không
            // Tạo kí tự thông thường
            $username = strtolower($firstName."".$lastName);
            // Gọi hàm kiếm tra sự tồn tại của username trong database 
            // Username của người dùng là duy nhất
            if(checkUsernameExist($username)) {
                // Nếu đã có firstName + lastName của người dùng tương tự trong csdl thì tạo random username
                $numberRandom = rand();
                $userLink = ''.$username.''.$numberRandom;
            } else {    
                // Ngược lại thì lấy tên người dùng
                $userLink = $username;
            }
            return $userLink;
        }
    }
    
    // Hàm kiểm tra username có tồn tại trong csdl
    function checkUsernameExist($username) {
        global $conn;
        // Thực hiện gọi hàm prepare để thực thi câu lệnh
        $statement = $conn->prepare("SELECT user_userName FROM tb_users WHERE user_userName=:username");
        // Thực hiện truyền tham chiếu username = biến username
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        // Thực thi câu lệnh sql trên database
        $statement->execute();
        // Đếm số lượng dòng trả về trên sql
        $count = $statement->rowCount();
        if($count > 0) {
            return true;
        } 
        return false;
    }

    function checkEmailInUse($email) {
        global $conn;
        // Bước 1: Kiểm tra sự tồn tại của email trong database
        $statement = $conn->prepare("SELECT user_email FROM tb_users WHERE user_email=:email");
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();
        if($statement->rowCount() > 0) {
            return "Email in use";
        } 
    }

    // Thực hiện chèn người dùng vào cơ sở dữ liệu
    function insertUser($firstName, $lastName, $userName, $email, $password) {
        global $conn;
        // Thực hiện băm password theo định dạng BCRYPT
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        // Thiết lập random ảnh avatar và ảnh nền cho người dùng
        $rand = rand(0, 2);
        if($rand == 0) {
            $profilePic = "frontend/assets/image/avatar.png";
            $profileCover = "frontend/assets/image/backgroundCoverPic.png";
        } else if($rand == 1) {
            $profilePic = "frontend/assets/image/defaultProfilePic.png";
            $profileCover = "frontend/assets/image/defaultProfilePic.png";
        } else {
            $profilePic = "frontend/assets/image/profilePic.jpeg";
            $profileCover = "frontend/assets/image/backgroundCoverPic.png";
        }

        // Chuẩn bị câu lệnh và thực thi insert người dùng lên csdl
        $statement = $conn->prepare("INSERT INTO tb_users(user_firstName, user_lastName, user_userName, user_email, user_password, user_profileImage, user_profileCover) VALUES(:fn, :ln, :un, :em, :pw, :pi, :pc)");
        $statement->bindParam(":fn",$firstName,         PDO::PARAM_STR);
        $statement->bindParam(":ln",$lastName,          PDO::PARAM_STR);
        $statement->bindParam(":un",$userName,          PDO::PARAM_STR);
        $statement->bindParam(":em",$email,             PDO::PARAM_STR);
        $statement->bindParam(":pw",$password_hashed,   PDO::PARAM_STR);
        $statement->bindParam(":pi",$profilePic,        PDO::PARAM_STR);
        $statement->bindParam(":pc",$profileCover,      PDO::PARAM_STR);
        $statement->execute();
        // Lấy id cuối cùng được chèn để return ra kết quả, tương tự như việc thành công chèn bản ghi mới vào trong cơ sở dữ liệu
        return $conn->lastInsertId();
    }
?>