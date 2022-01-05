<?php
// Kết nối cơ sở dữ liệu
include 'backend/initialize.php';

// Lấy dữ liệu header từ tệp header
include 'backend/shared/header.php';

if(isset($_POST['isLogout']) && $_POST['isLogout']) {
    resetSESSIONFor('isLogginOK');
}

?>
<div class="wrapper">
    <div class="container-fluid first-page">
        <div class="row first-page__main">
            <div class="col col-md-6 first-page__left">
                <img class="first-page__main-img" src="frontend/assets/image/main.png" alt="Main Image">
                <div class="first-page__logo">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="r-jwli3a r-4qtqp9 r-yyyyoo r-rxcuwo r-1777fci r-m327ed r-dnmrzs r-494qqr r-bnwqim r-1plcrui r-lrvibr">
                        <g>
                            <path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="col col-md-6 first-page__right">
                <div class="first-page__sub-logo">
                    <i class="fab fa-twitter"></i>
                </div>
                <div class="first-page__header">
                    <h1>Happening right now</h1>
                    <h3>Join Twitter today.</h3>
                </div>
                <div class="first-page__type d-inline-flex flex-column justify-content-center">
                    <a class="register-btn btn btn--primary" href="signUp">
                        Register by phone number or email
                    </a>
                    <span class="mt-5 mb-3 fw-bold">Already have an account?</span>
                    <a class="login-btn btn btn--secondary" href="login">
                        Login
                    </a>
                </div>
            </div>
        </div>
        <div class="row first-page__form text-center p-4">
            <ul class="d-flex pl-5 pr-5 justify-content-center align-items-center flex-wrap">
                <li class="me-4"><a class="lh-lg" href="#">Introduce</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Help Center</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Terms of Service</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Privacy Policy</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Cookie Policy</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Advertising information</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Blog</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Status</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Job</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Brand Resources</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Advertisement</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Marketing</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Twitter for business</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Developers</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Category</a></li>
                <li class="me-4"><a class="lh-lg" href="#">Setting</a></li>
            </ul>
            <span class="copyright">© 2021 Twitter, Inc.</span>
        </div>
    </div>
</div>

<?php
// Thực hiện gọi footer
include 'backend/shared/footer.php';
?>