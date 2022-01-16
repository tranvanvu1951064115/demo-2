<?php 
    include '../../initialize.php';
    if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0) || !isset($_POST["uploadProfile"])) {
        header("location: ../../../index.php");
    }
    // LẤY DỮ LIỆU NGƯỜI DÙNG
    $user = userData($_SESSION['isLogginOK']);

    // CẬP NHẬT TÊN CHO NGƯỜI DÙNG
    // LẤY VALUE HAI TRƯỜNG FIRST NAME VÀ LAST NAME
    $firstName = $_POST['input-setup-fname'];
    $lastName = $_POST['input-setup-lname'];
    if($user->user_firstName != $firstName) {
        update('tb_users', $user->user_id, ['user_firstName'=>$firstName]);
    }

    if($user->user_lastName != $lastName) {
        update('tb_users', $user->user_id, ['user_lastName'=>$lastName]);
    }
    update('tb_users', $user->user_id, ['user_userName'=>$firstName.$lastName]);

    // CẬP NHẬT DỮ LIỆU ẢNH CỦA NGƯỜI DÙNG
    // TẠO BIẾN MESSAGE
    $statusMsg = '';

    // File upload path
    $targetDir =  $_SERVER['DOCUMENT_ROOT'].'/twitter/backend/uploads/'.$user->user_id;
    $index = 0;
    foreach($_FILES as $key => $value) {
        $index++;
        // Tên file background
        $fileBackground = $key;
        // Lấy đường dẫn + tên file
        $targetFilePath = $targetDir .'/'. $value['name'];
        // Lấy thông tin kiểu file
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        // KIỂM TRA FILE ĐÃ TỒN TẠI HAY CHƯA
        if (!file_exists($value['name'])) {
            // KIỂM TRA FILE XEM KÍCH THƯỚC CỦA NÓ CÓ NHỎ HƠN 50KB HAY KHÔNG
            if ($value["size"] < 500000) {
                if($key){
                    // Allow certain file formats
                    $allowTypes = array('jpg','png','jpeg','gif');
                    if(in_array($fileType, $allowTypes)){
                        // Tạo một thư mục mới trên server
                        if(!file_exists($targetDir)) {
                            mkdir("$targetDir", 0700);
                        }
                        // Upload file to serverbackend
                        if(move_uploaded_file($value["tmp_name"], $targetFilePath)){
                            // Insert image file name into database
                            if($index == 1) {
                                $update = update('tb_users', $user->user_id, ['user_profileCover'=>$value['name']]);
                            } else {
                                $update = update('tb_users', $user->user_id, ['user_profileImage'=>$value['name']]);
                            }
                            if(!$update){
                                $errorMessage = "File upload failed, please try again.";
                            } 
                        }else{
                            $errorMessage = "Sorry, there was an error uploading your file.";
                        }
                    }else{
                        $errorMessage = "Sorry, only JPG, JPEG, PNG, GIF";
                    }   
                }else{
                    $errorMessage = 'Please select a file to upload.';
                }
            } else {
                $errorMessage = "Sorry, your file is too large.";
            }
            
        }

        // Display status message
        header("location:../../../profile?userProfile=$user->user_id&errorMessage=$errorMessage");
    }
    
?>