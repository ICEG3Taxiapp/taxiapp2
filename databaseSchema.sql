CREATE TABLE `driver` (
  `driver_id` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `nic_no` varchar(10) DEFAULT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT "1",
  `longitude` float DEFAULT NULL,
  `lattitude` float DEFAULT NULL,
  PRIMARY KEY (`driver_id`)
);

CREATE TABLE `passenger` (
  `contact_no` varchar(10) NOT NULL UNIQUE,
  `name` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY(`contact_no`)
);

CREATE TABLE `hire_request` (
  `request_id` varchar(10) NOT NULL,
  `start_loc_long` float(7,4) NOT NULL,
  `start_loc_lat` float(7,4) NOT NULL,
  `destination_long` float(7,4) NOT NULL,
  `destination_lat` float(7,4) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL DEFAULT "00:00:00",
  `num_of_passengers` int(2) NOT NULL,
  `max_bid` decimal(9,2) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `distanceM` int(11) NOT NULL,
  `durationMins` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT "0",
  `vehicle_type` varchar(30) NOT NULL,
  PRIMARY KEY(`request_id`),
  FOREIGN KEY(`contact_no`) REFERENCES passenger (`contact_no`) ON DELETE CASCADE
);

CREATE TABLE `driverbid` (
  `bid` decimal(9,2) NOT NULL,
  `driver_id` varchar(10) DEFAULT NULL,
  `request_id` varchar(10) DEFAULT NULL,
  FOREIGN KEY(`driver_id`) REFERENCES driver (`driver_id`) ON DELETE CASCADE,
  FOREIGN KEY(`request_id`) REFERENCES hire_request (`request_id`) ON DELETE CASCADE
);

CREATE TABLE `driver_inbox` (
  `driver_inbox_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` varchar(10) NOT NULL DEFAULT "",
  `message` varchar(100) NOT NULL DEFAULT "",
  `is_viewed` tinyint(1) NOT NULL DEFAULT "0",
  PRIMARY KEY (`driver_inbox_id`),
  FOREIGN KEY(`driver_id`) REFERENCES driver (`driver_id`) ON DELETE CASCADE
);

CREATE TABLE `payment` (
  `payment_id` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `driver_id` varchar(10),
  PRIMARY KEY(`payment_id`),
  FOREIGN KEY(`driver_id`) REFERENCES driver (`driver_id`) ON DELETE SET NULL
);

CREATE TABLE `taxi` (
  `reg_no` varchar(10) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `max_passengers` int(2) DEFAULT NULL,
  `driver_id` varchar(10),
  PRIMARY KEY (`reg_no`),
  FOREIGN KEY(`driver_id`) REFERENCES driver (`driver_id`) ON DELETE CASCADE
);

CREATE TABLE `tour` (
  `tour_id` int(10) NOT NULL AUTO_INCREMENT,
  `charge` decimal(9,2) NOT NULL,
  `feedback` text,
  `rating` tinyint(4) DEFAULT NULL check(`rating`<10 AND `rating`>0),
  `driver_id` varchar(10) DEFAULT NULL,
  `request_id` varchar(10) DEFAULT NULL,
  `TCompleted` tinyint(1) NOT NULL DEFAULT "0",
  PRIMARY KEY(`tour_id`),
  FOREIGN KEY(`driver_id`) REFERENCES driver(`driver_id`) ON DELETE SET NULL,
  FOREIGN KEY(`request_id`) REFERENCES hire_request(`request_id`) ON DELETE SET NULL
);
