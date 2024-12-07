/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
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
  `date_time` varchar(255) NOT NULL,
  `count` int(11) DEFAULT 1
);