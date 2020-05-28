-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2020 年 5 月 28 日 13:16
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
-- テーブルの構造 `genre_table`
--

CREATE TABLE `genre_table` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `genre_table`
--

INSERT INTO `genre_table` (`genre_id`, `genre_name`) VALUES
(1, '食べる'),
(2, '買う'),
(3, '遊ぶ'),
(4, '癒し'),
(5, '学ぶ・知る');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genre_table`
--
ALTER TABLE `genre_table`
  ADD PRIMARY KEY (`genre_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genre_table`
--
ALTER TABLE `genre_table`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
