-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2025 at 08:17 PM
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
-- Database: `bloom_salon`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `accepted_appointment_view`
-- (See below for the actual view)
--
CREATE TABLE `accepted_appointment_view` (
`appointment_id` varchar(15)
,`client_name` varchar(101)
,`email` varchar(255)
,`phone_number` varchar(11)
,`appointment_date` date
,`appointment_time` varchar(8)
,`services_name` mediumtext
,`total_price` decimal(32,0)
,`status` enum('pending','accepted','rejected')
);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'admin@bloomsalon.com', 'bloom@2025');

-- --------------------------------------------------------

--
-- Stand-in structure for view `all_appointment_view`
-- (See below for the actual view)
--
CREATE TABLE `all_appointment_view` (
`appointment_id` varchar(15)
,`client_name` varchar(101)
,`email` varchar(255)
,`phone_number` varchar(11)
,`appointment_date` date
,`appointment_time` varchar(8)
,`services_name` mediumtext
,`total_price` decimal(32,0)
,`status` enum('pending','accepted','rejected')
);

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `appointment`
--
DELIMITER $$
CREATE TRIGGER `enforce_slot_limit` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
    DECLARE `slot_count` INT;
    
    -- Count existing accepted appointments for the same date and time
    SELECT COUNT(*) INTO `slot_count`
    FROM `appointment`
    WHERE `appointment_date` = NEW.`appointment_date`
    AND `appointment_time` = NEW.`appointment_time`
    AND `status` = 'accepted';
    
    -- If slot is full, prevent insertion
    IF `slot_count` >= 3 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'This time slot is already full (maximum 3 appointments per hour)';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_business_hours` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
    IF NEW.appointment_time < '08:00:00' OR NEW.appointment_time > '18:00:00' THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Appointment time must be between 8:00 AM and 6:00 PM';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_future_date` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
    IF NEW.appointment_date < CURDATE() THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Appointment date cannot be in the past';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_services`
--

