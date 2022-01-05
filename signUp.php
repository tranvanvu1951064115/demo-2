<?php 
    // Thiết lập tiêu đề tương ứng với từng trang
    $pageTitle = "SignUp / Twitter";
    // Lấy dữ liệu header từ tệp header
    include 'backend/shared/header.php';
    // Gọi tệp initialize
    include 'backend/initialize.php';
    // XỬ LÝ ĐĂNG KÍ TÀI KHOẢN ĐĂNG NHẬP CHO NGƯỜI DÙNG
    include 'backend/functions/process/processSignUp.php';
    echo "<script src='./frontend/assets/js/signUp/handleRemember.js' defer></script>";
?>
    <section class="sign form">
        <!-- FORM-NAV SECTION -->
        <?php include 'backend/shared/formNav.php';?>
        <!-- FORM SECTION -->
        <div class="form-wrapper">
            <div class="form-content">
                <h2 class="form-title">Create your account</h2>
                <!-- SERVER['PHP_SELF'] là thư mục hiện tại đang đứng
                     htmlspecialchars loại bỏ những kí tự đặc biệt để tránh hacker dùng script để tấn công
                -->
                <form action="<?php echo removeSpecialCharacters($_SERVER['PHP_SELF']);?>" method="POST" class="form-main form-signup-main">
                    <div class="form-group">
                        <label for="firstName">FirstName</label>
                        <!-- AutoComplete là chức năng của Internet Explorer cho phép ghi nhớ các ký tự hay password vào biểu mẫu (form) trên trang web và tự động điền lại vào những lần sau. -->
                        <input type="text" name="firstName" id="firstName" placeholder="First Name" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="lastName" placeholder="Last Name" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <?php if(isset($_GET['errorEmail'])) echo "<span class='errorMessage d-block fs-6 pb-3'>" . $_GET['errorEmail'] . "</span>"?>
                        <input type="email" name="email" id="email" placeholder="Email" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirmPassword" placeholder="Confirm Password" required autocomplete="off">
                    </div>
                    <div class="form-show-password">
                        <input type="checkbox" name="showPassword" id="showPassword">
                        <label for="showPassword">Show Password</label>
                    </div>
                    <div class="form-btn-wrapper">
                        <input type="checkbox" name="remember" id="check">
                        <label for="check">Remember me</label>
                        <button class="form-btn form-btn-sign btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
                <footer class="form-footer">
                    <p>Already have an account ?<a href="login">Login now</a></p>
                </footer>
            </div>
        </div>
    </section>
    <script src="frontend/assets/js/first-page/app.js" type="module"></script>
    <script src="frontend/assets/js/first-page/showPassword.js"></script>
</body>
</html>