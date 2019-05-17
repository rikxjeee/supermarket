<?php

$connection = new PDO('mysql:host=localhost:9999;', 'root', 'simple');

$query = <<<'EOT'
CREATE DATABASE  IF NOT EXISTS `supermarket`;
USE `supermarket`;

 SET NAMES utf8 ;

DROP TABLE IF EXISTS `products`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` float DEFAULT 0 NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `products` WRITE;

INSERT INTO `products` VALUES (1,'Coca Cola',0.8,'Soft Drink'),(2,'Pepsi',0.8,'Soft Drink'),(3,'French Toast',3,'Sandwich'),(4,'Cubana',2,'Sandwich'),(5,'French Fries',0.75,'Crisps'),(6,'Soproni 1895',1,'Hard Drink'),(7,'Lays Wasabi',1,'Crisps'),(8,'Chio Wasabi',1,'Crisps'),(9,'Sharkoon Fireglider',30,'Gaming Mouse');

UNLOCK TABLES;
EOT;


$execute = $connection->prepare($query);
$execute->execute();