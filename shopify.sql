-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 12, 2020 at 07:17 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopify`
--

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `uid` varchar(16) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text DEFAULT NULL,
  `imageURL` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`uid`, `name`, `description`, `imageURL`) VALUES
('217780224163', 'Home page', '', ''),
('217942032547', 'Washing machines', '', ''),
('217942130851', 'LG', '', ''),
('217942392995', 'Samsung', '', ''),
('217942425763', 'STBs', '', ''),
('217942556835', 'Google', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/collections/image-20150902-6700-t2axrz.jpg?v=1599822559'),
('217942655139', 'Apple', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/collections/images.jpg?v=1599822616'),
('218159022243', 'New', 'Only new products.', ''),
('218812514467', 'Load washing machines', 'Load washing machines list.', '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `uid` varchar(16) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text DEFAULT NULL,
  `imageURL` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`uid`, `name`, `description`, `imageURL`, `price`, `stock`) VALUES
('5639019233443', 'Chromecast', '<br>', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_f76b24eb-b214-4ff1-987d-32604ae766b6.jpg?v=1599719227', 1196, 0),
('5643799429283', 'LG WTG6520', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_85117c8a-06fe-416a-888a-3f1a4956cf2a.png?v=1599719032', 14099, 0),
('5643802247331', 'LG WV5-1275W', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_a6269a87-c46e-49fa-b794-1715fa903ef5.jpg?v=1599719006', 26199, 0),
('5643807359139', 'WV5-1408', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image.jpg?v=1599718911', 17099, 0),
('5643810242723', 'Chromecast Ultra', 'Supports 4K.', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_347a5f85-a7bc-4487-8943-d456d554ab79.jpg?v=1599719182', 1999, 0),
('5643812339875', 'Apple TV HD 32 GB', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_bb3d640f-480c-42ba-a9a8-5f5803ffd1be.jpg?v=1599719278', 4199, 1),
('5643817910435', 'Apple TV 4K 32 GB', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_4052f63a-0209-4c61-a9ff-984051c8fcfd.jpg?v=1599719333', 5009, 0),
('5643827216547', 'Samsung Jet VS90', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_57853c47-e064-4a55-83ef-6269686cedb3.jpg?v=1599718976', 9000, 0),
('5643835375779', 'iPad Pro 4th 11\'\'', '', 'https://cdn.shopify.com/s/files/1/0477/7099/2803/products/image_22f27a58-1d94-48b5-aa14-ccf68da26e79.jpg?v=1599719143', 30099, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_has_collection`
--

CREATE TABLE `product_has_collection` (
  `product_uid` varchar(16) NOT NULL,
  `collection_uid` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_has_collection`
--

INSERT INTO `product_has_collection` (`product_uid`, `collection_uid`) VALUES
('5643835375779', '217942655139'),
('5643817910435', '217942655139'),
('5643812339875', '217942655139'),
('5643810242723', '217942556835'),
('5639019233443', '217942556835'),
('5643807359139', '217942130851'),
('5643802247331', '217942130851'),
('5643799429283', '217942130851'),
('5643799429283', '218812514467'),
('5643827216547', '217942392995'),
('5643817910435', '217942425763'),
('5643812339875', '217942425763'),
('5643810242723', '217942425763'),
('5639019233443', '217942425763'),
('5643807359139', '217942032547'),
('5643802247331', '217942032547'),
('5643799429283', '217942032547'),
('5643827216547', '217780224163'),
('5643817910435', '217780224163'),
('5643799429283', '217780224163'),
('5639019233443', '217780224163'),
('5643835375779', '218159022243');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `product_has_collection`
--
ALTER TABLE `product_has_collection`
  ADD KEY `fk_product_has_collection_product` (`product_uid`),
  ADD KEY `fk_product_has_collection_collection` (`collection_uid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_has_collection`
--
ALTER TABLE `product_has_collection`
  ADD CONSTRAINT `fk_product_has_collection_collection` FOREIGN KEY (`collection_uid`) REFERENCES `collection` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_has_collection_product` FOREIGN KEY (`product_uid`) REFERENCES `product` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
