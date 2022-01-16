<?php
  // KIỂM TRA XEM ĐÃ ĐƯỢC CẤP QUYỀN NGƯỜI DÙNG HAY CHƯA
  include '../../initialize.php';
  if (!isset($_SESSION['isLogginOK']) || !($_SESSION['isLogginOK'] > 0)) {
    redirect_to(url_for('index'));
  } 

  $user = userData($_SESSION['isLogginOK']);
  if(isset($_POST)) {
    $userForTweet = getInfo('tb_tweets', ['tweet_by'], ['tweet_id'=>$_POST['forTweet']], null, null)[0];

    if($userForTweet['tweet_by'] !==  $user->user_id) {
      // 1. LẤY THÔNG TIN NGƯỜI DÙNG CỦA TWEET
      // 2. CHÈN THÔNG BÁO VÀO CSDL
      insert('tb_notifications', ['notification_for'=>$userForTweet['tweet_by'], 'notification_fromTweet'=>$_POST['forTweet'], 'notification_type'=>$_POST['type'], 'notification_by'=>$user->user_id]);
      
      require __DIR__ . '/vendor/autoload.php';
    
      // THIẾT LẬP CẤU HÌNH SỬ DỤNG PUSHER
      $options = array(
        'cluster' => 'ap1',
        'encrypt' => true
      );

      // KEY
      // SECRET
      // APP_ID
      $pusher = new Pusher\Pusher(
        '3072343e725a64e73f66',
        '384f93e2610e675f0a77',
        '1325534',
        $options
      );
    
      // THIẾT LẬP NỘI DUNG GỬI TIN 
      // 1. TÊN 
      $data['name'] = '';
      // 2. TIN NHẮN
      $data['message'] = 'Bạn có một thông báo mới';
      // 3. ID TWEET
      $data['forTweet'] = $_POST['forTweet'];
      // 4. TYPE
      $data['type'] = $_POST['type'];
      // 5. KIỂM TRA NGƯỜI ĐANG ĐĂNG NHẬP VỚI NGƯỜI REPLY NẾU KHÔNG TRÙNG THÌ MỚI HIỂN THỊ THÔNG BÁO
      
      // 3. TÊN KÊNH / SỰ KIỆN / DỮ LIỆU
      // Twitter-$userForTweet['tweet_by']
      $pusher->trigger("Twitter-{$userForTweet['tweet_by']}", 'notice', $data);
    }
  }

?>