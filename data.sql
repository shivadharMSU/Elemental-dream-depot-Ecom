
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `shopper_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `is_orderd` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `name`, `mobile`, `email`, `user_name`, `password`, `role_id`) VALUES
(1, 'admin', '33333', 'shiva@gmail.com', 'admin', 'adminpassword', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `name`, `product_id`, `description`, `quantity`, `price`) VALUES
(1, 'item 1', 1, 'item one description', '23', 100),
(2, 'item 1', 1, 'item two description', '24', 200),
(3, 'item 1', 1, 'item three description', '54', 66),
(4, 'item 1', 1, 'item four description', '32', 56),
(5, 'item 1', 1, 'item five description', '22', 34),
(6, 'item 6', 2, 'item six description', '56', 65),
(7, 'item 7', 2, 'item seven description', '65', 76),
(8, 'item 8', 2, 'item eight description', '44', 55),
(9, 'item 9', 2, 'item nine description', '56', 65),
(10, 'item 10', 2, 'item ten description', '23', 67),
(11, 'item 1', 3, 'item eleven description', '66', 76),
(12, 'item 1', 3, 'item twelev description', '55', 45),
(13, 'item 1', 3, 'item thirteen description', '22', 45),
(14, 'item 1', 3, 'item fourteen description', '11', 45),
(15, 'item 1', 3, 'item fifteen description', '12', 67),
(16, 'item 1', 4, 'item sisteen description', '13', 34),
(17, 'item 1', 4, 'item seventeen description', '14', 34),
(18, 'item 1', 4, 'item eighteen description', '15', 55),
(19, 'item 1', 4, 'item ninteen description', '65', 65),
(20, 'item 1', 4, 'item twenty description', '45', 56),
(21, 'item 1', 4, 'item tenty one description', '44', 23),
(22, 'item 1', 5, 'item tenty two  description', '45', 54),
(23, 'item 1', 5, 'item tenty three  description', '73', 76),
(24, 'item 1', 5, 'item tenty four  description', '22', 56),
(25, 'item 1', 5, 'item tenty five  description', '54', 76),
(26, 'item 1', 5, 'item tenty six  description', '8', 67);

-- --------------------------------------------------------

--
-- Table structure for table `item_order_mappping`
--

CREATE TABLE `item_order_mappping` (
  `item_order_mappping_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `shopper_id` int(11) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `shopper_id` int(11) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `order_date` varchar(100) DEFAULT NULL,
  `address_id` int(10) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `shopper_id`, `total_price`, `order_date`, `address_id`) VALUES
(10, 2, 601, '2024-04-30', NULL),
(11, 2, 601, '2024-04-30', NULL),
(12, 2, 462, '2024-05-04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`) VALUES
(1, 'clothing'),
(2, 'product two'),
(3, 'product three'),
(4, 'product four'),
(5, 'product five');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'associate'),
(3, 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `shoppers`
--

CREATE TABLE `shoppers` (
  `shopper_id` int(11) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `middleName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoppers`
--

INSERT INTO `shoppers` (`shopper_id`, `firstName`, `middleName`, `lastName`, `mobile`, `email`, `username`, `password`) VALUES
(1, 'dsf', 'dsf', 'dsf', NULL, 'dsf@gmail.com', 'dsfdf', 'fdrdf'),
(2, 'shiva', 'reddy', 'arikon', '32344', 'shiva@gmail.com', 'shivadhar', 'shivapassword');

-- --------------------------------------------------------

--
-- Table structure for table `shopper_address`
--

CREATE TABLE `shopper_address` (
  `address_id` int(11) NOT NULL,
  `shopper_id` int(11) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zipCode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopper_address`
--

INSERT INTO `shopper_address` (`address_id`, `shopper_id`, `address`, `city`, `state`, `zipCode`) VALUES
(1, 2, '167 Columbia Ave', 'jersey city', 'new jersey', '07307'),
(2, 2, '168 Columbia Ave', 'jhb city', 'calfornia', '6675'),
(5, 2, '176 gvgh', 'hj ghb hjb', 'gh', 'jin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_item` (`item_id`),
  ADD KEY `shopper_id` (`shopper_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `employee_role` (`role_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `product_item` (`product_id`);

--
-- Indexes for table `item_order_mappping`
--
ALTER TABLE `item_order_mappping`
  ADD PRIMARY KEY (`item_order_mappping_id`),
  ADD KEY `item_shopper_id` (`shopper_id`),
  ADD KEY `item_order_id` (`order_id`),
  ADD KEY `order_item_map` (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_address` (`address_id`),
  ADD KEY `order_shopper_id` (`shopper_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `shoppers`
--
ALTER TABLE `shoppers`
  ADD PRIMARY KEY (`shopper_id`);

--
-- Indexes for table `shopper_address`
--
ALTER TABLE `shopper_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `shopper_adderss` (`shopper_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `item_order_mappping`
--
ALTER TABLE `item_order_mappping`
  MODIFY `item_order_mappping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shoppers`
--
ALTER TABLE `shoppers`
  MODIFY `shopper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shopper_address`
--
ALTER TABLE `shopper_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_item` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `shopper_id` FOREIGN KEY (`shopper_id`) REFERENCES `shoppers` (`shopper_id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `product_item` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `item_order_mappping`
--
ALTER TABLE `item_order_mappping`
  ADD CONSTRAINT `item_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `item_shopper_id` FOREIGN KEY (`shopper_id`) REFERENCES `shoppers` (`shopper_id`),
  ADD CONSTRAINT `order_item_map` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_address` FOREIGN KEY (`address_id`) REFERENCES `shopper_address` (`address_id`),
  ADD CONSTRAINT `order_shopper_id` FOREIGN KEY (`shopper_id`) REFERENCES `shoppers` (`shopper_id`);

--
-- Constraints for table `shopper_address`
--
ALTER TABLE `shopper_address`
  ADD CONSTRAINT `shopper_adderss` FOREIGN KEY (`shopper_id`) REFERENCES `shoppers` (`shopper_id`);



