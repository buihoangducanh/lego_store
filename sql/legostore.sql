-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th6 12, 2023 lúc 02:36 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `legostore`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`) VALUES
(2, 'Phương Tiện', 1),
(3, 'Nhà', 1),
(4, 'Tự do', 1),
(5, 'Đế lắp', 1),
(6, 'Khác', 1),
(7, 'Siêu anh hùng', 1),
(8, 'Súng Đạn', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `total` decimal(13,2) DEFAULT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `receivedDate` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `cancelled_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `userId`, `total`, `createdDate`, `receivedDate`, `status`, `cancelled_date`) VALUES
(45, 39, 4598000.00, '2023-06-11 17:43:29', '2023-06-11 13:38:34', 'Complete', NULL),
(46, 39, 3827000.00, '2023-06-11 18:42:17', '2023-06-11 18:43:12', 'Complete', NULL),
(47, 39, 5949000.00, '2023-06-11 18:45:30', '2023-06-14 00:00:00', 'Delivering', NULL),
(48, 39, 629000.00, '2023-06-11 23:27:33', NULL, 'Cancelled', NULL),
(49, 39, 7299000.00, '2023-06-12 06:34:29', NULL, 'Cancelled', '2023-06-12 01:47:21'),
(50, 40, 629000.00, '2023-06-12 06:51:00', NULL, 'Cancelled', '2023-06-12 06:51:04'),
(51, 40, 2398000.00, '2023-06-12 07:03:10', '2023-06-12 07:03:56', 'Complete', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `productPrice` decimal(10,0) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `productImage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `orderId`, `productId`, `qty`, `productPrice`, `productName`, `productImage`) VALUES
(45, 45, 9, 2, 2299000, 'Trung Tâm Mua Sắm Heartlake', 'trung_tam_mua_sam_heartlake.jpg'),
(46, 46, 2, 2, 1599000, 'Siêu Xe Đua Ford GT Heritage Edition & Bronco R', 'GT_Heritage_Edition_Bronco_R.jpg'),
(47, 46, 3, 1, 629000, 'Chiến Xe Monster Jam Grave Digger', 'Monster_Jam_Grave_Digger.jpg'),
(48, 47, 4, 1, 949000, 'Ca nô Đệm Khí Cứu Hộ', 'LEGO_TECHNIC_42120.jpg'),
(49, 47, 5, 1, 5000000, 'Xe Vận Tải Hạng Nặng', 'Xe_Van_Tai_Hang_Nang.jpg'),
(50, 48, 3, 1, 629000, 'Chiến Xe Monster Jam Grave Digger', 'Monster_Jam_Grave_Digger.jpg'),
(51, 49, 9, 1, 2299000, 'Trung Tâm Mua Sắm Heartlake', 'trung_tam_mua_sam_heartlake.jpg'),
(52, 49, 5, 1, 5000000, 'Xe Vận Tải Hạng Nặng', 'Xe_Van_Tai_Hang_Nang.jpg'),
(53, 50, 3, 1, 629000, 'Chiến Xe Monster Jam Grave Digger', 'Monster_Jam_Grave_Digger.jpg'),
(54, 51, 2, 2, 1199000, 'Siêu Xe Đua Ford GT Heritage Edition & Bronco R', 'GT_Heritage_Edition_Bronco_R.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `originalPrice` decimal(10,0) NOT NULL,
  `promotionPrice` decimal(10,0) NOT NULL,
  `image` varchar(50) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdDate` date NOT NULL DEFAULT current_timestamp(),
  `cateId` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `des` varchar(1000) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `soldCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `originalPrice`, `promotionPrice`, `image`, `createdBy`, `createdDate`, `cateId`, `qty`, `des`, `status`, `soldCount`) VALUES
(2, 'Siêu Xe Đua Ford GT Heritage Edition & Bronco R', 1999999, 1199000, 'GT_Heritage_Edition_Bronco_R.jpg', 1, '0000-00-00', 2, 54, 'Trẻ em và những người đam mê ô tô sẽ thích bộ đồ chơi xây dựng LEGO Speed Champions 76905 Siêu Xe Đua Ford GT Heritage Edition & Bronco R (660 chi tiết) này. Được đóng gói với các chi tiết thực tế, những mô hình sao chép tuyệt vời này mang lại trải nghiệm xây dựng bổ ích, trông tuyệt vời khi trưng bày và tuyệt vời cho sử thi hành động đua off-road và trên đường đua! Chi tiết đầy cảm hứng! Những chiếc xe trong vở kịch này có khung gầm rộng, cho phép đủ chỗ cho khoang lái 2 chỗ ngồi và thậm chí còn có nhiều chi tiết chân thực hơn.', 1, 9),
(3, 'Chiến Xe Monster Jam Grave Digger', 900000, 629000, 'Monster_Jam_Grave_Digger.jpg', 1, '0000-00-00', 2, 19, 'Bạn đang tìm một món đồ chơi hoặc món quà thú vị cho những bé trai và bé gái yêu thích xe tải Monster Jam®? Xe tải kéo LEGO TECHNIC 42118 Chiến Xe Monster Jam Grave Digger ( 212 Chi tiết) được tích hợp các tính năng mà trẻ em sẽ thích. Những nét chấm phá chân thực bao gồm đồ họa Grave Digger với các chi tiết huyền bí, cùng với lốp xe khổng lồ, lá cờ có thể di chuyển và đèn pha màu đỏ.', 1, 1),
(4, 'Ca nô Đệm Khí Cứu Hộ', 1000000, 949000, 'LEGO_TECHNIC_42120.jpg', 1, '0000-00-00', 2, 14, 'Bạn đang tìm kiếm món quà hoàn hảo cho những trẻ thích những chiếc xe thú vị? Chắc chắn các bé sẽ thích món đồ chơi LEGO® Technic ™ Ca nô Đệm Khí Cứu Hộ (42120) này. Được trang bị đầy đủ các tính năng đích thực, Ca nô Đệm Khí Cứu Hộ hoàn hảo để tái tạo các nhiệm vụ cứu hộ gay cấn. Các bé trai và bé gái từ 8 tuổi trở lên sẽ thích nhìn chiếc xe đồ chơi bay lơ lửng khi nó lăn trên các bánh xe được giấu kín.', 1, 6),
(5, 'Xe Vận Tải Hạng Nặng', 5500000, 5000000, 'Xe_Van_Tai_Hang_Nang.jpg', 1, '0000-00-00', 2, 7, 'Đồ Chơi LEGO Xe Vận Tải Hạng Nặng 42128', 1, 3),
(6, 'Siêu Xe Mclaren Senna GTR', 1899000, 1699000, 'Mclaren_Senna_GTR.jpg', 1, '0000-00-00', 2, 7, 'Bạn đang tìm kiếm món quà tuyệt vời dành cho trẻ em hoặc thanh thiếu niên yêu thích đồ chơi siêu xe? LEGO® Technic McLaren Senna GTR ™ (42123) này là một lựa chọn tuyệt vời - và những người hâm mộ McLaren trưởng thành cũng sẽ thích nó! Được trang bị các tính năng chân thực lấy cảm hứng từ đường đua gốc - biểu tượng siêu xe, đồ chơi mô hình sưu tập này chắc chắn sẽ thiết lập các cuộc đua gây cấn.', 1, 3),
(7, 'Lâu Đài Taj Mahal', 4500000, 3999000, 'Lau_Dai_Taj_Mahal.jpg', 1, '2021-12-07', 3, 7, 'Cho dù bạn đã đủ may mắn để tự mình đến thăm Taj Mahal và muốn có một món quà lưu niệm đặc biệt về trải nghiệm, hoặc bạn đang ước mơ được đến thăm nơi này một ngày nào đó hay chỉ là niềm yêu thích những tòa nhà trang nhã, bộ sưu tập LEGO Architecture 21056 Lâu Đài Taj Mahal (2022 chi tiết) này là lựa chọn lý tưởng dành cho bạn.', 1, 3),
(8, 'Biệt Thự Gia Đình Của Andrea', 2599000, 2299000, 'Biet_thu_gia_dinh_andrea.jpg', 1, '2021-12-07', 3, 7, 'Bộ lắp ghép LEGO FRIENDS 41449 Biệt Thự Gia Đình Của Andrea ( 802 Chi tiết) chắc chắn sẽ là món quà tuyệt vời khiến bé con của bạn hạnh phúc. Chi tiết tuyệt vời, từ các tấm năng lượng mặt trời trên mái nhà đến bàn phím mini trong xưởng để xe, bộ lắp ghép đóng kịch cao cấp này sẽ làm hài lòng những người hâm mộ LEGO Friends. ', 1, 3),
(9, 'Trung Tâm Mua Sắm Heartlake', 2599000, 2299000, 'trung_tam_mua_sam_heartlake.jpg', 1, '2021-12-07', 3, 5, 'Đàn guitar Takamine D2D là sản phẩm nổi bật của thương hiệu Takamine Nhật Bản và được rất nhiều tín đồ săn đón trong thời gian gần đây. Không những mang đến một thiết kế dáng đàn đẹp mắt, vừa vặn với mọi dáng người mà âm thanh tuyệt vời mà bạn không thể chê vào đâu được.', 1, 5),
(10, 'Thùng Gạch Trung Classic Sáng Tạo', 1000000, 880000, 'Classic_Creative_Medium_Size.jpg', 1, '2021-12-07', 4, 10, 'Được thiết kế dành cho các nhà xây dựng ở mọi lứa tuổi, bộ sưu tập gạch LEGO® với 35 màu sắc khác nhau này sẽ khuyến khích chơi xây dựng không gian mở và truyền cảm hứng cho mọi trí tưởng tượng. Cửa sổ, mắt và rất nhiều bánh xe tăng thêm sự thú vị và cung cấp khả năng vô tận cho việc xây dựng và chơi xe sáng tạo. Một bộ bổ sung tuyệt vời cho bất kỳ bộ sưu tập LEGO hiện có nào, bộ này đi kèm trong một hộp lưu trữ bằng nhựa tiện lợi và bao gồm các ý tưởng để bắt đầu xây dựng.', 0, 0),
(11, 'Thùng Gạch Lớn Classic Sáng Tạo', 2000000, 1920000, 'Classic_Creative_Large_Size.jpg', 1, '2021-12-07', 4, 10, 'Xây dựng đồ chơi cho trẻ em với LEGO CLASSIC Gạch Sáng Tạo Động Vật 11011, bao gồm một ngôi nhà LEGO ấm cúng, xe đồ chơi, bàn phím nhạc, đồ chơi khủng long đỏ dễ thương hoặc bất cứ điều gì bạn có thể tưởng tượng với bộ LEGO Classic rực rỡ này!', 1, 0),
(12, 'Gạch Sáng Tạo Động Vật', 2500000, 2159000, 'Creative_animal_bricks.jpg', 1, '2021-12-07', 4, 10, 'Đàn guitar Taylor 214CE DLX sở hữu thiết kế độc đáo với đường nét trên cơ thể mượt mà mang đến âm thanh trung thực, giai điệu rõ ràng và sử dụng chất liệu gỗ rosewood đem lại giai điệu tuyệt vời trong một loại nhạc cụ tuyệt đẹp.', 1, 0),
(13, 'Đế Lắp Ráp Màu Xanh Lá', 300000, 250000, '04_106_1.jpg', 1, '2021-12-07', 5, 20, 'Cho dù bạn đang tạo ra một khu vườn, khu rừng hay thứ gì đó theo trí tưởng tượng của riêng bạn, tấm đế 32x32 màu xanh lá cây này là điểm khởi đầu hoàn hảo để xây dựng, trưng bày và chơi với các tác phẩm LEGO® của bạn.', 1, 0),
(14, 'Đế Lắp Ráp Màu Xanh Nước Biển', 300000, 250000, '04_107.jpg', 1, '2021-12-07', 5, 15, 'Cho dù bạn đang tạo ra một khu vườn, khu rừng hay thứ gì đó theo trí tưởng tượng của riêng bạn, tấm đế 32x32 màu xanh lá cây này là điểm khởi đầu hoàn hảo để xây dựng, trưng bày và chơi với các tác phẩm LEGO® của bạn.', 1, 0),
(15, 'Đế Lắp Ráp Màu Trắng', 300000, 250000, '08_110.jpg', 1, '2021-12-07', 5, 10, 'Chưa bao giờ có một tấm nền LEGO màu trắng lớn như bộ đồ chơi lắp ráp này! Với diện tích hơn 10 \' (25cm), đồ chơi LEGO CLASSIC Đế Lắp Ráp Màu Trắng - 11010 mang đến cho trẻ em một khung cảnh LEGO rộng 32x32- stud để xây dựng, chơi và hiển thị. Lớn hơn, tốt hơn, sáng hơn, trắng hơn!', 1, 0),
(16, 'Khu Rừng Rậm Ma Quái', 2300000, 1699000, 'horror_jungle.jpg', 1, '2021-12-07', 6, 10, 'Không ai được an toàn trong rừng với LEGO Minecraft 21176 Khu Rừng Rậm Ma Quái (489 chi tiết). Bộ xây dựng và chơi sáng tạo này có con quái vật cùng với một loạt các nhân vật và tính năng Minecraft thú vị. Người chơi Minecraft sẽ thích chạm tay vào con quái vật to lớn, và bắt đầu chiến đấu. Với cái đầu khổng lồ, có thể di chuyển, miệng mở và cánh tay được tạo ra để nghiền nát, Jungle Abomination là siêu mô hình rừng Minecraft. ', 1, 0),
(17, 'LEGO HARRY POTTER 76382 Lớp Học Môn Biến Hình ', 1000000, 899000, '09_71.jpg', 1, '2021-12-07', 6, 20, 'Lớp Học Môn Biến Hình (76382) là một bộ độ chơi chứa bên trong một quyển sách lắp ráp bằng gạch. Trẻ em mở nó ra và ngay lập tức tham gia g lớp học biến hình của Giáo sư McGonagall. Phép thuật của Hogwarts khiến cho trẻ em thích thú dù ở bất cứ nơi đâu. ', 1, 0),
(18, 'LEGO HARRY POTTER 76383 Lớp Học Môn Độc Dược', 1000000, 899000, '09_87.jpg', 1, '2021-12-07', 6, 5, 'Mở bộ độ chơi quyển sách kỳ diệu được lắp ráp bằng gạch và bước vào căn phòng Hogwarts ™! Lớp học môn độc dược của Giáo sư Snape sắp bắt đầu. Nhanh chóng! Lấy thiết bị của bạn từ kệ và tham gia cùng Draco Malfoy ™ và Seamus Finnigan với tư cách là người đứng đầu Nhà Slytherin ™ dạy phép thuật chế tạo độc dược.', 1, 0),
(21, 'Siêu Xe Porsche 911', 6000000, 5500000, '10295-tiki-th_1.jpg', 40, '2023-06-11', 2, 43, 'Hãy tôn vinh phong cách không thể nhầm lẫn của Porsche với thử thách xây dựng tuyệt vời này khi bạn tạo ra chiếc xe cổ điển, sưu tầm của riêng mình với bộ mô hình LEGO Icons 10295 Siêu Xe Porsche 911 (1458 chi tiết). Chọn chế tạo mô hình Turbo với động cơ tăng áp hoặc Targa với quán bar Targa mang tính biểu tượng của nó và một mái che có thể tháo rời để lưu trữ bên dưới mui xe. Chế tạo chiếc Porsche 911 yêu thích của bạn Cả hai mẫu xe mô hình Turbo và Targa đều có các chi tiết đặc trưng của Porsche 911 như cản trước và cản sau mang tính biểu tượng, đèn pha góc cạnh, logo in và biển số. ', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Normal');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `address` varchar(500) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `fullname`, `dob`, `password`, `role_id`, `status`, `address`, `phone_number`) VALUES
(1, 'anhbui26@gmail.com', 'Bùi Hoàng Đức Anh', '2008-06-04', '$2a$12$fB68vD2t/Ouo1xFbOnM9Lu6m76LBz7.xpCJxE8lSnICCfOlqm5dnS', 1, 1, 'Cầu giấy, Hà nội', '0999222222'),
(39, 'anhbui@gmail.com', 'Bùi Hoàng Đức Anh', '2015-02-12', '$2a$12$0PtyIpc.EofbPpT1ILBmMeNxuFMS0p8zgen5zQ6.XzBlXznbyiG.K', 2, 1, 'Hà đông', '0987222888'),
(40, 'admin@gmail.com', 'Bùi Hoàng Đức Anh', '2002-11-26', '$2y$10$2CcP9fdmMx686TpnyYgc2ed9qNlpYhF4wmByLaeSrH7gA/Akr9u5S', 1, 1, 'Cầu Giấy, Hà Nội', '0348641180'),
(41, 'test@gmail.com', 'TEST USER', '2023-06-29', '$2y$10$4QhE7XcqwUfcttkFqkTU...rOrBU8dkh5LgdFRqkS3iBU5GwaEQUi', 2, 1, 'TEST', '0987222787');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`userId`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`orderId`),
  ADD KEY `product_id` (`productId`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cate_id` (`cateId`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_users_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cateId`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
