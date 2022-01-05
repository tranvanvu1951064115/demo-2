<?php 
    // Thiết lập tiêu đề tương ứng với từng trang
    $pageTitle = "Login on Twitter / Twitter";
    // Lấy dữ liệu header từ tệp header
    include 'backend/shared/header.php';
    // Gọi tệp initialize
    include 'backend/initialize.php';
    // XỬ LÝ LOGIN ĐĂNG NHẬP CHO NGƯỜI DÙNG
    include 'backend/functions/process/processLogin.php';
    echo "<script src='./frontend/assets/js/login/handleRememberLogin.js' defer></script>";

?>
    <section class="login form">
        <!-- FORM-NAV SECTION -->
        <?php include 'backend/shared/formNav.php';?>
        <!-- FORM SECTION -->
        <div class="form-wrapper">
            <div class="form-content">
                <h2 class="form-title">
                    Login to Twitter
                    <a class="errorEmail text-decoration-underline" href="verification.php?userOrEmail=<?php if(isset($_POST['userOrEmail'])) echo $_POST['userOrEmail']; ?>"></a>
                </h2>
                <!-- SERVER['PHP_SELF'] là thư mục hiện tại đang đứng
                     htmlspecialchars loại bỏ những kí tự đặc biệt để tránh hacker dùng script để tấn công
                -->
                <form action="<?php echo removeSpecialCharacters($_SERVER['PHP_SELF']);?>" method="POST" class="form-main form-log-main">
                    <div class="form-group">
                        <label for="userOrEmail">User name or Email</label>
                        <!-- AutoComplete là chức năng của Internet Explorer cho phép ghi nhớ các ký tự hay password vào biểu mẫu (form) trên trang web và tự động điền lại vào những lần sau. -->
                        <input type="text" name="userOrEmail" id="userOrEmail" placeholder="First Name" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
                    </div>
                    <div class="form-show-password">
                        <input type="checkbox" name="showPassword" id="showPassword">
                        <label for="showPassword">Show Password</label>
                    </div>
                    <div class="form-btn-wrapper">
                        <input type="checkbox" name="remember" id="check">
                        <label for="check">Remember me</label>
                        <button name="buttonLogin" value="login" class="form-btn btn btn-primary" type="submit">Login</button>
                    </div>
                </form>
                <footer class="form-footer">
                    <p>New to twitter ?<a href="signUp">Sign Up to Twitter</a></p>
                </footer>
            </div>
        </div>
    </section>
    <script src="frontend/assets/js/first-page/showPassword.js"></script>
</body>
</html>