CREATE TABLE `appointment_services` (
  `service_count` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `client_view`
-- (See below for the actual view)
--
CREATE TABLE `client_view` (
`client_id` varchar(15)
,`client_name` varchar(101)
,`email` varchar(255)
,`phone_number` varchar(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `client_visit_view`
-- (See below for the actual view)
--
CREATE TABLE `client_visit_view` (
`client_id` varchar(15)
,`client_name` varchar(101)
,`email` varchar(255)
,`phone_number` varchar(11)
,`first_visit` date
,`last_visit` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `pending_appointment_view`
-- (See below for the actual view)
--
CREATE TABLE `pending_appointment_view` (
`appointment_id` varchar(15)
,`client_name` varchar(101)
,`email` varchar(255)
,`phone_number` varchar(11)
,`appointment_date` date
,`appointment_time` varchar(8)
,`services_name` mediumtext
,`total_price` decimal(32,0)
,`status` enum('pending','accepted','rejected')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `rejected_appointment_view`
-- (See below for the actual view)
--
CREATE TABLE `rejected_appointment_view` (
`appointment_id` varchar(15)
,`client_name` varchar(101)
,`email` varchar(255)
,`phone_number` varchar(11)
,`appointment_date` date
,`appointment_time` varchar(8)
,`services_name` mediumtext
,`total_price` decimal(32,0)
,`status` enum('pending','accepted','rejected')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `schedule_view`
-- (See below for the actual view)
--
CREATE TABLE `schedule_view` (
`date` date
,`time` varchar(8)
,`appointment_id` varchar(15)
,`client_name` varchar(101)
,`services` mediumtext
);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `service_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_price`) VALUES
(1, 'Rebond with Botox', 2000),
(2, 'Rebond with Regular Treatment', 1500),
(3, 'Rebond with Brazilian', 2500),
(4, 'Rebond with Color', 2800),
(5, 'Rebond with Color Treatment', 3000),
(6, 'Color', 1000),
(7, 'Color Treatment', 1500),
(8, 'Color Botox', 2000),
(9, 'Haircut', 200),
(10, 'Regular Treatment', 500),
(11, 'Hair Botox', 1500),
(12, 'Hair Brazilian', 1800),
(13, 'Hair Detox', 1500),
(14, 'Manicure', 250),
(15, 'Pedicure', 250),
(16, 'Footspa', 200),
(17, 'Gel Polish', 450),
(18, 'Paraffin Wax', 200);

-- --------------------------------------------------------

--
-- Stand-in structure for view `services_view`
-- (See below for the actual view)
--
CREATE TABLE `services_view` (
`service_id` varchar(15)
,`service_name` varchar(50)
,`service_price` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `accepted_appointment_view`
--
DROP TABLE IF EXISTS `accepted_appointment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `accepted_appointment_view`  AS SELECT concat('AID',`a`.`appointment_id` + 100) AS `appointment_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `client_name`, `c`.`email` AS `email`, `c`.`phone_number` AS `phone_number`, `a`.`appointment_date` AS `appointment_date`, date_format(`a`.`appointment_time`,'%l:%i %p') AS `appointment_time`, group_concat(`s`.`service_name` separator ', ') AS `services_name`, sum(`s`.`service_price`) AS `total_price`, `a`.`status` AS `status` FROM (((`appointment` `a` join `clients` `c` on(`a`.`client_id` = `c`.`client_id`)) join `appointment_services` `ap` on(`a`.`appointment_id` = `ap`.`appointment_id`)) join `services` `s` on(`ap`.`service_id` = `s`.`service_id`)) WHERE `a`.`status` = 'accepted' GROUP BY `a`.`appointment_id` ;

-- --------------------------------------------------------

--
-- Structure for view `all_appointment_view`
--
DROP TABLE IF EXISTS `all_appointment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all_appointment_view`  AS SELECT concat('AID',`a`.`appointment_id` + 100) AS `appointment_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `client_name`, `c`.`email` AS `email`, `c`.`phone_number` AS `phone_number`, `a`.`appointment_date` AS `appointment_date`, date_format(`a`.`appointment_time`,'%l:%i %p') AS `appointment_time`, group_concat(`s`.`service_name` separator ', ') AS `services_name`, sum(`s`.`service_price`) AS `total_price`, `a`.`status` AS `status` FROM (((`appointment` `a` join `clients` `c` on(`a`.`client_id` = `c`.`client_id`)) join `appointment_services` `ap` on(`a`.`appointment_id` = `ap`.`appointment_id`)) join `services` `s` on(`ap`.`service_id` = `s`.`service_id`)) GROUP BY `a`.`appointment_id` ;

-- --------------------------------------------------------

--
-- Structure for view `client_view`
--
DROP TABLE IF EXISTS `client_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `client_view`  AS SELECT concat('CID',`clients`.`client_id` + 100) AS `client_id`, concat(`clients`.`first_name`,' ',`clients`.`last_name`) AS `client_name`, `clients`.`email` AS `email`, `clients`.`phone_number` AS `phone_number` FROM `clients` ;

-- --------------------------------------------------------

--
-- Structure for view `client_visit_view`
--
DROP TABLE IF EXISTS `client_visit_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `client_visit_view`  AS SELECT concat('CID',`c`.`client_id` + 100) AS `client_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `client_name`, `c`.`email` AS `email`, `c`.`phone_number` AS `phone_number`, min(`a`.`appointment_date`) AS `first_visit`, max(`a`.`appointment_date`) AS `last_visit` FROM (`clients` `c` left join `appointment` `a` on(`c`.`client_id` = `a`.`client_id`)) WHERE `a`.`status` = 'accepted' GROUP BY `c`.`client_id` ORDER BY max(`a`.`appointment_date`) DESC ;

-- --------------------------------------------------------

--
-- Structure for view `pending_appointment_view`
--
DROP TABLE IF EXISTS `pending_appointment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pending_appointment_view`  AS SELECT concat('AID',`a`.`appointment_id` + 100) AS `appointment_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `client_name`, `c`.`email` AS `email`, `c`.`phone_number` AS `phone_number`, `a`.`appointment_date` AS `appointment_date`, date_format(`a`.`appointment_time`,'%l:%i %p') AS `appointment_time`, group_concat(`s`.`service_name` separator ', ') AS `services_name`, sum(`s`.`service_price`) AS `total_price`, `a`.`status` AS `status` FROM (((`appointment` `a` join `clients` `c` on(`a`.`client_id` = `c`.`client_id`)) join `appointment_services` `ap` on(`a`.`appointment_id` = `ap`.`appointment_id`)) join `services` `s` on(`ap`.`service_id` = `s`.`service_id`)) WHERE `a`.`status` = 'pending' GROUP BY `a`.`appointment_id` ;

-- --------------------------------------------------------

--
-- Structure for view `rejected_appointment_view`
--
DROP TABLE IF EXISTS `rejected_appointment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rejected_appointment_view`  AS SELECT concat('AID',`a`.`appointment_id` + 100) AS `appointment_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `client_name`, `c`.`email` AS `email`, `c`.`phone_number` AS `phone_number`, `a`.`appointment_date` AS `appointment_date`, date_format(`a`.`appointment_time`,'%l:%i %p') AS `appointment_time`, group_concat(`s`.`service_name` separator ', ') AS `services_name`, sum(`s`.`service_price`) AS `total_price`, `a`.`status` AS `status` FROM (((`appointment` `a` join `clients` `c` on(`a`.`client_id` = `c`.`client_id`)) join `appointment_services` `ap` on(`a`.`appointment_id` = `ap`.`appointment_id`)) join `services` `s` on(`ap`.`service_id` = `s`.`service_id`)) WHERE `a`.`status` = 'rejected' GROUP BY `a`.`appointment_id` ;

-- --------------------------------------------------------

--
-- Structure for view `schedule_view`
--
DROP TABLE IF EXISTS `schedule_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `schedule_view`  AS SELECT `a`.`appointment_date` AS `date`, date_format(`a`.`appointment_time`,'%l:%i %p') AS `time`, concat('AID',`a`.`appointment_id` + 100) AS `appointment_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `client_name`, group_concat(`s`.`service_name` separator ', ') AS `services` FROM (((`appointment` `a` join `clients` `c` on(`a`.`client_id` = `c`.`client_id`)) join `appointment_services` `ap` on(`a`.`appointment_id` = `ap`.`appointment_id`)) join `services` `s` on(`ap`.`service_id` = `s`.`service_id`)) WHERE `a`.`status` = 'accepted' GROUP BY `a`.`appointment_id` ORDER BY `a`.`appointment_date` ASC, `a`.`appointment_time` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `services_view`
--
DROP TABLE IF EXISTS `services_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `services_view`  AS SELECT concat('SID',`services`.`service_id` + 100) AS `service_id`, `services`.`service_name` AS `service_name`, `services`.`service_price` AS `service_price` FROM `services` ORDER BY concat('SID',`services`.`service_id` + 100) ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `fk_client_id` (`client_id`);

--
-- Indexes for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD PRIMARY KEY (`service_count`),
  ADD KEY `fk_appointment_id` (`appointment_id`),
  ADD KEY `fk_service_id` (`service_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_services`
--
ALTER TABLE `appointment_services`
  MODIFY `service_count` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);

--
-- Constraints for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD CONSTRAINT `fk_appointment_id` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appointment_id`),
  ADD CONSTRAINT `fk_service_id` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
