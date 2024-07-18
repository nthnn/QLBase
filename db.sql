CREATE TABLE `accounts` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
);

CREATE TABLE `app` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `creator_id` int(11),
  `app_id` varchar(255) NOT NULL,
  `app_key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL
);

CREATE TABLE `cdp` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `api_key` varchar(255) NOT NULL,
  `ticket` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
);

CREATE TABLE `recovery` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `track_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
);

CREATE TABLE `sessions` (
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `remote_addr` varchar(255) NOT NULL
);

CREATE TABLE `shared_access` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `app_id` varchar(255) NOT NULL,
  `app_key` varchar(255) NOT NULL,
  `friend` int(11) NOT NULL
);

CREATE TABLE `traffic` (
  `app_id` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `date_time` varchar(255) DEFAULT DATE_FORMAT(CURRENT_DATE, '%d%m%Y'),
  `count` int(11) DEFAULT 1
);