-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 09 Tem 2023, 23:56:33
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
-- Veritabanı: `abccompany`
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
('DoctrineMigrations\\Version20230709232137', '2023-07-09 23:22:49', 2321);

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
(1, 3, 'ORD-1688896578', 2, 'User Adres', '2023-07-09 23:23:02', 1),
(2, 2, 'ORD-1688944982', 2, 'User Adres', '2023-07-09 23:23:02', 2),
(3, 3, 'ORD-1688944982', 2, 'User Adres', '2023-07-09 23:23:02', 3),
(4, 2, 'ORD-1688945019', 3, 'Adresss', '2023-07-15 00:00:00', 1),
(5, 2, 'ORD-1688946940', 3, 'Adres', NULL, 2);

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
(1, 'musteri1@abccompany.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$UGNJRE9sbGVMWENXdDQxRA$7lhXiylPayK4V4OCW0CduLeWTFmkzLXTdHBO9/y7n/E'),
(2, 'musteri2@abccompany.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$MW4yQjF2Q1djSkl2Zm84dA$B9lk5NrdYStirYORy8l2Kia9DWC53SFERRHlE0Bjll0'),
(3, 'musteri3@abccompany.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$WTdpbEpEYlVHSmIxdFJEUQ$NWQZzc1HOqP/OdqM6ixHT8VbIIo3dxxvHo9GPcK/Ysc');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
