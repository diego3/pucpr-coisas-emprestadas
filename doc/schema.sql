-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema coisas_emprestadas
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema coisas_emprestadas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `coisas_emprestadas` DEFAULT CHARACTER SET utf8mb4;
USE `coisas_emprestadas` ;

-- -----------------------------------------------------
-- Table `coisas_emprestadas`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coisas_emprestadas`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `createdAt` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `active` TINYINT NULL DEFAULT 1,
  `password` VARCHAR(32) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coisas_emprestadas`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coisas_emprestadas`.`item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `owner` INT NOT NULL,
  `thumb` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_item_user1_idx` (`owner` ASC) VISIBLE,
  CONSTRAINT `fk_item_user1`
    FOREIGN KEY (`owner`)
    REFERENCES `coisas_emprestadas`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coisas_emprestadas`.`loan`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coisas_emprestadas`.`loan` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_item` INT NOT NULL,
  `id_user` INT NOT NULL,
  `loanAt` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `devolution` DATE NULL,
  `devolvedAt` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_emprestimo_item1_idx` (`id_item` ASC) VISIBLE,
  INDEX `fk_loan_user1_idx` (`id_user` ASC) VISIBLE,
  CONSTRAINT `fk_emprestimo_item1`
    FOREIGN KEY (`id_item`)
    REFERENCES `coisas_emprestadas`.`item` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_loan_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `coisas_emprestadas`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coisas_emprestadas`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coisas_emprestadas`.`role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `coisas_emprestadas`.`user_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `coisas_emprestadas`.`user_role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_role` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_role_user_idx` (`id_user` ASC) VISIBLE,
  INDEX `fk_user_role_role1_idx` (`id_role` ASC) VISIBLE,
  CONSTRAINT `fk_user_role_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `coisas_emprestadas`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_role_role1`
    FOREIGN KEY (`id_role`)
    REFERENCES `coisas_emprestadas`.`role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
