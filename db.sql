CREATE TABLE `accounts` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
);

CREATE TABLE `app` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `creator_id` int(11),
  `app_id` varchar(255) DEFAULT NULL,
  `app_key` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
);

CREATE TABLE `recovery` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `track_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
);

CREATE TABLE `sessions` (
  `user_id` int(11) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `remote_addr` varchar(255) DEFAULT NULL
);

CREATE TABLE `traffic` (
  `app_id` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `date_time` varchar(255) DEFAULT DATE_FORMAT(CURRENT_DATE, '%d%m%Y'),
  `count` int(11) DEFAULT 1
);