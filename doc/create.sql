SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `unamed_bt`.`project_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`project_group` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`project_group` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unamed_bt`.`project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`project` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`project` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `project_group_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_project_project_group_idx` (`project_group_id` ASC) ,
  CONSTRAINT `fk_project_project_group`
    FOREIGN KEY (`project_group_id` )
    REFERENCES `unamed_bt`.`project_group` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unamed_bt`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`user` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(45) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `firstname` VARCHAR(255) NOT NULL ,
  `phone` VARCHAR(45) NULL ,
  `jabber_id` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unamed_bt`.`milestone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`milestone` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`milestone` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `project_id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL ,
  `due_date` DATETIME NULL ,
  `status` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_milestone_project1_idx` (`project_id` ASC) ,
  CONSTRAINT `fk_milestone_project1`
    FOREIGN KEY (`project_id` )
    REFERENCES `unamed_bt`.`project` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unamed_bt`.`story`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`story` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`story` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL ,
  `owner_user_id` INT NOT NULL ,
  `dev_user_id` INT NULL ,
  `status` VARCHAR(45) NOT NULL ,
  `due_date` DATETIME NULL ,
  `complexity` TINYINT NULL ,
  `closed_for` VARCHAR(45) NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  `position` INT NULL ,
  `milestone_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_story_user1_idx` (`owner_user_id` ASC) ,
  INDEX `fk_story_user2_idx` (`dev_user_id` ASC) ,
  INDEX `fk_story_milestone1_idx` (`milestone_id` ASC) ,
  CONSTRAINT `fk_story_user1`
    FOREIGN KEY (`owner_user_id` )
    REFERENCES `unamed_bt`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_story_user2`
    FOREIGN KEY (`dev_user_id` )
    REFERENCES `unamed_bt`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_story_milestone1`
    FOREIGN KEY (`milestone_id` )
    REFERENCES `unamed_bt`.`milestone` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unamed_bt`.`notes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`notes` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`notes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `story_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_notes_story1_idx` (`story_id` ASC) ,
  INDEX `fk_notes_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_notes_story1`
    FOREIGN KEY (`story_id` )
    REFERENCES `unamed_bt`.`story` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notes_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `unamed_bt`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unamed_bt`.`files`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`files` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`files` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `notes_id` INT NOT NULL ,
  `name` VARCHAR(255) NULL ,
  `description` VARCHAR(255) NULL ,
  `path` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_files_notes1_idx` (`notes_id` ASC) ,
  CONSTRAINT `fk_files_notes1`
    FOREIGN KEY (`notes_id` )
    REFERENCES `unamed_bt`.`notes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `unamed_bt`.`commit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unamed_bt`.`commit` ;

CREATE  TABLE IF NOT EXISTS `unamed_bt`.`commit` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `sha1` VARCHAR(40) NOT NULL ,
  `notes_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_commits_notes1_idx` (`notes_id` ASC) ,
  CONSTRAINT `fk_commits_notes1`
    FOREIGN KEY (`notes_id` )
    REFERENCES `unamed_bt`.`notes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
