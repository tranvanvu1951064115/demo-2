<?php
    if(isset($_POST['tweetId'])) {
        include '../../config.php';
        include '../connectToDatabase.php';
        try {
            $tweet_id = $_POST['tweetId'];
            $statement = $conn->prepare("DELETE FROM tb_tweets WHERE tweet_id=:tweet_id");
            $statement->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $statement->execute();
            echo $tweet_id;
        } catch(error) {
            // header('location: error.php');
        }
    }

?>