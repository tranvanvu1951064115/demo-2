
    <!-- LINK BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- JQUERY JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- PUSHER -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        // Pusher.logToConsole = true;
        // 1. TẠO KÊNH NGƯỜI DÙNG

        var pusher = new Pusher('3072343e725a64e73f66', {
            cluster: 'ap1',
            encrypted: true
        });

        // THIẾT LẬP CẤU HÌNH
        // 1. CHỈ ĐỊNH KÊNH MỖI NGƯỜI DÙNG, VỚI INDEX LÀ USER_ID
        var index = '<?php if(isset($user)) echo $user->user_id; ?>';
        var channel = pusher.subscribe(`Twitter-${index}`);
        // THIẾT LẬP SỰ KIỆN KHI CÓ THÔNG BÁO ĐƯỢC GỬI VỀ
        // function changeType(type) {
        //     switch(type){
        //         case 'comment': {
        //             return 'bình luận';
        //         }
        //     }
        // }

        channel.bind('notice', function (data) {
            {
                // THIẾT LẬP CÂU HÌNH TIN THÔNG BÁO
                // notif = new Notification(
                //     'Bạn nhận được thông báo mới',
                //     {
                //         // LẤY RA NAME ĐƯỢC SERVER GỬI VỀ 
                //         body: `Bạn vừa có một ${changeType(data.type)} mới`,
                //         // ICON CỦA THÔNG BÁO
                //         icon: 'https://img.icons8.com/fluency/48/000000/twitter.png',
                //         // ĐƯỜNG LIÊN KẾT THÔNG BÁO
                //         tag: 'http://localhost/twitter/tweetWithComments?tweetId='+ data.forTweet,
                //     }
                // );
                // // CÀI ĐẶT TIMER SAO CHO THÔNG BÁO TỰ ĐỘNG ĐÓNG TRONG SỐ THỜI GIAN ĐÓ
                // // NẾU THÔNG BÁO CHƯA ĐƯỢC ĐÓNG SẼ CHƯA THỂ GỬI TIN
                // setTimeout(notif.close.bind(notif), 5000);
                // // THIẾT LẬP LIÊN KẾT KHI NGƯỜI DÙNG NHẤN VÀO THÔNG BÁO
                // notif.onclick = function () {
                //     window.location.href = this.tag;
                // }
            }
            // KẾT THÚC
            // THIẾT LẬP THÔNG BÁO TỚI NGƯỜI DÙNG
            if(!document.querySelector('.isNotNotice')) {
                $('.l-sidebar__item--notification > span').css('display','inline-block');
            }
        });
    </script>
</body>

</html>