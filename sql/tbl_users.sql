CREATE TABLE `lothraza_db`.`users` ( 
    `id` INT NOT NULL , 
    `email` VARCHAR(255) NOT NULL , 
    `password` VARCHAR(255) NOT NULL , 
    `hidden` TINYINT NOT NULL DEFAULT '0' , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB; 