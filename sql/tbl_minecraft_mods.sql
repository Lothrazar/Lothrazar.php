CREATE TABLE `lothraza_db`.`minecraft_mods` ( 
    `curse_id` INT NOT NULL , 
    `name` VARCHAR(255) NOT NULL , 
    `curse_slug` VARCHAR(255) NOT NULL , 
    `logo_url` VARCHAR(1000) NULL , 
    `mc_version_csv` VARCHAR(255) NULL , 
    `github_slug` VARCHAR(255) NOT NULL , 
    `hidden` TINYINT NOT NULL DEFAULT '0' , 
    PRIMARY KEY (`curse_id`)) ENGINE = InnoDB; 