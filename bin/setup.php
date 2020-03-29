<?php
 $connection = new PDO('mysql:host=supermarket_mysql_1:3306;', 'root', 'simple', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $query =<<<'EOD'
DROP DATABASE IF EXISTS supermarket;
CREATE DATABASE supermarket;
USE supermarket;
SET NAMES utf8 ;

CREATE TABLE cartitem (
cart_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  quantity int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE product (
id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  description varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  price double NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id_UNIQUE (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES product WRITE;
INSERT INTO product VALUES (1,'Pepsi','Soft Drink','A bottle of Pepsi.',0.8),(2,'Cubana','Sandwich','Sandwich with ham and cheese.',2),(3,'Lays Wasabi','Crisps','Wasabi flavored potato chips.',0.75),(7,'Soproni 1895','Hard Drink','A bottle of Soproni',1.1),(8,'Soproni IPA','Hard Drink','A bottle of Soproni IPA',1),(9,'Lays Chili-Lime','Crisps','Chilli and Lime flavored potato chips.',0.75),(10,'Ketchup','Sauce','Yummy',1);
UNLOCK TABLES;
EOD;
    $connection = $connection->prepare($query)->execute();
    if ($connection) {
        exit(0);
    } else {
        exit(1);
    }
