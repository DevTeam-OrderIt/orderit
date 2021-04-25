-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2020 at 05:33 AM
-- Server version: 5.7.32
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_orderid`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `price_per_unit` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `token`, `product_id`, `quantity`, `discount`, `total_price`, `price_per_unit`, `unit_name`) VALUES
(1, 'chrome 86.0.4240.75linux', 8, 1, '10', 25.00, 25, '1 kg'),
(2, 'chrome 86.0.4240.75linux', 8, 1, '10', 25.00, 25, '1 kg'),
(3, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(4, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(5, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(6, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(7, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(8, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(9, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(10, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(11, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(12, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(13, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(14, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(15, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(16, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(17, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(18, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg'),
(19, 'chrome 86.0.4240.75linux', 6, 1, '20', 100.00, 100, '1 kg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `delete_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `delete_status`) VALUES
(1, 'vegetable', 0),
(3, 'fruits', 0),
(4, 'meat', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_id` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(12) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `order_status` int(2) NOT NULL DEFAULT '0' COMMENT '1=placed',
  `delivery_boys_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_status` enum('1','0') NOT NULL DEFAULT '0',
  `payment_method` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `user_id`, `cart_id`, `amount`, `shipping_address`, `customer_name`, `customer_phone`, `customer_email`, `order_status`, `delivery_boys_id`, `create_date`, `payment_date`, `payment_status`, `payment_method`) VALUES
(1, 'ORDER1000', 1, '2', 22.50, 'door no -  flor no -  building no -  appartment name -  street -  near by -  locality -  city -  district -  state -  pincode - ', 'Ajit Rathore', '1565615315', 'ajitk1565@gmail.com', 0, 2, '2020-11-29 01:04:34', '2020-11-29 01:04:34', '0', 'Cash'),
(2, 'ORDER1001', 1, '19', 80.00, 'door no -  flor no -  building no -  appartment name -  street -  near by -  locality -  city -  district -  state -  pincode - ', 'Ajit Rathore', '1565615315', 'ajitk1565@gmail.com', 0, 2, '2020-11-29 01:16:17', '2020-11-29 01:16:17', '0', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `other_name` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `mrp_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `no_of_product` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` varchar(10) NOT NULL,
  `offer_msg` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `services` enum('trending') DEFAULT NULL,
  `units` text NOT NULL,
  `delete_status` int(2) NOT NULL,
  `search_tags` text NOT NULL,
  `delivery_boys` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `other_name`, `images`, `mrp_price`, `price`, `no_of_product`, `discount`, `discount_type`, `offer_msg`, `category_id`, `unit_id`, `description`, `services`, `units`, `delete_status`, `search_tags`, `delivery_boys`) VALUES
(1, 'Patato', 'Alloo', '1601356923_c81uone3iglfzhbav7jr1601356923.jpg', 12.00, 10.00, 10, 10, '', 'up to 10% off', 1, 3, 'dunjfbgjfhnkfmnkfnbkf', NULL, '2,3', 0, 'Alloo,Patato', 0),
(2, 'Onion', 'Pyaz', '1602774735_ae0i5r81nwxjy3khbpmu1602774735.png,1602774735_s0v65l43mhgeozcfx1d91602774735.png', 40.00, 32.00, 10, 20, '', 'up to 10% off', 3, 3, 'vbfhjvfmnknr\r\n\r\nthsaryths', NULL, '2,3,4', 0, 'Onion,Pyaz', 0),
(3, 'Tometo', 'tometo', '', 30.00, 10.00, 10, 10, '', '', 1, 2, 'jhbvhj', NULL, '0', 0, 'tometo', 0),
(4, 'or fnvfk', 'vbf', '', 0.00, 1.00, 1, 1, '', ' fnvbfhj', 1, 2, ' jhvbfh', NULL, '0', 0, '', 0),
(5, 'bfhvjf', ' jhbv', '', 0.00, 0.00, 10, 0, '', '', 3, 2, '', NULL, '2', 0, '', 3),
(6, 'Bottle Guard', 'Loki', '1604928694_rvmwj12854lcupgnhk9t1604928694.png', 25.00, 100.00, 20, 20, '', 'up to 20% off', 1, 2, 'abcdefgh', 'trending', '2,3,4', 0, 'Loki, achi loki, badia loki', 2),
(7, 'meat', 'ghsh', '', 0.00, 0.00, 2, 10, '', 'up to 10% off', 4, 0, 'S', 'trending', '', 0, 'BSB', 0),
(8, 'Ginger', 'Adrak', '1606185105_6tz2h9eyw5q8prfuc3x41606185105.png', 25.00, 25.00, 10, 10, '%', 'NA', 1, 2, 'Normal adrak hai', NULL, '8', 0, 'Ginger, Adrak, Allam', 0),
(9, 'Patatov', 'Pyaz', '1606453538_lfkqbs5ua4jr38wh6c921606453538.jpg', 12.00, 64.00, 10, 20, 'rs', 'up to 10% off', 1, 3, 'xb', NULL, '2', 0, 'vcnfgn', 0),
(10, 'sgsg', 'vdsg', '1606455341_3qo8j47vwmatfd52cbe91606455341.jpg', 20.00, 20.00, 2, 10, 'rs', 'cxbf', 1, 2, 'f', NULL, '', 0, 'bf', 0),
(11, 'sgsgvd', 'vdsg', '1606455431_5crzywu9evbdknt23hfq1606455431.png', 20.00, 20.00, 2, 10, 'rs', 'cxbf', 4, 2, 'f', NULL, '', 0, 'bf', 0),
(12, 'sgsgvddfedf', 'vdsg', '1606455610_4yknc796izatqdugvoh21606455610.jpg', 20.00, 20.00, 2, 10, 'rs', 'cxbf', 1, 3, 'f', NULL, '', 0, 'bf', 0),
(13, 'sgsgvddfedfsfa', 'vdsg', '1606455691_qpy2srwjh8lkm9ug30cv1606455691.jpg', 20.00, 20.00, 2, 10, 'rs', 'cxbf', 1, 3, 'f', NULL, '', 0, 'bf', 0),
(14, 'sgsgvddfedfsfasf', 'vdsg', '1606455860_16imobye49u2avd5s7nh1606455860.jpg', 20.00, 20.00, 2, 10, 'rs', 'cxbf', 1, 2, 'f', NULL, '', 1, 'bf', 0),
(15, 'cvdsv', 'zvdv', '1606455903_95crahokfj0mgdxtliq61606455903.jpg', 20.00, 10.00, 1, 10, 'rs', 'cvcv', 1, 3, 'xv', NULL, '', 1, 'xfb', 0),
(16, 'svsdv', '10', '1606456003_8ylberqu935o7kx06pnw1606456003.jpg', 5.00, 5.00, 1, 10, 'rs', 'vsdbs', 1, 3, 'dvd', NULL, '', 1, 'vdzvd', 0),
(17, 'asff', 'fdfa', '1606456065_rjhqgk9385undw2vzo1s1606456065.jpg', 1.00, 1.00, 2, 10, 'rs', '20', 3, 4, 'dvdsv', NULL, '', 1, 'xbf', 0),
(18, 'cxv', 'cxv', '1606456097_spbk10co64etg3flud5w1606456097.jpg', 10.00, 10.00, 2, 10, 'rs', 'vsfsg1', 1, 2, 'xvfd', NULL, '2,3', 1, 'xcb', 0);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` int(2) NOT NULL,
  `images` text NOT NULL,
  `delete_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `title`, `description`, `status`, `images`, `delete_status`) VALUES
(1, 'vegetable', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 1, '1598008477_5otbfvaz9pk6gsjn37i21598008477.jpeg', 0),
(2, 'Fruits', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 1, '1598008510_p2e9fzq14t7kyhv0x3on1598008510.jpeg', 1),
(3, 'abcd', 'check', 1, '1601429451_d7ti928yk06xhqval1me1601429451.jpg', 1),
(4, 'Meat', 'Goat fresh meat', 1, '1606146740_ypuhoev2nzw5s4x18ak01606146740.PNG', 0),
(5, 'abcd', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 1, '1606182317_uwq3x158p4tsa0kcdi7m1606182317.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `last_name`, `phone`, `email`, `gender`, `image`) VALUES
(2, 'Ravi', 'Subrahmanyam', '9999401346', 'RAVISUBBU97@GMAIL.COM', 'Male', '1603372127_cl3t6o5zhur7wnyx8p1g1603372127.png'),
(3, 'Ajit', 'kumar', '9635615165', 'ajit@gmail.com', 'Female', '1604853318_q2rgl8916vcm4wynpokz1604853318.png'),
(4, 'check after', 'permissions khichidi', '9876543210', 'orderitonline24@GMAIL.COM', 'Male', '1605029338_abgxqecof0y6n74zvs3d1605029338.png'),
(6, 'sn', 'nns', '8373636363', 'ajay@y.com', 'Male', '1606148202_0uvsfy9qgxdai52nmc641606148202.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `add_on` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `image` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `first_name`, `last_name`, `mobile_number`, `email`, `password`, `add_on`, `last_update`, `last_login`, `ip_address`, `status`, `image`, `address`) VALUES
(1, 'ajit@12345', 'Ajit', 'kumar', '9634725012', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2019-11-28 08:00:26', '2020-06-15 09:38:27', '2019-11-16 04:16:00', '::1', '1', 'avatar042.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_address`
--

CREATE TABLE `tbl_delivery_address` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `door_no` varchar(255) NOT NULL,
  `floo_no` varchar(255) NOT NULL,
  `building_no` varchar(255) NOT NULL,
  `appartment_name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `near_by` varchar(255) NOT NULL,
  `locality` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `default` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_delivery_address`
--

INSERT INTO `tbl_delivery_address` (`id`, `user_id`, `door_no`, `floo_no`, `building_no`, `appartment_name`, `street`, `near_by`, `locality`, `city`, `district`, `state`, `pincode`, `default`) VALUES
(2, '7', '65', '2', '23', 'New appartment name', 'vandana enclave', 'atm', 'hdfc atm', 'noida', 'ghaziabad', 'up', '201309', '0');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unite_name` varchar(255) NOT NULL,
  `delete_status` int(2) NOT NULL,
  `unite_value` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unite_name`, `delete_status`, `unite_value`) VALUES
