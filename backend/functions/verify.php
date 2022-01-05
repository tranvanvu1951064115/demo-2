<?php 
    function generateLink() {
        // Khởi tạo phương phức tạo ra chuỗi random phục vụ tạo link liên kết
        return str_shuffle(substr(md5(time().mt_rand().time()),0,25));
    }

    function verifyCode($targetColumn, $code) {
        return getInfo("tb_verification", $targetColumn, array('code'=>$code), null, null);
    }

    // Phương thức dùng để gửi mail xác thực tới người dùng
    // Tham số thứ nhất nó là email address của người dùng
    // Tham số thứ 2 là tin nhắn gửi tới người dùng
    // Tham số thứ 3 là tiêu đề thư
    function sendToMail($emailAddr, $message, $subject) {
        // Tạo ra các thông tin cho việc gửi mail
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Host = M_HOST;
        $mail->Username = M_USERNAME;
        $mail->Password = M_PASSWORD;
        $mail->SMTPSecure = M_SMTPSECURE;
        $mail->Port = M_PORT;

        // Kiểm tra nếu địa chỉ email người dùng không rỗng mới thực thi gửi mail
        if(!empty($emailAddr)) {
            // Khởi tạo địa chỉ người gửi (admin)
            $mail->From = "wilsonkylerkl@gmail.com";
            // Khởi tạo tên người gửi (admin)
            $mail->FromName = "TWITTER";
            $mail->addReplyTo('no-reply@gmail.com');
            // Truyền vào tên người xác thực
            $mail->addAddress($emailAddr);
            
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = $message;

            // Thực thi việc gửi mail thành công thì trả về true,
            // Nếu không thì trả về false
            if($mail->send()) {
                return true;
            } else {
                return false;
            }
        }
    }

?>