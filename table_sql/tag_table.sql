-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2020 年 5 月 28 日 02:29
-- サーバのバージョン： 5.5.62
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `codecamp34620`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `tag_table`
--

CREATE TABLE `tag_table` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tag_table`
--

INSERT INTO `tag_table` (`tag_id`, `tag_name`) VALUES
(1, 'かわいい'),
(2, 'おいしい'),
(3, 'たのしい'),
(4, 'きれい'),
(5, 'なつかしい');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tag_table`
--
ALTER TABLE `tag_table`
  ADD PRIMARY KEY (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tag_table`
--
ALTER TABLE `tag_table`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
