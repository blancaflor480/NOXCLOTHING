-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 09:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noxclothing`
--

-- --------------------------------------------------------

--
-- Table structure for table `addcart`
--

CREATE TABLE `addcart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `wishlist_id` int(11) DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `image` longblob NOT NULL,
  `datereg` date NOT NULL DEFAULT current_timestamp(),
  `logintime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fname`, `mname`, `lname`, `email`, `uname`, `password`, `role`, `image`, `datereg`, `logintime`) VALUES
(1, 'admin', '', '', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '', '2024-05-07', '2024-05-26 08:32:19'),
(4, 'Ma. Angelica', 'M.', 'Rubrico', 'ghelle@gmail.com', 'ghelle', '2978c10efddd879133c9644f16ac570a', 'Staff', 0x2e2e2f75706c6f6164732f36363532623231326363653166352e38313139383839352e6a7067, '2024-05-26', '2024-05-26 11:52:50'),
(5, 'Jade Ryan', 'L.', 'Blancaflor', 'bryanblancaflor007@gmail.com', 'jade123', 'b220e82dde8abcb5dfe247ff49606009', 'Staff', 0x2e2e2f75706c6f6164732f36363532633431663030633262322e31343533383035322e706e67, '2024-05-26', '2024-05-26 13:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `uname` varchar(250) NOT NULL,
  `region` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zipcode` int(15) NOT NULL,
  `street` varchar(100) NOT NULL,
  `contactnumber` int(15) NOT NULL,
  `bday` date DEFAULT NULL,
  `image` longblob NOT NULL,
  `password` varchar(250) NOT NULL,
  `otp` varchar(11) DEFAULT NULL,
  `email_verified` tinyint(6) NOT NULL DEFAULT 0,
  `datereg` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fname`, `mname`, `lname`, `email`, `uname`, `region`, `province`, `barangay`, `city`, `zipcode`, `street`, `contactnumber`, `bday`, `image`, `password`, `otp`, `email_verified`, `datereg`) VALUES
(3, 'Jade ', 'L.', 'Blancaflor', 'blancaflor480@gmail.com', 'jade123', 'IV', 'Cavite', '', 'Bacoor', 5012, 'Kaingen, Tramo st.', 0, '2024-05-26', '', 'b220e82dde8abcb5dfe247ff49606009', NULL, 1, '2024-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `addcart_id` int(11) NOT NULL,
  `innovoice` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(11) NOT NULL,
  `size` varchar(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `mode_payment` varchar(50) NOT NULL,
  `cardnumber` int(11) NOT NULL,
  `cvv` int(11) NOT NULL,
  `exp_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name_item` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `quantity` int(15) NOT NULL,
  `status` varchar(50) NOT NULL,
  `image_front` longblob NOT NULL,
  `image_back` longblob NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_insert` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name_item`, `type`, `color`, `size`, `manufacturer`, `description`, `category`, `quantity`, `status`, `image_front`, `image_back`, `discount`, `price`, `date_insert`) VALUES
(1, 'Ghirl Tshirt', 'female', 'Pink', 'medium', 'Dickies', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'T-SHIRT', 10, 'Restock', 0x70726f647563742d312e6a7067, '', 28.00, 399.00, '2024-05-14'),
(2, 'Hoodie X', 'female', 'Purple', 'large', 'UNIQLO', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'T-SHIRT', 12, 'Low Stock', 0x70726f647563742d332e6a7067, '', 50.00, 299.00, '2024-05-14'),
(3, 'Hoodie X', 'male', 'Gray', 'medium', 'UNIQLO', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'JACKETS', 10, 'Low Stock', 0x70726f647563742d342e6a7067, '', 38.00, 399.00, '2024-05-14'),
(4, 'Hoodie M', 'male', 'Black', 'large', 'UNIQLO', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'T-SHIRT', 10, 'Instock', 0x70726f647563742d352e6a7067, '', 100.00, 599.00, '2024-05-14'),
(5, 'Boy\'s Greeny', 'male', 'Green', 'medium', 'UNIQLO', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'T-SHIRT', 10, 'Restock', 0x70726f647563742d362e6a7067, '', 38.00, 299.00, '2024-05-14'),
(6, 'Sky Cloud', 'female', 'Sky Blue', 'small', 'Nike', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'T-SHIRT', 10, 'Restock', 0x70726f647563742d382e6a7067, '', 38.00, 199.00, '2024-05-14'),
(7, 'Jansport', 'other', 'Red', 'medium', 'Nike', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'SHORTS', 10, 'Restock', 0x70726f647563742d322e6a7067, '', 10.00, 599.00, '2024-05-14'),
(8, 'Jansport Edition', 'female', 'Red', 'medium', 'UNIQLO', 'ahhahda', 'T-SHIRT', 10, 'Restock', 0x70726f647563742d322e6a7067, '', 0.00, 999.00, '2024-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rate` decimal(11,0) NOT NULL COMMENT '1 - 5',
  `datetime` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uservoucher`
--

CREATE TABLE `uservoucher` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 1,
  `dateused` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `vouchercode` varchar(50) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `expirydate` date NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id`, `vouchercode`, `discount`, `expirydate`, `date`) VALUES
(1, '123000', 25.00, '2024-05-26', '2024-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addcart`
--
ALTER TABLE `addcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `products_id` (`products_id`),
  ADD KEY `wishlist_id` (`wishlist_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_id` (`customer_id`),
  ADD KEY `prod_id` (`products_id`),
  ADD KEY `add_id` (`addcart_id`),
  ADD KEY `voucher_id_1` (`voucher_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_fbk` (`orders_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`customer_id`),
  ADD KEY `product_id` (`products_id`);

--
-- Indexes for table `uservoucher`
--
ALTER TABLE `uservoucher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_id_2` (`voucher_id`),
  ADD KEY `customer_id_2` (`customer_id`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_id` (`customer_id`),
  ADD KEY `pro_id` (`products_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addcart`
--
ALTER TABLE `addcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uservoucher`
--
ALTER TABLE `uservoucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addcart`
--
ALTER TABLE `addcart`
  ADD CONSTRAINT `customerid` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productid` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `wishlistid` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlist` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `addcartid` FOREIGN KEY (`addcart_id`) REFERENCES `addcart` (`id`),
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `voucher_id_1` FOREIGN KEY (`voucher_id`) REFERENCES `voucher` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `ordersid` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `uservoucher`
--
ALTER TABLE `uservoucher`
  ADD CONSTRAINT `customer_id_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `voucher_id_2` FOREIGN KEY (`voucher_id`) REFERENCES `voucher` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `customer_id_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `products_id_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
