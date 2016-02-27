-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2016 at 11:06 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `supplier` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `product_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `purchase_id`, `supplier_id`, `purchase_date`, `sku`, `title`, `supplier`, `cost_price`, `quantity`, `total_cost`, `status`, `date_added`, `date_modified`, `product_image`) VALUES
(20, '20160220', '', '2016-02-20', '16668721', 'Folding Spring Assisted Knife Stainless Steel Belt Cutter Glass Breaker', 'Overstock', '10.00', 50, '500.00', 1, '2016-02-20 18:42:28', '0000-00-00 00:00:00', 'product_images/8-Collection-Folding-Spring-Assisted-Knife-Stainless-Steel-Belt-Cutter-Glass-Breaker-034ed151-d762-41b6-b9b9-0dff858a03dd_600.jpg'),
(21, '20160220', '', '2016-02-20', '12094082', 'Furniture of America Tepekiie Two-side Open Coffee Table', 'Overstock', '153.56', 10, '1535.60', 1, '2016-02-20 18:46:55', '2016-02-25 22:08:49', ''),
(23, '20160221', '', '2016-02-21', '17915665', 'South Shore Spark Twin Mates Bed with Drawers and Bookcase Headboard Set', 'Overstock', '32.00', 100, '3200.00', 1, '2016-02-20 19:35:24', '2016-02-25 21:51:55', ''),
(24, '20160221', '', '2016-02-21', '17319766', 'Wood 36-inch Round Antique Table', 'Overstock', '172.00', 30, '5160.00', 1, '2016-02-20 19:38:00', '2016-02-20 21:17:17', 'product_images/a967d4eafc126ee771aef6977abd29d7.jpg'),
(25, 'PUR111111111', 'sup111111111', '2016-02-27', 'SKU111111', 'Product 111', 'supplier111', '222.25', 10, '2222.50', 1, '2016-02-27 18:49:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `inventory2`
--

CREATE TABLE IF NOT EXISTS `inventory2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `supplier` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `product_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `inventory2`
--

INSERT INTO `inventory2` (`id`, `purchase_id`, `purchase_date`, `sku`, `title`, `supplier`, `cost_price`, `quantity`, `total_cost`, `status`, `date_added`, `date_modified`, `product_image`) VALUES
(20, 20160220, '2016-02-20', '16668721', 'Folding Spring Assisted Knife Stainless Steel Belt Cutter Glass Breaker', 'Overstock', '10.00', 50, '500.00', 1, '2016-02-20 18:42:28', '0000-00-00 00:00:00', 'product_images/8-Collection-Folding-Spring-Assisted-Knife-Stainless-Steel-Belt-Cutter-Glass-Breaker-034ed151-d762-41b6-b9b9-0dff858a03dd_600.jpg'),
(24, 20160221, '2016-02-21', '17319766', 'Wood 36-inch Round Antique Table', 'Overstock', '172.00', 30, '5160.00', 1, '2016-02-20 19:38:00', '2016-02-20 21:17:17', 'product_images/a967d4eafc126ee771aef6977abd29d7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_20feb2016`
--

CREATE TABLE IF NOT EXISTS `inventory_20feb2016` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_date` date NOT NULL,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `supplier` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `product_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `inventory_20feb2016`
--

