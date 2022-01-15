-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 05, 2022 lúc 03:54 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `twitter`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_comment`
--

CREATE TABLE `tb_comment` (
  `comment_id` int(11) NOT NULL,
  `comment_by` int(11) NOT NULL,
  `comment_on` int(11) NOT NULL,
  `comment_status` text NOT NULL,
  `comment_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_comment`
--

INSERT INTO `tb_comment` (`comment_id`, `comment_by`, `comment_on`, `comment_status`, `comment_at`) VALUES
(164, 35, 438, 'No..', '2022-01-03 19:12:03'),
(195, 35, 440, 'Box', '2022-01-04 00:06:02'),
(196, 35, 440, 'Hello\n\n', '2022-01-04 00:06:15'),
(197, 35, 439, 'Boxx', '2022-01-04 00:08:56'),
(203, 35, 440, 'Great', '2022-01-04 00:15:57'),
(209, 35, 440, 'Hi', '2022-01-04 01:10:38'),
(234, 35, 441, 'Hix', '2022-01-04 18:24:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_follows`
--

CREATE TABLE `tb_follows` (
  `follow_id` int(11) NOT NULL,
  `follow_user` int(11) NOT NULL,
  `follow_following` int(11) NOT NULL,
  `follow_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_follows`
--

INSERT INTO `tb_follows` (`follow_id`, `follow_user`, `follow_following`, `follow_at`) VALUES
(42, 36, 35, '2022-01-04 03:14:29'),
(43, 35, 36, '2022-01-04 20:44:48'),
(45, 40, 35, '2022-01-05 09:53:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_loves`
--

CREATE TABLE `tb_loves` (
  `love_id` int(11) NOT NULL,
  `love_forTweet` int(11) NOT NULL,
  `love_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_loves`
--

INSERT INTO `tb_loves` (`love_id`, `love_forTweet`, `love_by`) VALUES
(165, 433, 35),
(166, 434, 35),
(167, 435, 35),
(168, 436, 35),
(169, 437, 35),
(170, 438, 35),
(171, 440, 35),
(173, 439, 35),
(198, 441, 35),
(201, 441, 40),
(202, 440, 40);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_messages`
--

CREATE TABLE `tb_messages` (
  `message_id` int(11) NOT NULL,
  `message_message` text NOT NULL,
  `message_to` int(11) NOT NULL,
  `message_from` int(11) NOT NULL,
  `message_on` datetime NOT NULL DEFAULT current_timestamp(),
  `message_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_notifications`
--

CREATE TABLE `tb_notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_for` int(11) NOT NULL,
  `notification_fromTweet` int(11) NOT NULL,
  `notification_type` enum('follow','love','retweet','comment') NOT NULL,
  `notification_on` datetime NOT NULL DEFAULT current_timestamp(),
  `notification_state` enum('1','0') NOT NULL DEFAULT '1',
  `notification_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_notifications`
--

INSERT INTO `tb_notifications` (`notification_id`, `notification_for`, `notification_fromTweet`, `notification_type`, `notification_on`, `notification_state`, `notification_by`) VALUES
(61, 35, 441, 'love', '2022-01-05 00:13:59', '0', 40),
(62, 35, 440, 'love', '2022-01-05 00:14:19', '0', 40);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_retweet`
--

CREATE TABLE `tb_retweet` (
  `retweet_id` int(11) NOT NULL,
  `retweet_by` int(11) NOT NULL,
  `retweet_from` int(11) NOT NULL,
  `retweet_status` text NOT NULL,
  `retweet_On` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_tweets`
--

CREATE TABLE `tb_tweets` (
  `tweet_id` int(11) NOT NULL,
  `tweet_status` text NOT NULL,
  `tweet_by` int(11) NOT NULL,
  `tweet_postedOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_tweets`
--

INSERT INTO `tb_tweets` (`tweet_id`, `tweet_status`, `tweet_by`, `tweet_postedOn`) VALUES
(433, 'Lionel Messi is one of four Paris Saint-Germain players to have tested positive for Covid-19, the club said in a statement.', 35, '2022-01-03 15:08:51'),
(434, 'Cristiano Ronaldo and Aaron Lennon’s longevity… long live the Barclays', 35, '2022-01-03 15:09:41'),
(435, 'Hiç bir oyuncu Cristiano Ronaldo\'nun 2016\'sından daha iyi bir yıl geçiremeyecek.', 35, '2022-01-03 15:10:00'),
(436, 'BREAKING NEWS: Triangular flag on post\n\nCristiano Ronaldo has just tested positive for being the best football player in the WORLD!', 35, '2022-01-03 15:10:30'),
(437, 'Cristiano Ronaldo has tested positive for being the Greatest Player of All Time Goat', 35, '2022-01-03 15:11:18'),
(438, 'Lionel Messi has tested positive for Covid-19.', 35, '2022-01-03 15:12:01'),
(439, '“Messi is finished, he has had the worst year of his life”\n\nMessi\'s worst year:', 35, '2022-01-03 15:12:44'),
(440, '\'\'Thomas müller and Robert lewandowski in 2021 have been involved in 74 goals and 33 assists of Bayern, \'\'europe’s top five leagues in club competitions\n\nthe top scorer and the best playmaker isn’t ta', 35, '2022-01-03 15:13:44'),
(441, 'Top scorer in the calendar year again.', 35, '2022-01-03 15:14:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_uploadedimages`
--

CREATE TABLE `tb_uploadedimages` (
  `uploadedImage_id` int(11) NOT NULL,
  `uploadedImage_link` text NOT NULL,
  `uploadedImage_forTweet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_uploadedimages`
--

INSERT INTO `tb_uploadedimages` (`uploadedImage_id`, `uploadedImage_link`, `uploadedImage_forTweet`) VALUES
(39, 'xY__4xY4.jpeg', 433),
(40, 'FIGkr4QXwAQqRrH.jpeg', 434),
(41, 'FIFflW8XwAQBLIF.jpeg', 435),
(42, 'FIHS1s5XIAE3I6e.jpeg', 436),
(43, 'FIGGaB8XoAASvQZ.jpeg', 437),
(44, 'FIGCizMWQAAnVKu.jpeg', 438),
(45, 'FH-MItrXwAk_GzU.jpeg', 439),
(46, 'FIHemmYUUAAYTbg.jpeg', 440),
(47, 'FIHemmYUUAAYTbhug.jpeg', 441);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `user_firstName` varchar(100) NOT NULL,
  `user_lastName` varchar(100) NOT NULL,
  `user_userName` varchar(150) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_profileImage` varchar(255) NOT NULL,
  `user_profileCover` varchar(255) NOT NULL,
  `user_following` int(11) NOT NULL,
  `user_followers` int(11) NOT NULL,
  `user_bio` text NOT NULL,
  `user_country` varchar(255) NOT NULL,
  `user_website` varchar(255) NOT NULL,
  `user_signUpDate` datetime NOT NULL DEFAULT current_timestamp(),
  `user_profileEdit` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `user_firstName`, `user_lastName`, `user_userName`, `user_email`, `user_password`, `user_profileImage`, `user_profileCover`, `user_following`, `user_followers`, `user_bio`, `user_country`, `user_website`, `user_signUpDate`, `user_profileEdit`) VALUES
(35, 'Admin', '9999', 'Admin9999', 'wilsonkylerkl@gmail.com', '$2y$10$.rSg0CFTo7MeD9W5rKcHmOFQs0PgnFYuA/IZjczX39XUH4VaKCTLu', 'FH-MItrXwAk_GzU.jpeg', 'FIFflW8XwAQBLIF.jpeg', 0, 0, '', '', '', '2022-01-03 14:42:29', '0'),
(40, 'Donal', 'Trump', 'donaltrump', 'tanvu13042001@gmail.com', '$2y$10$dwwuklhrskSxccM2UfivXOyZ0NvRNfttqE9JsT468XMzK/IOu0vci', 'frontend/assets/image/defaultProfilePic.png', 'frontend/assets/image/defaultProfilePic.png', 0, 0, '', '', '', '2022-01-05 00:11:15', '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_verification`
--

CREATE TABLE `tb_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_verification`
--

INSERT INTO `tb_verification` (`id`, `user_id`, `code`, `status`, `createdAt`) VALUES
(77, 35, '1b7694d0ffa7984fe1d82dcce', '1', '2022-01-03 14:42:33'),
(78, 35, '1b7694d0ffa7984fe1d82dcce', '1', '2022-01-03 14:43:13'),
(115, 40, '7585c7c9cb855afd045ab56f7', '1', '2022-01-05 00:12:21'),
(116, 40, '7585c7c9cb855afd045ab56f7', '1', '2022-01-05 00:12:42'),
(117, 40, '7585c7c9cb855afd045ab56f7', '1', '2022-01-05 00:13:10');

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `view_top_tweet`
-- (See below for the actual view)
--
CREATE TABLE `view_top_tweet` (
`tweet_id` int(11)
,`tweet_status` text
,`tweet_by` int(11)
,`tweet_postedOn` datetime
,`COUNT(*)` bigint(21)
);

-- --------------------------------------------------------

--
-- Cấu trúc cho view `view_top_tweet`
--
DROP TABLE IF EXISTS `view_top_tweet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_top_tweet`  AS SELECT `tb_tweets`.`tweet_id` AS `tweet_id`, `tb_tweets`.`tweet_status` AS `tweet_status`, `tb_tweets`.`tweet_by` AS `tweet_by`, `tb_tweets`.`tweet_postedOn` AS `tweet_postedOn`, count(0) AS `COUNT(*)` FROM ((`tb_tweets` join `tb_loves`) join `tb_comment`) WHERE `tb_tweets`.`tweet_id` = `tb_loves`.`love_forTweet` AND `tb_tweets`.`tweet_id` = `tb_comment`.`comment_on` GROUP BY `tb_tweets`.`tweet_id` LIMIT 0, 150 ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tb_comment`
--
ALTER TABLE `tb_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_foreign_commentForTweet` (`comment_on`),
  ADD KEY `fk_foreign_commentUser` (`comment_by`);

--
-- Chỉ mục cho bảng `tb_follows`
--
ALTER TABLE `tb_follows`
  ADD PRIMARY KEY (`follow_id`);

--
-- Chỉ mục cho bảng `tb_loves`
--
ALTER TABLE `tb_loves`
  ADD PRIMARY KEY (`love_id`),
  ADD KEY `fk_foreign_byTweet` (`love_forTweet`),
  ADD KEY `fk_foreign_byUser` (`love_by`);

--
-- Chỉ mục cho bảng `tb_messages`
--
ALTER TABLE `tb_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `fk_foreign_from` (`message_from`);

--
-- Chỉ mục cho bảng `tb_notifications`
--
ALTER TABLE `tb_notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `fk_foreign_NotiFor` (`notification_for`),
  ADD KEY `fk_foreign_NotiFrom` (`notification_fromTweet`),
  ADD KEY `fk_foreign_notiBy` (`notification_by`);

--
-- Chỉ mục cho bảng `tb_retweet`
--
ALTER TABLE `tb_retweet`
  ADD PRIMARY KEY (`retweet_id`);

--
-- Chỉ mục cho bảng `tb_tweets`
--
ALTER TABLE `tb_tweets`
  ADD PRIMARY KEY (`tweet_id`),
  ADD KEY `fk_foreign_tweets` (`tweet_by`);

--
-- Chỉ mục cho bảng `tb_uploadedimages`
--
ALTER TABLE `tb_uploadedimages`
  ADD PRIMARY KEY (`uploadedImage_id`),
  ADD KEY `fk_foreign_uploadImageForTweet` (`uploadedImage_forTweet`);

--
-- Chỉ mục cho bảng `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `tb_verification`
--
ALTER TABLE `tb_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_verify` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tb_comment`
--
ALTER TABLE `tb_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT cho bảng `tb_follows`
--
ALTER TABLE `tb_follows`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `tb_loves`
--
ALTER TABLE `tb_loves`
  MODIFY `love_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT cho bảng `tb_messages`
--
ALTER TABLE `tb_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tb_notifications`
--
ALTER TABLE `tb_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `tb_retweet`
--
ALTER TABLE `tb_retweet`
  MODIFY `retweet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tb_tweets`
--
ALTER TABLE `tb_tweets`
  MODIFY `tweet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=443;

--
-- AUTO_INCREMENT cho bảng `tb_uploadedimages`
--
ALTER TABLE `tb_uploadedimages`
  MODIFY `uploadedImage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `tb_verification`
--
ALTER TABLE `tb_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tb_comment`
--
ALTER TABLE `tb_comment`
  ADD CONSTRAINT `fk_foreign_commentForTweet` FOREIGN KEY (`comment_on`) REFERENCES `tb_tweets` (`tweet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_foreign_commentUser` FOREIGN KEY (`comment_by`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_loves`
--
ALTER TABLE `tb_loves`
  ADD CONSTRAINT `fk_foreign_byTweet` FOREIGN KEY (`love_forTweet`) REFERENCES `tb_tweets` (`tweet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_foreign_byUser` FOREIGN KEY (`love_by`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_messages`
--
ALTER TABLE `tb_messages`
  ADD CONSTRAINT `fk_foreign_from` FOREIGN KEY (`message_from`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_foreign_message_by` FOREIGN KEY (`message_id`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_notifications`
--
ALTER TABLE `tb_notifications`
  ADD CONSTRAINT `fk_foreign_NotiFor` FOREIGN KEY (`notification_for`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_foreign_NotiFrom` FOREIGN KEY (`notification_fromTweet`) REFERENCES `tb_tweets` (`tweet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_foreign_notiBy` FOREIGN KEY (`notification_by`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_tweets`
--
ALTER TABLE `tb_tweets`
  ADD CONSTRAINT `fk_foreign_tweets` FOREIGN KEY (`tweet_by`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_uploadedimages`
--
ALTER TABLE `tb_uploadedimages`
  ADD CONSTRAINT `fk_foreign_uploadImageForTweet` FOREIGN KEY (`uploadedImage_forTweet`) REFERENCES `tb_tweets` (`tweet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_verification`
--
ALTER TABLE `tb_verification`
  ADD CONSTRAINT `fk_foreign_verify` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
