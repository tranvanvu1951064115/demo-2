<?php 
    if(isset($_POST['username'])) {
        session_start();
        try {
            $conn = new PDO("mysql:host=localhost;dbname=twitter","root","");
            $sql = "SELECT user_id, user_isAdmin FROM tb_users WHERE (user_username = '{$_POST['username']}' OR user_email = '{$_POST['username']}') AND user_password = '{$_POST['password']}'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if($user->user_isAdmin == 1) {
                $_SESSION['isLoginAdmin'] = $user->user_id;
                header("location: ../../admin/src/index.php");
            } else {
                header("location: ../../admin/index.php");
            }
        } catch(Exception $e) {
            header("location: ../../error.php?error={$e->getMessage()}");
        }
    }

?>