INSERT INTO `inventory_20feb2016` (`id`, `purchase_date`, `sku`, `title`, `supplier`, `cost_price`, `quantity`, `total_cost`, `status`, `date_added`, `date_modified`, `product_image`) VALUES
(1, '2016-02-17', '111111', 'wertretyrr11', 'rtret11', '13.00', 2, '52.00', 1, '2016-02-16 12:12:42', '2016-02-16 20:52:36', NULL),
(7, '2016-02-18', '111231', 'test product', 'supplier 1', '16.00', 2, '32.00', 1, '2016-02-15 18:10:11', '0000-00-00 00:00:00', NULL),
(8, '2016-02-25', '111123', 'new product', 'new supplier', '19.00', 2, '38.00', 1, '2016-02-15 18:11:09', '0000-00-00 00:00:00', NULL),
(9, '2016-02-26', '111134', 'Special product', 'Special supplier', '10.00', 3, '30.00', 1, '2016-02-16 11:26:26', '2016-02-17 21:31:00', NULL),
(10, '2016-02-22', '111222', 'this is a old product', 'old supplier', '23.00', 3, '69.00', 1, '2016-02-16 11:29:26', '2016-02-16 21:48:34', 'product_images/champion-speaking.png');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_copy`
--

CREATE TABLE IF NOT EXISTS `inventory_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `supplier` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `product_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `inventory_copy`
--

INSERT INTO `inventory_copy` (`id`, `purchase_id`, `purchase_date`, `sku`, `title`, `supplier`, `cost_price`, `quantity`, `total_cost`, `status`, `date_added`, `date_modified`, `product_image`) VALUES
(20, 20160220, '2016-02-20', '16668721', 'Folding Spring Assisted Knife Stainless Steel Belt Cutter Glass Breaker', 'Overstock', '10.00', 50, '500.00', 1, '2016-02-20 18:42:28', '0000-00-00 00:00:00', 'product_images/8-Collection-Folding-Spring-Assisted-Knife-Stainless-Steel-Belt-Cutter-Glass-Breaker-034ed151-d762-41b6-b9b9-0dff858a03dd_600.jpg'),
(21, 20160220, '2016-02-20', '12094082', 'Furniture of America Tepekiie Two-side Open Coffee Table', 'Overstock', '161.00', 10, '1610.00', 1, '2016-02-20 18:46:55', '2016-02-20 18:48:06', 'product_images/Furniture-of-America-Tepekiie-Two-side-Open-Coffee-Table-7371e686-2dd9-4a6a-b838-291df352569f_600.jpg'),
(22, 20160220, '2016-02-20', '15337879', 'Blazing Needles Twill Swivel Rocker Cushion', 'Overstock', '49.00', 20, '980.00', 1, '2016-02-20 19:29:34', '0000-00-00 00:00:00', 'product_images/Blazing-Needles-Twill-Swivel-Rocker-Cushion-a6dff8da-c1c0-4d4f-a724-0899e4a8eae4_600.jpg'),
(23, 20160221, '2016-02-21', '17915665', 'South Shore Spark Twin Mates Bed with Drawers and Bookcase Headboard Set', 'Overstock', '329.00', 100, '32900.00', 1, '2016-02-20 19:35:24', '0000-00-00 00:00:00', 'product_images/South-Shore-Spark-Twin-Mates-Bed-with-Drawers-and-Bookcase-Headboard-Set-558a8865-7b1c-45bb-b351-ab4f29b8dd66_600.jpg'),
(24, 20160221, '2016-02-21', '17319766', 'Wood 36-inch Round Antique Table', 'Overstock', '172.00', 30, '5160.00', 1, '2016-02-20 19:38:00', '2016-02-20 21:17:17', 'product_images/a967d4eafc126ee771aef6977abd29d7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `master_inventory`
--

CREATE TABLE IF NOT EXISTS `master_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `added_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Inventory Stock Data' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `master_inventory`
--

INSERT INTO `master_inventory` (`id`, `sku`, `stock`, `added_date`, `modified_date`) VALUES
(1, '15337879', 20, '2016-02-20 19:29:34', '0000-00-00 00:00:00'),
(2, '16668721', -21, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '12094082', 10, '0000-00-00 00:00:00', '2016-02-25 22:08:49'),
(4, '17915665', 100, '2016-02-20 19:35:24', '2016-02-25 21:51:55'),
(5, '17319766', 10, '2016-02-20 19:38:00', '2016-02-20 21:17:17'),
(6, 'SKU111111', 10, '2016-02-27 18:49:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `supplier` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity_purchased` int(11) DEFAULT NULL,
  `profit_retained` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_date` date NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `sale_id`, `order_id`, `sku`, `title`, `supplier`, `cost_price`, `sale_price`, `quantity_purchased`, `profit_retained`, `sale_date`, `date_added`, `date_modified`, `status`) VALUES
(7, '20160220', '', '17319766', 'Wood 36-inch Round Antique Table', 'Overstock', '172.00', '180.00', 5, '40.00', '2016-02-21', '2016-02-20 22:26:46', '0000-00-00 00:00:00', 1),
(8, 'SAL1234567', '', '16668721', 'Folding Spring Assisted Knife Stainless Steel Belt Cutter Glass Breaker', 'Overstock', '10.00', '30.00', 20, '400.00', '2016-02-24', '2016-02-25 15:15:02', '0000-00-00 00:00:00', 1),
(14, 'SAL27FEB2016', 'ORD27FEB2016', '16668721', 'Folding Spring Assisted Knife Stainless Steel Belt Cutter Glass Breaker', 'Overstock', '10.00', '225.45', 21, '4524.45', '2016-02-28', '2016-02-27 20:23:57', '0000-00-00 00:00:00', 1),
(15, 'SAL27FEB2016', 'ORD27FEB2016', '16668721', 'Folding Spring Assisted Knife Stainless Steel Belt Cutter Glass Breaker', 'Overstock', '10.00', '225.45', 21, '4524.45', '2016-02-28', '2016-02-27 20:24:51', '0000-00-00 00:00:00', 1),
(16, 'SAL27FEB2016', 'OR127FEB2016', '17319766', 'Wood 36-inch Round Antique Table', 'Overstock', '172.00', '221.23', 5, '246.15', '2016-02-28', '2016-02-27 20:26:58', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_copy`
--

CREATE TABLE IF NOT EXISTS `sales_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `supplier` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity_purchased` int(11) DEFAULT NULL,
  `profit_retained` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_date` date NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sales_copy`
--

INSERT INTO `sales_copy` (`id`, `sale_id`, `sku`, `title`, `supplier`, `cost_price`, `sale_price`, `quantity_purchased`, `profit_retained`, `sale_date`, `date_added`, `date_modified`, `status`) VALUES
(6, 20160220, '17319766', 'Wood 36-inch Round Antique Table', 'Overstock', '172.00', '180.00', 10, '80.00', '2016-02-20', '2016-02-20 21:58:59', '0000-00-00 00:00:00', 1),
(7, 20160220, '17319766', 'Wood 36-inch Round Antique Table', 'Overstock', '172.00', '180.00', 5, '40.00', '2016-02-21', '2016-02-20 22:26:46', '0000-00-00 00:00:00', 1),
(8, 20160221, '16668721', 'Folding Spring Assisted Knife Stainless Steel Belt Cutter Glass Breaker', 'Overstock', '10.00', '12.00', 9, '18.00', '2016-02-19', '2016-02-20 22:33:03', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(3, 'admin@eezy.com', '21232f297a57a5a743894a0e4a801fc3'),
(10, 'test@eezy.com', '9f51ce8e8e4374fd0736f3ece4a679dc');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `inventory2` (`sku`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
