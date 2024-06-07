-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Haz 2024, 00:23:17
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `jobs`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `about`
--

INSERT INTO `about` (`id`, `image_path`, `text`) VALUES
(2, '../admin/uploads/66576ac2249552.37975615.jpg', '&lt;p&gt;&lt;strong&gt;Job Pursuit,&lt;/strong&gt; iş bulma s&amp;uuml;recini kolaylaştırmayı hedefleyen bir iş platformudur.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Misyonumuz,&lt;/strong&gt; iş arayanlarla işverenleri bir araya getirerek karşılıklı fayda sağlamaktır. Vizyonumuz İş arama s&amp;uuml;recini yeniden tanımlamak ve adaylar ile işverenler arasında etkili iletişim ve bağlantı kurmayı sağlamak.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Değerlerimiz&lt;/strong&gt; M&amp;uuml;şteri Odaklılık: M&amp;uuml;şterilerimizin ihtiya&amp;ccedil;larını anlamak ve onlara en iyi hizmeti sunmak.&lt;/p&gt;\r\n\r\n&lt;p&gt;Şeffaflık: A&amp;ccedil;ık ve d&amp;uuml;r&amp;uuml;st iletişimle g&amp;uuml;venilir bir platform olmak. İnovasyon: S&amp;uuml;rekli olarak platformumuzu geliştirmek ve yenilik&amp;ccedil;i &amp;ccedil;&amp;ouml;z&amp;uuml;mler sunmak.&lt;/p&gt;\r\n\r\n&lt;p&gt;Ekip &amp;Ccedil;alışması: İşbirliği ve dayanışma i&amp;ccedil;inde &amp;ccedil;alışarak başarıyı elde etmek.&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `img`, `author_id`, `created_at`) VALUES
(2, 'deneme', 'deneme deneme deememe', 'uploads/66637e15057353.02035709.jpg', 8, '2024-05-30 13:13:57'),
(4, 'deneme123', 'deneme deneme deememe 123', 'uploads/66637f01d16e69.44085841.jpg', 8, '2024-05-30 13:13:57'),
(7, 'deneme IK', 'Deneme', 'uploads/66637f74a50c92.23452990.jpg', 16, '2024-06-01 08:22:56'),
(9, 'blog 12', 'deneme12', 'uploads/66637f7fd9add8.03820796.jpg', 8, '2024-06-07 21:42:16');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`id`, `blog_id`, `author`, `email`, `subject`, `comment`, `date`) VALUES
(4, 2, 'denem', 'ozmenyusufatakan@gmail.com', 'deneme', 'dasdasdsadasd', '2024-05-31 12:30:33'),
(5, 4, 'yusuf atakan', 'sonis@gmail.com', 'deneme', 'fdsafsdfsdaf', '2024-06-01 12:57:15'),
(6, 4, 'yusuf atakan', 'deneme@yusuf.com', 'sadfsdaff', 'asdfdff', '2024-06-01 12:58:46'),
(7, 7, 'denemd', 'deneme@atakan.com', 'deneme', 'deneme', '2024-06-02 13:39:08'),
(9, 4, 'Blog sayım Deneme', 'ozmenyusufatakan@gmail.com', 'BLOG SAYIM DENEME', 'BLOG SAYIM DENEME', '2024-06-07 22:53:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `google_maps_embed` text NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `contact_info`
--

INSERT INTO `contact_info` (`id`, `phone_number`, `email_address`, `google_maps_embed`, `facebook_link`, `twitter_link`, `linkedin_link`) VALUES
(1, '545454545454', 'info@jobsagency.com', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d195884.30043175886!2d32.597958319630735!3d39.90352329770587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d347d520732db1%3A0xbdc57b0c0842b8d!2sAnkara!5e0!3m2!1str!2str!4v1717101751210!5m2!1str!2str\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://www.facebook.com/example', 'https://www.twitter.com/example', 'https://www.linkedin.com/in/yusufatakanozmen');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'deneme', 'deneme@ozal.edu.tr', 'deneme', '2024-06-01 09:27:05'),
(3, 'atakan ', 'sonis@gmail.com', 'deneme metnidir', '2024-06-01 09:28:19'),
(9, 'Yusuf Atakan Özmen', 'ozmenyusufatakan@gmail.com', 'selam ', '2024-06-03 19:02:23'),
(10, 'Yusuf Atakan Özmen', 'ozmenyusufatakan@gmail.com', 'deneme mesajıdır', '2024-06-07 21:52:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `img` varchar(150) NOT NULL,
  `city` varchar(150) NOT NULL,
  `sector` varchar(150) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `description`, `email`, `company_name`, `img`, `city`, `sector`, `date`, `user_id`) VALUES
(22, 'Software Developer', 'We are looking for a skilled software developer to join our team. Must have experience in Java and Spring Framework.', 'deneme@gmail.com', 'deneme_company', 'uploads/1.jpg', 'San Francisco', 'Technology', '2024-05-28', 8),
(23, 'Marketing Manager', 'Seeking an experienced marketing manager to lead our marketing team. Must have experience in digital marketing and SEO.', 'deneme@gmail.com', 'deneme_company', 'uploads/2.jpg', 'New York', 'Marketing', '2024-05-28', 15),
(24, 'Graphic Designer', 'Creative graphic designer needed for our design team. Proficiency in Adobe Creative Suite is required.', 'deneme@gmail.com', 'deneme_company', 'uploads/3.jpg', 'Los Angeles', 'Design', '2024-05-28', 16),
(25, 'Accountant', 'Detail-oriented accountant needed to manage financial records and ensure compliance with tax regulations.', 'deneme@gmail.com', 'deneme_company', 'uploads/4.jpg', 'Chicago', 'Finance', '2024-05-28', 17),
(33, 'Software Developer', 'We are looking for a skilled software developer to join our team. Must have experience in Java and Spring Framework.', 'deneme@gmail.com', 'deneme_company', 'uploads/1.jpg', 'San Francisco', 'Technology', '2024-05-28', 8),
(34, 'Graphic Designer', 'Creative graphic designer needed for our design team. Proficiency in Adobe Creative Suite is required.', 'deneme@gmail.com', 'deneme_company', 'uploads/3.jpg', 'Los Angeles', 'Design', '2024-05-28', 16);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_status` enum('unread','read','','') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `name`, `email`, `phone`, `cover_letter`, `resume`, `application_date`, `read_status`) VALUES
(1, 22, 'deneme', 'deneme@ozal.edu.tr', 'dededed', 'dede', '../admin/uploads/Techcareer.net X PeopleBox Bitirme Projesi.pdf', '2024-05-31 20:43:46', 'read'),
(6, 23, 'deneme', 'deneme@atakan.com', '5466545646', 'fsdafsdafsdaf sa', '50bcb6cba6b0fae47b237c00bb03b4848ad69e4dc6ca301a4fe3b8777fa81e68.docx', '2024-06-01 12:13:11', 'unread'),
(8, 22, 'eyup', 'eyup.ylmz3449@gmail.com', 'deneme', 'ded de ed ', 'cdfcfe5b960c2eb73cafdf325fc1f6e1a30fc4de0c19e27bdafbd8b5ed0d5580.pdf', '2024-06-02 22:14:46', 'read'),
(9, 23, 'Yusuf Atakan Özmen', 'ozmenyusufatakan@gmail.com', '05452757110', 'deneme deneme', 'fa77b86ad9308ea6d73995f3b4e25a478af2250702bf47e3c338d1280d0fcb81.pdf', '2024-06-03 11:45:28', 'read'),
(11, 23, 'eyup', 'yusufatakanozmen06@gmail.com', '05452757110', 'sadasd sadsad as', '50bcb6cba6b0fae47b237c00bb03b4848ad69e4dc6ca301a4fe3b8777fa81e68.docx', '2024-06-03 13:05:17', 'read'),
(13, 23, 'Yusuf Atakan Özmen', 'ozmenyusufatakan@gmail.com', '05452757110', 'DENEME MAİL', 'cdfcfe5b960c2eb73cafdf325fc1f6e1a30fc4de0c19e27bdafbd8b5ed0d5580.pdf', '2024-06-04 12:44:01', 'unread'),
(19, 25, 'Yusuf Atakan Özmen', 'ozmenyusufatakan@gmail.com', '05452757110', 'deneme', '4036bacfbf49920a56c3f8b6a047c15e8c749468fd7a0ff8ab42aad819d88966.docx', '2024-06-07 20:17:22', 'unread'),
(20, 34, 'Yusuf Atakan Özmen', 'ozmenyusufatakan@gmail.com', '05452757110', 'denemem', 'cdfcfe5b960c2eb73cafdf325fc1f6e1a30fc4de0c19e27bdafbd8b5ed0d5580.pdf', '2024-06-07 20:18:57', 'unread');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('job_application','blog_comment','contact_message') DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `is_read`, `created_at`) VALUES
(1, 0, 'contact_message', 'New contact message from deneme', 1, '2024-06-01 09:27:05'),
(2, 0, 'contact_message', 'New contact message from atakan ', 1, '2024-06-01 09:27:54'),
(3, 0, 'contact_message', 'New contact message from atakan ', 1, '2024-06-01 09:28:19'),
(4, NULL, 'job_application', 'New job application received from User ID ', 1, '2024-06-01 09:55:28'),
(5, NULL, 'job_application', 'New job application received from User ID ', 1, '2024-06-01 09:55:42'),
(6, NULL, 'job_application', 'New job application received from User ID ', 1, '2024-06-01 09:56:12'),
(7, NULL, 'job_application', 'New job application received from User ID ', 1, '2024-06-01 09:56:15'),
(8, NULL, 'job_application', 'New job application received from User ID ', 1, '2024-06-01 09:56:50'),
(9, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-01 09:57:21'),
(10, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-01 09:58:20'),
(11, 0, 'contact_message', 'New contact message from atakan ', 1, '2024-06-01 10:24:22'),
(12, 0, 'contact_message', 'New contact message from atakan ', 1, '2024-06-01 10:44:33'),
(13, 0, 'contact_message', 'New contact message from atakan ', 1, '2024-06-01 10:46:00'),
(14, 1, 'blog_comment', 'New job application received from User ID 1', 1, '2024-06-01 10:57:15'),
(15, 1, 'blog_comment', 'New comment added to blog ID 4 by yusuf atakan', 1, '2024-06-01 10:58:46'),
(16, 0, 'contact_message', 'New contact message from yusuf', 1, '2024-06-01 11:06:40'),
(17, 0, 'contact_message', 'New contact message from atakan ', 1, '2024-06-01 11:10:54'),
(18, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-01 13:10:34'),
(19, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-01 13:13:11'),
(20, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-02 10:17:57'),
(21, 1, 'blog_comment', 'New comment added to blog ID 7 by denemd', 1, '2024-06-02 11:39:08'),
(22, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-02 23:14:46'),
(23, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-03 12:45:28'),
(24, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-03 14:02:35'),
(25, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-03 14:05:17'),
(26, 0, 'contact_message', 'New contact message from Yusuf Atakan Özmen', 1, '2024-06-03 19:02:23'),
(27, 1, 'blog_comment', 'New comment added to blog ID 2 by abdurrezak', 1, '2024-06-04 13:25:39'),
(28, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-04 13:40:48'),
(29, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-04 13:44:01'),
(30, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-04 13:44:41'),
(31, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-04 13:44:43'),
(32, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-04 13:44:57'),
(33, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-04 13:45:51'),
(34, 1, 'blog_comment', 'New comment added to blog ID 4 by Blog sayım Deneme', 1, '2024-06-07 20:53:43'),
(35, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-07 21:16:40'),
(36, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-07 21:17:22'),
(37, 1, 'job_application', 'New job application received from User ID 1', 1, '2024-06-07 21:18:57'),
(38, 0, 'contact_message', 'New contact message from Yusuf Atakan Özmen', 1, '2024-06-07 21:52:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `social_media` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `team`
--

INSERT INTO `team` (`id`, `image_path`, `position`, `name`, `social_media`) VALUES
(1, '../admin/uploads/66636c64511141.64181383.jpg', 'Developer', 'Atakan', 'https://www.linkedin.com/in/yusufatakanozmen/'),
(8, '../admin/uploads/66636ca4beb520.76848559.jpg', 'CEO', 'Yusuf Atakan Özmen', 'https://www.linkedin.com/in/yusufatakanozmen/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(150) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `date`) VALUES
(8, 'admin', 'admin@gmail.com', '$2y$10$3SuM1gezATXF8WKFcnZJWuEZZmjRnTgsvGV23bkusk/9XKoVA/HnC', 'admin', '2024-05-28'),
(15, 'YusufAtakan', 'ozmenyusufatakan@gmail.com', '$2y$10$MtWWSwzqrl4CKQOzpx8PDOKL1edChuAC1D4YPpX0/qE11PX09CibG', 'admin', '2024-05-28'),
(16, 'atakan', 'atakan@gmail.com', '$2y$10$Jp/AXJgL8CEaqqZvjvaM4OlNwoMNmEgxROh3Ks4xaXqpoS6FbAxJ2', 'IK', '2024-05-28'),
(17, 'eyup', 'egitim@alvagrup.com', '$2y$10$WDENGvvEwS1r22OlE0R5TeY.r45jfwxiPVvqZH.D1o76cAnzMpqWe', 'employee', '2024-05-28'),
(22, 'deneme', 'lamicir524@avastu.com', '$2y$10$pB9pv..MUVbY2j8P3C3QLOnMBR9Cn6mkLph86q/EahhPZJ.og.5wC', 'Admin', '2024-06-01'),
(24, 'admin13', 'eyup.ylmz3449@gmail.com', '$2y$10$oUf4eDKZUyQ3RTTybVURHO0WTYPCrulH6fC.U97BthnWStOX4k8X2', 'IK', '2024-06-03'),
(25, 'admin20', 'vesose4385@cnurbano.com', '$2y$10$eEf.8k84egnkFn.S7HTCqeunZ3qpabpZiPBAJC3/C.QOb8A.WIVWi', 'IK', '2024-06-08');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Tablo için indeksler `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Tablo için indeksler `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tablo için AUTO_INCREMENT değeri `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Tablo için AUTO_INCREMENT değeri `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Tablo kısıtlamaları `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Tablo kısıtlamaları `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
