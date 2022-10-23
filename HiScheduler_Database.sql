-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-09-22 16:47:56
-- サーバのバージョン： 10.4.20-MariaDB
-- PHP のバージョン: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `hischeduler`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `details` text NOT NULL,
  `pdf_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  `area_password` text NOT NULL,
  `admin_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `area`
--

INSERT INTO `area` (`id`, `area_name`, `area_password`, `admin_password`) VALUES
(16, '広島', '$2y$10$rfORoJ/aEx0wswiviO9/L.R0jFmkUYd/OvF6clzyooE4JP9Gyl3h6', '$2y$10$VxzeuCb7.QqOjVUhuPvAnOJXcuW5n9IRuFvh3428Zj9OScs9y7eO.');

-- --------------------------------------------------------

--
-- テーブルの構造 `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `com_name` varchar(100) NOT NULL,
  `com_password` text NOT NULL,
  `admin_password` text NOT NULL,
  `area` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `company`
--

INSERT INTO `company` (`id`, `com_name`, `com_password`, `admin_password`, `area`) VALUES
(5, 'KTT PROJECTS', '$2y$10$KzkQFAv470g3EHX7y1xu3usTFE7Hz.8rqbJrCvfo5Hnx.LcxNHoqG', '$2y$10$8/WuUWp8FCR/i.AOzwJrZemBr6x9QT2JeN/DQh0OWToyEwVxu14NS', '広島');

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `area` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `permission` int(11) NOT NULL DEFAULT 0,
  `history` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`id`, `area`, `company`, `name`, `password`, `permission`, `history`) VALUES
(6, '広島', 'KTT PROJECTS', 'Takami Marsh', '$2y$10$91Vz/G4QFSi4JWTyZ973pu99fwFs/YBHGEPaWD.QKDJ6w9m7/uvh.', 0, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pdf_path` (`pdf_path`);

--
-- テーブルのインデックス `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `area_name` (`area_name`);

--
-- テーブルのインデックス `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `com_name` (`com_name`,`area`) USING BTREE;

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `area` (`area`,`company`,`name`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- テーブルの AUTO_INCREMENT `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
