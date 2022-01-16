<?php 
    // DEFINE DATABASE
    // Định nghĩa các hằng thể hiện server và những thông số để kết nối database
    define("DB_HOST","localhost");
    define("DB_NAME","twitter");
    define("DB_USER","root");
    define("DB_PASS","");
    // define("BASE_URL","http://localhost/twitter/index.php");

    // DEFINE LINK
    // script name lấy ra đường dẫn hiện tại của trang + 9 để lấy phần tên thư mục gốc
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/frontend') + 9;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);
    
    // DEFINE SMTP
    // Định nghĩa host cho việc gửi email: yahoo, gmail, outlook ,...
    define("M_HOST", "smtp.gmail.com");
    // Định nghĩa user gửi đến người dùng
    define("M_USERNAME", "wilsonkylerkl@gmail.com");
    // Mật khẩu ứng dụng
    define("M_PASSWORD", "czhlmybsnrpoqesx");
    // Định nghĩa kiểu bảo mật của giao thức SMTP
    define("M_SMTPSECURE", "tls");
    // Cổng kết nối
    define("M_PORT",587);
?>