(2, '1 kg', 0, 1.00),
(3, '2 kg', 0, 2.00),
(4, '5 kg', 0, 5.00),
(5, '5Kg', 0, 0.00),
(6, '15 kg', 0, 15.00),
(7, '1 ltr', 0, 1.00),
(8, '250 g', 0, 0.25),
(9, '500 g', 0, 0.50),
(10, '2 kg', 0, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verify` int(2) NOT NULL COMMENT '0=unverify,1=verify',
  `otp` int(5) NOT NULL,
  `device_token` text NOT NULL,
  `login_type` varchar(20) NOT NULL,
  `outh_id` varchar(255) NOT NULL,
  `add_on` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `image` text NOT NULL,
  `status` int(2) NOT NULL,
  `delete_status` int(2) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `phone`, `email`, `email_verify`, `otp`, `device_token`, `login_type`, `outh_id`, `add_on`, `last_update`, `last_login`, `image`, `status`, `delete_status`, `gender`) VALUES
(1, 'Ajit', 'Rathore', '1565615315', 'ajitk1565@gmail.com', 0, 0, '', '', '', '2020-08-21 17:38:16', '2020-10-22 04:42:57', '0000-00-00 00:00:00', '1598011696_ipc5tmvl7820wd3kh1eb1598011696.jpg', 1, 0, 'Female'),
(2, 'Praveen', 'pp', '9634725013', 'ajitk15656@gmail.com', 0, 0, '', '', '', '2020-08-21 17:43:32', '2020-08-21 12:47:41', '0000-00-00 00:00:00', '1598013316_n74guzbvixyod23ktrsl1598013316.jpg', 1, 0, 'Male'),
(3, 'Ravi', 'SUBRAHMANYAM', '9999401346', 'ravisubbu97@gmail.com', 0, 0, '', '', '', '2020-09-30 07:05:00', '2020-09-30 01:35:38', '0000-00-00 00:00:00', '1601429700_s63gpzud84eibcnwtrk51601429700.jpg', 1, 0, 'Male'),
(6, 'Ajit', 'kumar', '9634725012', '', 0, 6873, '', '', '', '0000-00-00 00:00:00', '2020-11-17 19:23:58', '0000-00-00 00:00:00', '', 0, 0, ''),
(7, '', '', '963472501', '', 0, 6744, '', '', '', '0000-00-00 00:00:00', '2020-11-11 06:54:13', '0000-00-00 00:00:00', '', 0, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_delivery_address`
--
ALTER TABLE `tbl_delivery_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_delivery_address`
--
ALTER TABLE `tbl_delivery_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
