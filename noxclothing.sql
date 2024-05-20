-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 03:14 AM
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
  `whishlist_id` int(11) DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
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
(1, 'admin', '', '', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '', '2024-05-07', '2024-05-20 02:54:10');

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
  `address` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zipcode` int(15) NOT NULL,
  `contactnumber` int(15) NOT NULL,
  `bday` date DEFAULT NULL,
  `image` longblob NOT NULL,
  `password` varchar(250) NOT NULL,
  `otp_code` int(11) NOT NULL,
  `datereg` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fname`, `mname`, `lname`, `email`, `uname`, `address`, `city`, `zipcode`, `contactnumber`, `bday`, `image`, `password`, `otp_code`, `datereg`) VALUES
(1, 'aaaa', 'jade', 'blancaflor', 'blancaflor@gmail.com', 'aaaa', 'tramo st.', 'bacoor', 2013, 9989, NULL, 0x89504e470d0a1a0a0000000d49484452000000c8000000c80806000000ad58ae9e000000097048597300000b1300000b1301009a9c18000000017352474200aece1ce90000000467414d410000b18f0bfc610500000cc3494441547801ed9d3f7613cb12c6e7bef70232f00a8c57000e890c2bb00989302bc03bb058812123c38a086d42229b8ccc78058690089c41a437df9c539c66aea625cdf45457f57cbf73ea4a36ba566b345f5757ffa9faa7aaaa45450859ca7f2a424827140821112810422250208444a0400889408110128102212402054248040a849008140821112810422250208444a0400889408110128102212402054248040a849008140821112810422250208444a040088940811012810221240205424884ff55a437f7eedd6becfefdfb8d81ededede6517e9647796dfbff5dc5cf9f3f1b13be7efdfaafe778c46b6e6f6ffffa5df85ad28f7f2a6656ec0437f7c3870f9b1b1937be0801b6ee0d9e1b084704f4e5cb97e6f1fafafaaf9f4937931788780008e1c183077f9e4bcf5f3a2220180403f1c873323181e0a67ffcf8f12485d0078844c4f2e9d3a7497a9c6205128a014290a112198608662aa229462022063cc228063d44309797978d684a9a1c702b1011c4c1c101bd8331201088a504c1b81108864cfbfbfbf4100e110ff3e1c38746349e8664a60502214014f0120ca6cb0122393f3f6f0463ddbb981208bc02c4b0b7b7d73cd24b940f0422628170ac614220f014c7c7c78c25268ec42ef3f9dc8c58b20a0482383939690442488815b16413c8d1d151230e425621c3b0376fdea8c72c5904329bcd9a2115219b026f727a7aaa367dac2e108a83a400e2d8d9d9a9c646552098aabdb9b9a908190ad655767777abb1513d3075717151119202ad58444d208787875cec23c9d0da8eaf2610c61d2425450904eb1cf41e2425dfbe7dab34501108b68e10920a392eac819a072124159ac7815504c2e1154989e6d6130a84b843d383a82c142e16cc2c44d2b1b5b5a576e88a9915892b24c797162a0261863f920aed7c5d2a02611232920a6c7bd7444520168f52129f20f3a3262a02d1fe50a44c341708050eb1881b728c44540402e57398458652ac4000bd08194a8e7b484d20c87b44485f300ac139746de841880b720dd1d504c238840ca17881000a84f425c7f00aa80a24d78724bec959124edd83b06824d9949c230ff532d0f8b0c8dc3e25c252ceedb2ceed9f41fbfc4c5851778a676b281087c88d2d35fac2bae4e1f3b1920ba02c35ce45dcbd7bf7af5aed52a23aacddee9d9c4373f5d4a3deb22bcaf8372c93fce3c70fb5ac1a4341067d88482afa7a2b68aa9541b10b750f22bdabb5de4dbc003c5c582fdc7bcc24c16dbb178640a402b0a465c2736be49ef9cc92dd1d650f50fe2027a118a49cf1d4698bc6422d48788f9cdf4d1681e0c26be7e9951a13524c92b369eb214332d48a94619a16b98757c22287d5e3f8c598e0efbf7bf76ef1fcf9f345dd0b2e727dced2ac16c9e2e5cb978bba835b8c4dedcd2c7ce63c6f8c9b373575f0bf383e3e5eeceded59b8b0c51b3a9edab334df25ae7d4af03d1af99c79def8f0f0709102f464b898f5b467af76488f58c7458b7af890eb4b28c2d031a5100bfe86a1cf95e78dd1fbf41d665d5d5df516451dfffc1922b4df1f5f2c4592c6fa8a051d95b1cf92efcd371dc7e2f59b0e9f70c343106767676b099222496f2296d4dfad86652d035ddfb8d5ebd7afd77a2da68551e574159896945917acd8f79975c10cd78b172fd453cc940ebe1b64fa0fd75b30bb687d56319b3a31cc5aa747479cb0eaef20a659d74baccb6c36cbda7bd14c58de06c48659ab863b882796c51229c1dfe7906bd296b701880fbae8f21c220c2d2054aca7e4be56b42c96b7015dc3acae79700c7b72c1a9e0495afe46b4bd017aec65afcb298eb06df42693b2fc8d682f1a2ebb012d882304d396f42693b0fc8d08170d97790fc41c56a1508a371b0d9185a465db0c52eff319030aa54c3353616a3e9f378fedc5b97af865fee8a81c00ab2716588fb130d44f147621194fda4759eb78a4b240fbe8ad9c47f772f496f4c38c4000b69de0bcb780ad09396aac4b164818048113873c60354d4c0944865982d619e9f0b4214441af400453026917fbc4f9e83180371041e031a52024ed8e641391143ce1bf85e7bcbb6296f05ac873493524c924d0ee76ca219216530269933261006ea4d3d3d3461043f32c89002060c93f95fabc76f8b7d6fdbb616c04c120338bfc8ef4c3b44086de702944217110b6698f218494c890b41db78987c1f05132b85034eb615a207dbe4409b011f0f711056e7e1184e48bf28e78b950381089c45cb84e1ca275637691061b16d705c770b13378d30c2678fdc1c141b311d1c382e458e0b363b113d7825960fe32bb8d5b27b1c39063b89a5be6bd816b833d71dc1d60b871f872626c72c01fbd22363c52149b3371b1d86e60d7b0679dbc4910053d455a262816db0d5c1687acf21cd8fd9bfa7c3af937885970adaddf4303cd7603dbf9b3e051ba82c8a3a3a34907dab9904364857a15fb8d0cbdc8b2c354f862388cb24181dbfe7d3414025876980a5f06bd863d0a1a7ef968a804dceddf511cb691a0decb7de65620cbac5e2d5f101fac9300d0a2fdb7fecfac7208b64ebc7fffbe223ec09eb65fbf7e551f3f7eac3c61e6c8eda620af2ff1c53ab995ade15620394e1a92fe6057b5c70d9159b3bbf705ee3a3c9a4becb3b3b3e352202e3d083387f8c2abf7002e0592bb3431d90c8fb187e052203cdce307a945ef159702e171513fcc66b3ca336e05829e89d8468ef37ac6ed342f05621fefde03b89ce60508d46f6e6e18b01b051dd893274f2aefb8dd6a826d0b77eedce182a1519074bc840c956e3d08a017b109d63d5046bb04dc7a10402f6293a74f9f1633d3e8364817b008c5695f3b785e355f866b0f02e8456c5192f700ee3d088017e1ea7a7e4af31ec0bd0701f022b7b7b7d5c1c14145f200aff1ecd9b3e286bb45781080de8b8b87f940b2f012bdb8eb69de3688432e2e2e2aa20b84b1bbbb5be46449311e04485d41a20bb694943a9358940701384c757575c5c54325e03d705ab0548af220005f18c6c344076c292999e23c08e016141d4ada52d24511d3bc6d30edfbfdfb774efb8e4c698b82cb28d2830898d1b2bcc22e659ddbb44b455b0481f9ab57afaad2295a20a8fa8a805d1ba95d1e966596bae648578445cd757bdeededed6a6b6baba9b92ec538c3d2d33984547a601e52b440c0c9c949757474548d850820ac1aab790e020241bd768805de52a34c3502f3f97c5e4d05d3c98387da1819e091b11c354b503cd46245589484400154942048fdd937a90b5988b96a6c2f4369e3a140147dca4c5b3064554f51e61aa5b63d7dee1456fc104be81bb0632a13c168df7d46180249bc8038427e16c2e778afb1872e6807127fe35a6c3214c3da12aec314cfdeb851f310c3b06393a29e78eda6f5d7d153c3cb606883de76d322a278bd660d0d0cc35695aeeb5387be249b8c070108d611b4af02de02193956790df4c2b0fa064a36a3b4ee7ba7049e049f03c1be7c064c3820a795e7ac88a970a3e614b6aac7442f1e2b4289ba7b18cf8f59623a56c997a66eae1a3bd870f3c768d74114833034eb21628846919830578d4d626159e99065557461b96a212296f1724d0b36578d4d66e8a1db2cabc69abb50e804d71dac99abc62633cc16b569c71e98e5b1c06c3673735d0b34578d4d6af5acd69f9b10c17bfbdf2dd560a748b299abc6263799d56a8ff7ad788f108a44df8a3b51b82938f023bb6f43f6f7f72b6bd4930b551d2755448f220f4c6d02c4f1fbf7ef263b6358ece5eddbb7cdefac81436010f3f5f575457470e3eec6340ca9c29fadc3e1969ab96aac8aad5a4cb40245a262ae1aab6258c1f6024532bab96aac9a8db9d72a35676767d1fd63b4fe36f959ac2e3ced6245e08ef32e631fb59d22144807e7e7e79527200ee4021bf3fcfd5471e5f2b40c7188a7615608163d39e44a63935f07e9c273e52a1cdec2b00b6b3c5c2f198e2b456b1abcc8b25dbf9ea037196cae1aab6e9b9e65b70ab6cd5328bdcc5563b398c58d8b7dc074b0a7eb6ec45c35369ba107f6ccaab3f6b44e73d5d8acb62ae18365903ccfd3b53664ae1a9bd5c64863aa01cee07bbacec6cc5563b39bb7a09d67da079babc69a30a400f200f36b2531578d3563e179768b401c0cca871b57d27bf2f9f3e7e6d1e24a3b56d01f3d7aa49abeb4645c29da9a9d9e9e2eacc119aba4e6aab126cdd2f42f67ac929babc69a342b7bb6288e51cc5563cd1a02e29c6b24cce33b9ab96aac69cb25922996465334578d356fc8f9abb990c8b58ed1cd55635d98d64222d73a54cc5563ddd8d85be4290e3573d5585736d66a3bc5a16aae1aebce52976ec39a0bc5a16aae1aebd27043631a760808fcbbea27d24635578d756d7d8402616001903355796c5275d2ad2075c9518304cf61529f1c1b0cb1d9f0f2f2b2495e87b43df899e48102212402538f12128102212402054248040a849008140821112810422250208444a0400889408110128102212402054248040a849008140821112810422250208444a0400889408110128102212402054248040a849008140821112810422250208444a0400889f07faf3ece341c22271f0000000049454e44ae426082, 'ahahah', 0, '2024-05-09'),
(2, 'Jade ', '', '', 'bryanblancaflor007@gmail.com', 'admin', '', '', 0, 0, '2024-05-14', '', '21232f297a57a5a743894a0e4a801fc3', 0, '2024-05-14');

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

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `orders_id`, `amount_paid`, `mode_payment`, `cardnumber`, `cvv`, `exp_date`, `status`, `payment_date`) VALUES
(1, 1, 299.00, 'Credit Card', 111, 111, '2024-05-19', 'Process', '2024-05-19');

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
(1, 'Ghirl Tshirt', 'female', 'Pink', 'medium', 'Dickies', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'T-SHIRT', 10, 'Restock', 0x70726f647563742d312e6a7067, '', 10.00, 399.00, '2024-05-14'),
(2, 'Hoodie X', 'female', 'Purple', 'large', 'UNIQLO', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'JACKETS', 12, 'Low Stock', 0x70726f647563742d332e6a7067, '', 10.00, 299.00, '2024-05-14'),
(3, 'Hoodie X', 'male', 'Gray', 'medium', 'UNIQLO', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'JACKETS', 10, 'Low Stock', 0x70726f647563742d342e6a7067, '', 38.00, 399.00, '2024-05-14'),
(4, 'Hoodie M', 'male', 'Black', 'large', 'UNIQLO', 'A colorful t-shirt featuring a large image of a surfer on the front, exuding a laid-back and cool vibe for anyone seeking adventure.', 'JACKETS', 10, 'Instock', 0x70726f647563742d352e6a7067, '', 10.00, 599.00, '2024-05-14'),
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
-- Table structure for table `whishlist`
--

CREATE TABLE `whishlist` (
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
  ADD KEY `whishlist_id` (`whishlist_id`);

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
  ADD KEY `add_id` (`addcart_id`);

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
-- Indexes for table `whishlist`
--
ALTER TABLE `whishlist`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `whishlist`
--
ALTER TABLE `whishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addcart`
--
ALTER TABLE `addcart`
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `whishlist_id` FOREIGN KEY (`whishlist_id`) REFERENCES `whishlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `add_id` FOREIGN KEY (`addcart_id`) REFERENCES `addcart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customers_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prod_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `orders_fbk` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Id`);

--
-- Constraints for table `whishlist`
--
ALTER TABLE `whishlist`
  ADD CONSTRAINT `custom_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pro_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
