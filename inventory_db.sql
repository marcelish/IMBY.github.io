DROP DATABASE IF EXISTS php;
CREATE DATABASE php;
USE php;
-- USERS TABLE
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  `email` VARCHAR(250) NOT NULL,
  `phonenumber` VARCHAR(250) NOT NULL,
  `password` VARCHAR(250) NOT NULL,
  `dob` DATE NOT NULL,
  `bname` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
-- Display the users table
SELECT * FROM users;                  
-- INVENTORY TABLE
CREATE TABLE `inventory` (
  `item_id` INT NOT NULL AUTO_INCREMENT,
  `item_name` VARCHAR(250) NOT NULL,
  `item_quantity` INT NOT NULL,
  `item_price` FLOAT NOT NULL,
  `item_manufacturer` VARCHAR(250) NOT NULL,
  `item_value` FLOAT NOT NULL,
  `user_id` INT, -- Use the same name as the primary key in the users table
  PRIMARY KEY (`item_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB;
-- Display the inventory table
SELECT * FROM inventory;
-- EMPLOYEES TABLE
CREATE TABLE `employees`(
  `empID` INT NOT NULL AUTO_INCREMENT,
  `empName` VARCHAR(250) NOT NULL,
  `empAddress` VARCHAR(250) NOT NULL,
  `empPhone` VARCHAR(250) NOT NULL,
  `user_id` INT, -- Assuming this is the foreign key referencing users(id)
  PRIMARY KEY (`empID`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB;
-- Display the employees table
SELECT * FROM php.employees;
-- INVOICE TABLE
CREATE TABLE `invoice` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `orderNum` VARCHAR(50) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `detail` TEXT NOT NULL,
  `comment` TEXT,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT, -- Assuming this is the foreign key referencing users(id)
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB;
-- Display invoice table
SELECT * FROM invoice;

-- PRODUCT TABLE
CREATE TABLE `product` (
  `PId` INT NOT NULL AUTO_INCREMENT,
  `PName` VARCHAR(100),
  `PPrice` FLOAT NOT NULL,
  `PCategory` VARCHAR(200),
  `user_id` INT, -- Assuming this is the foreign key referencing users(id)
  PRIMARY KEY (`PId`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB;
-- Display the product table
SELECT * FROM php.product;
-- SUPPLIER TABLE
CREATE TABLE `supplier` (
  `SId` INT NOT NULL AUTO_INCREMENT,
  `SName` VARCHAR(150) NOT NULL,
  `SPhone` VARCHAR(100) NOT NULL,
  `user_id` INT, -- Assuming this is the foreign key referencing users(id)
  PRIMARY KEY (`SId`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE = InnoDB;
-- Display the supplier table
SELECT * FROM php.supplier;

CREATE TABLE `location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `LCity` VARCHAR(100) NOT NULL,
  `LStreet` VARCHAR(150) NOT NULL,
  `LCountry` VARCHAR(120) NOT NULL,
  `user_id` INT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE = InnoDB;

-- Then create `delivery` table
CREATE TABLE `delivery` (
  `DId` INT NOT NULL AUTO_INCREMENT,
  `DCustomer` VARCHAR(100) NOT NULL,
  `DAddress` INT NOT NULL,
  `user_id` INT,
  PRIMARY KEY (`DId`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`DAddress`) REFERENCES `location`(`id`)
) ENGINE = InnoDB;

SELECT * FROM php.delivery; 
