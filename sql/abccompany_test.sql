-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 09 Tem 2023, 23:56:37
-- Sunucu sürümü: 5.7.24
-- PHP Sürümü: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `abccompany_test`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230709232137', '2023-07-09 23:43:55', 2002);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_date` datetime DEFAULT NULL,
  `productId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `quantity`, `address`, `shipping_date`, `productId`) VALUES
(1, 2, 'ORD-1688896578', 2, 'User Adres', '2023-07-09 23:44:14', 1),
(2, 1, 'ORD-1688946254', 2, 'User Adres', '2023-07-09 23:44:14', 2),
(3, 3, 'ORD-1688946254', 2, 'User Adres', '2023-07-09 23:44:14', 3),
(4, 1, 'ORD-1688946277', 10, '123 Test Adres', '2023-07-10 00:00:00', 1),
(5, 1, 'ORD-1688946278', 3, '123 Test Street', NULL, 1),
(6, 1, 'ORD-1688946400', 10, '123 Test Adres', '2023-07-10 00:00:00', 1),
(7, 1, 'ORD-1688946401', 3, '123 Test Street', '2023-07-12 00:00:00', 1),
(8, 1, 'ORD-1688946620', 10, '123 Test Adres', '2023-07-10 00:00:00', 1),
(9, 1, 'ORD-1688946621', 3, '123 Test Street', '2023-07-12 00:00:00', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `product`
--

INSERT INTO `product` (`id`, `name`, `price`) VALUES
(1, 'Ürün 1', '10.99'),
(2, 'Ürün 2', '20.99'),
(3, 'Ürün 3', '30.99');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'musteri1@abccompany.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$ckR5akx5MWJwN0lFT1JRbA$+HK/ANDu0iBW2TQwhkHqDcQ9oAG1uR+2ukkD+vqSGyI'),
(2, 'musteri2@abccompany.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$ay5wdS4vNERadEFqWmNuQg$Sayf5qn/ciSb/FWRDUmCEOuMMjWsCTmiGNk1uZDo6a0'),
(3, 'musteri3@abccompany.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$REZvTko2cXliSVNZSXY5SQ$js8PzQ4/PS+AX/PqdcM24aYNy3E2omrPTQZofjxlORk');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E52FFDEEA76ED395` (`user_id`),
  ADD KEY `IDX_E52FFDEE36799605` (`productId`);

--
-- Tablo için indeksler `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEE36799605` FOREIGN KEY (`productId`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_E52FFDEEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
