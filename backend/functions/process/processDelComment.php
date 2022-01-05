<?php
    if(isset($_POST['commentId'])) {
        include '../../initialize.php';
        $listComment = '';
        try {
            $comment_id = $_POST['commentId'];
            $statement = $conn->prepare("DELETE FROM tb_comment WHERE comment_id=:comment_id");
            $statement->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
            $statement->execute();

            $user = userData($_SESSION['isLogginOK']); // USER ĐANG LOGGIN
            $tweetComments = getInfo('tb_comment', ['*'], ['comment_id'=>$comment_id], null, null);
        } catch(Exception $e) {
            echo $e;
        }
    }

?>